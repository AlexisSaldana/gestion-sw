<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'hora',
        'activo',
        'pacienteid',
        'usuariomedicoid'
    ];

    // Relación con el modelo Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'pacienteid');
    }

    // Relación con el modelo User (medico)
    public function usuarioMedico()
    {
        return $this->belongsTo(User::class, 'usuariomedicoid');
    }
}
