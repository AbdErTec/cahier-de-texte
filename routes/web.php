<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (auth::check()) {
        return redirect()->route('home');
    }
    return redirect()->route('login');
});

Auth::routes();

//home route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//search routes
Route::get('/search/all', [App\Http\Controllers\SearchController::class, 'indexAdmin'])->name('search.admin');
Route::get('/search/alll', [App\Http\Controllers\SearchController::class, 'indexUser'])->name('search.user');

//Cahier de texte routes
Route::get('/cahierTexte', [App\Http\Controllers\CahierTexteController::class, 'index'])->name('cahierTexte.index');
Route::get('/cahierTexte/create', [App\Http\Controllers\CahierTexteController::class, 'create'])->name('cahierTexte.create');
Route::post('/cahierTexte', [App\Http\Controllers\CahierTexteController::class, 'store'])->name('cahierTexte.store');
Route::delete('/cahierTexte/{id}', [App\Http\Controllers\CahierTexteController::class, 'destroy'])->name('cahierTexte.destroy');
Route::get('/cahierTexte/{id}/edit', [App\Http\Controllers\CahierTexteController::class, 'edit'])->name('cahierTexte.edit');
Route::put('/cahierTexte/{id}', [App\Http\Controllers\CahierTexteController::class, 'update'])->name('cahierTexte.update');
Route::get('/cahierTexte/{id}/download', [App\Http\Controllers\CahierTexteController::class, 'downloadPdf'])->name('cahierTexte.downloadPDF');


//User routes
//create re deja kayna m3a make:auth
Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
Route::get('/user/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
Route::delete('/user/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
Route::get('/user/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('user.show');

//Filiere routes 
Route::get('filiere/create', [App\Http\Controllers\FiliereController::class, 'create'])->name('filiere.create');
Route::post('/filiere', [App\Http\Controllers\FiliereController::class, 'store'])->name('filiere.store');
Route::get('/filiere', [App\Http\Controllers\FiliereController::class, 'index'])->name('filiere.index');
Route::put('/filiere/{id}', [App\Http\Controllers\FiliereController::class, 'update'])->name('filiere.update');
Route::get('/filiere/edit/{id}', [App\Http\Controllers\FiliereController::class, 'edit'])->name('filiere.edit');
Route::delete('/filiere/{id}', [App\Http\Controllers\FiliereController::class, 'destroy'])->name('filiere.destroy');

//Module routes
Route::get('/module', [App\Http\Controllers\ModuleController::class, 'index'])->name('module.index');
Route::post('/module', [App\Http\Controllers\ModuleController::class, 'store'])->name('module.store');
Route::delete('/module/{id}', [App\Http\Controllers\ModuleController::class, 'destroy'])->name('module.destroy');
Route::put('/module/{id}', [App\Http\Controllers\ModuleController::class, 'update'])->name('module.update');

//groupe Routes
Route::get('/groupe', [App\Http\Controllers\GroupeController::class, 'index'])->name('groupe.index');
Route::post('/groupe/store', [App\Http\Controllers\GroupeController::class, 'store'])->name('groupe.store');
Route::put('/groupe/{id}', [App\Http\Controllers\GroupeController::class, 'update'])->name('groupe.update');
Route::delete('/groupe/{id}', [App\Http\Controllers\GroupeController::class, 'destroy'])->name('groupe.destroy');

// Seance routes
Route::get('/seance/show/{id}', [App\Http\Controllers\SeanceController::class, 'show'])->name('seance.show');
Route::get('/seance/{user_id}', [App\Http\Controllers\SeanceController::class, 'index'])->name('seance.index');
Route::put('/seance/{id}', [App\Http\Controllers\SeanceController::class, 'update'])->name('seance.update');
Route::delete('/seance/{id}', [App\Http\Controllers\SeanceController::class, 'destroy'])->name('seance.destroy');
Route::post('/seance/store/{user_id}', [App\Http\Controllers\SeanceController::class, 'store'])->name('seance.store');
