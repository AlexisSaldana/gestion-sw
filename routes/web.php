<?php

use App\Http\Controllers\ConsultasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\Upload;
use Illuminate\Support\Facades\Route;

// Ruta de la página de bienvenida
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/consultas/descargar', [ConsultasController::class, 'descargarPorCodigo'])->name('consultas.descargarPorCodigo');

// Aqui son las rutas que verifican que hayan iniciado sesion
Route::middleware(['auth', 'verified'])->group(function () {
    // Rutas del perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de Pacientes
    Route::post('/pacientes/agregarPaciente', [PacientesController::class, 'storePacientes'])->name('registrarPaciente.store');
    Route::get('/agregarPaciente', function () {
        return view('secretaria.pacientes.agregarPaciente');
    })->name('agregarPaciente');
    Route::get('/secretaria/dashboardSecretaria', [PacientesController::class, 'mostrarPacientes'])->name('dashboardSecretaria');
    Route::get('/secretaria/pacientes/editar/{id}', [PacientesController::class, 'editarPaciente'])->name('pacientes.editar');
    Route::patch('/secretaria/pacientes/editar/{id}', [PacientesController::class, 'updatePaciente'])->name('pacientes.update');
    Route::delete('/secretaria/pacientes/eliminar/{id}', [PacientesController::class, 'eliminarPaciente'])->name('pacientes.eliminar');

    // Rutas de Productos
    Route::get('/secretaria/productos', [ProductosController::class, 'mostrarProductos'])->name('productos');
    Route::post('/secretaria/productos/agregarProducto', [ProductosController::class, 'storeProductos'])->name('productos.store');
    Route::get('/secretaria/productos/editar/{id}', [ProductosController::class, 'editarProducto'])->name('productos.editar');
    Route::patch('/secretaria/productos/editar/{id}', [ProductosController::class, 'updateProducto'])->name('productos.update');
    Route::delete('/secretaria/productos/eliminar/{id}', [ProductosController::class, 'eliminarProducto'])->name('productos.eliminar');
    
    // Rutas de Citas
    Route::get('/secretaria/citas', [CitasController::class, 'mostrarCitas'])->name('citas');
    Route::post('/secretaria/citas/agregarCita', [CitasController::class, 'storeCitas'])->name('citas.store');
    Route::get('/secretaria/citas/editar/{id}', [CitasController::class, 'editarCita'])->name('citas.editar');
    Route::patch('/secretaria/citas/editar/{id}', [CitasController::class, 'updateCita'])->name('citas.update');
    Route::delete('/secretaria/citas/eliminar/{id}', [CitasController::class, 'eliminarCita'])->name('citas.eliminar');
    Route::get('/get-events', [CitasController::class, 'getEvents']);
    Route::post('/obtener-citas-por-fecha', [CitasController::class, 'obtenerCitasPorFecha'])->name('citas.obtenerPorFecha');

    // Rutas de Usuarios
    Route::get('/secretaria/usuarios', [UsuariosController::class, 'mostrarUsuarios'])->name('usuarios');
    Route::post('/secretaria/usuarios/agregarUsuario', [UsuariosController::class, 'storeUsuarios'])->name('usuarios.store');
    Route::get('/secretaria/usuarios/agregar', [UsuariosController::class, 'crearUsuario'])->name('usuarios.agregar');
    Route::get('/secretaria/usuarios/editar/{id}', [UsuariosController::class, 'editarUsuario'])->name('usuarios.editar');
    Route::patch('/secretaria/usuarios/editar/{id}', [UsuariosController::class, 'updateUsuario'])->name('usuarios.update');
    Route::delete('/secretaria/usuarios/eliminar/{id}', [UsuariosController::class, 'eliminarUsuario'])->name('usuarios.eliminar');

    // Rutas de Servicios
    Route::get('/secretaria/servicios', [ServiciosController::class, 'mostrarServicios'])->name('servicios');
    Route::post('/secretaria/servicios/agregarServicio', [ServiciosController::class, 'storeServicios'])->name('servicios.store');
    Route::get('/secretaria/servicios/editar/{id}', [ServiciosController::class, 'editarServicio'])->name('servicios.editar');
    Route::patch('/secretaria/servicios/editar/{id}', [ServiciosController::class, 'updateServicio'])->name('servicios.update');
    Route::delete('/secretaria/servicios/eliminar/{id}', [ServiciosController::class, 'eliminarServicio'])->name('servicios.eliminar');
    
    // Rutas de Consultas
    Route::get('/consultas', [ConsultasController::class, 'index'])->name('consultas.index');
    Route::get('/consultas/crear/{citaId}', [ConsultasController::class, 'create'])->name('consultas.create');
    Route::post('/consultas/guardar/{citaId}', [ConsultasController::class, 'store'])->name('consultas.store');
    Route::get('/consultas/editar/{id}', [ConsultasController::class, 'edit'])->name('consultas.edit'); 
    Route::patch('consultas/{id}', [ConsultasController::class, 'update'])->name('consultas.update');
    Route::get('/citas/verificar', [CitasController::class, 'verificarCita'])->name('citas.verificar');
    Route::get('/consultas/{id}', [ConsultasController::class, 'show'])->name('consultas.show');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rutas del data table
    Route::get('/buscar-pacientes', [PacientesController::class, 'buscarPacientes'])->name('pacientes.buscar');

    // Rutas del PDF
    Route::get('/consultas/{id}/download', [ConsultasController::class, 'downloadPDF'])->name('consultas.download');
});

// Rutas de autenticación generadas por Laravel Breeze
require __DIR__.'/auth.php';