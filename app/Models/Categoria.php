<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $nombre
 * @property int $sla_horas_defecto
 * @property string $prioridad_defecto
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Collection<int, Ticket> $tickets
 */
final class Categoria extends Model
{
    public const PRIORIDAD_ALTA = 'ALTA';

    public const PRIORIDAD_MEDIA = 'MEDIA';

    public const PRIORIDAD_BAJA = 'BAJA';

    protected $fillable = [
        'nombre',
        'sla_horas_defecto',
        'prioridad_defecto',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
