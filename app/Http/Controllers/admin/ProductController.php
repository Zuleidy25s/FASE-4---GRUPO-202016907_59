<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Category, App\Models\Product, App\Models\Inventory, App\Models\ProductGallery, App\Models\Variant;;

use Validator, Str, Config, Image, Auth;

class ProductController extends Controller
{
    public function __Construct(){
    	$this->middleware('auth');
        // $this->middleware('user.status');
        // $this->middleware('user.permissions');
    	$this->middleware('isadmin');
    }
    // view home product
    public function getHome($status){
        // Verificar si el usuario tiene permisos para editar
        if (!kvfj(Auth::user()->permissions, 'products')) {
            // Handle unauthorized access (redirect, show error message, etc.)
            abort(403, 'No tienes permisos para ver la lista de usuarios.');
        }

        switch ($status) {
            case '0':
                $products = Product::with(['cat', 'getPrice'])->where('status', '0')->orderBy('id', 'desc')->paginate(5);
                break;
            case '1':
                $products = Product::with(['cat', 'getPrice'])->where('status', '1')->orderBy('id', 'desc')->paginate(5);
                break;
            case 'all':
                $products = Product::with(['cat', 'getPrice'])->orderBy('id', 'desc')->paginate(5);
                break;
            case 'trash':
                $products = Product::with(['cat', 'getPrice'])->onlyTrashed()->orderBy('id', 'desc')->paginate(5);
                break;
        }

        $data = ['products' => $products];
    	return view('admin.products.home', $data);
    }
    // add product get
    public function getProductAdd(){
        $cats = Category::where('module', '0')->where('parent','0')->pluck('name', 'id');
        $data = ['cats' => $cats];
    	return view('admin.products.add', $data);
    }
    // add product post
    public function postProductAdd(Request $request){
        // Reglas de validación para los campos del formulario
        $rules = [
            'name' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Reglas para la imagen
        ];

        // Mensajes de error personalizados para las reglas de validación
        $messages = [
            'name.required' => 'El nombre del producto es requerido',
            'content.required' => 'Ingrese una descripción del producto',
            'image.image' => 'El archivo seleccionado debe ser una imagen',
            'image.mimes' => 'El archivo debe ser de tipo jpeg, png, jpg o gif',
            'image.max' => 'El tamaño máximo permitido para la imagen es de 2MB',
        ];

        // Validar los datos del formulario
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validación falla, redireccionar de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withInput();
        }

        // Crear una instancia de Producto y asignar los valores
        $product = new Product;
        $product->status = '0';
        $product->code = e($request->input('code'));
        $product->name = e($request->input('name'));
        $product->slug = Str::slug($request->input('name'));
        $product->category_id = $request->input('category');
        $product->subcategory_id = $request->input('subcategory');
        $product->file_path = date('Y-m-d');
        $product->in_discount = $request->input('indiscount');
        $product->discount = $request->input('discount') ?? 0.00;
        $product->content = e($request->input('content'));

