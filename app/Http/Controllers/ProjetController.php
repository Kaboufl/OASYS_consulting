<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Domaine;
use App\Models\Intervenant;
use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjetController extends Controller
{
    public function showAll() {
        if (Auth::user()->chefDe->count()) {
            return $this->showByChef();
        }
        $projets = Projet::with('etapes')->paginate($this::$pagination);
        // $projets->withPath('/admin/projets');

        $domaines = Domaine::all();

        $chefsDispo = Intervenant::select('intervenants.*')
        ->leftJoin('projets', function ($join) {
            $join->on('intervenants.id', 'projets.id_chef_projet');
        })
        ->leftJoin('prestataires', function ($join) {
            $join->on('intervenants.id', 'prestataires.id_intervenant');
        })
        ->whereNull('projets.id_chef_projet')
        ->whereNull('prestataires.id_intervenant')
        ->get();

        $clients = Client::all();

        $statuts = Projet::getStatuts();

        return view('listes.projets', compact('projets', 'domaines', 'chefsDispo', 'clients', 'statuts'));
    }

    public function showByChef() {
        $chef = Intervenant::with('chefDe')->find(Auth::id());
        $projets = $chef->chefDe()->paginate($this::$pagination);

        return view('listes.projets', compact('projets'));
    }

    public function show(Projet $projet) {
        $projet = $projet->load(['chefProj', 'client', 'domaine', 'etapes']);
        session()->put('id_projet', $projet->id);

        $salaries = Intervenant::select('intervenants.*')
        ->leftJoin('prestataires', 'intervenants.id', 'prestataires.id_intervenant')
        ->leftJoin('interventions', 'intervenants.id', '=', 'interventions.id_intervenant')
        ->leftJoin('etapes', 'interventions.id_etape', '=', 'etapes.id')
        ->leftJoin('projets', 'etapes.id_projet', '=', 'projets.id')
        ->whereNull('prestataires.id_intervenant')
        ->where('projets.id', '=', $projet->id)->get();

        $prestataires = Intervenant::select('intervenants.*')
        ->leftJoin('prestataires', 'intervenants.id', 'prestataires.id_intervenant')
        ->leftJoin('interventions', 'intervenants.id', '=', 'interventions.id_intervenant')
        ->leftJoin('etapes', 'interventions.id_etape', '=', 'etapes.id')
        ->leftJoin('projets', 'etapes.id_projet', '=', 'projets.id')
        ->whereNotNull('prestataires.id_intervenant')
        ->where('projets.id', '=', $projet->id)->get();
        return view('fiches.projet', compact('projet', 'salaries', 'prestataires'));
    }

    public function store(Request $request) {
        $request->validate([
            'libelle' => 'required|min:3',
            'domaine' => 'required|numeric',
            'chefProj' => 'required|numeric',
            'client' => 'required|numeric',
            'taux_horaire' => 'required|numeric',
            'statut' => 'nullable|numeric'
        ]);

        $projet = new Projet($request->only(['libelle', 'taux_horaire', 'statut']));
        $projet->domaine()->associate($request->domaine);
        $projet->client()->associate($request->client);
        $projet->chefProj()->associate($request->chefProj);

        $projet->save();

        return redirect()->route('back.projets.showAll');
    }

    public function update(Projet $projet, Request $request) {
        $projet->update($request->all());

        return redirect()->route('back.projets.show', ['projet' => $projet]);
    }
}
