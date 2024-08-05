<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Consultas;
use App\Models\Citas;
use App\Models\Productos;
use App\Models\Servicio;
use App\Models\User;
use Dompdf\Dompdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ConsultasController extends Controller
{

    // Método para descargar el PDF
    public function downloadPDF($id)
    {
        $consulta = Consultas::with(['cita', 'cita.paciente', 'cita.usuarioMedico', 'productos' => function($query) {
            $query->withPivot('cantidad');
        }, 'servicios'])->findOrFail($id);

        $html = view('secretaria.consultas.pdf', compact('consulta'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('consulta_' . $consulta->id . '.pdf');
    }

    // Método para manejar la descarga por código
    public function descargarPorCodigo(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string',
        ]);
    
        try {
            $consulta = Consultas::where('codigo', $request->codigo)->firstOrFail();
            return $this->downloadPDF($consulta->id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Código incorrecto, por favor intente de nuevo.');
        }
    }
    
    public function show($id)
    {
        try {
            $consulta = Consultas::with(['cita.paciente', 'cita.usuarioMedico', 'enfermera'])->findOrFail($id);
    
            $data = [
                'medico' => $consulta->cita->usuarioMedico ? $consulta->cita->usuarioMedico->nombres . ' ' . $consulta->cita->usuarioMedico->apepat : 'No asignado',
                'paciente' => $consulta->cita->paciente ? $consulta->cita->paciente->nombres . ' ' . $consulta->cita->paciente->apepat . ' ' . $consulta->cita->paciente->apemat : 'No asignado',
                'fecha' => $consulta->cita->fecha ?? 'No asignada',
                'hora' => $consulta->cita->hora ?? 'No asignada',
                'estado' => $consulta->estado ?? 'No asignado',
                'motivo' => $consulta->motivo ?? 'No asignado',
                'talla' => $consulta->talla ?? 'No asignada',
                'temperatura' => $consulta->temperatura ?? 'No asignada',
                'saturacion_oxigeno' => $consulta->saturacion_oxigeno ?? 'No asignada',
                'frecuencia_cardiaca' => $consulta->frecuencia_cardiaca ?? 'No asignada',
                'peso' => $consulta->peso ?? 'No asignado',
                'tension_arterial' => $consulta->tension_arterial ?? 'No asignada',
                'padecimiento' => $consulta->padecimiento ?? 'No asignado',
                'total_pagar' => $consulta->total_pagar ?? 0.0,
                'enfermera' => $consulta->enfermera ? $consulta->enfermera->nombres . ' ' . $consulta->enfermera->apepat : 'No asignada',
            ];
    
            return response()->json($data);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Mostrar las citas pendientes para tomar una consulta
    public function index(Request $request)
    {
        $query = Citas::query()->with(['paciente', 'usuarioMedico', 'consulta']);
    
        // Filtros de búsqueda por términos
        if ($request->has('busqueda') && $request->busqueda != '') {
            $terms = explode(' ', $request->busqueda);
            $query->where(function($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->orWhereHas('usuarioMedico', function($q) use ($term) {
                        $q->where('nombres', 'like', '%' . $term . '%')
                          ->orWhere('apepat', 'like', '%' . $term . '%');
                    });
                    $q->orWhereHas('paciente', function($q) use ($term) {
                        $q->where('nombres', 'like', '%' . $term . '%')
                          ->orWhere('apepat', 'like', '%' . $term . '%')
                          ->orWhere('apemat', 'like', '%' . $term . '%');
                    });
                }
            });
        }
    
        // Filtro por fecha
        if ($request->has('fecha') && $request->fecha != '') {
            $query->where('fecha', '=', $request->fecha);
        } else {
            // Filtro por defecto desde hoy en adelante
            $query->where('fecha', '>=', Carbon::today()->toDateString());
        }
    
        // Filtro por estado
        if ($request->has('estado') && $request->estado != '') {
            $estado = $request->estado == 'en proceso' ? 'En proceso' : 'Finalizado';
            $query->whereHas('consulta', function($q) use ($estado) {
                $q->where('estado', $estado);
            });
        }
    
        // Ordenar por fecha
        $query->orderBy('fecha', 'asc');
    
        $citas = $query->get();
    
        return view('secretaria.consultas.consultas', compact('citas'));
    }
    
    // Mostrar el formulario para crear una nueva consulta
    public function create($citaId)
    {
        $consulta = Consultas::where('cita_id', $citaId)->first(); // Asumiendo que existe una relación así
        $cita = Citas::with('paciente')->findOrFail($citaId);
        $productos = Productos::where('activo', 'si')->get();
        $servicios = Servicio::where('activo', 'si')->get();
        $enfermeras = User::where('rol', 'enfermera')->where('activo', 'si')->get();
        return view('secretaria.consultas.crearConsulta', compact('cita', 'productos', 'servicios', 'enfermeras', 'consulta'));
    }

    public function store(Request $request, $citaId)
    {
        $request->validate([
            'motivo' => 'nullable|string|max:1000',
            'total_pagar' => 'required|numeric',
            'estado' => 'required|in:En proceso,Finalizado',
            'talla' => 'nullable|string|max:1000',
            'temperatura' => 'nullable|string|max:1000',
            'saturacion_oxigeno' => 'nullable|string|max:1000',
            'frecuencia_cardiaca' => 'nullable|string|max:1000',
            'peso' => 'nullable|string|max:1000',
            'tension_arterial' => 'nullable|string|max:1000',
            'padecimiento' => 'nullable|string|max:1000',
            'enfermera_id' => 'nullable|exists:users,id',
            'productos' => 'nullable|array',
            'productos.*' => 'exists:productos,id',
            'cantidades_productos' => 'nullable|array',
            'cantidades_productos.*' => 'integer|min:1',
            'servicios' => 'nullable|array',
            'servicios.*' => 'exists:servicios,id',
        ]);
    
        $consulta = Consultas::create([
            'motivo' => $request->input('motivo'),
            'total_pagar' => $request->input('total_pagar'),
            'cita_id' => $citaId,
            'usuariomedicoid' => auth()->id(),
            'estado' => $request->input('estado'),
            'talla' => $request->input('talla'),
            'temperatura' => $request->input('temperatura'),
            'saturacion_oxigeno' => $request->input('saturacion_oxigeno'),
            'frecuencia_cardiaca' => $request->input('frecuencia_cardiaca'),
            'peso' => $request->input('peso'),
            'tension_arterial' => $request->input('tension_arterial'),
            'padecimiento' => $request->input('padecimiento'),
            'enfermera_id' => $request->input('enfermera_id'),
        ]);
    
        // Adjuntar productos si existen
        if ($request->has('productos')) {
            $productos = $request->input('productos');
            $cantidades = $request->input('cantidades_productos', []);
            foreach ($productos as $index => $productoId) {
                $cantidad = $cantidades[$index] ?? 1;
                $consulta->productos()->attach($productoId, [
                    'cantidad' => $cantidad,
                ]);
            }
        }
    
        // Adjuntar servicios si existen
        if ($request->has('servicios')) {
            $consulta->servicios()->attach($request->input('servicios'));
        }
    
        return redirect()->route('consultas.index')->with('success', 'Consulta creada exitosamente');
    }

    // Mostrar el formulario para editar una consulta existente
    public function edit($id)
    {
        $consulta = Consultas::findOrFail($id);
        $productos = Productos::where('activo', 'si')->get();
        $servicios = Servicio::where('activo', 'si')->get();
        $enfermeras = User::where('rol', 'enfermera')->where('activo', 'si')->get();
        return view('secretaria.consultas.editarConsulta', compact('consulta', 'productos', 'servicios', 'enfermeras'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'motivo' => 'nullable|string|max:1000',
            'total_pagar' => 'required|numeric',
            'estado' => 'required|in:En proceso,Finalizado',
            'talla' => 'nullable|string|max:1000',
            'temperatura' => 'nullable|string|max:1000',
            'saturacion_oxigeno' => 'nullable|string|max:1000',
            'frecuencia_cardiaca' => 'nullable|string|max:1000',
            'peso' => 'nullable|string|max:1000',
            'tension_arterial' => 'nullable|string|max:1000',
            'padecimiento' => 'nullable|string|max:1000',
            'enfermera_id' => 'nullable|exists:users,id',
            'productos' => 'nullable|array',
            'productos.*' => 'exists:productos,id',
            'cantidades_productos' => 'nullable|array',
            'cantidades_productos.*' => 'integer|min:1',
            'servicios' => 'nullable|array',
            'servicios.*' => 'exists:servicios,id',
        ]);

        $consulta = Consultas::findOrFail($id);
        $consulta->update($request->only([
            'motivo', 'total_pagar', 'estado', 'talla', 'temperatura', 
            'saturacion_oxigeno', 'frecuencia_cardiaca', 'peso', 'tension_arterial', 'padecimiento', 'enfermera_id'
        ]));

        // Actualización de productos
        $productosExistentes = $request->input('productos_existentes', []);
        $cantidadesExistentes = $request->input('cantidades_existentes', []);
        $productosNuevos = $request->input('productos', []);
        $cantidadesNuevas = $request->input('cantidades_productos', []);
        $productosSyncData = [];

        foreach ($productosExistentes as $index => $productoId) {
            $cantidad = $cantidadesExistentes[$index] ?? 1;
            $productosSyncData[$productoId] = [
                'cantidad' => $cantidad,
            ];
        }

        foreach ($productosNuevos as $index => $productoId) {
            $cantidad = $cantidadesNuevas[$index] ?? 1;
            if (isset($productosSyncData[$productoId])) {
                $productosSyncData[$productoId]['cantidad'] += $cantidad;
            } else {
                $productosSyncData[$productoId] = [
                    'cantidad' => $cantidad,
                ];
            }
        }

        $consulta->productos()->sync($productosSyncData);

        // Actualización de servicios
        $serviciosExistentes = $request->input('servicios_existentes', []);
        $serviciosNuevos = $request->input('servicios', []);
        $serviciosSyncData = array_merge($serviciosExistentes, $serviciosNuevos);

        $consulta->servicios()->sync($serviciosSyncData);

        return redirect()->route('consultas.index')->with('success', 'Consulta actualizada exitosamente');
    }
}
