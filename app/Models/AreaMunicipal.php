<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Ticket> $tickets
 */
final class AreaMunicipal extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Get the tickets associated with the area.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}