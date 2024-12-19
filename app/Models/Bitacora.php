<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Modulo;

class Bitacora extends Model
{
    protected $table = 'bitacora';

    protected $fillable = [
        'user_id',
        'usuario',
        'modulo_id',
        'accion',
        'detalles',
        'datos_nuevos',
        'ip',
        'user_agent'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'datos_nuevos' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function modulo(): BelongsTo
    {
        return $this->belongsTo(Modulo::class);
    }
}
