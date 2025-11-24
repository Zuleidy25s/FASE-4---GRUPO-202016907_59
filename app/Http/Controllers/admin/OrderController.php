<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    // function de session
    public function __Construct(){
        $this->middleware('auth');
        $this->middleware('isadmin');
    }
    //
    public function index()
    {
        return view('admin.order.home');
    }

    public function list()
    {
        $orders = Order::with('items', 'payment')->get();

        return DataTables::of($orders)
            ->addColumn('total', function ($row) {
                return '$' . number_format($row->items->sum('subtotal'), 0, ',', '.');
            })
            ->addColumn('actions', function ($row) {
                return '
                    <a href="'.route('admin.orders.view', ['id' => $row->id]).'" class="px-2 py-1 bg-blue-600 text-white rounded mr-1">Ver</a>
                    
                    <a href="'.route('admin.orders.print', ['id' => $row->id]).'" class="px-2 py-1 bg-gray-600 text-white rounded mr-1">Imprimir</a>
                    
                    <button onclick="deleteOrder('.$row->id.')" class="px-2 py-1 bg-red-600 text-white rounded">Eliminar</button>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function view($id)
    {
        $order = Order::with(['items.product', 'payment'])->findOrFail($id);
        return view('admin.order.view', compact('order'));
    }


    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Borrar QR si existe
        if($order->qr_path && Storage::disk('public')->exists($order->qr_path)) {
            Storage::disk('public')->delete($order->qr_path);
        }

        $order->delete();

        return response()->json(['success' => true]);
    }

    public function print($id)
    {
        $order = Order::with(['items.product', 'payment'])->findOrFail($id);

        // Retornamos vista con los datos de la orden
        return view('admin.order.print', compact('order'));
    }

}
