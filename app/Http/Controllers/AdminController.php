<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


use App\Models\Intervenant;
use App\Models\Admin;
use App\Models\Etape;
use App\Models\Projet;
use App\Models\Client;
use App\Models\Domaine;
use App\Models\Facture;
use App\Models\Intervention;
use App\Models\Prestataire;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index() {
        return view('admin-dashboard');
    }

    public function clients() {
        $clients = Client::paginate($this::$pagination);

        $clients->withPath('/admin/clients');

        //dd($clients);

        return view('admin.clients', compact('clients'));
    }

    /**
     * Retourne la liste des projets, ainsi que le la liste des intervenants internes ET disponibles pour gérer un projet
     *
     * Requête SQL originale :
     *
     * SELECT intervenants.*
     * FROM oasys_consulting.intervenants
     * LEFT JOIN oasys_consulting.projets ON intervenants.id = projets.id_chef_projet
     * WHERE projets.id_chef_projet IS NULL
     * AND intervenants.prestataire = FALSE;
     *
     *
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function projets() {
        $projets = Projet::with('etapes')->paginate($this::$pagination);

        $projets->withPath('/admin/projets');

        $domaines = Domaine::all();

        $chefsDispo = Intervenant::select('intervenants.*')->leftJoin('projets', function ($join) {
            $join->on('intervenants.id', '=', 'projets.id_chef_projet');
        })->whereNull('projets.id_chef_projet')
        ->where('prestataire', '0')->get();

        $clients = Client::all();

        $statuts = Projet::getStatuts();

        return view('admin.projets', compact('projets', 'domaines', 'chefsDispo', 'clients', 'statuts'));
    }

    public function salaries() {
        $salaries = Intervenant::select('intervenants.*')->leftJoin('admins', 'intervenants.id', '=', 'admins.id_intervenant')
                                ->whereNull('admins.id_intervenant')
                                ->where('prestataire', false)
                                ->paginate($this::$pagination);
        return view('admin.salaries', compact('salaries'));
    }

    public function storeSalarie(Request $request) {
        $request->validate(
            [
                'nom' => 'required|min:3',
                'prenom' => 'required|min:3',
                'email' => 'required|email|unique:intervenants',
                // Minimum eight characters, at least one uppercase letter, one lowercase letter, one number, and one special character
                'password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
                'confirmPassword' => 'required|same:password'
            ],
            [
                'nom.required' => 'Veuillez renseigner le nom du salarié',
                'nom.min' => 'Le nom doit faire au moins 3 caractères',
                'prenom.required' => 'Veuillez renseigner le prénom du salarié',
                'prenom.min' => 'Le prénom doit faire au moins 3 caractères',
                'email.required' => 'Veuillez renseigner l\'adresse mail du salarié',
                'email.email' => 'L\'adresse mail n\'a pas le bon format !',
                'email.unique' => 'Cette adresse existe déjà !',
                'password.required' => 'Veuillez renseigner un mot de passe !',
                'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
                'password.regex' => 'Le mot de passe doit contenir une majuscule, minuscule, un chiffre et un caractère spécial',
                'confirmPassword' => 'Veuillez confirmer le mot de passe'
            ]
        );

        $salarie = new Intervenant;
        $salarie->nom = $request->nom;
        $salarie->prenom = $request->prenom;
        $salarie->email = $request->email;
        $salarie->password = Hash::make($request->password);
        $salarie->prestataire = false;

        $salarie->save();

        return redirect()->back()->with('success', 'Salarié ajouté !');
    }

    public function showIntervenant($intervenantId) {
        $intervenant = Intervenant::with('intervention', 'chefDe')
                                    //->where('prestataire', false)
                                    ->find($intervenantId);
        //dd($intervenantId, $intervenant);
        if ($intervenant->intervention)
        {
            $etape = $intervenant->intervention->etape;
        }

        return view('fiches.intervenant', ['intervenant' => $intervenant, 'etape' => $etape??null]);
    }

    public function prestataires() {
        $prestataires = Intervenant::with('getPrestataire')
                                    ->select('intervenants.*')
                                    ->leftJoin('admins', 'intervenants.id', '=', 'admins.id_intervenant')
                                    ->leftJoin('prestataires', 'intervenants.id', '=', 'prestataires.id_intervenant')
                                    ->whereNull('admins.id_intervenant')
                                    ->whereNotNull('prestataires.id_intervenant')
                                    ->paginate();

        //$prestataires = Intervenant::where('prestataire', true)->get();

        //dd($prestataires);
        return view('admin.prestataires', compact('prestataires'));
    }

    public function storePrestataire(Request $request) {
        $request->validate([
            // basic salary information
            'nom' => 'required|min:3',
            'prenom' => 'required|min:3',
            'email' => 'required|email|unique:intervenants',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', // Minimum eight characters, at least one uppercase letter, one lowercase letter, one number, and one special character
            // additionnal prestataire information
            'siret' => 'required|numeric|regex:/[0-9]{14}/',
            'raison_sociale' => 'required|min:3',
            'adresse' => 'required|min:3',
            'code_postal' => 'required|numeric|regex:/[0-9]{5}/',
            'ville' => 'required|min:3',
            'taux_horaire' => 'required|decimal'
        ]);

        $intervenant = new Intervenant;
        $intervenant->nom = $request->nom;
        $intervenant->prenom = $request->prenom;
        $intervenant->email = $request->email;
        $intervenant->password = Hash::make($request->password);
        $intervenant->prestataire = true;
        $intervenant->save();

        $prestataire = new Prestataire;
        $prestataire->siret = $request->siret;
        $prestataire->raison_sociale = $request->raison_sociale;
        $prestataire->nom = implode(' ', [$request->prenom, $request->nom]);
        $prestataire->adresse = $request->adresse;
        $prestataire->code_postal = $request->code_postal;
        $prestataire->taux_horaire = $request->taux_horaire;
        $prestataire->ville = $request->ville;
        $prestataire->taux_horaire = $request->taux_horaire;
        $prestataire->intervenant()->associate($intervenant);
        $prestataire->save();

        return redirect()->back()->with('success', 'Prestataire ajouté !');
    }

    public function addProjet(Request $request) {

        $validate = $request->validate([
            'libelle' => 'required',
            'domaine' => 'required|numeric',
            'chefProj' => 'required|numeric',
            'client' => 'required|numeric',
            'taux_horaire' => 'required|numeric',
            'statut' => 'nullable|numeric'
        ]);

        $projet = new Projet;

        $projet->libelle = $request->libelle;
        $projet->id_domaine = $request->domaine;
        $projet->id_chef_projet = $request->chefProj;
        $projet->id_client = $request->client;
        $projet->taux_horaire = $request->taux_horaire;
        $projet->statut = $request->statut;

        $projet->save();

        return back()->with(['succes' => 'Projet enregistré']);
    }

    public function showProjet(Projet $projet) {
        $chefProjet = $projet->chefProj;
        $client = $projet->client;
        $domaine = $projet->domaine;
        $etapes = $projet->etapes;
        session(['id_projet' => $projet->id]);
        return view('fiches.projet', compact('projet', 'chefProjet', 'client', 'domaine', 'etapes'));
    }
    /**
     * Retourne de détail d'une étape
     *
     * La commande SQL originale pour retourner les intervenants non administrateurs et non-attribués pour l'ajout d'une intervention
     *
     * SELECT intervenants.*
     * FROM oasys_consulting.intervenants
     * LEFT JOIN oasys_consulting.projets ON intervenants.id = projets.id_chef_projet
     * LEFT JOIN oasys_consulting.interventions ON intervenants.id = interventions.id_intervenant
     * LEFT JOIN oasys_consulting.admins ON intervenants.id = admins.id_intervenant
     * WHERE projets.id_chef_projet IS NULL
     * AND interventions.id_intervenant IS NULL;
     * AND admins.id_intervenant IS NULL;
     *
     * @param $projet
     * @param Etape $etape
     * @return \Illuminate\Contracts\View\View
     */
    public function showEtape($projet, Etape $etape) {
        //dd($projet, $etape);
        $projet = Projet::find(session('id_projet'));
        $interventions = $etape->interventions()->with('intervenant')->get();
        //dd($interventions);

        $intervenantsDispo = Intervenant::select('intervenants.*')
        ->leftJoin('projets', 'intervenants.id', '=', 'projets.id_chef_projet')
        ->leftJoin('admins', 'intervenants.id', '=', 'admins.id_intervenant')
        ->leftJoin('interventions', 'intervenants.id', '=', 'interventions.id_intervenant')
        ->whereNull('projets.id_chef_projet')
        //->whereNull('interventions.id_intervenant')
        ->whereNull('admins.id_intervenant')->get();

        //dd($test);

        return view('fiches.etape', compact('projet', 'etape', 'interventions', 'intervenantsDispo'));
    }

    public function addEtape(Request $request, Projet $projet) {
        $request->validate([
            'libelle' => 'required|min:3'
        ]);

        $etape = new Etape;
        $etape->libelle = $request->libelle;
        $etape->id_projet = $projet->id;

        $etape->save();

        dd($etape);
        return redirect()->route('admin.projet.etape.etape', ['projet' => $projet->id, 'etape' => $etape->id]);
    }

    public function addIntervention($etape, Request $request)
    {
        //dd($request);
        $request->validate(
            [
                'libelle' => 'required|min:3',
                'debut' => 'required|date',
                'fin' => 'required|date',
                'intervenant' => 'required|numeric'
            ],
            [
                'libelle' => 'Veuillez renseigner un libelle pour l\'intervention',
                'debut' => 'Veuillez renseigner une date de début pour l\'intervention',
                'fin' => 'Veuillez renseigner une date de fin pour l\'intervention',
                'intervenant' => 'Veuillez sélectionner l\'intervenant qui réalisera l\'intervention'
            ]
        );


        $debut = Carbon::parse($request->date)->setTimeFromTimeString($request->debut);
        $fin = Carbon::parse($request->date)->setTimeFromTimeString($request->fin);

        $intervenant = Intervenant::with('intervention')->find($request->intervenant);

        foreach($intervenant->intervention()->get() as $intervention) {
            $debutIntervention = Carbon::parse($intervention->date_debut_intervention);
            $finIntervention = Carbon::parse($intervention->date_fin_intervention);

            if ($debut >= $debutIntervention && $debut < $finIntervention || $fin <= $finIntervention && $fin > $debutIntervention) {
                //dump('overlapping event !');
                return redirect()->back()->withErrors(['date' => 'L\'intervenant a déjà une intervention programmée sur cette période !']);
            }
        }

        //dd($intervenant);

        $intervention = new Intervention;
        $intervention->libelle = $request->libelle;
        $intervention->date_debut_intervention = $debut;
        $intervention->date_fin_intervention = $fin;
        $intervention->id_etape = $etape;
        $intervention->intervenant()->save($intervenant);

        $intervention->save();

        return redirect()->route('admin.projet.etape.etape', ['projet' => session('id_projet'), 'etape' => $etape]);
    }

    public function addFacture(Projet $projet, $etape) {
        $etape = Etape::find($etape);
        $interventions = $etape->interventions()->orderBy('date_debut_intervention')->get();
        $client = $projet->client;

        $interventions->map(function($intervention) use ($projet) {
            $debut = Carbon::parse($intervention->date_debut_intervention);
            $fin = Carbon::parse($intervention->date_fin_intervention);
            $duree = 0;
            for($i = $debut; $i->lessThan($fin); $i->addDay()) {
                $i->diffInHours($fin) > 7 ? $duree += 7 : $duree += $i->diffInHours($fin);
            }
            $intervention->duree = $duree;

            if ($intervention->intervenant->prestataire) {
                $intervention->totalPresta = number_format($intervention->intervenant->getPrestataire->taux_horaire * $intervention->duree, 2, '.', ''); // round float to 2 decimals  number_format($number, 2, '.', '');
            }

            return;
        });

        $projet->total = $interventions->sum('duree') * $projet->taux_horaire;

        //dd($interventions, $projet);

        return view('chefs.addFacture', compact('interventions', 'etape', 'projet', 'client'));
    }

    public function putClient(Request $request) {
        //dd($request->SIRET);

        $validate = $request->validate([
            'raison_sociale' => 'required',
            'SIRET' => 'required|numeric|regex:/[0-9]{14}/',
            'ville' => 'required'
        ],[
            'raison_sociale.required' => 'Veuillez renseigner la Raison Sociale du client',
            'SIRET.required' => 'Veuillez renseigner le numéro de SIRET',
            'SIRET.size' => 'Le numéro de SIRET doit faire 14 chiffres',
            'ville.required' => "Veuillez renseigner la ville du client"
        ]);

        $client = new Client([
            'raison_sociale' => $request->raison_sociale,
            'siret' => $request->SIRET,
            'ville' => $request->ville
        ]);
        $client->save();


        return back();
    }
}
