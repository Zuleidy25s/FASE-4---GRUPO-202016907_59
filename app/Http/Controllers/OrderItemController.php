<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function addItem(Request $request, Order $order)
    {
        $product = Product::findOrFail($request->product_id);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => $product->discount > 0 ? $product->discount : $product->price,
            'subtotal' => $product->discount > 0 ? $product->discount : $product->price,
        ]);

        return back()->with('success', 'Producto agregado.');
    }
}
