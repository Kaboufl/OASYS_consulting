<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;

use App\Models\Admin;
use App\Models\Intervenant;

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

Route::middleware(['auth', 'is-admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::post('/', [AdminController::class, 'store']);
});


Route::prefix('login')->group(function () {
    Route::view('/', 'auth.login')->name('login');
    Route::post('/', [LoginController::class, 'login'])->name('login');
});


Route::get('test', function () {
    $intervenant = Intervenant::find(auth()->user()->id);
    dd(auth()->user()->admin);
});

Route::get('logout', function () {Auth::logout();return redirect('/');});
