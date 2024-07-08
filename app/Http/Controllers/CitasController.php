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
    public function mostrarCitas()
    {
        $this->actualizarCitasPasadas();
    
        $citas = Citas::where('activo', 'si')->get();
        $pacientes = Paciente::where('activo', 'si')->get();
        $totalCitasActivas = Citas::where('activo', 'si')->count();
        $totalPacientesActivos = Paciente::where('activo', 'si')->count();
        $totalUsuariosActivos = User::where('activo', 'si')
                                     ->whereIn('rol', ['medico', 'secretaria','colaborador'])
                                     ->count();
        $usuario = auth()->user();
        
        return view('secretaria.citas.citas', compact('citas','usuario', 'pacientes', 'totalCitasActivas', 'totalPacientesActivos', 'totalUsuariosActivos'));
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

        $existeCita = Citas::where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->where('usuariomedicoid', $request->usuariomedicoid)
            ->where('activo', 'si')
            ->exists();

        if ($existeCita) {
            return redirect()->back()->withErrors(['fecha' => 'Ya existe una cita agendada para esta fecha y hora con el mismo médico.'])->withInput();
        }

        Citas::create($request->all());

        return redirect()->route('citas')->with('status', 'Cita registrada correctamente');
    }

    public function getEvents()
    {
        $citas = Citas::with(['paciente', 'usuarioMedico'])->where('activo', 'si')->get();
        $events = $citas->map(function ($cita) {
            return [
                'event_date' => $cita->fecha,
                'event_title' => $cita->paciente->nombres . ' ' . $cita->paciente->apepat,
                'event_time' => $cita->hora,
                'event_theme' => 'blue'
            ];
        });

        return response()->json($events);
    }

    public function editarCita($id)
    {
        $cita = Citas::findOrFail($id);
        return response()->json($cita);
    }

    public function updateCita(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora' => ['required', 'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/'],
            'paciente_id' => 'required|exists:pacientes,id',
            'usuariomedicoid' => 'required|exists:users,id'
        ]);

        $existeCita = Citas::where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->where('usuariomedicoid', $request->usuariomedicoid)
            ->where('id', '!=', $id)
            ->where('activo', 'si')
            ->exists();

        if ($existeCita) {
            return redirect()->back()->withErrors(['fecha' => 'Ya existe una cita agendada para esta fecha y hora con el mismo médico.'])->withInput();
        }

        $cita = Citas::findOrFail($id);
        $cita->update($request->all());

        return redirect()->route('citas')->with('status', 'Cita actualizada correctamente');
    }

    public function eliminarCita($id)
    {
        $cita = Citas::findOrFail($id);
        $cita->update(['activo' => 'no']);

        return redirect()->route('citas')->with('status', 'Cita eliminada correctamente');
    }
}
