<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'precio',
        'activo',
    ];

    public function consultas()
    {
        return $this->belongsToMany(Consultas::class, 'consulta_servicio');
    }
}
