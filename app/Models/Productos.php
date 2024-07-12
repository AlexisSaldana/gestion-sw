<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'precio',
        'cantidad',
        'activo',
    ];

    public function consultas()
    {
        return $this->belongsToMany(Consultas::class, 'consulta_producto');
    }
}
