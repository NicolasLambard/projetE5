<?php

/**
 * Created by Reliese Model.
 */

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
 *
 * @package App\Models
 */
class Statut extends Model
{
	protected $table = 'APP_statuts';
	protected $primaryKey = 'id_status';
	public $timestamps = false;

	protected $fillable = [
		'label'
	];

	public function demandes()
	{
		return $this->hasMany(Demande::class, 'id_status');
	}

	public function suivis()
	{
		return $this->hasMany(Suivi::class, 'id_status');
	}
}
