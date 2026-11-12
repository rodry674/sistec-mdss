<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tecnico extends Model
{
    protected $fillable = ['nombre', 'especialidad', 'email', 'activo'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
