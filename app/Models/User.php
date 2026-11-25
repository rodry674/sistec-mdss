<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cargo',  // NUEVO: Agregado para el rol en la OTSI.
        'rol',    // NUEVO: Agregado ('jefe' o 'tecnico').
        'activo', // NUEVO: Estado del usuario.
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'activo' => 'boolean', // NUEVO: Casteado explícito para simplificar consultas.
    ];

    /**
     * RELACIÓN NUEVA: Un usuario puede haber registrado múltiples tickets de soporte.
     */
    public function ticketsRegistrados(): HasMany
    {
        return $this->hasMany(Ticket::class, 'registrado_por_user_id');
    }
}