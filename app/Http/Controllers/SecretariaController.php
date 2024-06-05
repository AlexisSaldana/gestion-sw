<?php

namespace App\Http\Controllers;
use App\Models\Paciente;
use App\Models\Productos;
use App\Models\Citas;

use Illuminate\Http\Request;

class SecretariaController extends Controller
{
    /**
     * Display the dashboard for medico.
     */
    public function index()
    {
        return view('/UsuarioSecretaria');
    }

/////////////////////////////////    PACIENTES    /////////////////////////////////////////

    // Guardar pacientes
    public function storePacientes(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'activo' => 'required|string|in:si,no',
        ]);

        Paciente::create([
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'activo' => $request->activo,
        ]);

        return redirect()->route('dashboardSecretaria')->with('status', 'Paciente registrado correctamente');
    }

    // Mostrar pacientes
    public function mostrarPacientes()
    {
        $pacientes = Paciente::all();
        return view('/secretaria.dashboardSecretaria', compact('pacientes'));
    }

    // Editar paciente (form)
    public function editarPaciente($id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('/secretaria.pacientes.editarPaciente', compact('paciente'));
    }

    // Actualizar paciente
    public function updatePaciente(Request $request, $id)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'activo' => 'required|string|in:si,no',
        ]);

        $paciente = Paciente::findOrFail($id);
        $paciente->update([
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'activo' => $request->activo,
        ]);

        return redirect()->route('dashboardSecretaria')->with('status', 'Paciente actualizado correctamente');
    }

    // Eliminar paciente
    public function eliminarPaciente($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->delete();

        return redirect()->route('dashboardSecretaria')->with('status', 'Paciente eliminado correctamente');
    }

/////////////////////////////////    PRODUCTOS    /////////////////////////////////////////

    // Mostrar productos
    public function mostrarProductos()
    {
        $productos = Productos::all();
        return view('/secretaria.productos.productos', compact('productos'));
    }

    // Guardar productos
    public function storeProductos(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0'
        ]);
    
        Productos::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio
        ]);

        return redirect()->route('productos')->with('status', 'Producto registrado correctamente');
    }

    // Ruta para agregar productos(form)
    public function crearProducto()
    {
        return view('/secretaria.productos.agregarProducto');
    }
    
    // Editar producto (form)
    public function editarProducto($id)
    {
        $producto = Productos::findOrFail($id);
        return view('/secretaria.productos.editarProducto', compact('producto'));
    }

    // Actualizar producto
    public function updateProducto(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0'
        ]);

        $producto = Productos::findOrFail($id);
        $producto->update([
            'nombre' => $request->nombre,
            'precio' => $request->precio
        ]);

        return redirect()->route('productos')->with('status', 'Producto actualizado correctamente');
    }

    // Eliminar producto
    public function eliminarProducto($id)
    {
        $producto = Productos::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos')->with('status', 'Producto eliminado correctamente');
    }

/////////////////////////////////    CITAS    /////////////////////////////////////////


    // Mostrar citas
    public function mostrarCitas()
    {
        $citas = Citas::all();
        return view('/secretaria.citas.citas', compact('citas'));
    }

    // Guardar citas
    public function storeCitas(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required|time',
            'estado' => 'required|varchar|max:50'
        ]);

            Citas::create([
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado' => $request->estado
        ]);

        return redirect()->route('citas')->with('status', 'Cita registrada correctamente');
    }
}
