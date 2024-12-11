<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Statut
 *
 * @property int $id_status
 * @property string $label
 *
 * @property Collection|Demande[] $demandes
 * @property Collection|Suivi[] $suivis
 */
class Statut extends Model
{
    // Nom de la table associée
    // protected $table = 'APP_statuts'; 
    protected $primaryKey = 'id_status'; // Clé primaire personnalisée
    public $timestamps = false; // Indique qu'il n'y a pas de colonnes created_at et updated_at

    // Champs modifiables via fillable
    protected $fillable = [
        'label'
    ];

    /**
     * Relation avec les demandes
     * Une statut peut être associé à plusieurs demandes
     */
    public function demandes()
    {
        return $this->hasMany(Demande::class, 'id_status', 'id_status');
    }

    /**
     * Relation avec les suivis
     * Un statut peut être associé à plusieurs suivis
     */
    public function suivis()
    {
        return $this->hasMany(Suivi::class, 'id_status', 'id_status');
    }

    /**
     * Relation avec les tickets
     * Si tu utilises un modèle Ticket et qu'il a une colonne id_status
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_status', 'id_status');
    }
}
