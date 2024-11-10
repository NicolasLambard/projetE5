<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Suivi
 * 
 * @property int $id_suivi
 * @property string $status_commande
 * @property Carbon $date_suivi
 * @property string $message
 * @property bool $auteur_client
 * @property int $id_demande
 * @property int $id_status
 * @property int|null $id_service_APP_services_demandes
 * @property int|null $id_demande_APP_services_demandes
 * 
 * @property Demande $demande
 * @property ServicesDemande|null $services_demande
 * @property Statut $statut
 *
 * @package App\Models
 */
class Suivi extends Model
{
	// protected $table = 'APP_suivis';
	protected $primaryKey = 'id_suivi';
	public $timestamps = false;

	protected $casts = [
		'date_suivi' => 'datetime',
		'auteur_client' => 'bool',
		'id_demande' => 'int',
		'id_status' => 'int',
		'id_service_APP_services_demandes' => 'int',
		'id_demande_APP_services_demandes' => 'int'
	];

	protected $fillable = [
		'status_commande',
		'date_suivi',
		'message',
		'auteur_client',
		'id_demande',
		'id_status',
		'id_service_APP_services_demandes',
		'id_demande_APP_services_demandes'
	];

	public function demande()
	{
		return $this->belongsTo(Demande::class, 'id_demande');
	}

	public function services_demande()
	{
		return $this->belongsTo(ServicesDemande::class, 'id_service_APP_services_demandes')
					->where('APP_services_demandes.id_service', '=', 'APP_suivis.id_service_APP_services_demandes')
					->where('APP_services_demandes.id_demande', '=', 'APP_suivis.id_demande_APP_services_demandes');
	}

	public function statut()
	{
		return $this->belongsTo(Statut::class, 'id_status');
	}
}
