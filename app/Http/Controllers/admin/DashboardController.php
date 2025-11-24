<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    // function de session
    public function __Construct(){
        $this->middleware('auth');
        $this->middleware('isadmin');
    }
    // view dashboard
    public function getDashboard(){
        // Verificar si el usuario tiene permisos para editar
        if (!kvfj(Auth::user()->permissions, 'dashboard')) {
            // Handle unauthorized access (redirect, show error message, etc.)
            abort(403, 'No tienes permisos para ver las estadísticas.');
        }
        return view('admin.dashboard.home');
    }
}
