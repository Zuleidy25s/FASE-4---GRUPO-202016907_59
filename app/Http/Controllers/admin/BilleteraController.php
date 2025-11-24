<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BilleteraController extends Controller
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
        return view('admin.billetera.home');
    }

    public function comunal()
    {
        return view('admin.billetera.comunal');
    }
}
