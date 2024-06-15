<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function showAll() {
        $clients = Client::paginate($this::$pagination);
        // TODO $clients->withPath('/admin/clients');

        return view('listes.clients', compact('clients'));
    }

    public function show($client) {
        $client = Client::with('projets')->find($client);
        return view('fiches.client', compact('client'));
    }

    public function store(Request $request) {
        $request->validate([
            'raison_sociale' => 'required',
            'SIRET' => 'required|numeric|regex:/[0-9]{14}/',
            'ville' => 'required'
        ],[
            'raison_sociale.required' => 'Veuillez renseigner la Raison Sociale du client',
            'SIRET.required' => 'Veuillez renseigner le numéro de SIRET',
            'SIRET.size' => 'Le numéro de SIRET doit faire 14 chiffres',
            'ville.required' => "Veuillez renseigner la ville du client"
        ]);

        $client = new Client($request->all());
        $client->save();

        return back();
    }
}
