<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Service; // Assurez-vous d'importer le modèle Service
use Illuminate\Http\Request;
use Carbon\Carbon;

class DemandeController extends Controller
{
    public function create()
    {
        // Récupère la liste des services et la passe à la vue
        $services = Service::all();
        return view('demande', compact('services'));
    }

    public function store(Request $request)
    {
        // Valide les données du formulaire
        $validated = $request->validate([
            'description' => 'required|string',
            'date' => 'required|date',
            'services' => 'required|integer', // Attend un seul ID de service
            'tarif' => 'nullable|numeric',
        ]);

        // Crée et enregistre la demande dans la base de données
        $demande = Demande::create([
            'description_demande' => $validated['description'],
            'date_commande' => Carbon::parse($validated['date']),
            'prix' => $validated['tarif'] ?? null,
            'id' => auth()->id(), // ID de l'utilisateur authentifié
            'id_status' => 1, // Statut par défaut pour une nouvelle demande
        ]);

        // Associe la demande au service sélectionné
        $demande->services()->attach($validated['services']);

        // Redirige avec un message de succès
        return redirect()->route('demande')->with('success', 'Demande soumise avec succès.');
    }
}
