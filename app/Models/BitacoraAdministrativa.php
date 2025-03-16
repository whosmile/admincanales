<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class BitacoraAdministrativa extends Model
{
    protected $table = 'bitacora_administrativa';

    protected $fillable = [
        'user_id',
        'usuario',
        'accion',
        'modulo',
        'detalles',
        'ip',
        'user_agent'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
