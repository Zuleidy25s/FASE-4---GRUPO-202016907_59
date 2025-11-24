@extends('index')

@section('content')

<div class="flex w-full h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    <div class="w-56 border-r px-4 py-6 flex flex-col">
        
        {{-- Flecha y logo --}}
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('home') }}" class="text-xl">←</a>
            <div class="border px-2 py-1 text-sm">Logo</div>
        </div>

        <h2 class="font-bold text-lg mb-4">Categorías</h2>

        <ul class="space-y-3">
            @foreach($categories as $cat)
            <li>
                <button 
                    onclick="filterCategory({{ $cat->id }})"
                    class="w-full text-left flex items-center gap-2 py-1 hover:bg-gray-200 px-2 rounded"
                >
                    ☆ {{ $cat->name }}
                </button>
            </li>
            @endforeach
        </ul>

        <div class="mt-auto flex flex-col gap-3">
            <button class="w-full border py-2 rounded">Reiniciar Pedido</button>
            <button class="w-full border py-2 rounded">X Cancelar</button>
        </div>
    </div>

    {{-- CONTENIDO PRINCIPAL --}}
    <div class="flex-1 p-8 overflow-y-auto">

        {{-- TOP VENTAS --}}
        <h2 class="text-lg font-bold mb-4">TOP VENTAS</h2>

        <div class="grid grid-cols-3 gap-6 mb-10">
            @foreach($products->take(3) as $product)
            <div class="border rounded p-3 flex flex-col product-card" data-category="{{ $product->category_id }}">
                
                <div class="w-full h-28 bg-gray-200 mb-3 flex items-center justify-center">
                    <span class="text-gray-500">Img</span>
                </div>

                <div class="text-sm font-semibold">{{ $product->name }}</div>
                <div class="text-xs text-gray-500">(Nombre de categoría)</div>
                <div class="font-bold mt-2">$ {{ number_format($product->price) }}</div>

                <button class="mt-3 border py-1 text-sm rounded hover:bg-gray-100">Agregar</button>
            </div>
            @endforeach
        </div>

        {{-- ANTOJOS DE SAL --}}
        <h2 class="text-lg font-bold mb-3">ANTOJOS DE SAL</h2>

        <div class="grid grid-cols-3 gap-6">
            @foreach($products->skip(3)->take(3) as $product)
            <div class="border rounded p-3 flex flex-col product-card" data-category="{{ $product->category_id }}">
                
                <div class="w-full h-28 bg-gray-200 mb-3 flex items-center justify-center">
                    <span class="text-gray-500">Img</span>
                </div>

                <div class="text-sm font-semibold">{{ $product->name }}</div>
                <div class="text-xs text-gray-500">(Nombre de categoría)</div>
                <div class="font-bold mt-2">$ {{ number_format($product->price) }}</div>

                <button 
                    class="btn-add mt-3 border py-1 text-sm rounded hover:bg-gray-100 w-full"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->name }}"
                    data-price="{{ $product->price }}"
                >
                    Agregar
                </button>

            </div>
            @endforeach
        </div>

    </div>

    {{-- CARRITO --}}
    <div class="w-64 border-l p-6">

        <h3 class="font-bold mb-4 text-lg">🛒 MI PEDIDO</h3>

        <div id="cart-items" class="text-sm space-y-1">
            {{-- Items dinámicos --}}
        </div>

        <p class="font-bold mt-6 text-lg">
            Total: $ <span id="cart-total">0</span>
        </p>

        <button class="mt-6 bg-black text-white w-full py-3 rounded text-lg">
            PAGAR AHORA
        </button>
    </div>

</div>

{{-- FILTRO JS --}}
<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".btn-add").forEach(btn => {
        btn.addEventListener("click", function(){
            const product = {
                id: this.dataset.id,
                name: this.dataset.name,
                price: this.dataset.price
            };

            if(window.opener){
                window.opener.postMessage({ 
                    source: "catalog",
                    product: product 
                }, "*");

                alert("Producto añadido. Se agregó en la ventana principal.");
            } else {
                alert("No se detectó ventana principal.");
            }
        });
    });

});
</script>


@endsection
