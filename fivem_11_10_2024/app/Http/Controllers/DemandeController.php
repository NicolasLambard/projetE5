<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande; 
use App\Models\Service; 
use Illuminate\Support\Facades\Auth;

class DemandeController extends Controller
{
    public function create()
    {
        $services = Service::all();
        return view('demande', compact('services'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description_demande' => 'required|string|max:255',
            'description_resultat' => 'required|string|max:255',
            'date_resultat' => 'required|date',
            'prix' => 'required|numeric',
        ]);

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

        return redirect()->back()->with('success', 'Demande créée avec succès.'); 
    }
}

