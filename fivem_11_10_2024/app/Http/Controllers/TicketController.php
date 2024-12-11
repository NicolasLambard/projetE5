<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\ChatBoxLog;
use App\Models\Statut;
use App\Models\Ticket;

class TicketController extends Controller
{
    /**
     * Afficher les tickets de l'utilisateur ou tous les tickets si administrateur
     */
    public function index(Request $request)
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();
    
        if (!$user) {
            abort(403, 'Vous devez être connecté pour accéder à cette page.');
        }
    
        // Vérifier si l'utilisateur a un rôle admin
        $isAdmin = $user->role->id_role === 1 || $user->role->id_role === 2;
    
        // Vérifier si l'administrateur souhaite voir tous les tickets via le paramètre GET 'view=all'
        $viewAll = $request->query('view', '') === 'all';
    
        // Charger les demandes selon le rôle
        if ($isAdmin && $viewAll) {
            // Administrateurs : voir toutes les demandes
            $demandes = Demande::with('statut')->get(); // Charger la relation 'statut'
        } else {
            // Utilisateurs pour voir ses propres demandes 
            $demandes = Demande::where('id', $user->id) // Filtrer par l'utilisateur connecté
                ->with('statut') // Charger la relation 'statut' qui est de base a 'en cours'
                ->get();
        }
    
        // Retourner la vue 
        return view('ticket', compact('demandes', 'viewAll', 'isAdmin'));
    }
    


    


    /**
     * Afficher la chatbox pour une demande spécifique
     */
    public function chatbox($id)
    {
        // Vérifie si l'utilisateur est connecté
        if (!auth()->check()) {
            abort(403, 'Vous devez être connecté pour accéder à cette page.');
        }
    
        $user = auth()->user();
    
        // Récupérer la demande avec les logs, utilisateurs, et leurs rôles associés
        $demande = Demande::with(['chatBoxLogs.user.role'])->findOrFail($id);
    
        // Vérifie si l'utilisateur est autorisé à accéder à cette demande
        if (!($user->role->id_role === 1 || $user->role->id_role === 2 || $user->id === $demande->user_id)) {
            abort(403, 'Vous n\'avez pas les permissions pour voir ce ticket.');
        }
    
        // Retourne la vue de la chatbox avec la demande
        return view('chatbox', compact('demande'));
    }

    /**
     * Enregistrer un nouveau ticket
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
            'date_resultat' => 'required|date',
            'prix' => 'required|numeric',
        ]);

        // Créer une nouvelle demande
        Demande::create([
            'description_demande' => $validatedData['description'],
            'date_resultat' => $validatedData['date_resultat'],
            'prix' => $validatedData['prix'],
            'id_status' => 1, // Par exemple, définir un statut par défaut
            'user_id' => auth()->id(), // Associer la demande à l'utilisateur connecté
        ]);

        // Rediriger avec un message de succès
        return redirect()->route('ticket')->with('success', 'Ticket créé avec succès.');
    }

    /**
     * Envoyer un message dans la chatbox
     */
    public function sendMessage(Request $request, $id)
    {
        if (!auth()->check()) {
            abort(403, 'Vous devez être connecté pour envoyer un message.');
        }
    
        $user = auth()->user();
        $demande = Demande::findOrFail($id);
    
        // Vérifie si l'utilisateur est autorisé à accéder à cette demande
        if (!($user->role->id_role === 1 || $user->role->id_role === 2 || $user->id === $demande->user_id)) {
            abort(403, 'Vous n\'êtes pas autorisé à envoyer un message sur ce ticket.');
        }
    
        $request->validate([
            'message' => 'required|string|max:255',
        ]);
    
        // Enregistre le message
        ChatBoxLog::create([
            'description' => $request->message,
            'id_demande' => $demande->id_demande,
            'id' => $user->id,
            'valide' => 1,
            'date' => now(),
        ]);
    
        return redirect()->route('chatbox', $demande->id_demande)->with('success', 'Message envoyé avec succès !');
    }

    /**
     * Afficher le formulaire d'édition d'un ticket
     */
    public function edit($id)
    {
        $demande = Demande::findOrFail($id);
    
        if (!auth()->check() || !(auth()->user()->role->id_role === 1 || auth()->user()->role->id_role === 2)) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier ce ticket.');
        }
    
        // Récupérer les statuts pour la liste déroulante
        $statuts = Statut::all(['id_status', 'label']); // Assure-toi que 'label' est la bonne colonne pour le nom
    
        return view('edit', compact('demande', 'statuts'));
    }
    
    

    /**
     * Mettre à jour un ticket existant
     */
    public function update(Request $request, $id)
    {
        // Vérification des autorisations avant toute modification
        if (!auth()->check() || !(auth()->user()->role->id_role === 1 || auth()->user()->role->id_role === 2)) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier ce ticket.');
        }
    
        // Validation des données
        $validated = $request->validate([
            'description_demande' => 'required|string|max:255',
            'date_resultat' => 'required|date',
            'prix' => 'required|numeric|min:0',
            'id_status' => 'required|exists:statuts,id_status', // Statut valide
        ]);
    
        // Récupérer la demande
        $demande = Demande::findOrFail($id);
    
        // Mise à jour des données
        $demande->update($validated);
    
        // Redirection avec message de succès
        return redirect()->route('ticket')->with('success', 'Le ticket a été modifié avec succès.');
    }
    
    /**
     * Supprimer un ticket
     */
    public function destroy($id)
{
    $demande = Demande::findOrFail($id);

    if (!auth()->user()->role || !(auth()->user()->role->id_role === 1 || auth()->user()->role->id_role === 2)) {
        abort(403, 'Vous n\'êtes pas autorisé à supprimer ce ticket.');
    }

    $demande->chatBoxLogs()->delete();

    $demande->delete();

    return redirect()->route('ticket')->with('success', 'Ticket supprimé avec succès.');
}

    /**
     * Méthode redondante, peut être supprimée si non utilisée
     */
    public function showTickets()
    {
        $user = auth()->user();

        if ($user->role->id_role === 1 || $user->role->id_role === 2) {
            // Les administrateurs voient toutes les demandes
            $demandes = Demande::with('statut')->get();
        } else {
            // Les utilisateurs normaux voient uniquement leurs demandes
            $demandes = Demande::where('id_demande', $user->id)->with('statut')->get();
        }

        // Retourne la vue avec la variable $demandes
        return view('ticket', compact('demandes'));
    }
}

