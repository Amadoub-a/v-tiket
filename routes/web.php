<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
});

//Route::namespace('Parametre')->middleware('auth')->name('parametre.')->prefix('parametre')->group(function () {
Route::namespace('Parametre')->name('parametre.')->prefix('parametre')->group(function () {
    Route::resource('countries', 'CountryController');
    //Route::get('countries/store', 'CountryController@store');
});

require __DIR__.'/auth.php';
