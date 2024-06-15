<?php

namespace App\Http\Controllers;

use App\Models\Intervenant;
use App\Models\Prestataire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PrestataireController extends Controller
{
    /**
     * SELECT intervenants.*
     * FROM intervenants
     * LEFT JOIN admins ON intervenants.id = admins.id_intervenant
     * LEFT JOIN prestataires ON intervenants.id = prestataires.id_intervenant
     * WHERE admins.id_intervenant IS NULL AND prestataires.id_intervenant IS NOT NULL;
     */
    public function showAll() {
        $prestataires = Intervenant::select('intervenants.*')
                                ->leftJoin('admins', function($join) {
                                    $join->on('intervenants.id', 'admins.id_intervenant');
                                })
                                ->leftJoin('prestataires', function($join) {
                                    $join->on('intervenants.id', 'prestataires.id_intervenant');
                                })
                                ->whereNull('admins.id_intervenant')
                                ->whereNotNull('prestataires.id_intervenant')
                                ->paginate($this::$pagination);
        return view('listes.prestataires', compact('prestataires'));
    }

    public function show(Intervenant $prestataire) {
        $prestataire = $prestataire->load(['interventions.etape']);

        return view('fiches.intervenant', ['intervenant' => $prestataire]);
    }

    public function store(Request $request) {
        $request->validate([
            // basic salary information
            'nom' => 'required|min:3',
            'prenom' => 'required|min:3',
            'email' => 'required|email|unique:intervenants',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', // Minimum eight characters, at least one uppercase letter, one lowercase letter, one number, and one special character
            // additionnal prestataire information
            'siret' => 'required|numeric|regex:/[0-9]{14}/',
            'raison_sociale' => 'required|min:3',
            'adresse' => 'required|min:3',
            'code_postal' => 'required|numeric|regex:/[0-9]{5}/',
            'ville' => 'required|min:3',
            'taux_horaire' => 'required|decimal'
        ]);

        $intervenant = new Intervenant;
        $intervenant->nom = $request->nom;
        $intervenant->prenom = $request->prenom;
        $intervenant->email = $request->email;
        $intervenant->password = Hash::make($request->password);
        $intervenant->prestataire = true;
        $intervenant->save();

        $prestataire = new Prestataire;
        $prestataire->siret = $request->siret;
        $prestataire->raison_sociale = $request->raison_sociale;
        $prestataire->nom = implode(' ', [$request->prenom, $request->nom]);
        $prestataire->adresse = $request->adresse;
        $prestataire->code_postal = $request->code_postal;
        $prestataire->taux_horaire = $request->taux_horaire;
        $prestataire->ville = $request->ville;
        $prestataire->taux_horaire = $request->taux_horaire;
        $prestataire->intervenant()->associate($intervenant);
        $prestataire->save();

        return redirect()->back()->with('success', 'Prestataire ajouté !');
    }
}
