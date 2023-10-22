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
use Carbon\Carbon;

class AdminController extends Controller
{
    //
    public $pagination;
    public function __construct($pagination = 10) {
        $this->pagination = $pagination;
    }

    public function index() {
        return view('admin.dashboard');
    }

    public function clients() {
        $clients = Client::paginate($this->pagination);

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
     * @return void
     */
    public function projets() {
        $projets = Projet::paginate($this->pagination);

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
     * @param Projet $projet
     * @param Etape $etape
     * @return void
     */
    public function showEtape($projet, Etape $etape) {
        //dd($projet, $etape);
        $projet = Projet::find(session('id_projet'));
        $interventions = $etape->interventions()->get();

        $intervenantsDispo = Intervenant::select('intervenants.*')
        ->leftJoin('projets', 'intervenants.id', '=', 'projets.id_chef_projet')
        ->leftJoin('admins', 'intervenants.id', '=', 'admins.id_intervenant')
        ->leftJoin('interventions', 'intervenants.id', '=', 'interventions.id_intervenant')
        ->whereNull('projets.id_chef_projet')
        ->whereNull('interventions.id_intervenant')
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
        $etape->id_facture = Facture::create([
            "libelle" => "Facture de l'étape ".$etape->libelle,
            "montant" => 0,
        ])->id;

        $etape->save();


        dd($etape);
    }

    public function addIntervention($etape, Request $request)
    {
        //dd($request);
        $request->validate([
            'libelle' => 'required|min:3',
            'debut' => 'required|date',
            'fin' => 'required|date',
            'intervenant' => 'required|numeric'
        ]); 

        $debut = Carbon::parse($request->date)->setTimeFromTimeString($request->debut);
        $fin = Carbon::parse($request->date)->setTimeFromTimeString($request->fin);


        $intervention = new Intervention;
        $intervention->libelle = $request->libelle;
        $intervention->date_debut_intervention = $debut;
        $intervention->date_fin_intervention = $fin;
        $intervention->id_etape = $etape;
        $intervention->id_intervenant = $request->intervenant;

        $intervention->save();

        return redirect()->route('admin.projet.etape.etape', ['projet' => session('id_projet'), 'etape' => $etape]);
        dd($request, $intervention, $intervention->facture);
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
