<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Commentaire
 * 
 * @property int $id_commentaire
 * @property string $description
 * @property Carbon $date
 * @property bool $valide
 * @property int $id_demande
 * @property int $id
 * 
 * @property Demande $demande
 * @property User $user
 *
 * @package App\Models
 */	
class Commentaire extends Model
{
    // Nom de la table
    // protected $table = 'APP_commentaires';

    // Clé primaire
    protected $primaryKey = 'id_commentaire';

// Désactive la gestion automatique des colonnes created_at et updated_at
    public $timestamps = false;

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

// Relation avec le modèle User via la clé étrangère id_demande
 public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}