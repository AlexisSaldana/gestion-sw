<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoctorColaboradorController extends Controller
{
    /**
     * Display the dashboard for medico.
     */
    public function index()
    {
        return view('/UsuarioDoctorColaborador');
    }
}
