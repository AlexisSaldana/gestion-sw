<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\SecretariaController;
use App\Http\Controllers\DoctorColaboradorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Ruta para el dashboard del médico
Route::get('/UsuarioDoctor', [DoctorController::class, 'index'])->middleware(['auth', 'verified'])->name('UsuarioDoctor');

// Ruta para el dashboard de la secretaria
Route::get('/UsuarioSecretaria', [SecretariaController::class, 'index'])->middleware(['auth', 'verified'])->name('UsuarioSecretaria');

// Ruta para el dashboard del colaborador
Route::get('/UsuarioDoctorColaborador', [DoctorColaboradorController::class, 'index'])->middleware(['auth', 'verified'])->name('UsuarioDoctorColaborador');

require __DIR__.'/auth.php';
