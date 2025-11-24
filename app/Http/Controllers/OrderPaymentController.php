<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderPayment;
use Illuminate\Http\Request;

class OrderPaymentController extends Controller
{
    public function processPayment(Request $request, Order $order)
    {
        // Pago MANUAL (en el lugar)
        if ($order->payment_method === 'manual') {

            OrderPayment::create([
                'order_id' => $order->id,
                'status' => 'pendiente',
                'amount' => $order->items->sum('subtotal'),
            ]);

            $order->update(['payment_status' => 'pendiente']);

            return view('order.ticket', compact('order'));
        }

        // Pago RÁPIDO (online)
        // Aquí simulo la pasarela por ahora
        $transactionId = 'TRX-' . strtoupper(uniqid());

        OrderPayment::create([
            'order_id' => $order->id,
            'transaction_id' => $transactionId,
            'gateway' => 'demo-gateway',
            'status' => 'pagado',
            'amount' => $order->items->sum('subtotal'),
            'payment_data' => [
                'message' => 'Pago simulado exitoso',
                'transaction_id' => $transactionId
            ]
        ]);

        $order->update(['payment_status' => 'pagado']);

        return view('order.ticket', compact('order'));
    }
}
