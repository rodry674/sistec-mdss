<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'codigo',
        'solicitante',
        'area_id',
        'categoria_id',
        'tecnico_id',
        'titulo',
        'descripcion',
        'prioridad',
        'sla_horas',
        'estado',
        'diagnostico',
        'solucion',
        'fecha_cierre',
    ];

    protected $casts = [
        'fecha_cierre' => 'datetime',
    ];

    public function areaMunicipal()
    {
        return $this->belongsTo(AreaMunicipal::class, 'area_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class, 'tecnico_id');
    }
}
