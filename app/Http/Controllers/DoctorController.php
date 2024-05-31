<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display the dashboard for medico.
     */
    public function index()
    {
        return view('/UsuarioDoctor');
    }
}
