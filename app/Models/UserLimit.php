<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLimit extends Model
{
    protected $fillable = [
        'cedula',
        'limite_delsur',
        'limite_otros'
    ];

    protected $casts = [
        'limite_delsur' => 'decimal:2',
        'limite_otros' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'cedula', 'cedula');
    }
}
