<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

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
        try {
            Log::info('Iniciando validación de datos');
            $validatedData = $request->validate([
                'nombres' => 'required|string|max:255',
                'apepat' => 'required|string|max:255',
                'apemat' => 'required|string|max:255',
                'fechanac' => 'required|date',
                'telefono' => 'required|string|max:15',
            ]);
    
            Log::info('Datos validados correctamente', $validatedData);
            $paciente = Paciente::create($validatedData);
    
            Log::info('Paciente creado correctamente');
            return redirect()->route('dashboardSecretaria')->with('status', 'Paciente registrado correctamente');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación', ['errors' => $e->errors()]);
            return redirect()->route('dashboardSecretaria')->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error al registrar el paciente', ['message' => $e->getMessage()]);
            return redirect()->route('dashboardSecretaria')->with('error', 'Error al registrar el paciente');
        }
    }
    
    // Actualiza la información de un paciente específico
    public function updatePaciente(Request $request, $id)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'telefono' => 'required|string|max:15',
        ]);
    
        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->all());
    
        return redirect()->route('dashboardSecretaria')->with('status', 'Paciente actualizado correctamente');
    }
    
    // Marca a un paciente como inactivo (eliminado)
    public function eliminarPaciente($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->update(['activo' => 'no']);
    
        return redirect()->route('dashboardSecretaria')->with('status', 'Paciente eliminado correctamente');
    }

    // Muestra todos los pacientes activos
    public function mostrarPacientes(Request $request)
    {
        $query = Paciente::where('activo', 'si');

        // Filtros de búsqueda
        if ($request->has('busqueda') && $request->busqueda != '') {
            $terms = explode(' ', $request->busqueda);
            $query->where(function($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->orWhere('nombres', 'like', '%' . $term . '%')
                      ->orWhere('apepat', 'like', '%' . $term . '%')
                      ->orWhere('apemat', 'like', '%' . $term . '%')
                      ->orWhere('telefono', 'like', '%' . $term . '%');
                }
            });
        }

        $pacientes = $query->get();
        $totalPacientesActivos = Paciente::where('activo', 'si')->count(); // Contar pacientes activos
        $totalCitasActivas = Citas::where('activo', 'si')->count(); // Contar citas activas
        $totalUsuariosActivos = User::where('activo', 'si')
                                     ->whereIn('rol', ['medico', 'secretaria','enfermera'])
                                     ->count(); // Contar usuarios activos con roles de médico y secretaria
        
        return view('/secretaria.dashboardSecretaria', compact('pacientes', 'totalPacientesActivos', 'totalCitasActivas', 'totalUsuariosActivos'));
    }

    // Muestra el formulario de edición de un paciente específico
    public function editarPaciente($id)
    {
        $paciente = Paciente::findOrFail($id);
        return response()->json($paciente);
    }
}
