<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemandeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/services', function () {
    return view('services');
})->middleware(['auth', 'verified'])->name('services');

Route::get('/demande', [DemandeController::class, 'create'])->middleware(['auth', 'verified'])->name('demande'); // Route GET pour afficher le formulaire
Route::post('/soumettre-demande', [DemandeController::class, 'store'])->middleware(['auth', 'verified'])->name('demande.submit'); // Route POST pour soumettre le formulaire

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/update', [ProfileController::class, 'update'])->name('profile.update'); 
    Route::get('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy'); 
});

require __DIR__.'/auth.php';
