<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
    ->name('ticket.sendMessage'); 

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
    ->middleware(['auth', 'verified'])
    ->name('ticket.all');

Route::post('/ticket/{id}/accepter', [TicketController::class, 'accepterCommande'])
    ->middleware(['auth', 'verified'])
    ->name('ticket.accepter');


Route::get('/ticket/{id}/details', [TicketController::class, 'details'])
    ->middleware(['auth', 'verified'])
    ->name('ticket.details');

Route::post('/commentaire/{id_commentaire}/valider', [TicketController::class, 'validerCommentaire'])
    ->middleware(['auth', 'verified'])
    ->name('commentaire.valider');

Route::delete('/commentaire/{id_commentaire}', [TicketController::class, 'supprimerCommentaire'])
    ->middleware(['auth', 'verified'])
    ->name('commentaire.supprimer');

Route::post('/ticket/{id}/commentaire-admin', [TicketController::class, 'ajouterCommentaireAdmin'])
    ->middleware(['auth', 'verified'])
    ->name('ticket.commentaire.admin');

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

Route::get('/services', function () {
    return view('services');
})->middleware(['auth', 'verified'])->name('services');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/commentaires', [TicketController::class, 'listeCommentaires'])
    ->middleware(['auth', 'verified'])
    ->name('commentaires');
