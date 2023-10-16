<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


use App\Models\Intervenant;
use App\Models\Admin;
use App\Models\Projet;
use App\Models\Client;
use App\Models\Domaine;

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

    public function insertEtape(Request $request) {

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
