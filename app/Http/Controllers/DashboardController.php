<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Citas;
use App\Models\Paciente;
use App\Models\User;
use App\Models\Consultas;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPacientesActivos = Paciente::where('activo', 'si')->count();
        $totalCitasActivas = Citas::where('activo', 'si')->count();
        $totalUsuariosActivos = User::where('activo', 'si')
                                     ->whereIn('rol', ['medico', 'secretaria', 'enfermera'])
                                     ->count();        
        $totalPagadoFinalizado = Consultas::where('estado', 'Finalizado')->sum('total_pagar');
    
        // Obtener el total de citas por día usando el campo 'fecha'
        $totalCitasPorDia = Citas::selectRaw('fecha as date, COUNT(*) as total')
            ->where('activo', 'si')
            ->groupBy('fecha')
            ->get();
    
        // Obtener el total pagado por día basado en la fecha de la cita asociada y el estado "Finalizado"
        $totalPagadoPorDia = Consultas::join('citas', 'consultas.cita_id', '=', 'citas.id')
            ->selectRaw('citas.fecha as date, SUM(consultas.total_pagar) as total')
            ->where('consultas.estado', 'Finalizado')
            ->groupBy('citas.fecha')
            ->get();
    
        // Obtener el total de pacientes registrados por día
        $totalPacientesPorDia = Paciente::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('activo', 'si')
            ->groupBy('date')
            ->get();
        
        // Preparar los datos para la vista en formato JSON
        $citasData = $totalCitasPorDia->map(function($item) {
            return [
                'date' => Carbon::parse($item->date)->format('Y-m-d'),
                'total' => $item->total,
            ];
        });
    
        $pagadoData = $totalPagadoPorDia->map(function($item) {
            return [
                'date' => Carbon::parse($item->date)->format('Y-m-d'),
                'total' => $item->total,
            ];
        });
    
        $pacientesData = $totalPacientesPorDia->map(function($item) {
            return [
                'date' => Carbon::parse($item->date)->format('Y-m-d'),
                'total' => $item->total,
            ];
        });
    
        $citasDataJson = json_encode($citasData);
        $pagadoDataJson = json_encode($pagadoData);
        $pacientesDataJson = json_encode($pacientesData);
        
        return view('dashboard', compact(
            'totalPacientesActivos',
            'totalCitasActivas',
            'totalUsuariosActivos',
            'citasDataJson',
            'pagadoDataJson',
            'pacientesDataJson',
            'totalPagadoFinalizado'
        ));
    }
    
    
}
