<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultas extends Model
{
    use HasFactory;

    protected $fillable = [
        'diagnostico',
        'receta',
        'total_pagar',
        'cita_id',
        'usuariomedicoid',
        'estado'
    ];

    public function cita()
    {
        return $this->belongsTo(Citas::class, 'cita_id');
    }

    public function usuarioMedico()
    {
        return $this->belongsTo(User::class, 'usuariomedicoid');
    }

    public function productos()
    {
        return $this->belongsToMany(Productos::class, 'consulta_producto', 'consulta_id', 'producto_id')->withPivot('cantidad');
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'consulta_servicio', 'consulta_id', 'servicio_id');
    }
}
