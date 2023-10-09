<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


use App\Models\Intervenant;
use App\Models\Admin;
use App\Models\Projet;
use App\Models\Client;

class AdminController extends Controller
{
    //

    public function index() {
        return view('admin.dashboard');
    }

    public function clients() {
        $clients = Client::get();

        //dd($clients);

        return view('admin.clients', compact('clients'));
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
