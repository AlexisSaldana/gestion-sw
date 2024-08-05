<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Paciente;
use App\Models\Citas;

class UsuariosController extends Controller
{
    // Muestra todos los usuarios activos
    public function mostrarUsuarios(Request $request)
    {
        $query = User::query();

        // Filtros de búsqueda
        if ($request->has('busqueda') && $request->busqueda != '') {
            $terms = explode(' ', $request->busqueda);
            $query->where(function($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->orWhere('nombres', 'like', '%' . $term . '%')
                      ->orWhere('apepat', 'like', '%' . $term . '%')
                      ->orWhere('apemat', 'like', '%' . $term . '%')
                      ->orWhere('email', 'like', '%' . $term . '%')
                      ->orWhere('telefono', 'like', '%' . $term . '%');
                }
            });
        }

        // Filtro por rol
        if ($request->has('rol') && $request->rol != '') {
            $query->where('rol', $request->rol);
        }

        // Obtiene todos los usuarios que están activos y coinciden con la búsqueda
        $usuarios = $query->whereIn('rol', ['medico', 'secretaria', 'enfermera'])
                          ->where('activo', 'si')
                          ->get();
                          
        $totalPacientesActivos = Paciente::where('activo', 'si')->count(); // Contar pacientes activos
        $totalCitasActivas = Citas::where('activo', 'si')->count(); // Contar citas activas
        $totalUsuariosActivos = User::where('activo', 'si')
                                     ->whereIn('rol', ['medico', 'secretaria', 'enfermera'])
                                     ->count(); // Contar usuarios activos con roles de médico y secretaria
        
        return view('secretaria.usuarios.usuarios', compact('usuarios', 'totalPacientesActivos', 'totalCitasActivas', 'totalUsuariosActivos'));
    }

    // Guarda un nuevo usuario
    public function storeUsuarios(Request $request)
    {
        // Validación de los datos recibidos
        $validator = \Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => ['required', 'date', function ($attribute, $value, $fail) {
                $age = \Carbon\Carbon::parse($value)->age;
                if ($age < 18) {
                    $fail('El usuario debe ser mayor de edad (18 años o más).');
                }
            }],
            'telefono' => 'required|string|max:20',
            'rol' => ['required', 'in:medico,secretaria,enfermera,admin'],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Si la validación falla, redirige de vuelta con un mensaje de error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $validator->errors()->first());
        }
    
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

    // Actualiza la información de un usuario específico 
    public function updateUsuario(Request $request, $id)
    {
        // Validación de los datos recibidos
        $validator = \Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => ['required', 'date', function ($attribute, $value, $fail) {
                $age = \Carbon\Carbon::parse($value)->age;
                if ($age < 18) {
                    $fail('El usuario debe ser mayor de edad (18 años o más).');
                }
            }],
            'telefono' => 'required|string|max:20',
            'rol' => ['required', 'in:medico,secretaria,enfermera,admin'],
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
    
        // Si la validación falla, redirige de vuelta con un mensaje de error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $validator->errors()->first());
        }
    
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

    // Muestra el formulario para agregar un nuevo usuario
    public function crearUsuario()
    {
        return view('secretaria.usuarios.agregarUsuario');
    }

    // Muestra el formulario de edición de un usuario específico
    public function editarUsuario($id)
    {
        $usuario = User::findOrFail($id);
        return response()->json($usuario);
    }

    // Marca a un usuario como inactivo (eliminado)
    public function eliminarUsuario($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->update(['activo' => 'no']);

        return redirect()->route('usuarios')->with('status', 'Usuario eliminado correctamente');
    }
}
