<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Fichier
 * 
 * @property int $id_fichier
 * @property string $nom_fichier
 * @property string $commentaire_fichier
 * @property Carbon $date_depot
 * @property bool $auteur_client
 * @property int $id_demande
 * 
 * @property Demande $demande
 *
 * @package App\Models
 */
class Fichier extends Model
{
	protected $table = 'APP_fichiers';
	protected $primaryKey = 'id_fichier';
	public $timestamps = false;

	protected $casts = [
		'date_depot' => 'datetime',
		'auteur_client' => 'bool',
		'id_demande' => 'int'
	];

	protected $fillable = [
		'nom_fichier',
		'commentaire_fichier',
		'date_depot',
		'auteur_client',
		'id_demande'
	];

	public function demande()
	{
		return $this->belongsTo(Demande::class, 'id_demande');
	}
}
