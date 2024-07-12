<?php

namespace App\Http\Controllers;

use App\Models\Consultas;
use App\Models\Citas;
use App\Models\Productos;
use App\Models\Servicio;
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
        $cita = Citas::findOrFail($citaId);
        $productos = Productos::where('activo', 'si')->get();
        $servicios = Servicio::where('activo', 'si')->get();
        return view('secretaria.consultas.crearConsulta', compact('cita', 'productos', 'servicios'));
    }

    public function store(Request $request, $citaId)
    {
        $request->validate([
            'diagnostico' => 'required|string',
            'receta' => 'nullable|string',
            'total_pagar' => 'required|numeric',
            'estado' => 'required|in:En proceso,Finalizado',
            'productos' => 'nullable|array',
            'productos.*' => 'exists:productos,id',
            'cantidades_productos' => 'nullable|array',
            'cantidades_productos.*' => 'integer|min:1',
            'servicios' => 'nullable|array',
            'servicios.*' => 'exists:servicios,id',
        ]);
    
        $consulta = Consultas::create([
            'diagnostico' => $request->input('diagnostico'),
            'receta' => $request->input('receta'),
            'total_pagar' => $request->input('total_pagar'),
            'cita_id' => $citaId,
            'usuariomedicoid' => auth()->id(),
            'estado' => $request->input('estado'),
        ]);
    
        // Adjuntar productos y servicios si existen
        if ($request->has('productos')) {
            $productos = $request->input('productos');
            $cantidades = $request->input('cantidades_productos', []);
            foreach ($productos as $index => $productoId) {
                $cantidad = $cantidades[$index] ?? 1; // Por defecto la cantidad es 1 si no está definida
                $consulta->productos()->attach($productoId, ['cantidad' => $cantidad]);
            }
        }
    
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
        return view('secretaria.consultas.editarConsulta', compact('consulta', 'productos', 'servicios'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'diagnostico' => 'required|string',
            'receta' => 'nullable|string',
            'total_pagar' => 'required|numeric',
            'estado' => 'required|in:En proceso,Finalizado',
            'productos' => 'nullable|array',
            'productos.*' => 'exists:productos,id',
            'cantidades_productos' => 'nullable|array',
            'cantidades_productos.*' => 'integer|min:1',
            'servicios' => 'nullable|array',
            'servicios.*' => 'exists:servicios,id',
        ]);
    
        $consulta = Consultas::findOrFail($id);
        $consulta->update($request->only(['diagnostico', 'receta', 'total_pagar', 'estado']));
    
        // Actualización de productos
        $productos = $request->input('productos', []);
        $cantidades = $request->input('cantidades_productos', []);
        $productosSyncData = [];
    
        foreach ($productos as $index => $productoId) {
            if (isset($cantidades[$index])) {
                $productosSyncData[$productoId] = ['cantidad' => $cantidades[$index]];
            }
        }
    
        $consulta->productos()->sync($productosSyncData);
    
        // Actualización de servicios
        $consulta->servicios()->sync($request->input('servicios', []));
    
        return redirect()->route('consultas.index')->with('success', 'Consulta actualizada exitosamente');
    }
    
}
