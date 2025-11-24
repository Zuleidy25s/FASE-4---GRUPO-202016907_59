<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alquiler;
use App\Models\DetalleAlquiler;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class AlquilerController extends Controller
{
    //
    // function de session
    public function __Construct(){
        $this->middleware('auth');
        $this->middleware('isadmin');
    }
        /**
     * Muestra el formulario para iniciar un nuevo alquiler.
     */

    public function index()
    {
        return view('admin.alquileres.home');
    }

}
