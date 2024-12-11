<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Class Service
 * 
 * @property int $id_service
 * @property string $nom_service
 * @property string $description_service
 * @property float $prix
 * 
 * @property Collection|Demande[] $demandes
 *
 * @package App\Models
 */
class Service extends Model
{
	// protected $table = 'APP_services';
	protected $primaryKey = 'id_service';
	public $timestamps = false;
	use HasFactory;

	protected $casts = [
		'prix' => 'float'
	];

	protected $fillable = [
		'nom_service',
		'description_service',
		'prix'
	];

	

	public function demandes()
	{
		return $this->belongsToMany(Demande::class, 'APP_services_demandes', 'id_service', 'id_demande');
	}
}
