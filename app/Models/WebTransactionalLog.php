<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebTransactionalLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'module',
        'description',
        'details',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'details' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
