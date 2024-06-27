<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Paciente;

class UsuariosController extends Controller
{
    // Muestra todos los usuarios activos
    public function mostrarUsuarios()
    {
        $usuarios = User::whereIn('rol', ['medico', 'secretaria', 'colaborador'])
                        ->where('activo', 'si')
                        ->get();
        return view('/secretaria.usuarios.usuarios', compact('usuarios'));
    }
    

    // Guarda un nuevo médico
    public function storeUsuarios(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'telefono' => 'required|string|max:20',
            'rol' => ['required', 'in:medico,secretaria,colaborador,admin'],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Creación del usuario con cifrado de la contraseña
        User::create([
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'telefono' => $request->telefono,
            'rol' => $request->rol,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Redirecciona a la vista de usuarios con un mensaje de éxito
        return redirect()->route('usuarios')->with('status', 'Usuario registrado correctamente');
    }

    // Muestra el formulario para agregar un nuevo usuario
    public function crearUsuario()
    {
        return view('/secretaria.usuarios.agregarUsuario');
    }

    // Muestra el formulario de edición de un usuario específico
    public function editarUsuario($id)
    {
        $usuario = User::findOrFail($id);
        return response()->json($usuario);
    }

    // Actualiza la información de un usuario específico
    public function updateUsuario(Request $request, $id)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'telefono' => 'required|string|max:20',
            'rol' => ['required', 'in:medico,secretaria,colaborador,admin'],
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Encuentra el usuario y actualiza sus datos
        $usuario = User::findOrFail($id);
        $usuario->update([
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'telefono' => $request->telefono,
            'rol' => $request->rol,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $usuario->password,
        ]);

        // Redirecciona a la vista de usuarios con un mensaje de éxito
        return redirect()->route('usuarios')->with('status', 'Usuario actualizado correctamente');
    }

    // Marca a un usuario como inactivo (eliminado)
    public function eliminarUsuario($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->update(['activo' => 'no']);

        return redirect()->route('usuarios')->with('status', 'Usuario eliminado correctamente');
    }
}
