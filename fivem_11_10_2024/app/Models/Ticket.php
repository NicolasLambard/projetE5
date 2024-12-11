<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class Ticket extends Model
// {
//     // Spécifie le nom exact de la table
//     // protected $table = 'APP_demandes';

//     // Si la clé primaire de la table est "id_demande"
//     protected $primaryKey = 'id_demande';

//     // Si la table n'utilise pas created_at et updated_at
//     public $timestamps = false;

//     // Les colonnes pouvant être modifiées par assignation massive
//     protected $fillable = [
//         'description',
//         'date',
//         'valide',
//         'id_demande',
//         'id',
//     ];

//     // Relation avec le modèle Status (si elle existe)
//     public function status()
//     {
//         return $this->belongsTo(Status::class, 'id_status', 'id_status'); // Assure-toi que la table status existe
//     }

//     // Relation avec le modèle User (si chaque demande appartient à un utilisateur)
//     public function user()
//     {
//         return $this->belongsTo(User::class, 'user_id', 'id'); // Ajoute "user_id" dans ta table si nécessaire
// //     }
// }
