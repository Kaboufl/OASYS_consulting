<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


use App\Models\Intervenant;
use App\Models\Admin;
use App\Models\Projet;

class AdminController extends Controller
{
    //

    public function index() {
        $admin = Admin::where('id', 1)->first();

        $intervenant = $admin->profile;

        //dd($intervenant->nom);

        return view('admin.index', ['title' => 'Formulaire Admin']);
    }

    public function store(Request $request) {
        Projet::create([
            'libelle' => $request->libelle,
            'statut' => $request->statut,
            'taux_horaire' => $request->taux,
            'id_domaine' => $request->domaine,
            'id_client' => $request->client,
            'id_chef_projet' => $request->chef
        ]);

        return back()->with('message', 'ok');
    }
}
