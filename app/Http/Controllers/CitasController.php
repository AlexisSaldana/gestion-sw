<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Citas;
use App\Models\Paciente;
use Carbon\Carbon; // Asegúrate de importar Carbon

class CitasController extends Controller
{
    // Muestra todas las citas activas
    public function mostrarCitas()
    {
        // Actualizar citas pasadas
        $this->actualizarCitasPasadas();

        $citas = Citas::where('activo', 'si')->get();
        $pacientes = Paciente::where('activo', 'si')->get();
        $usuario = auth()->user(); // Obtiene el usuario autenticado
        return view('secretaria.citas.citas', compact('citas', 'pacientes', 'usuario'));
    }

    // Función para actualizar citas pasadas
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

    // Guarda una nueva cita
    public function storeCitas(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'fecha' => 'required|date',
            'hora' => ['required', 'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/'],
            'pacienteid' => 'required|exists:pacientes,id',
            'usuariomedicoid' => 'required|exists:users,id'
        ]);

        // Verificar si ya existe una cita para la misma fecha y hora que esté activa
        $existeCita = Citas::where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->where('usuariomedicoid', $request->usuariomedicoid)
            ->where('activo', 'si')
            ->exists();

        if ($existeCita) {
            return redirect()->back()->withErrors(['fecha' => 'Ya existe una cita agendada para esta fecha y hora con el mismo médico.'])->withInput();
        }

        // Creación de la cita
        Citas::create($request->all());

        // Redirecciona a la vista de citas con un mensaje de éxito
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

    // Muestra el formulario de edición de una cita específica
    public function editarCita($id)
    {
        $cita = Citas::findOrFail($id);
        return response()->json($cita);
    }

    // Actualiza la información de una cita específica
    public function updateCita(Request $request, $id)
    {
        // Validación de los datos recibidos
        $request->validate([
            'fecha' => 'required|date',
            'hora' => ['required', 'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/'],
            'paciente_id' => 'required|exists:pacientes,id',
            'usuariomedicoid' => 'required|exists:users,id'
        ]);

        // Verificar si ya existe una cita para la misma fecha y hora, excluyendo la cita actual y considerando solo las activas
        $existeCita = Citas::where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->where('usuariomedicoid', $request->usuariomedicoid)
            ->where('id', '!=', $id)
            ->where('activo', 'si')
            ->exists();

        if ($existeCita) {
            return redirect()->back()->withErrors(['fecha' => 'Ya existe una cita agendada para esta fecha y hora con el mismo médico.'])->withInput();
        }

        // Encuentra la cita y actualiza sus datos
        $cita = Citas::findOrFail($id);
        $cita->update($request->all());

        // Redirecciona a la vista de citas con un mensaje de éxito
        return redirect()->route('citas')->with('status', 'Cita actualizada correctamente');
    }

    // Marca una cita como inactiva (eliminada)
    public function eliminarCita($id)
    {
        $cita = Citas::findOrFail($id);
        $cita->update(['activo' => 'no']);

        return redirect()->route('citas')->with('status', 'Cita eliminada correctamente');
    }
}
