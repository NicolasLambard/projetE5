<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatBoxLog extends Model
{
   // protected $table = 'APP_ChatBoxLogs';

    
    protected $primaryKey = 'id_ticket';  // Clé primaire
    public $timestamps = false; // Désactive la gestion automatique des colonnes created_at et updated_at

// Cela protège contre l'injection de données non autorisées sinon laravel autorise rien
    protected $fillable = [
        'description',
        'date',
        'valide',
        'id_demande',
        'id',
    ];

// Relation avec le modèle Demande via la clé étrangère id_demande
public function demande()
    {
        return $this->belongsTo(Demande::class, 'id_demande');
    }
    
// Relation avec le modèle User via la clé étrangère id
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
