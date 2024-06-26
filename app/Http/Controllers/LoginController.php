<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Intervenant;
use App\Models\Admin;

class LoginController extends Controller
{
    public function login(Request $request) {

        $email = $request->email;
        $password = $request->password;

        $attempt = Auth::attempt(compact('email', 'password'), $request->rememberMe);

        if($attempt) {
            if (Auth::user()->admin) {
                return redirect()->route('back.admin.dashboard');
            }
            if (Auth::user()->chefDe->count())
            {
                return redirect()->route('back.projets.showAll');
            }
            if (Auth::user()->interventions)
            {
                return redirect()->route('back.intervenant.showAll');
            }

            return response('ok');



        }

        return redirect()->back()->withErrors(['compte' => 'Aucun compte ne correspond aux identifiants renseignés']);

    }
}
