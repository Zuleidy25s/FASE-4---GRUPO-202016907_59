<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{
    //view index
    public function index(){
        return view('public.home');
    }

}
