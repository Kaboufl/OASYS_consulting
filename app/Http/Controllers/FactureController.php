<?php

namespace App\Http\Controllers;

use App\Models\Etape;
use App\Models\Facture;
use App\Models\Projet;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function create(Projet $projet, Etape $etape) {
        $etape->load(['projet.client', 'facture']);
        $interventions = $etape
                            ->interventions()
                            ->with('intervenant.getPrestataire')
                            ->orderBy('date_debut_intervention')
                            ->get();

        $interventions = $this->calculerHeuresAFacturer($interventions);

        $etape->projet->total = $interventions->sum('duree') * $projet->taux_horaire;

        return view('fiches.facture', compact('interventions', 'etape'));
    }

    public function store(Projet $projet, Etape $etape, Request $request) {
        $etape->load(['projet.client']);
        $interventions = $etape
                            ->interventions()
                            ->with('intervenant.getPrestataire')
                            ->orderBy('date_debut_intervention')
                            ->get();

        $interventions = $this->calculerHeuresAFacturer($interventions);

        $etape->projet->total = $interventions->sum('duree') * $projet->taux_horaire;

        $facture = Facture::create($request->merge(['montant' => $etape->projet->total])->all());
        $etape->facture()->associate($facture)->save();

        return redirect()->route('back.projets.etape.facture.create-facture', compact('projet', 'etape'));
    }

    public function calculerHeuresAFacturer(Collection $interventions) {
        return $interventions->map(function($intervention) {
            $debut = Carbon::parse($intervention->date_debut_intervention);
            $fin = Carbon::parse($intervention->date_fin_intervention);
            $duree = 0;

            // On ne peut pas facturer un client plus de 7 heures par jour

            for ($i = $debut; $i->lessThan($fin); $i->addDay()) {
                if ($i->diffInHours($fin) > 7) {
                    $duree += 7;
                } else {
                    $duree += $i->diffInHours($fin);
                }
            }

            $intervention->duree = $duree;

            if ($intervention->intervenant->prestataire) {
                $taux_horaire = $intervention->intervenant->getPrestataire->taux_horaire;
                $totalPrestation = $taux_horaire * $duree;
                $intervention->totalPresta = $totalPrestation;
            }

            return $intervention;
        });
    }
}
