<?php

use App\Http\Controllers\SecretariaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de Pacientes
    Route::post('/pacientes/agregarPaciente', [SecretariaController::class, 'storePacientes'])->name('registrarPaciente.store');
    Route::get('/agregarPaciente', function () {
        return view('secretaria.pacientes.agregarPaciente');
    })->name('agregarPaciente');
    Route::get('/secretaria/dashboardSecretaria', [SecretariaController::class, 'mostrarPacientes'])->name('dashboardSecretaria');
    Route::get('/secretaria/pacientes/editar/{id}', [SecretariaController::class, 'editarPaciente'])->name('pacientes.editar');
    Route::patch('/secretaria/pacientes/editar/{id}', [SecretariaController::class, 'updatePaciente'])->name('pacientes.update');
    Route::delete('/secretaria/pacientes/eliminar/{id}', [SecretariaController::class, 'eliminarPaciente'])->name('pacientes.eliminar');

    // Rutas de Productos
    Route::get('/secretaria/productos/agregar', [SecretariaController::class, 'crearProducto'])->name('productos.agregar');
    Route::post('/secretaria/productos/agregarProducto', [SecretariaController::class, 'storeProductos'])->name('productos.store');
    Route::get('/secretaria/productos/editar/{id}', [SecretariaController::class, 'editarProducto'])->name('productos.editar');
    Route::patch('/secretaria/productos/editar/{id}', [SecretariaController::class, 'updateProducto'])->name('productos.update');
    Route::delete('/secretaria/productos/eliminar/{id}', [SecretariaController::class, 'eliminarProducto'])->name('productos.eliminar');
    Route::get('/secretaria/productos', [SecretariaController::class, 'mostrarProductos'])->name('productos');

    // Rutas de Citas
    Route::get('/secretaria/citas', [SecretariaController::class, 'mostrarCitas'])->name('citas');
});

require __DIR__.'/auth.php';
