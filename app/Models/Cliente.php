<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserLimit;

class Cliente extends Model
{
    protected $fillable = [
        'cedula',
        'nombre',
        'email',
        'telefono',
        'status',
        'ultimo_login'
    ];

    public function limits()
    {
        return $this->hasOne(UserLimit::class, 'cedula', 'cedula');
    }
}
