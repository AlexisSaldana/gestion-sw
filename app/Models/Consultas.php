<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultas extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_pagar',
        'cita_id',
        'usuariomedicoid',
        'estado',
        'motivo',
        'talla',
        'temperatura',
        'saturacion_oxigeno',
        'frecuencia_cardiaca',
        'peso',
        'tension_arterial',
        'padecimiento',
        'enfermera_id',
    ];

    public function cita()
    {
        return $this->belongsTo(Citas::class, 'cita_id');
    }

    public function usuarioMedico()
    {
        return $this->belongsTo(User::class, 'usuariomedicoid');
    }

    public function enfermera()
    {
        return $this->belongsTo(User::class, 'enfermera_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Productos::class, 'consulta_producto', 'consulta_id', 'producto_id')
                    ->withPivot('cantidad');
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'consulta_servicio', 'consulta_id', 'servicio_id');
    }
}
