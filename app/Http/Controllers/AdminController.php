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
        return view('admin.dashboard');
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
