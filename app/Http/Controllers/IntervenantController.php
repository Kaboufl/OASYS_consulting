<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IntervenantController extends Controller
{
    //


    public function intervention() {
        $intervention = auth()->user()->intervention;
        $etape = $intervention->etape;
        $projet = $intervention->etape->projet;
        //dd($intervention, $etape, $projet);
        return view('intervenants.fiches.intervention', compact('intervention', 'etape', 'projet'));
    }

    public function updateIntervention(Request $request) {
        $request->validate([
            'commentaire' => 'required|string']);
        
        $intervention = auth()->user()->intervention;
        $intervention->commentaire = $request->commentaire;
        $intervention->save();
        return redirect()->route('intervenant.intervention');
    }
}
