@extends('admin.index')
{{-- sidebar --}}
@include('admin.layout.sidebar')

<main class="main p-4">
    <div class="max-w-md mx-auto bg-white p-6 shadow rounded">
        <div class="text-center mb-6">
            <h1 class="text-xl font-bold">Mini Factura</h1>
            <p class="text-gray-600">Orden #{{ $order->order_number }}</p>
        </div>

        <div class="mb-4">
            <p><strong>Cliente:</strong> {{ $order->customer_name }}</p>
            @if($order->customer_phone)
                <p><strong>Teléfono:</strong> {{ $order->customer_phone }}</p>
            @endif
            @if($order->customer_email)
                <p><strong>Email:</strong> {{ $order->customer_email }}</p>
            @endif
            <p><strong>Tipo de pedido:</strong> {{ $order->type == 'comer_aqui' ? 'Comer aquí' : 'Para llevar' }}</p>
        </div>

        <div class="mb-4">
            <table class="w-full text-sm border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2 border">Producto</th>
                        <th class="p-2 border">Cantidad</th>
                        <th class="p-2 border">Precio</th>
                        <th class="p-2 border">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr class="text-center">
                        <td class="p-2 border">{{ $item->product->name }}</td>
                        <td class="p-2 border">{{ $item->quantity }}</td>
                        <td class="p-2 border">${{ number_format($item->price, 2, ',', '.') }}</td>
                        <td class="p-2 border">${{ number_format($item->subtotal, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-right mb-4">
            <p><strong>Total:</strong> ${{ number_format($order->items->sum('subtotal'), 2, ',', '.') }}</p>
            <p><strong>Pago:</strong> {{ ucfirst($order->payment_status) }}</p>
        </div>

        @if($order->qr_path)
            <div class="text-center mt-4">
                <?= QrCode::size(300)->generate($order->order_number) ?>
            </div>
        @endif

        <div class="mt-4 text-center">
            <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded">Imprimir Factura</button>
        </div>
    </div>
</main>
