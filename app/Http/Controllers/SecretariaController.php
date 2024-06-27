<?php

namespace App\Http\Controllers;

class SecretariaController extends Controller
{
    // Muestra la vista principal del usuario secretaria
    public function index()
    {
        return view('/UsuarioSecretaria');
    }
}
