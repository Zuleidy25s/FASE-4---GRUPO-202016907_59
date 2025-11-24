<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Variant;


class CartController extends Controller
{
    //
    public function __construct(){
		$this->middleware('auth');
	}
    // views cart get
    public function getCart(){
        // Obtener la instancia completa de la orden del usuario
        $order = $this->getUserOrder();

        // Verificar que $order es una instancia válida del modelo Order
        if ($order) {
            $items = $order->getItems; // Obtener los items de la orden
            $data = ['order' => $order, 'items' => $items];
            return view('public.cart', $data);
        } else {
            // Manejar el caso donde no hay una orden para el usuario
            return view('public.cart')->with('message', 'No items in cart.');
        }
    }
    // view order users
    public function getUserOrder(){
        // verify active order
        $order = Order::where('status', '0')->count();
        if($order == 0):
            // Instanciar orden
            $order = new Order;
            $order->user_id = Auth::id();
            $order->save();
        else:
            // Obtener orden active
            $order = Order::where('status', '0')->first();
        endif;
        return $order;
    }
    // add card item
    public function postCartAdd(Request $request, $id) {
        // Obtiene la orden del usuario
        $order = $this->getUserOrder();
        // Encuentra el producto por su ID
        $product = Product::find($id);
    
        // Verifica si el producto existe
        if (!$product) {
            return back()->with('message', 'Producto no encontrado.')->with('typealert', 'danger');
        }
    
        // Verifica si se ha seleccionado un inventario válido
        $inventoryId = $request->input('inventory_id');
        if (!$inventoryId || !$product->getInventory->contains('id', $inventoryId)) {
            return back()->with('message', 'Seleccione un inventario válido.')->with('typealert', 'danger');
        }
    
        // Encuentra el inventario por su ID
        $inventory = Inventory::find($inventoryId);
        // Verifica si el inventario existe
        if (!$inventory) {
            return back()->with('message', 'Inventario no encontrado.')->with('typealert', 'danger');
        }
    
        // Verifica si la cantidad ingresada es válida
        $quantity = $request->input('quantity');
        if (!is_numeric($quantity) || $quantity < 1) {
            return back()->with('message', 'Debes ingresar una cantidad válida.')->with('typealert', 'danger');
        }
        // Verifica si hay la cantidad disponible en la orden de inventario, en inventario
        if ($inventory->limited == "0"): 
            if ($request->input('quantity') > $inventory->quantity):
                return back()->with('message', 'La cantidad ingresada supera la disponible.')->with('typealert', 'danger');
            endif;
        endif;
    
        // Verifica si se ha seleccionado una variante válida en caso de que haya variantes disponibles
        $variantId = $request->input('variant_id');
        if ($inventory->getVariants->isNotEmpty() && (!$variantId || !$inventory->getVariants->contains('id', $variantId))) {
            return back()->with('message', 'Debe seleccionar una variante válida.')->with('typealert', 'danger');
        }
    
        // Encuentra la variante por su ID (si aplica)
        $variant = $variantId ? Variant::find($variantId) : null;
        $variant_label = $variant ? ' / ' . $variant->name : '';
    
        // Genera la etiqueta del producto con el inventario y la variante
        $label = $product->name . ' / ' . $inventory->name . $variant_label;
    
        $query = OrderItem::where('order_id', $order->id)->where('product_id', $product->id)->count();
        if($query == 0):
            // Crea un nuevo item de orden
            $oitems = new OrderItem;
        
            // Calcula el precio final considerando descuentos
            $price = $this->getCalcutePrice($product->in_discount, $product->discount, $inventory->price);
            // Calcula el total
            $total = $price * $quantity;
        
            // Asigna valores al item de orden
            $oitems->user_id = Auth::id();
            $oitems->order_id = $order->id;
            $oitems->product_id = $id;
            $oitems->inventory_id = $inventory->id;
            $oitems->variant_id = $variant ? $variant->id : null;
            $oitems->label_item = $label;
            $oitems->quantity = $quantity;
            $oitems->discount_status = $product->in_discount;
            $oitems->discount = $product->discount;
            $oitems->discount_until_date = $product->discount_until_date;
            $oitems->price_initial = $inventory->price;
            $oitems->price_unit = $price;
            $oitems->total = $total;

            if ($oitems->save()) {
                return back()->with('message', 'Producto agregado al carrito de compras')->with('typealert', 'success');
            }
            return back()->with('message', 'No se pudo agregar el producto al carrito.')->with('typealert', 'danger');
        else:
            return back()->with('message', 'Este producto ya se encuentra en su carrito.')->with('typealert', 'danger');
        endif;
    }
    // update quantity
    public function postItemQuantityUpdate($id, Request $request) {
        // Obtiene la orden del usuario
        $order = $this->getUserOrder();
        $oitem = OrderItem::find($id);
        $inventory = Inventory::find($oitem->inventory_id);
        if($order->id != $oitem->order_id):
            return back()->with('message', 'No podemos actualizar la cantidad de este grupo.')->with('typealert', 'danger');
        else:
            if($inventory->limited == "0"):
                if($request->input('quantity') > $inventory->quantity):
                    return back()->with('message', 'la cantidad ingresada supera al inventario.')->with('typealert', 'danger');
                endif;
            endif;
            $total = $oitem->price_unit * $request->input('quantity');
            $oitem->quantity = $request->input('quantity');
            $oitem->total = $total;
            if($oitem->save()):
                return back()->with('message', 'Cantidad actualizada con éxito.')->with('typealert','success');
            endif;
        endif;
    }
    // Función para calcular el precio final considerando descuentos
    public function getCalcutePrice($in_discount, $discount, $price) {
        $final_price = $price;
        // Si el producto está en descuento, calcula el precio final
        if ($in_discount == "1") {
            // Convertir el descuento a un número de punto flotante
            $discount_value = floatval('0.'.$discount);
            // Calcular el descuento
            $discount_calc = $price * $discount_value;
            // Calcular el precio final
            $final_price = $price - $discount_calc;
        }
        return $final_price;
    }

    public function getItemQuantityDelete($id){
        $oitem = OrderItem::find($id);
        if ($oitem->delete()){
            return back()->with('message', 'Producto eliminado del carrito de compras.')->with('typealert','success');
        }
        
    }

    

}
