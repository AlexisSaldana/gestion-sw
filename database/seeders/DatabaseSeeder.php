<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Paciente;
use App\Models\Citas;
use App\Models\Productos;
use App\Models\Servicio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Monolog\Processor\ProcessIdProcessor;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Crear el usuario admin
        User::create([
            'nombres' => 'admin',
            'apepat' => 'admin',
            'apemat' => 'admin',
            'fechanac' => '2003-12-11',
            'telefono' => '8343041441',
            'rol' => 'admin',
            'activo' => 'si',
            'email' => 'admin@admin.com',
            'password' => Hash::make('Admin123')
        ]);

        // Crear un paciente
        $paciente = Paciente::create([
            'nombres' => 'Juan',
            'apepat' => 'Perez',
            'apemat' => 'Gomez',
            'fechanac' => '1990-05-21',
            'activo' => 'si',
        ]);

        // Crear una cita para el paciente
        Citas::create([
            'fecha' => '2024-07-15',
            'hora' => '10:00:00',
            'activo' => 'si',
            'pacienteid' => $paciente->id,
            'usuariomedicoid' => 1, // ID del médico usuario. Asegúrate de que este ID exista en tu tabla de usuarios.
        ]);

        // Crear un servicio
        Productos::create([
            'nombre' => 'Tijeras',
            'precio' => '30',
            'cantidad' => '10',
        ]);
        // Crear un producto
        Servicio::create([
            'nombre' => 'Rayos-x',
            'precio' => '30',
        ]);
    }
}
