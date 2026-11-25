<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $nombre
 * @property int $sla_horas_defecto
 * @property string $prioridad_defecto
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Ticket> $tickets
 */
final class Categoria extends Model
{
    // MEJORA: Constantes para valores predefinidos (evita strings mágicos).
    public const PRIORIDAD_ALTA = 'ALTA';
    public const PRIORIDAD_MEDIA = 'MEDIA';
    public const PRIORIDAD_BAJA = 'BAJA';

    protected $fillable = [
        'nombre',
        'sla_horas_defecto',
        'prioridad_defecto',
    ];

    /**
     * Get the tickets associated with the category.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}