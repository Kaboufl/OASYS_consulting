<?php

namespace App\Http\Controllers;

use App\Models\Etape;
use App\Models\Intervenant;
use App\Models\Projet;
use Illuminate\Http\Request;

class EtapeController extends Controller
{
    public function show(Projet $projet, Etape $etape) {

        $etape->load('interventions.intervenant');

        $intervenants = Intervenant::select('intervenants.*')
                            ->leftJoin('projets', 'intervenants.id', 'projets.id_chef_projet')
                            ->leftJoin('admins', 'intervenants.id', 'admins.id_intervenant')
                            ->whereNull('projets.id_chef_projet')
                            ->whereNull('admins.id_intervenant')
                            ->get();

        return view('fiches.etape', compact('projet', 'etape', 'intervenants'));
    }

    public function store(Projet $projet, Request $request) {
        $request->validate([
            'libelle' => 'required|min:3'
        ]);

        $etape = new Etape($request->all());
        $etape->projet()->associate($projet);
        $etape->save();

        return redirect()->route('back.projets.etape.show', ['projet' => $projet, 'etape' => $etape]);
    }
}
