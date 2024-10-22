<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * 
 * @property int $id_role
 * @property string $nom
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Role extends Model
{
	protected $table = 'APP_roles';
	protected $primaryKey = 'id_role';
	public $timestamps = false;

	protected $fillable = [
		'nom'
	];

	public function users()
	{
		return $this->hasMany(User::class, 'id_role');
	}
}
