<?php

namespace App\Http\Controllers;

use App\Models\Consultas;
use App\Models\Citas;
use App\Models\Productos;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Http\Request;

class ConsultasController extends Controller
{
    // Mostrar las citas pendientes para tomar una consulta
    public function index()
    {
        $citas = Citas::where('activo', 'si')->with(['paciente', 'usuarioMedico', 'consulta'])->get();
        return view('secretaria.consultas.consultas', compact('citas'));
    }

    // Mostrar el formulario para crear una nueva consulta
    public function create($citaId)
    {
        $cita = Citas::with('paciente')->findOrFail($citaId);
        $productos = Productos::where('activo', 'si')->get();
        $servicios = Servicio::where('activo', 'si')->get();
        $enfermeras = User::where('rol', 'enfermera')->where('activo', 'si')->get();
        return view('secretaria.consultas.crearConsulta', compact('cita', 'productos', 'servicios', 'enfermeras'));
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
