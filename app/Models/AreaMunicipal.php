<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Collection<int, Ticket> $tickets
 */
final class AreaMunicipal extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
