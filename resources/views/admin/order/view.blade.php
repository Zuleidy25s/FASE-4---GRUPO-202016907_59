@extends('admin.index')
{{-- Cabecera web --}}
{{-- sidebar --}}
@include('admin.layout.sidebar')
<main id="main" class="main py-10 px-10">
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">Detalle del Pedido #{{ $order->order_number }}</h1>

        {{-- Información del cliente --}}
        <div class="bg-white p-6 rounded shadow mb-6">
            <p><strong>Cliente:</strong> {{ $order->customer_name }}</p>
            <p><strong>Teléfono:</strong> {{ $order->customer_phone ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $order->customer_email ?? 'N/A' }}</p>
            <p><strong>Tipo de pedido:</strong> {{ ucfirst(str_replace('_', ' ', $order->type)) }}</p>
            <p><strong>Estado:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Total:</strong> ${{ number_format($order->items->sum(fn($i) => $i->subtotal), 2) }}</p>
        </div>

        {{-- Productos --}}
        <h2 class="text-xl font-bold mb-2">Productos</h2>
        <div class="overflow-x-auto">
            <table class="w-full table-auto border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-2 py-1 text-left">Producto</th>
                        <th class="border px-2 py-1 text-left">Cantidad</th>
                        <th class="border px-2 py-1 text-left">Precio</th>
                        <th class="border px-2 py-1 text-left">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->items as $item)
                        <tr>
                            <td class="border px-2 py-1">{{ $item->product?->name ?? 'Producto no encontrado' }}</td>
                            <td class="border px-2 py-1">{{ $item->quantity }}</td>
                            <td class="border px-2 py-1">${{ number_format($item->price, 2) }}</td>
                            <td class="border px-2 py-1">${{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="border px-2 py-1 text-center" colspan="4">No hay productos</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Información de pago --}}
        <h2 class="text-xl font-bold mt-6 mb-2">Pago</h2>
        <div class="bg-white p-4 rounded shadow">
            <p><strong>Método:</strong> {{ $order->payment?->gateway ?? 'N/A' }}</p>
            <p><strong>Estado:</strong> {{ ucfirst($order->payment?->status ?? 'N/A') }}</p>
            <p><strong>Valor pagado:</strong> ${{ number_format($order->payment?->amount ?? 0, 2) }}</p>
        </div>

        <a href="{{ route('admin.orders.index') }}" class="mt-6 inline-block px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
            ← Volver a Órdenes
        </a>
    </div>
</main>
