<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaMunicipal extends Model
{
    protected $table = 'area_municipals';

    protected $fillable = ['nombre', 'descripcion'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'area_id');
    }
}
