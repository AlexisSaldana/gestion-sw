<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;

class DashboardController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::all();
        return view('dashboard', compact('pacientes'));
    }
}
