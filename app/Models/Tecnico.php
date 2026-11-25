<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $nombre
 * @property string $especialidad
 * @property string $email
 * @property bool $activo
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Collection<int, Ticket> $tickets
 */
final class Tecnico extends Model
{
    protected $fillable = [
        'nombre',
        'especialidad',
        'email',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}