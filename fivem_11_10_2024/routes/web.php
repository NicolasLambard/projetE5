<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;

// Accueil
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Tickets
Route::get('/ticket', [TicketController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('ticket');

Route::post('/ticket/{id}', [TicketController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->name('ticket.update');

Route::get('/ticket/{id}/chatbox', [TicketController::class, 'chatbox'])
    ->middleware(['auth', 'verified'])
    ->name('chatbox');

Route::post('/ticket/{id}/send-message', [TicketController::class, 'sendMessage'])
    ->middleware(['auth', 'verified'])
    ->name('ticket.sendMessage'); // Correspond a la fonction dans ticketController 

Route::get('/ticket/{id}/edit', [TicketController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->name('ticket.edit');

Route::put('/ticket/{id}', [TicketController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->name('ticket.update');

Route::delete('/ticket/{id}', [TicketController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('ticket.destroy');

Route::get('/ticketall', [TicketController::class, 'allTickets'])
    ->middleware(['auth', 'verified', 'can:see-all-tickets'])
    ->name('ticket.all');

// Demandes
Route::get('/demande', function () {
    $services = Service::all();
    return view('demande', compact('services'));
})->middleware(['auth', 'verified'])->name('demandes.create');

Route::post('/demande', [DemandeController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('demandes.store');

Route::get('/demande/{id}/chatbox', [TicketController::class, 'chatbox'])
    ->middleware(['auth', 'verified'])
    ->name('chatbox');

Route::post('/demande/{id}/send-message', [TicketController::class, 'sendMessage'])
    ->middleware(['auth', 'verified'])
    ->name('sendMessage');

// Services
Route::get('/services', function () {
    return view('services');
})->middleware(['auth', 'verified'])->name('services');

// Profile utilisateur
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentification
require __DIR__.'/auth.php';
