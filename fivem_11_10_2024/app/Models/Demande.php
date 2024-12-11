<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\ChatBox;



/**
 * Class Demande
 * 
 * @property int $id_demande
 * @property string $description_demande
 * @property Carbon $date_commande
 * @property string $description_resultat
 * @property Carbon $date_resultat
 * @property float $prix
 * @property Carbon $date_travail
 * @property int $id
 * @property int $id_status
 * 
 * @property Statut $statut
 * @property User $user
 * @property Collection|Commentaire[] $commentaires
 * @property Collection|Fichier[] $fichiers
 * @property Collection|Service[] $services
 * @property Collection|Suivi[] $suivis
 *
 * @package App\Models
 */
class Demande extends Model
{
    
    protected $primaryKey = 'id_demande';
    public $timestamps = false;

    protected $casts = [
        'date_commande' => 'datetime',
        'date_resultat' => 'datetime',
        'prix' => 'float',
        'date_travail' => 'datetime',
    ];

    protected $attributes = [
        'id_status' => 1, // Statut "en cours" par défaut
    ];
    

    protected $fillable = [
        'description_demande',
        'date_commande',
        'description_resultat',
        'date_resultat',
        'prix',
        'date_travail',
        'id',
        'id_status'
    ];
    
//  Relation avec le modèle User via la clé étrangère `id`

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
//  Relation avec le modèle User via la clé étrangère `id`
    public function statut()
    {
        return $this->belongsTo(Statut::class, 'id_status', 'id_status');
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'id_demande');
    }

    public function fichiers()
    {
        return $this->hasMany(Fichier::class, 'id_demande');
    }
// Relation avec le modèle Services via la clé étrangère id_demande
    public function services()
    {
        return $this->belongsToMany(Service::class, 'APP_services_demandes', 'id_demande', 'id_service');
    }
    public function chatBoxLogs()
    {
        return $this->hasMany(ChatBoxLog::class, 'id_demande', 'id_demande');
    }
    

    public function suivis()
    {
        return $this->hasMany(Suivi::class, 'id_demande');
    }
}