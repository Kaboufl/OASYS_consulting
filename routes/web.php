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

Route::prefix('login')->group(function () {
    Route::view('/', 'auth.login')->name('login');
    Route::post('/', [LoginController::class, 'login'])->name('login');
});

Route::get('logout', function () {Auth::logout();return redirect('/');})->name('logout');

Route::get('encryptPassword/{password}', function ($password) {
    return Hash::make($password);
});
