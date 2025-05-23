<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $email
 * @property Carbon $email_verified_at
 * @property string $telephone
 * @property string $name
 * @property string $password
 * @property string $remember_token
 * @property Carbon $create_at
 * @property Carbon $update_at
 * @property int $id_role
 * 
 * @property Role $role
 * @property Collection|Commentaire[] $commentaires
 * @property Collection|Demande[] $demandes
 *
 * @package App\Models
 */
class User extends Authenticatable

{
	// protected $table = 'APP_users';
	public $timestamps = true;


	const CREATED_AT = 'create_at'; 
    const UPDATED_AT = 'update_at';

	protected $casts = [
		'email_verified_at' => 'datetime',
		'create_at' => 'datetime',
		'update_at' => 'datetime',
		'id_role' => 'int'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'nom',
		'prenom',
		'email',
		'email_verified_at',
		'telephone',
		'name',
		'password',
		'remember_token',
		'create_at',
		'update_at',
		'id_role'
	];

	public function role()
{
    return $this->belongsTo(Role::class, 'id_role', 'id_role');
}


	public function commentaires()
	{
		return $this->hasMany(Commentaire::class, 'id');
	}

	public function demandes()
	{
		return $this->hasMany(Demande::class,'id');
	}

}
