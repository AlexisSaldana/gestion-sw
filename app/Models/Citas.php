<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    use HasFactory;

    // Los campos aqui se asignan
    protected $fillable = [
        'fecha',
        'hora',
        'activo',
        'pacienteid',
        'usuariomedicoid'
    ];

    // Relación con el modelo Paciente
    // Una cita pertenece a un paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'pacienteid');
    }

    // Relación con el modelo User (medico)
    // Una cita pertenece a un médico usuario
    public function usuarioMedico()
    {
        return $this->belongsTo(User::class, 'usuariomedicoid');
    }
    
    // Definir la relación con el modelo Consultas
    public function consulta()
    {
        return $this->hasOne(Consultas::class, 'cita_id');
    }
    
    // Relación con el modelo User (enfermera)
    public function enfermera()
    {
        return $this->hasOneThrough(User::class, Consultas::class, 'cita_id', 'id', 'id', 'enfermera_id');
    }
    
}
