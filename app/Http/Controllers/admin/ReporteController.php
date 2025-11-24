<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    //
    // function de session
    public function __Construct(){
        $this->middleware('auth');
        $this->middleware('isadmin');
    }

    public function index()
    {
        return view('admin.reportes.home');
    }

    public function comunal()
    {
        return view('admin.reportes.consult');
    }

    public function saldo()
    {
        return view('admin.reportes.saldo');
    }
}
