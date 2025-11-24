<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class OrderMobileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Vista selección tipo (mobile)
    public function selectMobile()
    {
        return view('order.select-mobile');
    }

    // Crear orden según tipo
    public function createType($type)
    {
        $map = [
            1 => 'comer_aqui',
            2 => 'para_llevar',
            3 => 'para_llevar',
            4 => 'para_llevar',
        ];

        $categories = Category::where('parent', 0)
            ->with('products')
            ->get();

        $products = Product::with('category')
            ->where('status', 1)
            ->get();

        $typeEnum = $map[$type] ?? 'para_llevar';

        return view('order.create-mobile', compact('typeEnum', 'categories', 'products'));
    }

    // Vista de creación completa
    public function create()
    {
        $categories = Category::where('parent', 0)
            ->with('products')
            ->get();

        $products = Product::with('category')
            ->where('status', 1)
            ->get();

        return view('order.create-mobile', [
            'typeEnum' => 'para_llevar',
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    // Catálogo mobile
    public function catalog()
    {
        $categories = Category::where('parent', 0)
            ->with('products')
            ->get();

        $products = Product::with('category')
            ->where('status', 1)
            ->get();

        return view('order.catalog-mobile', compact('categories', 'products'));
    }

    // Guardar orden
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:comer_aqui,para_llevar',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'customer_email' => 'nullable|email|max:255',
            'payment_method' => 'required|in:rapida,manual',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.subtotal' => 'required|numeric|min:0',
            'payment.amount' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $orderNumber = 'ORD-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));
            $order = Order::create([
                'order_number' => $orderNumber,
                'type' => $request->input('type'),
                'customer_name' => $request->input('customer_name'),
                'customer_phone' => $request->input('customer_phone'),
                'customer_email' => $request->input('customer_email'),
                'payment_method' => $request->input('payment_method'),
                'payment_status' => 'pendiente',
                'status' => 'pendiente',
                'qr_path' => null,
            ]);

            $total = 0;
            foreach ($request->input('items') as $it) {
                $order->orderItems()->create([
                    'product_id' => $it['product_id'],
                    'quantity' => $it['quantity'],
                    'price' => $it['price'],
                    'subtotal' => $it['subtotal'],
                ]);
                $total += floatval($it['subtotal']);
            }

            Storage::disk('public')->makeDirectory('qrs');
            $qrName = 'qr_' . $order->id . '.svg';
            $qrPath = 'qrs/' . $qrName;
            $qrData = [
                'order_number' => $order->order_number,
                'type' => $order->type,
                'customer_name' => $order->customer_name,
                'customer_phone' => $order->customer_phone,
                'customer_email' => $order->customer_email,
                'payment_method' => $order->payment_method,
                'payment_status' => $order->payment_status,
                'status' => $order->status,
                'total' => $total,
                'items' => $order->items->map(fn($item) => [
                    'product' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal
                ]),
            ];

            Storage::disk('public')->put($qrPath, QrCode::format('svg')->size(300)->generate(json_encode($qrData)));
            $order->qr_path = $qrPath;
            $order->save();

            if ($request->has('payment') && $request->input('payment.amount')) {
                $pay = $request->input('payment');
                $orderPayment = OrderPayment::create([
                    'order_id' => $order->id,
                    'transaction_id' => $pay['transaction_id'] ?? null,
                    'reference' => $pay['reference'] ?? null,
                    'gateway' => $pay['gateway'] ?? null,
                    'receipt_path' => $pay['receipt_path'] ?? null,
                    'payment_data' => $pay['payment_data'] ?? null,
                    'status' => $pay['status'] ?? 'pendiente',
                    'amount' => $pay['amount'],
                ]);

                if (($pay['status'] ?? null) === 'pagado') {
                    $order->payment_status = 'pagado';
                    $order->save();
                }
            }

            DB::commit();
            return redirect()->route('order.confirm-mobile', $order->id);

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Error al crear la orden: ' . $e->getMessage()]);
        }
    }

    // Confirmación de orden
    public function confirmation($id)
    {
        $order = Order::with('items.product')->findOrFail($id); 
        return view('order.confirm-mobile', compact('order')); 
    }
}
