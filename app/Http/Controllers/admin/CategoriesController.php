<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator, Str, Config, Auth;

use App\Models\Category;

class CategoriesController extends Controller
{
    public function __Construct(){
    	$this->middleware('auth');
    	// $this->middleware('user.status');
        // $this->middleware('user.permissions');
        $this->middleware('isadmin');
    }
    
    public function getHome($module){
		// Verificar si el usuario tiene permisos para editar
        if (!kvfj(Auth::user()->permissions, 'categories')) {
            // Handle unauthorized access (redirect, show error message, etc.)
            abort(403, 'No tienes permisos para ver la lista de categorias.');
        }
    	$cats = Category::where('module', $module)->where('parent', '0')->orderBy('name','Asc')->get();
    	$data = ['cats' => $cats, 'module' => $module];
    	return view('admin.categories.home', $data);
    }

    public function postCategoryAdd (Request $request, $module){
    	$rules = [
    		'name' => 'required',
    	];
    	$messages = [
    		'name.required' => 'Se requiere de un nombre para la categoria.'
    	];
    	$validator = Validator::make($request->all(), $rules, $messages);

    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger'); 
    	else:

    		$c = new Category;
    		$c->module = $module;
			$c->parent = $request->input('parent');
    		$c->name = e($request->input('name'));
    		$c->slug = Str::slug($request->input('name'));
    		if($c->save()):
    			return back()->with('message', 'Guardado con éxito')->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function getCategoryEdit($id){
		// Verificar si el usuario tiene permisos para editar
        if (!kvfj(Auth::user()->permissions, 'category_edit')) {
            // Handle unauthorized access (redirect, show error message, etc.)
            abort(403, 'No tienes permisos para editar las categorías.');
        }
    	$cat = Category::find($id);
    	$data = ['cat' => $cat];
    	return view('admin.categories.edit', $data);
    }
	
    public function postCategoryEdit (Request $request, $id){
    	$rules = [
    		'name' => 'required',
    	];
    	$messages = [
    		'name.required' => 'Se requiere de un nombre para la categoria.',
    	];
    	$validator = Validator::make($request->all(), $rules, $messages);

    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger'); 
    	else:
    		$c = Category::find($id);
    		$c->name = e($request->input('name'));
    		$c->slug = Str::slug($request->input('name'));
    		if($c->save()):
    			return back()->with('message', 'Editado con éxito')->with('typealert', 'success');
    		endif;
    	endif;
    }

	public function getSubCategories($id){
		// Verificar si el usuario tiene permisos para editar
        if (!kvfj(Auth::user()->permissions, 'category_subs')) {
            // Handle unauthorized access (redirect, show error message, etc.)
            abort(403, 'No tienes permisos para ver la lista de Sub categorías.');
        }
		$cat = Category::findOrFail($id);
		$data = ['category' => $cat];
		return view('admin.categories.sub_categories', $data);
	}

    public function getCategoryDelete($id){
    	$c = Category::find($id);
    	if($c->delete()):
    		return back()->with('message', 'Borrado con éxito.')->with('typealert', 'danger');
    	endif; 
    } 
}
