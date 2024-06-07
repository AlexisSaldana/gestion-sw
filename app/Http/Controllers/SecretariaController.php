<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Productos;
use App\Models\User;
use App\Models\Citas;
use App\Models\Servicio;
use Illuminate\Http\Request;

class SecretariaController extends Controller
{
    public function index()
    {
        return view('/UsuarioSecretaria');
    }

    //////////////////////////////////    PACIENTES    /////////////////////////////////////////

    // Guardar pacientes
    public function storePacientes(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
        ]);

        Paciente::create($request->all());

        return redirect()->route('dashboardSecretaria')->with('status', 'Paciente registrado correctamente');
    }

    // Mostrar pacientes
    public function mostrarPacientes()
    {
        $pacientes = Paciente::where('activo', 'si')->get();
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
        ]);

        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->all());

        return redirect()->route('dashboardSecretaria')->with('status', 'Paciente actualizado correctamente');
    }

    // Eliminar paciente
    public function eliminarPaciente($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->update(['activo' => 'no']);

        return redirect()->route('dashboardSecretaria')->with('status', 'Paciente eliminado correctamente');
    }

    //////////////////////////////////    PRODUCTOS    /////////////////////////////////////////

    // Mostrar productos
    public function mostrarProductos()
    {
        $productos = Productos::where('activo', 'si')->get();
        return view('/secretaria.productos.productos', compact('productos'));
    }

    // Guardar productos
    public function storeProductos(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        Productos::create($request->all());

        return redirect()->route('productos')->with('status', 'Producto registrado correctamente');
    }

    // Ruta para agregar productos (form)
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
            'precio' => 'required|numeric|min:0',
        ]);

        $producto = Productos::findOrFail($id);
        $producto->update($request->all());

        return redirect()->route('productos')->with('status', 'Producto actualizado correctamente');
    }

    // Eliminar producto
    public function eliminarProducto($id)
    {
        $producto = Productos::findOrFail($id);
        $producto->update(['activo' => 'no']);

        return redirect()->route('productos')->with('status', 'Producto eliminado correctamente');
    }

    //////////////////////////////////    CITAS    /////////////////////////////////////////

    // Mostrar citas
    public function mostrarCitas()
    {
        $citas = Citas::where('activo', 'si')->get();
        return view('/secretaria.citas.citas', compact('citas'));
    }

    // Guardar citas
    public function storeCitas(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora' => ['required', 'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/'],
            'pacienteid' => 'required|exists:pacientes,id',
            'usuariomedicoid' => 'required|exists:users,id'
        ]);

        Citas::create($request->all());

        return redirect()->route('citas')->with('status', 'Cita registrada correctamente');
    }

    // Ruta para agregar citas (form)
    public function crearCita()
    {
        $pacientes = Paciente::where('activo', 'si')->get();
        $usuarios = User::where('activo', 'si')->get();
        return view('/secretaria.citas.agregarCita', compact('pacientes', 'usuarios'));
    }

    // Editar cita (form)
    public function editarCita($id)
    {
        $cita = Citas::findOrFail($id);
        $pacientes = Paciente::where('activo', 'si')->get();
        $usuarios = User::where('activo', 'si')->get();
        return view('/secretaria.citas.editarCita', compact('cita', 'pacientes', 'usuarios'));
    }

    // Actualizar cita
    public function updateCita(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora' => ['required', 'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/'],
            'pacienteid' => 'required|exists:pacientes,id',
            'usuariomedicoid' => 'required|exists:users,id'
        ]);

        $cita = Citas::findOrFail($id);
        $cita->update($request->all());

        return redirect()->route('citas')->with('status', 'Cita actualizada correctamente');
    }

    // Eliminar cita
    public function eliminarCita($id)
    {
        $cita = Citas::findOrFail($id);
        $cita->update(['activo' => 'no']);

        return redirect()->route('citas')->with('status', 'Cita eliminada correctamente');
    }

    //////////////////////////////////    MEDICOS    /////////////////////////////////////////

    // Mostrar medicos
    public function mostrarMedicos()
    {
        $medicos = User::where('rol', 'medico')->where('activo', 'si')->get();
        return view('/secretaria.medicos.medicos', compact('medicos'));
    }

    // Guardar medicos
    public function storeMedicos(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'telefono' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol' => 'medico',
        ]);

        return redirect()->route('medicos')->with('status', 'Médico registrado correctamente');
    }

    // Ruta para agregar medicos (form)
    public function crearMedico()
    {
        return view('/secretaria.medicos.agregarMedico');
    }

    // Editar medico (form)
    public function editarMedico($id)
    {
        $medico = User::findOrFail($id);
        return view('/secretaria.medicos.editarMedico', compact('medico'));
    }

    // Actualizar medico
    public function updateMedico(Request $request, $id)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'telefono' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $medico = User::findOrFail($id);
        $medico->update([
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $medico->password,
        ]);

        return redirect()->route('medicos')->with('status', 'Médico actualizado correctamente');
    }

    // Eliminar medico
    public function eliminarMedico($id)
    {
        $medico = User::findOrFail($id);
        $medico->update(['activo' => 'no']);

        return redirect()->route('medicos')->with('status', 'Médico eliminado correctamente');
    }

    //////////////////////////////////    SERVICIOS    /////////////////////////////////////////

    // Mostrar servicios
    public function mostrarServicios()
    {
        $servicios = Servicio::where('activo', 'si')->get();
        return view('/secretaria.servicios.servicios', compact('servicios'));
    }

    // Guardar servicio
    public function storeServicios(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        Servicio::create($request->all());

        return redirect()->route('servicios')->with('status', 'Servicio registrado correctamente');
    }

    // Ruta para agregar servicio (form)
    public function crearServicio()
    {
        return view('/secretaria.servicios.agregarServicio');
    }

    // Editar servicio (form)
    public function editarServicio($id)
    {
        $servicio = Servicio::findOrFail($id);
        return view('/secretaria.servicios.editarServicio', compact('servicio'));
    }

    // Actualizar servicio
    public function updateServicio(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        $servicio = Servicio::findOrFail($id);
        $servicio->update($request->all());

        return redirect()->route('servicios')->with('status', 'Servicio actualizado correctamente');
    }

    // Eliminar servicio
    public function eliminarServicio($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->update(['activo' => 'no']);

        return redirect()->route('servicios')->with('status', 'Servicio eliminado correctamente');
    }
}
