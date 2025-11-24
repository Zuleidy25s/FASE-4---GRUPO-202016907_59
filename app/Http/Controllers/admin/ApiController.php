<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Auth;

class ApiController extends Controller
{
    //
    public function __Construct(){
    	$this->middleware('auth');
    	// $this->middleware('user.status');
        // $this->middleware('user.permissions');
        $this->middleware('isadmin');
    }

    public function getSubcategories($parent){
        $categories = Category::where('parent', $parent)->get();
        return response()->json($categories);
    }
}
