<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ServicesDemande
 * 
 * @property int $id_service
 * @property int $id_demande
 * 
 * @property Demande $demande
 * @property Service $service
 * @property Collection|Suivi[] $suivis
 *
 * @package App\Models
 */
class ServicesDemande extends Model
{
	protected $table = 'services_demandes';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_service' => 'int',
		'id_demande' => 'int'
	];

	public function demande()
	{
		return $this->belongsTo(Demande::class, 'id_demande');
	}

	public function service()
	{
		return $this->belongsTo(Service::class, 'id_service');
	}

	public function suivis()
	{
		return $this->hasMany(Suivi::class, 'id_service_services_demandes');
	}
}