        // Si se cargó una imagen, guardarla
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::slug($request->input('name')) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs($imageName, $imageName, 'uploads_product_image');
            $product->image = $path;
        }

        // Guardar el producto en la base de datos
        if ($product->save()) {
            return redirect('/admin/products/all')->with('message', 'Guardado con éxito.')->with('typealert', 'success');
        } else {
            return back()->with('message', 'Error al guardar el producto')->with('typealert', 'danger')->withInput();
        }
    }
    // edit product get
    public function getProductEdit($id){
        $p = Product::findOrFail($id);
        $cats = Category::where('module', '0')->where('parent', '0')->pluck('name', 'id');
        
        // Obtener todas las imágenes asociadas al producto
        $images = ProductGallery::where('product_id', $id)->get();

        $data = ['cats' => $cats, 'p' => $p, 'images' => $images, 'productId' => $id]; // Añade 'productId' => $id
        return view('admin.products.edit', $data);
    }
    // edit product post
    public function postProductEdit($id, Request $request){
        $rules = [
            'name' => 'required',
            'content' => 'required',
        ];

        $messages = [
            'name.required' => 'El nombre del producto es requerido',
            'content.required' => 'Ingresé una descripción del producto'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger')->withInput(); 
        else:
            $product = Product::findOrFail($id);
            $product->status = $request->input('status');
            $product->code = e($request->input('code'));
            $product->name = e($request->input('name'));
            $product->category_id = $request->input('category');
            $product->subcategory_id = $request->input('subcategory');
            $product->price = e($request->input('price'));
            $product->in_discount = $request->input('indiscount');
            $product->discount = $request->input('discount');
            $product->discount_until_date = $request->input('discount_until_date');
            $product->content = e($request->input('content'));

            if($product->save()):
                $this->getUpdateMinPrice($product->id);
                return back()->with('message', 'Actualizado con éxito.')->with('typealert', 'success');
            endif; 
        endif;
    }
    // search product
    public function postProductSearch(Request $request){
         $rules = [
            'search' => 'required'
        ];

        $messages = [
            'search.required' => 'El campo consulta es requerido'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return redirect('/admin/products/1')->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger')->withInput(); 
        else:
            switch ($request->input('filter')):
                case '0':
                    $products = Product::with(['cat'])->where('name', 'LIKE', '%'.$request->input('search').'%')->where('status', $request->input('status'))->orderBy('id', 'desc')->get();
                    break;
                case '1':
                    $products = Product::with(['cat'])->where('code', $request->input('search'))->orderBy('id', 'desc')->get();
                    break;
            endswitch;

            $data = ['products' => $products];
            return view('admin.products.search', $data);
        endif;
    }
    // delete producto
    public function getProductDelete($id){
        $p = Product::findOrFail($id);

        if ($p->delete()): 
            return back()->with('message', 'Producto enviado a la papelera de reciclaje.')->with('typealert','danger');
        endif;
    }
    // restore producto
    public function getProductRestore($id){
        $p = Product::onlyTrashed()->where('id', $id)->first();
        if ($p->restore()): 
            return redirect('/admin/products/all')->with('message', 'Este producto se restauro con éxito.')->with('typealert','success');
        endif;
    }

    //*********************************
    //  SECTION INVENTORY PRODUCT
    //************************************/

    // inventory
    public function getProductInventory($id){
        $product = Product::findOrfail($id);
        $data = ['product' => $product];
        return view('admin.products.inventory', $data);
    }
    // add post inventory
    public function postProductInventory($id, Request $request){
        // Reglas de validación para los campos del formulario
        $rules = [
            'name' => 'required',
            'price' => 'required',
        ];

        // Mensajes de error personalizados para las reglas de validación
        $messages = [
            'name.required' => 'El nombre del inventario es requerido',
            'price.required' => 'Ingrese el precio del inventario',
        ];

        // Validar los datos del formulario
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validación falla, redireccionar de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withInput();
        } else {
            // Crear una instancia de inventarios
            $inventory = new Inventory;
            $inventory->product_id = $id;
            $inventory->name = e($request->input('name'));
            $inventory->quantity = e($request->input('inventory'));
            $inventory->price = e($request->input('price'));
            $inventory->limited = e($request->input('limited'));
            $inventory->minimum = e($request->input('minimum'));
        }
        // Guardar el producto en la base de datos
        if ($inventory->save()) {
            $this->getUpdateMinPrice($inventory->product_id);
            return back()->with('message', 'Guardado con exito.')->with('typealert', 'success')->withInput();
        } else {
            return back()->with('message', 'Error al guardar el producto')->with('typealert', 'danger')->withInput();
        }
    }
    // edit get inventory and view variants
    public function getProductInventoryEdit($id){
        $inventory = Inventory::findOrfail($id);
        $data = ['inventory' => $inventory];
        return view('admin.products.inventory_edit', $data);
    }
    // edit post inventory
    public function postProductInventoryEdit($id, Request $request){
        // Reglas de validación para los campos del formulario
        $rules = [
            'name' => 'required',
            'price' => 'required',
        ];

        // Mensajes de error personalizados para las reglas de validación
        $messages = [
            'name.required' => 'El nombre del inventario es requerido',
            'price.required' => 'Ingrese el precio del inventario',
        ];

        // Validar los datos del formulario
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validación falla, redireccionar de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withInput();
        } else {
            // Crear una instancia de inventarios
            $inventory = Inventory::find($id);
            $inventory->name = e($request->input('name'));
            $inventory->quantity = e($request->input('inventory'));
            $inventory->price = e($request->input('price'));
            $inventory->limited = e($request->input('limited'));
            $inventory->minimum = e($request->input('minimum'));
        }
        // Guardar el producto en la base de datos
        if ($inventory->save()) {
            $this->getUpdateMinPrice($inventory->product_id);
            return back()->with('message', 'Guardado con exito.')->with('typealert', 'success')->withInput();
        } else {
            return back()->with('message', 'Error al guardar el producto')->with('typealert', 'danger')->withInput();
        }
    }
    // delete inventory
    public function getProductInventoryDelete($id){
        $inv = Inventory::findOrFail($id);

        if ($inv->delete()): 
            $this->getUpdateMinPrice($inv->product_id);
            return back()->with('message', 'Inventario eliminado.')->with('typealert','danger');
        endif;
    }

    //*********************************
    //  SECTION INVENTORY VARIANTS
    //************************************/

    // view 
    public function postProductInventoryVariantAdd($id, Request $request){
        // Reglas de validación para los campos del formulario
        $rules = [
            'name' => 'required',
        ];

        // Mensajes de error personalizados para las reglas de validación
        $messages = [
            'name.required' => 'El nombre de la variante es requerido',
        ];

        // Validar los datos del formulario
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validación falla, redireccionar de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withInput();
        } else {
            // Crear una instancia de inventarios
            $inventory = Inventory::findOrFail($id);
            // instance variant
            $variant = new Variant;
            $variant->product_id = $inventory->product_id;
            $variant->inventory_id = $id;
            $variant->name = e($request->input('name'));
        }
        // Guardar el producto en la base de datos
        if ($variant->save()) {
            return back()->with('message', 'Guardado con exito.')->with('typealert', 'success')->withInput();
        } else {
            return back()->with('message', 'Error al guardar la variante')->with('typealert', 'danger')->withInput();
        }
    }
    // delete get inventory variant
    public function getProductInventoryVariantDelete($id){
        $variant = Variant::findOrFail($id);

        if ($variant->delete()): 
            return back()->with('message', 'Variante eliminada.')->with('typealert','danger');
        endif;
    }


    public function getUpdateMinPrice($id) {
        $product = Product::find($id);
        $price = $product->getPrice()->min('price');
    
        // Si el precio es nulo, no actualice el campo `price` del producto
        if (!is_null($price)) {
            $product->price = $price;
            $product->save();
        }
    }

}
