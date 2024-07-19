<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Citas;
use App\Models\Paciente;
use App\Models\User;
use Carbon\Carbon;

class CitasController extends Controller
{
    public function mostrarCitas(Request $request)
    {
        $query = Citas::query();
    
        // Filtros de búsqueda
        if ($request->has('busqueda') && $request->busqueda != '') {
            $terms = explode(' ', $request->busqueda);
            $query->where(function($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->orWhere('usuariomedicoid', 'like', '%' . $term . '%');
                    $q->orWhere('pacienteid', 'like', '%' . $term . '%');
                    $q->orWhere('fecha', 'like', '%' . $term . '%');
                }
            });
        }
    
        $this->actualizarCitasPasadas();
    
        $citas = Citas::where('activo', 'si')->get();
        $pacientes = Paciente::where('activo', 'si')->get();
        $medicos = User::Where('rol', 'medico')->get();
    
        $totalCitasActivas = Citas::where('activo', 'si')->count();
        $totalPacientesActivos = Paciente::where('activo', 'si')->count();
        $totalUsuariosActivos = User::where('activo', 'si')
                                    ->whereIn('rol', ['medico', 'secretaria','enfermera'])
                                    ->count();
        $usuario = auth()->user();
    
        $citas = $query->where('activo', 'si')->get();
    
        return view('secretaria.citas.citas', compact('citas', 'usuario', 'pacientes', 'medicos', 'totalCitasActivas', 'totalPacientesActivos', 'totalUsuariosActivos'));
    }
    
    private function actualizarCitasPasadas()
    {
        $now = Carbon::now();
        Citas::where('fecha', '<', $now->toDateString())
            ->orWhere(function ($query) use ($now) {
                $query->where('fecha', '=', $now->toDateString())
                      ->where('hora', '<', $now->toTimeString());
            })
            ->where('activo', 'si')
            ->update(['activo' => 'no']);
    }

    public function storeCitas(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora' => ['required', 'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/'],
            'pacienteid' => 'required|exists:pacientes,id',
            'usuariomedicoid' => 'required|exists:users,id'
        ]);
    
        $fechaCita = Carbon::parse($request->fecha)->startOfDay();
        $today = Carbon::today()->startOfDay();
    
        if ($fechaCita->eq($today)) {
            return redirect()->back()->withErrors(['fecha' => 'No se pueden crear citas para el mismo día.'])->withInput();
        }
    
        $existeCita = Citas::where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->where('usuariomedicoid', $request->usuariomedicoid)
            ->where('activo', 'si')
            ->exists();
    
        if ($existeCita) {
            return redirect()->back()->withErrors(['fecha' => 'Ya existe una cita agendada para esta fecha y hora con el mismo médico.'])->withInput();
        }
    
        Citas::create($request->all());
    
        return redirect()->route('citas')->with('success', 'Cita registrada correctamente');
    }
    
    public function updateCita(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora' => ['required', 'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/'],
        ]);
    
        $cita = Citas::findOrFail($id);
    
        $fechaCita = Carbon::parse($request->fecha);
        $today = Carbon::today();
    
        if ($fechaCita->eq($today)) {
            return redirect()->back()->withErrors(['fecha' => 'No se pueden editar citas para el mismo día.'])->withInput();
        }
    
        $existeCita = Citas::where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->where('usuariomedicoid', $request->usuariomedicoid)
            ->where('id', '!=', $id)
            ->where('activo', 'si')
            ->exists();
    
        if ($existeCita) {
            return redirect()->back()->withErrors(['fecha' => 'Ya existe una cita agendada para esta fecha y hora con el mismo médico.'])->withInput();
        }
    
        $cita->update($request->all());
        
        return redirect()->route('citas')->with('success', 'Cita actualizada correctamente');
    }
    
    public function eliminarCita($id)
    {
        $cita = Citas::findOrFail($id);
        $cita->update(['activo' => 'no']);
    
        return redirect()->route('citas')->with('success', 'Cita eliminada correctamente');
    }
    
    
    public function getEvents()
    {
        $citas = Citas::with(['paciente', 'usuarioMedico'])->where('activo', 'si')->get();
        
        // Map the appointments to event data
        $events = $citas->map(function ($cita) {
            return [
                'event_date' => $cita->fecha,
                'event_title' => $cita->paciente->nombres . ' ' . $cita->paciente->apepat,
                'event_time' => $cita->hora,
            ];
        });

        return response()->json($events);
    }

    public function editarCita($id)
    {
        $cita = Citas::findOrFail($id);
        
        return response()->json($cita);
    }    
}
