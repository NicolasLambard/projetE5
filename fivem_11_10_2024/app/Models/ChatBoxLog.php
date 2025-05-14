<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatBoxLog extends Model
{
   // protected $table = 'APP_ChatBoxLogs';

    
    protected $primaryKey = 'id_ticket'; 
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
}
