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
    // protected $table = 'APP_commentaires';
    protected $primaryKey = 'id_commentaire';

    public $timestamps = false;

    protected $fillable = [
        'description',
        'date',
        'valide',
        'id_demande',
        'id',
    ];

 public function demande()
    {
        return $this->belongsTo(Demande::class, 'id_demande');
    }

 public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

 public static function peutValider($user)
    {
        return $user && ($user->role->id_role === 1 || $user->role->id_role === 2);
    }
}