<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    //
    // function de session
    public function __Construct(){
        $this->middleware('auth');
        $this->middleware('isadmin');
    }
        /**
     * Muestra una lista de todos los items.
     */
    public function index()
    {
        $items = Item::where('es_alquilable', true)->get();
        return view('admin.items.home', compact('items'));
    }

    /**
     * Muestra el formulario para crear un nuevo item.
     */
    public function create()
    {
        return view('admin.items.create');
    }

    /**
     * Almacena un item recién creado en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_item' => 'required|string|max:150',
            'tipo_servicio' => 'required|in:Comunal,Enseres',
            'costo_unitario' => 'required|numeric|min:0',
            'cantidad_total' => 'required|integer|min:0',
        ]);

        Item::create($request->all());

        return redirect()->route('admin.items.index')
                         ->with('success', 'Ítem creado exitosamente.');
    }

    /**
     * Muestra los detalles de un item específico.
     */
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    //
    /**
     * Elimina un item específico de la base de datos.
     */
   // ItemController
    public function destroy($id_item)
    {
        $item = Item::findOrFail($id_item); // buscar manualmente
        $item->delete();

        return redirect()->route('admin.items.index')
                        ->with('success', 'Ítem eliminado correctamente.');
    }




}
