<?php

namespace App\Http\Controllers;

use App\Models\Etape;
use App\Models\Facture;
use App\Models\Intervenant;
use App\Models\Intervention;
use App\Models\Projet;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use Carbon\Carbon;

class ChefProjetController extends Controller
{
    //

    public function index() {
        return view('chefs.dashboard');
    }

    public function projets() {

        $projets = Intervenant::find(auth()->user()->id)->chefDe()->get();

        //dd($projets);

        return view('chefs.projets', compact('projets'));
    }

    public function showProjet($projet) {

        try {
            $projetSel = Intervenant::find(auth()->user()->id)->chefDe()->findOrFail($projet);
        } catch (ModelNotFoundException $th) {
            //dd(get_class_methods($th));
            //dd($th->getMessage());
            return abort(403);
            return redirect()->route('chef.projets.projets');
        }
        //dd($projetSel);

        $intervenants = Intervenant::select('intervenants.*')
        ->leftJoin('interventions', 'intervenants.id', '=', 'interventions.id_intervenant')
        ->leftJoin('etapes', 'interventions.id_etape', '=', 'etapes.id')
        ->leftJoin('projets', 'etapes.id_projet', '=', 'projets.id')
        ->where('projets.id', '=', $projetSel->id)->get();

        session(['id_projet' => $projetSel->id]);
        return view('chefs.fiches.projet', ['projet' => $projetSel,
                                         'domaine' => $projetSel->domaine,
                                        'client' => $projetSel->client,
                                        'etapes' => $projetSel->etapes,
                                        'intervenants' => $intervenants]);

    }

    public function editProjet(Request $request) {
        $projet = Projet::find(session('id_projet'));
        $projet->statut = $request->statut;
        $projet->save();

        return redirect()->route('chef.projet.projet', $projet->id);
    }

    public function showEtape($etape) {

        
        $projet = Projet::find(session('id_projet'));
        try {
            $etape = $projet->etapes()->findOrFail($etape);
        } catch (ModelNotFoundException $th) {
            return abort(404);
            //throw $th;
        }
        $interventions = $etape->interventions()->get();

        $intervenants_dispo = Intervenant::select('intervenants.*')
        ->leftJoin('projets', 'intervenants.id', '=', 'projets.id_chef_projet')
        ->leftJoin('admins', 'intervenants.id', '=', 'admins.id_intervenant')
        ->leftJoin('interventions', 'intervenants.id', '=', 'interventions.id_intervenant')
        ->whereNull('projets.id_chef_projet')
        ->whereNull('interventions.id_intervenant')
        ->whereNull('admins.id_intervenant')->orderBy('intervenants.prestataire', 'asc')->get();

        //dd($projet, $etape, $interventions, $intervenants_dispo);

        session(['id_etape' => $etape->id]);

        return view('chefs.fiches.etape', compact('projet', 'etape', 'interventions', 'intervenants_dispo'));
    }

    public function addEtape(Request $request) {
        $request->validate([
            'libelle' => 'required|min:3'
        ]);

        $etape = new Etape;
        $etape->libelle = $request->libelle;
        $etape->id_projet = session('id_projet');

        $etape->save();

        //dd(session('id_projet'), $etape);

        return redirect()->route('chef.projet.etape.show', $etape->id);
    }

    public function addFacture() {
        $etape = Etape::find(session('id_etape'));
        $interventions = $etape->interventions()->orderBy('date_debut_intervention')->get();
        $projet = $etape->projet;
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

    public function storeFacture(Request $request) {
        $request->validate([
            'libelle' => 'required|min:3',
            'date' => 'date'
        ]);

        $etape = Etape::find(session('id_etape'));
        $interventions = $etape->interventions()->get();
        $projet = $etape->projet;

        $heuresAFacturer = $interventions->map(function($intervention) use ($projet) {
            $debut = Carbon::parse($intervention->date_debut_intervention);
            $fin = Carbon::parse($intervention->date_fin_intervention);
            $duree = 0;
            for($i = $debut; $i->lessThan($fin); $i->addDay()) {
                $i->diffInHours($fin) > 7 ? $duree += 7 : $duree += $i->diffInHours($fin);
            }
            $intervention->duree = $duree;

            if ($intervention->intervenant->prestataire) {
                $intervention->totalPresta = number_format($intervention->intervenant->getPrestataire->taux_horaire * $intervention->duree, 2, '.', '');
            }

            return;
        });

        $projet->total = $interventions->sum('duree') * $projet->taux_horaire;

        //dd($projet);

        $etape->id_facture = Facture::create([
            'libelle' => $request->libelle,
            'montant' => $projet->total,
            'date_facture' => $request->date
        ])->id;

        $etape->save();

        return redirect()->route('chef.projet.etape.show', session('id_etape'));
    }

    public function addIntervention(Request $request) {

        $request->validate([
            'libelle' => 'required|min:3',
            'debut' => 'required|date',
            'fin' => 'required|date',
            'intervenant' => 'required'
        ]);

        $debut = Carbon::parse($request->date)->setTimeFromTimeString($request->debut);
        $fin = Carbon::parse($request->date)->setTimeFromTimeString($request->fin);

        $intervention = new Intervention;
        $intervention->libelle = $request->libelle;
        $intervention->date_debut_intervention = $debut;
        $intervention->date_fin_intervention = $fin;
        $intervention->commentaire = 'test';
        $intervention->id_etape = session('id_etape');
        $intervention->id_intervenant = $request->intervenant;

        $intervention->save();

        return redirect()->route('chef.projet.etape.show', session('id_etape'));
    }
}
