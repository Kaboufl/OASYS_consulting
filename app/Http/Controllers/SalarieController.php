<?php

namespace App\Http\Controllers;

use App\Models\Intervenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SalarieController extends Controller
{
    /**
     * SELECT intervenants.*
     * FROM intervenants
     * LEFT JOIN admins ON intervenants.id = admins.id_intervenant
     * LEFT JOIN prestataires ON intervenants.id = prestataires.id_intervenant
     * WHERE admins.id_intervenant IS NULL AND prestataires.id_intervenant IS NULL;
     */
    public function showAll() {
        $salaries = Intervenant::select('intervenants.*')
                                ->leftJoin('admins', function($join) {
                                    $join->on('intervenants.id', 'admins.id_intervenant');
                                })
                                ->leftJoin('prestataires', function($join) {
                                    $join->on('intervenants.id', 'prestataires.id_intervenant');
                                })
                                ->whereNull('admins.id_intervenant')
                                ->whereNull('prestataires.id_intervenant')
                                ->paginate($this::$pagination);
        return view('listes.salaries', compact('salaries'));
    }

    public function show(Intervenant $salarie) {
        $salarie = $salarie->load(['chefDe', 'interventions.etape']);

        return view('fiches.intervenant', ['intervenant' => $salarie]);
    }

    public function store(Request $request) {
        $request->validate(
            [
                'nom' => 'required|min:3',
                'prenom' => 'required|min:3',
                'email' => 'required|email|unique:intervenants',
                // Minimum eight characters, at least one uppercase letter, one lowercase letter, one number, and one special character
                'password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
                'confirmPassword' => 'required|same:password'
            ],
            [
                'nom.required' => 'Veuillez renseigner le nom du salarié',
                'nom.min' => 'Le nom doit faire au moins 3 caractères',
                'prenom.required' => 'Veuillez renseigner le prénom du salarié',
                'prenom.min' => 'Le prénom doit faire au moins 3 caractères',
                'email.required' => 'Veuillez renseigner l\'adresse mail du salarié',
                'email.email' => 'L\'adresse mail n\'a pas le bon format !',
                'email.unique' => 'Cette adresse existe déjà !',
                'password.required' => 'Veuillez renseigner un mot de passe !',
                'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
                'password.regex' => 'Le mot de passe doit contenir une majuscule, minuscule, un chiffre et un caractère spécial',
                'confirmPassword' => 'Veuillez confirmer le mot de passe'
            ]
        );

        $salarie = new Intervenant;
        $salarie->nom = $request->nom;
        $salarie->prenom = $request->prenom;
        $salarie->email = $request->email;
        $salarie->password = Hash::make($request->password);
        $salarie->prestataire = false;

        $salarie->save();

        return redirect()->route('back.salaries.showAll')->with('success', 'Salarié ajouté !');
    }
}
