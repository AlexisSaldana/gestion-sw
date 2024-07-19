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

        User::create([
            'nombres' => 'enfermera',
            'apepat' => 'enfermera',
            'apemat' => 'enfermera',
            'fechanac' => '2003-12-11',
            'telefono' => '123456789',
            'rol' => 'enfermera',
            'activo' => 'si',
            'email' => 'enfermera@enfermera.com',
            'password' => Hash::make('Enfermera123')
        ]);

        User::create([
            'nombres' => 'medico',
            'apepat' => 'medico',
            'apemat' => 'medico',
            'fechanac' => '2003-12-11',
            'telefono' => '123456789',
            'rol' => 'medico',
            'activo' => 'si',
            'email' => 'medico@medico.com',
            'password' => Hash::make('Medico123')
        ]);

        User::create([
            'nombres' => 'secretaria',
            'apepat' => 'secretaria',
            'apemat' => 'secretaria',
            'fechanac' => '2003-12-11',
            'telefono' => '8343041441',
            'rol' => 'secretaria',
            'activo' => 'si',
            'email' => 'secretaria@secretaria.com',
            'password' => Hash::make('Secretaria123')
        ]);

        // Crear un paciente
        Paciente::create([
            'nombres' => 'Alexis',
            'apepat' => 'Saldaña',
            'apemat' => 'Carvajal',
            'fechanac' => '2003-12-11',
            'telefono' => '8343041441',
            'activo' => 'si',
        ]);

        // Crear un servicio
        Productos::create([
            'nombre' => 'Ibuprofeno',
            'precio' => '30',
            'cantidad' => '10',
        ]);

        Productos::create([
            'nombre' => 'Paracetamol',
            'precio' => '20',
            'cantidad' => '15',
        ]);
        
        // Crear un producto
        Servicio::create([
            'nombre' => 'Rayos-x',
            'precio' => '300',
        ]);

        Servicio::create([
            'nombre' => 'Radiografías',
            'precio' => '150',
        ]);
    }
}
