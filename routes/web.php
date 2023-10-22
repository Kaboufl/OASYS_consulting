<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ChefProjetController;
use App\Http\Controllers\IntervenantController;

use App\Models\Admin;
use App\Models\Intervenant;
use App\Models\Intervention;

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

Route::name('admin.')
->middleware(['auth', 'is-admin'])
->prefix('admin')
->group(function () {

    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/clients', [AdminController::class, 'clients'])->name('clients');
    Route::get('/projets', [AdminController::class, 'projets'])->name('projets');
    Route::post('/projets', [AdminController::class, 'addProjet']);
    Route::name('projet.')->prefix('/projet')->group(function () {
        Route::get('/{projet}', [AdminController::class, 'showProjet'])->name('projet');

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
    Route::post('/clients', [AdminController::class, 'putClient']);
});

Route::name('chef.')
->middleware(['auth', 'is-chef'])
->prefix('chefs')
->group(function () {
    Route::get('/', function () {
        return redirect()->route('chef.projets');
    });

    Route::get('/projets', [ChefProjetController::class, 'projets'])->name('projets');
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
