<?php

namespace App\Http\Controllers;
use Config;
use Illuminate\Http\Request;
use App\Models\Product, App\Models\Favorite;

class ApiJsController extends Controller
{
    //
    public function __construct(){
		$this->middleware('auth')->except(['getProductsSection']);
	}

    function getProductsSection($section, Request $request){
        $items_x_page = Config::get('cms.products_per_page');
        $items_x_page_random = Config::get('cms.products_per_page_random');
        switch ($section):
            case 'home':
                $products = Product::where('status', 1)->inRandomOrder()->paginate($items_x_page_random);
                break;

            case 'store':
                $products = Product::where('status', 1)->orderBy('id', 'Desc')->paginate($items_x_page);
                break;

            case 'store_category':
                $products = Product::where('status', 1)->where('category_id', $request->get('object_id'))->orderBy('id', 'Desc')->paginate($items_x_page);
                break;
            
            default:
                $products = Product::where('status', 1)->inRandomOrder()->paginate($items_x_page);
                break;
        endswitch;
        return $products;
    }

    function postFavoriteAdd($object, $module, Request $request){
        $query = Favorite::where('user_id', Auth::id())->where('module', $module)->where('object_id', $object)->count();
        if($query > 0):
            $data = ['error' => 'success', 'msg' => 'Este ítem ya está en tus favoritos.'];
        else:
            $favorite = new Favorite;
            $favorite->user_id = Auth::id();
            $favorite->module = $module;
            $favorite->object_id = $object;
            if($favorite->save()):
                $data = ['status' => 'success', 'msg' => 'Se guardo su favorito.'];  
            endif;  
        endif;

        return response()->json($data);
    }
    
    public function postUserFavorites(Request $request){
        $objects = json_decode($request->input('objects'), true);
        $query = Favorite::where('user_id', Auth::id())->where('module', $request->input('module'))->whereIn('object_id', explode(",", $request->input('objects')))->pluck('object_id');
        
        if(count(collect($query)) > 0):
            $data = ['status' => 'success', 'count' => count(collect($query)), 'objects' => $query];  
        else:
            $data = ['status' => 'success', 'count' => count(collect($query))];  
        endif;
        return response()->json($data);
        //return response()->json($request->input('objects'));
    }
}
