<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande; // Import de la classe Demande
use App\Models\Service; // Import de la classe Service
use Illuminate\Support\Facades\Auth;

class DemandeController extends Controller
{
    // Méthode pour afficher le formulaire
    public function create()
    {
        $services = Service::all();
        return view('demande', compact('services'));
    }
    
    // Méthode pour enregistrer une demande
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description_demande' => 'required|string|max:255',
            'description_resultat' => 'required|string|max:255',
            'date_resultat' => 'required|date',
            'prix' => 'required|numeric',
        ]);

        // Créer la demande + add dans la BDD
        Demande::create([
            'description_demande' => $validated['description_demande'], 
            'date_commande' => now(),
            'description_resultat' => $validated['description_resultat'],
            'date_resultat' => $validated['date_resultat'],
            'prix' => $validated['prix'],
            'date_travail' => now(),
            'id' => Auth::id(),
            'id_status' => 1,
        ]);

        return redirect()->back()->with('success', 'Demande créée avec succès.'); // message qui affiche comme quoi la demande est crée
    }
}

