<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\SecretariaController;
use App\Http\Controllers\DoctorColaboradorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/registrarUsuario', function () {
        return view('registrarUsuario');
    })->name('registrarUsuario');

    Route::post('/registrarUsuario', [PacienteController::class, 'store'])->name('registrarUsuario.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/UsuarioDoctor', [DoctorController::class, 'index'])->name('UsuarioDoctor');
    Route::get('/UsuarioSecretaria', [SecretariaController::class, 'index'])->name('UsuarioSecretaria');
    Route::get('/UsuarioDoctorColaborador', [DoctorColaboradorController::class, 'index'])->name('UsuarioDoctorColaborador');
});

require __DIR__.'/auth.php';
