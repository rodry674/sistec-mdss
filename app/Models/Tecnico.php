<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $nombre
 * @property string $especialidad
 * @property string $email
 * @property bool $activo
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Ticket> $tickets
 */
final class Tecnico extends Model
{
    protected $fillable = [
        'nombre',
        'especialidad',
        'email',
        'activo',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'activo' => 'boolean', // MEJORA: Casteo explícito booleano.
    ];

    /**
     * Get the tickets attended by the technician.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}