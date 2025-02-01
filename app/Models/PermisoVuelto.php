<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermisoVuelto extends Model
{
    protected $table = 'permisos_vuelto';

    protected $fillable = [
        'user_id',
        'permiso_p2p',
        'permiso_homebanking',
        'modificado_por'
    ];

    protected $casts = [
        'permiso_p2p' => 'boolean',
        'permiso_homebanking' => 'boolean'
    ];

    /**
     * Obtiene el usuario al que pertenece este permiso
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
