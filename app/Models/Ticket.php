<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $codigo_ticket
 * @property string $descripcion_incidente
 * @property int $area_municipal_id
 * @property int $categoria_id
 * @property int|null $tecnico_id
 * @property int|null $registrado_por_user_id
 * @property string $prioridad
 * @property string $estado
 * @property string|null $diagnostico_solucion
 * @property Carbon|null $fecha_cierre
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read AreaMunicipal $areaMunicipal
 * @property-read Categoria $categoria
 * @property-read Tecnico|null $tecnico
 * @property-read User|null $registradoPor
 */
final class Ticket extends Model
{
    public const ESTADO_PENDIENTE = 'PENDIENTE';

    public const ESTADO_EN_PROCESO = 'EN PROCESO';

    public const ESTADO_ATENDIDO = 'ATENDIDO';

    protected $fillable = [
        'codigo_ticket',
        'descripcion_incidente',
        'area_municipal_id',
        'categoria_id',
        'tecnico_id',
        'registrado_por_user_id',
        'prioridad',
        'estado',
        'diagnostico_solucion',
        'fecha_cierre',
    ];

    protected $casts = [
        'fecha_cierre' => 'datetime',
    ];

    public function areaMunicipal(): BelongsTo
    {
        return $this->belongsTo(AreaMunicipal::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function tecnico(): BelongsTo
    {
        return $this->belongsTo(Tecnico::class);
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por_user_id');
    }
}
