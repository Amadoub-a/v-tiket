<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\ChauffeurController;
use App\Http\Controllers\Parametre\GenreController;
use App\Http\Controllers\Parametre\VilleController;
use App\Http\Controllers\Parametre\MarqueController;
use App\Http\Controllers\Parametre\ModeleController;
use App\Http\Controllers\Parametre\CountryController;
use App\Http\Controllers\Parametre\CompagnieController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('chauffeurs', ChauffeurController::class);
    Route::resource('vehicules', VehiculeController::class);
    Route::resource('departs', DepartController::class);
}); 

Route::middleware('auth')->name('parametre.')->prefix('parametre')->group(function (){
    //Route ressources
    Route::resource('countries', CountryController::class);
    Route::resource('genres', GenreController::class);
    Route::resource('marques', MarqueController::class);
    Route::resource('modeles', ModeleController::class);
    Route::resource('villes', VilleController::class);
    Route::resource('compagnies', CompagnieController::class);
});

require __DIR__.'/auth.php';
