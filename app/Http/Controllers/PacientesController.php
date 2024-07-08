<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Citas;
use App\Models\User;

class PacientesController extends Controller
{
    // Guarda un nuevo paciente
    public function storePacientes(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
        ]);

        // Creación del paciente
        Paciente::create($request->all());

        // Redirecciona a la vista del dashboard de la secretaria con un mensaje de éxito
        return redirect()->route('dashboardSecretaria')->with('status', 'Paciente registrado correctamente');
    }

    // Muestra todos los pacientes activos
    public function mostrarPacientes()
    {
        $pacientes = Paciente::where('activo', 'si')->get();
        $totalPacientesActivos = Paciente::where('activo', 'si')->count(); // Contar pacientes activos
        $totalCitasActivas = Citas::where('activo', 'si')->count(); // Contar citas activas
        $totalUsuariosActivos = User::where('activo', 'si')
                                     ->whereIn('rol', ['medico', 'secretaria','colaborador'])
                                     ->count(); // Contar usuarios activos con roles de médico y secretaria
        
        return view('/secretaria.dashboardSecretaria', compact('pacientes', 'totalPacientesActivos', 'totalCitasActivas', 'totalUsuariosActivos'));
    }

    // Muestra el formulario de edición de un paciente específico
    public function editarPaciente($id)
    {
        $paciente = Paciente::findOrFail($id);
        return response()->json($paciente);
    }

    // Actualiza la información de un paciente específico
    public function updatePaciente(Request $request, $id)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
        ]);

        // Encuentra el paciente y actualiza sus datos
        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->all());

        // Redirecciona al dashboard con un mensaje de éxito
        return redirect()->route('dashboardSecretaria')->with('status', 'Paciente actualizado correctamente');
    }

    // Marca a un paciente como inactivo (eliminado)
    public function eliminarPaciente($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->update(['activo' => 'no']);

        return redirect()->route('dashboardSecretaria')->with('status', 'Paciente eliminado correctamente');
    }
}
