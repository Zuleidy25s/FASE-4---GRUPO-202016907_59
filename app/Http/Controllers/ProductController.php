<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //
    public function getProduct($id, $slug){
        // Obtener el producto con su inventario y variantes
        $product = Product::with('getInventory.getVariants')->findOrFail($id);
        return view('component.product_single', ['product' => $product]);
    }
}
