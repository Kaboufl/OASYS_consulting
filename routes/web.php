<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ChefProjetController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EtapeController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\IntervenantController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\PrestataireController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\SalarieController;
use App\Models\Intervenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'home')->name('home');
Route::view('/projets', 'projets')->name('projets');
Route::view('/equipe', 'equipe')->name('equipe');

Route::name('back.')
->middleware(['auth'])
->prefix('app')
->group(function() {

    Route::get('/admin-dashboard', [AdminController::class, 'index'])
        ->middleware('is-admin')
        ->name('admin.dashboard');

    Route::name('projets.')
    ->middleware(['is-cadre'])
    ->group(function() {
        Route::get('/projets', [ProjetController::class, 'showAll'])->name('showAll');
        Route::post('/projets', [ProjetController::class, 'store'])->middleware('is-admin');
        Route::get('projet/{projet}', [ProjetController::class, 'show'])->name('show');
        Route::post('/projet/{projet}', [ProjetController::class, 'update']);

        Route::name('etape.')
        ->prefix('/projet/{projet}/etape')
        ->group(function() {
            Route::get('/{etape}', [EtapeController::class, 'show'])->name('show');
            Route::post('/ajouter', [EtapeController::class, 'store'])->name('store');

            Route::post('/{etape}/ajouter-intervention', [InterventionController::class, 'store'])->name('store-intervention');

            Route::name('facture.')
            ->prefix('/{etape}/facture')
            ->group(function() {
                Route::get('/ajouter', [FactureController::class, 'create'])->name('create-facture');
                Route::post('/ajouter', [FactureController::class, 'store']);
            });
        });
    });

    Route::name('clients.')
    ->middleware(['is-admin'])
    ->group(function() {
        Route::get('/clients', [ClientController::class, 'showAll'])->name('showAll');
        Route::post('/clients', [ClientController::class, 'store']);
        Route::get('/client/{client}', [ClientController::class, 'show'])->name('show');
    });

    Route::name('salaries.')
    ->middleware(['is-admin'])
    ->group(function() {
        Route::get('/salaries', [SalarieController::class, 'showAll'])->name('showAll');
        Route::post('/salaries', [SalarieController::class, 'store']);
        Route::get('/salarie/{salarie}', [SalarieController::class, 'show'])->name('show');
    });

    Route::name('prestataires.')
    ->middleware(['is-admin'])
    ->group(function() {
        Route::get('/prestataires', [PrestataireController::class, 'showAll'])->name('showAll');
        Route::post('/prestataires', [PrestataireController::class, 'store']);
        Route::get('/prestataire/{prestataire}', [PrestataireController::class, 'show'])->name('show');
    });

    Route::name('intervenant.')
    ->middleware(['is-intervenant'])
    ->group(function() {
        Route::get('/interventions', [InterventionController::class, 'showAllByIntervenant'])->name('showAll');
        Route::get('/intervention/{intervention}', [InterventionController::class, 'show'])->name('show');
        Route::post('/intervention/{intervention}', [InterventionController::class, 'update']);
    });
});

Route::name('admin.')
->middleware(['auth', 'is-admin'])
->prefix('admin')
->group(function () {

    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/clients', [ClientController::class, 'showAll'])->name('clients');
    Route::post('/clients', [ClientController::class, 'store']);
    Route::get('/client/{client}', [ClientController::class, 'show'])->name('client');

    Route::get('/salaries', [SalarieController::class, 'showAll'])->name('salaries');
    Route::post('/salaries', [SalarieController::class, 'store']);
    Route::get('/salarie/{salarie}', [SalarieController::class, 'show'])->name('salarie');
    Route::get('/intervenant/{intervenant}', [AdminController::class, 'showIntervenant'])->name('intervenant');

    Route::get('/prestataires', [PrestataireController::class, 'showAll'])->name('prestataires');
    Route::post('/prestataires', [PrestataireController::class, 'store']);
    Route::get('/prestataire/{prestataire}', [PrestataireController::class, 'show'])->name('prestataire');
    Route::get('/projets', [ProjetController::class, 'showAll'])->name('projets');
    Route::post('/projets', [ProjetController::class, 'store']);
    Route::name('projet.')->prefix('/projet')->group(function () {
        Route::get('/{projet}', [ProjetController::class, 'show'])->name('projet');

        Route::name('etape.')->prefix('{projet}/etape')->group(function () {
            Route::get('/{etape}', [AdminController::class, 'showEtape'])->name('etape');
            Route::post('/ajouter', [AdminController::class, 'addEtape'])->name('add');
            Route::get('/{etape}/facture', [AdminController::class, 'addFacture'])->name('facturer');

            Route::name('intervention.')->prefix('/intervention')->group(function () {
                Route::post('/ajouter', [AdminController::class, 'addIntervention'])->name('add');
            });
            Route::name('facture.')->prefix('/facture')->group(function () {
            });
        });
    });
});

Route::name('chef.')
->middleware(['auth', 'is-chef'])
->prefix('chefs')
->group(function () {
    Route::get('/', function () {
        return redirect()->route('chef.projets');
    });

    Route::get('/projets', [ProjetController::class, 'showByChef'])->name('projets');
    Route::name('projet.')->prefix('/projets')->group(function () {
        Route::get('/{projet}', [ChefProjetController::class, 'showProjet'])->name('projet');
        Route::post('/{projet}', [ChefProjetController::class, 'editProjet'])->name('edit');

        Route::name('etape.')->prefix('/etape')->group(function () {
            Route::get('/{etape}', [ChefProjetController::class, 'showEtape'])->name('show');
            Route::post('/ajouter', [ChefProjetController::class, 'addEtape'])->name('add');
            Route::post('/intervention/ajouter', [ChefProjetController::class, 'addIntervention'])->name('intervention.add');

            Route::name('facture.')->prefix('/facture')->group(function () {
                Route::get('/ajouter', [ChefProjetController::class, 'addFacture'])->name('facturer');
                Route::post('/ajouter', [ChefProjetController::class, 'storeFacture'])->name('add');
            });
        });
    });
});

Route::name('intervenant.')
->middleware(['auth', 'is-intervenant'])
->prefix('/intervenant')->group(function () {
    Route::get('/intervention', [IntervenantController::class, 'intervention'])->name('intervention');
    Route::post('/intervention', [IntervenantController::class, 'updateIntervention'])->name('intervention.edit');
});




Route::prefix('login')->group(function () {
    Route::view('/', 'auth.login')->name('login');
    Route::post('/', [LoginController::class, 'login'])->name('login');
});


Route::get('test/{id}', function ($id) {
    $intervenant = Intervenant::find($id);
    dd($intervenant, empty($intervenant->chefDe()->first()));
});

Route::get('logout', function () {Auth::logout();return redirect('/');})->name('logout');

Route::get('encryptPassword/{password}', function ($password) {
    return Hash::make($password);
});
