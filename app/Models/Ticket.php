<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property \Illuminate\Support\Carbon|null $fecha_cierre
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read AreaMunicipal $areaMunicipal
 * @property-read Categoria $categoria
 * @property-read Tecnico|null $tecnico
 * @property-read User|null $registradoPor
 */
final class Ticket extends Model
{
    // Constantes para los estados del flujo de tickets.
    public const ESTADO_PENDIENTE = 'PENDIENTE';
    public const ESTADO_EN_PROCESO = 'EN PROCESO';
    public const ESTADO_ATENDIDO = 'ATENDIDO';

    protected $fillable = [
        'codigo_ticket',
        'descripcion_incidente',
        'area_municipal_id',
        'categoria_id',
        'tecnico_id',
        'registrado_por_user_id', // NUEVO: Se permite asignación masiva para el usuario que registra.
        'prioridad',
        'estado',
        'diagnostico_solucion',
        'fecha_cierre',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'fecha_cierre' => 'datetime',
    ];

    /**
     * Get the area that owns the ticket.
     */
    public function areaMunicipal(): BelongsTo
    {
        return $this->belongsTo(AreaMunicipal::class);
    }

    /**
     * Get the category that owns the ticket.
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Get the technician assigned to the ticket.
     */
    public function tecnico(): BelongsTo
    {
        return $this->belongsTo(Tecnico::class);
    }

    /**
     * NUEVA RELACIÓN: Get the user who registered the ticket.
     */
    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por_user_id');
    }
}