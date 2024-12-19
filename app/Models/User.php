<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\RegistraActividad;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, RegistraActividad;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cedula',
        'role_id',
        'status',
        'apellido',
        'telefono',
        'username',
        'activo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'activo' => 'boolean',
    ];

    /**
     * Get the role that the user belongs to.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if the user has a specific role.
     *
     * @param string $roleName
     * @return bool
     */
    public function hasRole($roleName): bool
    {
        if (is_string($this->role)) {
            return $this->role === $roleName;
        }
        return $this->role && $this->role->nombre === $roleName;
    }

    /**
     * Buscar usuarios por cédula.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $tipoCedula
     * @param  string  $numeroCedula
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBuscarPorCedula($query, $tipoCedula, $numeroCedula)
    {
        // Aseguramos que la búsqueda sea exacta incluyendo el tipo de cédula
        return $query->where('cedula', $tipoCedula . $numeroCedula);
    }
}
