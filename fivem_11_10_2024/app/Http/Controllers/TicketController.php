<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\ChatBoxLog;
use App\Models\Statut;
use App\Models\Ticket;
use App\Models\Commentaire;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Afficher les tickets de l'utilisateur ou tous les tickets si administrateur
     */
    public function index(Request $request)
    {
        $user = auth()->user();
    
        if (!$user) {
            abort(403, 'Vous devez être connecté pour accéder à cette page.');
        }
    
        $isAdmin = $user->role->id_role === 1 || $user->role->id_role === 2;
    
        $viewAll = $request->query('view', '') === 'all';
    
        if ($isAdmin && $viewAll) {
            $demandes = Demande::with('statut')->get(); 
        } else {
            $demandes = Demande::where('id', $user->id) 
                ->with('statut') 
                ->get();
        }
    
        return view('ticket', compact('demandes', 'viewAll', 'isAdmin'));
    }
    
    /**
     * Afficher tous les tickets pour les admins (rôle 1 et 2)
     */
    public function allTickets()
    {
        $user = auth()->user();
        
        if (!$user) {
            abort(403, 'Vous devez être connecté pour accéder à cette page.');
        }
        
        $isAdmin = $user->role->id_role === 1 || $user->role->id_role === 2;
        
        if (!$isAdmin) {
            abort(403, 'Vous n\'avez pas les permissions pour voir tous les tickets.');
        }
        
        $demandes = Demande::with('statut')->get();
        $viewAll = true;
        
        return view('ticket', compact('demandes', 'viewAll', 'isAdmin'));
    }

    /**
     * Afficher la chatbox pour une demande spécifique
     */
    public function chatbox($id)
    {
        if (!auth()->check()) {
            abort(403, 'Vous devez être connecté pour accéder à cette page.');
        }
    
        $user = auth()->user();
    
        $demande = Demande::with(['chatBoxLogs.user.role'])->findOrFail($id);
    
        if (!($user->role->id_role === 1 || $user->role->id_role === 2 || $user->id === $demande->id)) {
            abort(403, 'Vous n\'avez pas les permissions pour voir ce ticket.');
        }
    
        return view('chatbox', compact('demande'));
    }

    /**
     * Enregistrer un nouveau ticket
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
            'date_resultat' => 'required|date',
            'prix' => 'required|numeric',
        ]);

        Demande::create([
            'description_demande' => $validatedData['description'],
            'date_resultat' => $validatedData['date_resultat'],
            'prix' => $validatedData['prix'],
            'id_status' => 1, 
            'id' => auth()->id(), 
        ]);

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
    
        if (!($user->role->id_role === 1 || $user->role->id_role === 2 || $user->id === $demande->id)) {
            abort(403, 'Vous n\'êtes pas autorisé à envoyer un message sur ce ticket.');
        }
    
        $request->validate([
            'message' => 'required|string|max:255',
        ]);
    
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
    
        $statuts = Statut::all(['id_status', 'label']); 
    
        return view('edit', compact('demande', 'statuts'));
    }
    
    

    /**
     * Mettre à jour un ticket existant
     */
    public function update(Request $request, $id)
    {
        if (!auth()->check() || !(auth()->user()->role->id_role === 1 || auth()->user()->role->id_role === 2)) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier ce ticket.');
        }
    
        $validated = $request->validate([
            'description_demande' => 'required|string|max:255',
            'date_resultat' => 'required|date',
            'prix' => 'required|numeric|min:0',
            'id_status' => 'required|exists:statuts,id_status',
        ]);
    
        $demande = Demande::findOrFail($id);
    
        $demande->update($validated);
    
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

        try {
            // Désactiver temporairement les contraintes de clés étrangères
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            
            // Supprimer d'abord les commentaires associés
            $demande->commentaires()->delete();
            
            // Supprimer les logs de chatbox
            $demande->chatBoxLogs()->delete();
            
            // Supprimer les fichiers associés
            $demande->fichiers()->delete();
            
            // Supprimer les suivis associés
            $demande->suivis()->delete();
            
            // Supprimer directement la demande sans se soucier des relations many-to-many
            $demande->delete();
            
            // Réactiver les contraintes de clés étrangères
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            
            return redirect()->route('ticket')->with('success', 'Ticket supprimé avec succès.');
        } catch (\Exception $e) {
            // Réactiver les contraintes de clés étrangères en cas d'erreur
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            
            return redirect()->route('ticket')->with('error', 'Erreur lors de la suppression du ticket: ' . $e->getMessage());
        }
    }

    public function showTickets()
    {
        $user = auth()->user();

        if ($user->role->id_role === 1 || $user->role->id_role === 2) {
            $demandes = Demande::with('statut')->get();
        } else {
            $demandes = Demande::where('id_demande', $user->id)->with('statut')->get();
        }

        return view('ticket', compact('demandes'));
    }

    /**
     * Accepter une commande de ticket
     */
    public function accepterCommande(Request $request, $id)
    {
        if (!auth()->check()) {
            abort(403, 'Vous devez être connecté pour accepter une commande.');
        }
    
        $user = auth()->user();
        $demande = Demande::findOrFail($id);
    
        if ($user->id !== $demande->id) {
            abort(403, 'Vous n\'êtes pas autorisé à accepter cette commande.');
        }
    
        $validated = $request->validate([
            'commentaire' => 'nullable|string|max:255',
        ]);
    
        $demande->id_status = 2;
        $demande->save();
    
        $commentaireExistant = Commentaire::where('id_demande', $demande->id_demande)
            ->where('id', $user->id)
            ->exists();
        
        if (!empty($validated['commentaire']) && !$commentaireExistant) {
            $valide = Commentaire::peutValider($user) ? 1 : 0;
            
            Commentaire::create([
                'description' => htmlspecialchars($validated['commentaire']),
                'date' => now(),
                'valide' => $valide,
                'id_demande' => $demande->id_demande,
                'id' => $user->id,
            ]);
            
            $commentaireMessage = $valide 
                ? ' Votre commentaire a été ajouté.' 
                : ' Votre commentaire a été ajouté et sera visible après validation par un administrateur.';
        } else {
            $commentaireMessage = '';
        }
    
        ChatBoxLog::create([
            'description' => 'Commande acceptée par le client' . (!empty($validated['commentaire']) ? ' avec un commentaire' : ''),
            'date' => now(),
            'valide' => 1,
            'id_demande' => $demande->id_demande,
            'id' => $user->id,
        ]);
    
        return redirect()->route('ticket')->with('success', 'Commande acceptée avec succès !' . $commentaireMessage);
    }

    /**
     * Afficher les détails d'un ticket avec ses commentaires
     */
    public function details($id)
    {
        if (!auth()->check()) {
            abort(403, 'Vous devez être connecté pour voir les détails d\'un ticket.');
        }
    
        $user = auth()->user();
        $demande = Demande::with(['commentaires.user', 'statut', 'user'])->findOrFail($id);
    
        if (!($user->role->id_role === 1 || $user->role->id_role === 2 || $user->id === $demande->id)) {
            abort(403, 'Vous n\'êtes pas autorisé à voir les détails de ce ticket.');
        }
    
        return view('ticket.details', compact('demande'));
    }

    /**
     * Valider un commentaire (réservé aux administrateurs)
     */
    public function validerCommentaire($id_commentaire)
    {
        if (!auth()->check()) {
            abort(403, 'Vous devez être connecté pour valider un commentaire.');
        }
    
        $user = auth()->user();
    
        if (!Commentaire::peutValider($user)) {
            abort(403, 'Vous n\'avez pas les permissions pour valider des commentaires.');
        }
    
        $commentaire = Commentaire::findOrFail($id_commentaire);
        $commentaire->valide = 1;
        $commentaire->save();
    
        return redirect()->route('ticket.details', $commentaire->id_demande)
            ->with('success', 'Commentaire validé avec succès !');
    }
    
    /**
     * Supprimer un commentaire (réservé aux administrateurs)
     */
    public function supprimerCommentaire($id_commentaire)
    {
        if (!auth()->check()) {
            abort(403, 'Vous devez être connecté pour supprimer un commentaire.');
        }
    
        $user = auth()->user();
    
        if (!Commentaire::peutValider($user)) {
            abort(403, 'Vous n\'avez pas les permissions pour supprimer des commentaires.');
        }
    
        $commentaire = Commentaire::findOrFail($id_commentaire);
        $id_demande = $commentaire->id_demande;
        $commentaire->delete();
    
        return redirect()->route('ticket.details', $id_demande)
            ->with('success', 'Commentaire supprimé avec succès !');
    }

    /**
     * Afficher la liste des commentaires clients validés
     */
    public function listeCommentaires()
    {
        $user = auth()->user();
        $isAdmin = Commentaire::peutValider($user);
        

        if ($isAdmin) {
            $commentaires = Commentaire::with(['user', 'demande'])
                ->orderBy('date', 'desc')
                ->get();
                
            $nbCommentairesNonValides = $commentaires->where('valide', 0)->count();
        } else {

            $commentaires = Commentaire::with(['user', 'demande'])
                ->where('valide', 1)
                ->orderBy('date', 'desc')
                ->get();
                
            $mesCommentairesEnAttente = Commentaire::where('id', $user->id)
                ->where('valide', 0)
                ->with(['demande'])
                ->get();
                
            return view('commentaires', compact('commentaires', 'isAdmin', 'mesCommentairesEnAttente'));
        }
        
        return view('commentaires', compact('commentaires', 'isAdmin', 'nbCommentairesNonValides'));
    }

    /**
     * Ajouter ou mettre à jour un commentaire (réservé aux administrateurs)
     */
    public function ajouterCommentaireAdmin(Request $request, $id)
    {
        if (!auth()->check()) {
            abort(403, 'Vous devez être connecté pour ajouter un commentaire.');
        }
    
        $user = auth()->user();
        
        if (!Commentaire::peutValider($user)) {
            abort(403, 'Vous n\'avez pas les permissions pour ajouter un commentaire administrateur.');
        }
        
        $demande = Demande::findOrFail($id);
    
        $validated = $request->validate([
            'commentaire' => 'required|string|max:255',
        ]);
        
        $commentaireExistant = Commentaire::where('id_demande', $demande->id_demande)
            ->where('id', $user->id)
            ->first();
        
        if ($commentaireExistant) {
            $commentaireExistant->description = htmlspecialchars($validated['commentaire']);
            $commentaireExistant->date = now();
            $commentaireExistant->valide = 1;
            $commentaireExistant->save();
            
            return redirect()->route('ticket.details', $demande->id_demande)
                ->with('success', 'Commentaire administrateur mis à jour avec succès !');
        } else {
            Commentaire::create([
                'description' => htmlspecialchars($validated['commentaire']),
                'date' => now(),
                'valide' => 1,
                'id_demande' => $demande->id_demande,
                'id' => $user->id,
            ]);
            
            return redirect()->route('ticket.details', $demande->id_demande)
                ->with('success', 'Commentaire administrateur ajouté avec succès !');
        }
    }
}

