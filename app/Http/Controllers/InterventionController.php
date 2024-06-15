<?php

namespace App\Http\Controllers;

use App\Models\Etape;
use App\Models\Intervenant;
use App\Models\Intervention;
use App\Models\Projet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterventionController extends Controller
{
    public function showAllByIntervenant() {
        $intervenant = Intervenant::with('interventions.etape.projet')->find(Auth::id());
        return view('listes.interventions', ['interventions' => $intervenant->interventions]);
    }

    public function show(Intervention $intervention) {
        $intervention->load('etape.projet');
        //dd($intervention);
        return view('fiches.intervention', compact('intervention'));
    }

    public function update(Intervention $intervention, Request $request) {
        $request->validate([
            'commentaire' => 'required|string|min:3'
        ]);

        $intervention->update($request->all());
        $intervention->save();

        return redirect()
            ->route('back.intervenant.show', ['intervention' => $intervention])
            ->with(['success' => 'Commentaire mis à jour !']);
    }

    public function store(Projet $projet, Etape $etape, Request $request) {
        $request->validate(
            [
                'libelle' => 'required|min:3',
                'debut' => 'required|date',
                'fin' => 'required|date',
                'intervenant' => 'required|numeric'
            ],
            [
                'libelle' => 'Veuillez renseigner un libelle pour l\'intervention',
                'debut' => 'Veuillez renseigner une date de début pour l\'intervention',
                'fin' => 'Veuillez renseigner une date de fin pour l\'intervention',
                'intervenant' => 'Veuillez sélectionner l\'intervenant qui réalisera l\'intervention'
            ]
        );

        $intervenant = Intervenant::with('interventions')->find($request->intervenant);

        $debut = Carbon::parse($request->debut);
        $fin = Carbon::parse($request->fin);

        if ($intervenant->interventions->isNotEmpty()) {

            foreach($intervenant->interventions as $intervention) {
                $debutIntervention = Carbon::parse($intervention->date_debut_intervention);
                $finIntervention = Carbon::parse($intervention->date_fin_intervention);

                if (
                    $debut >= $debutIntervention
                    &&
                    $debut < $finIntervention
                    ||
                    $fin <= $finIntervention
                    &&
                    $fin > $debutIntervention
                ) {
                    return redirect()->back()->withErrors(['date' => 'L\'intervenant a déjà une intervention programmée sur cette période !']);
                }
            }

        }

        //dd($request->all());
        $intervention = new Intervention($request->all());
        $intervention->intervenant()->associate($intervenant);
        $intervention->date_debut_intervention = $debut;
        $intervention->date_fin_intervention = $fin;
        $intervention->etape()->associate($etape);
        $intervention->save();

        return redirect()->route('back.projets.etape.show', ['projet' => $projet->id, 'etape' => $etape->id]);
    }
}
