<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servicio;

class ServiciosController extends Controller
{
    // Muestra todos los servicios activos
    public function mostrarServicios()
    {
        // Obtiene todos los servicios que están activos
        $servicios = Servicio::where('activo', 'si')->get();
        return view('/secretaria.servicios.servicios', compact('servicios'));
    }

    // Guarda un nuevo servicio
    public function storeServicios(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        // Creación del servicio
        Servicio::create($request->all());

        // Redirecciona a la vista de servicios con un mensaje de éxito
        return redirect()->route('servicios')->with('status', 'Servicio registrado correctamente');
    }

    // Muestra el formulario de edición de un servicio específico
    public function editarServicio($id)
    {
        // Encuentra el servicio por su ID
        $servicio = Servicio::findOrFail($id);
        return response()->json($servicio);
    }

    // Actualiza la información de un servicio específico
    public function updateServicio(Request $request, $id)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        // Encuentra el servicio y actualiza sus datos
        $servicio = Servicio::findOrFail($id);
        $servicio->update($request->all());

        // Redirecciona a la vista de servicios con un mensaje de éxito
        return redirect()->route('servicios')->with('status', 'Servicio actualizado correctamente');
    }

    // Marca a un servicio como inactivo (eliminado)
    public function eliminarServicio($id)
    {
        // Encuentra el servicio por su ID y marca como inactivo
        $servicio = Servicio::findOrFail($id);
        $servicio->update(['activo' => 'no']);

        // Redirecciona a la vista de servicios con un mensaje de éxito
        return redirect()->route('servicios')->with('status', 'Servicio eliminado correctamente');
    }
}
