@extends('index')

@section('content')

<div class="w-full min-h-screen bg-gray-100 flex flex-col">

    {{-- HEADER --}}
    <div class="w-full bg-white shadow px-6 py-4 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-700">Crear Pedido</h1>
            <p class="text-sm text-gray-500 ">Tipo: <strong class="rounded-full bg-[#57F527] p-1">{{ $typeEnum }}</strong></p>
        </div>

        <a href="{{ route('home') }}" class="text-blue-600 text-sm hover:underline">
            ← Volver
        </a>
    </div>

    {{-- FORMULARIO --}}
    <form id="orderForm" action="{{ route('order.store') }}" method="POST" class="flex flex-1">
        @csrf
        <input type="hidden" id="itemsData" name="items">

        <input type="hidden" name="type" value="{{ $typeEnum }}">

        {{-- SIDEBAR IZQUIERDO --}}
        <aside class="w-64 bg-white border-r p-6 hidden lg:block">
            <h2 class="text-lg font-bold mb-4 text-gray-700">Categorías</h2>

            <ul class="space-y-2">
                @foreach($categories as $cat)
                    <li>
                        <button 
                            onclick="filterCategory({{ $cat->id }})"
                            type="button"
                            class="w-full py-2 px-3 rounded-lg bg-gray-50 hover:bg-gray-200 text-left text-gray-600"
                        >
                            {{ $cat->name }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="mt-10 space-y-3">
                <button type="button" id="clearItems" class="w-full py-2 border rounded-lg text-gray-700">
                    Limpiar Pedido
                </button>

                <a href="{{ route('home') }}" class="block w-full py-2 text-center border rounded-lg text-red-600">
                    Cancelar
                </a>
            </div>
        </aside>

        {{-- CONTENIDO CENTRAL --}}
        <div class="flex-1 p-6 overflow-y-auto">

            {{-- DATOS DEL CLIENTE --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="text-sm text-gray-600 font-medium">Nombre del cliente</label>
                    <input type="text" name="customer_name" required 
                        class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400"
                        value="{{ old('customer_name') }}">
                </div>

                <div>
                    <label class="text-sm text-gray-600 font-medium">Teléfono</label>
                    <input type="text" name="customer_phone"
                        class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400"
                        value="{{ old('customer_phone') }}">
                </div>

                <div>
                    <label class="text-sm text-gray-600 font-medium">Email</label>
                    <input type="email" name="customer_email"
                        class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400"
                        value="{{ old('customer_email') }}">
                </div>
            </div>

            {{-- MÉTODO DE PAGO --}}
            <div class="mb-6">
                <label class="text-sm font-medium text-gray-700">Forma de pago</label>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-2">

                    {{-- Pago rápido --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" value="rapida"
                            class="peer hidden" 
                            {{ old('payment_method')=='rapida' ? 'checked':'' }}>
                        <div class="p-3 border rounded-lg peer-checked:border-blue-500 peer-checked:bg-blue-50">
                            Pago rápido (online)
                        </div>
                    </label>

                    {{-- Pago manual --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" value="manual"
                            class="peer hidden"
                            {{ old('payment_method')=='manual' ? 'checked':'' }}>
                        <div class="p-3 border rounded-lg peer-checked:border-blue-500 peer-checked:bg-blue-50">
                            Pago en punto
                        </div>
                    </label>

                </div>
            </div>

            {{-- PASARELA DE BANCOS --}}
            <div id="bankPayment" class="hidden bg-white shadow border p-5 rounded-lg mb-6">
                <h3 class="font-bold text-gray-700 mb-3">Selecciona tu banco</h3>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                    @foreach([
                        'Bancolombia', 'Nequi', 'Davivienda', 'BBVA',
                        'Banco de Bogotá', 'Banco Agrario', 'AV Villas', 'PSE'
                    ] as $bank)
                        <label class="cursor-pointer">
                            <input type="radio" name="bank" value="{{ $bank }}" class="hidden peer">
                            <div class="border rounded-lg p-3 text-center peer-checked:border-blue-500 peer-checked:bg-blue-50">
                                {{ $bank }}
                            </div>
                        </label>
                    @endforeach

                </div>
            </div>

            {{-- PRODUCTOS (TOP VENTAS Y CATEGORÍAS) --}}
            <h2 class="text-xl font-bold text-gray-700 mb-4">Productos</h2>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                @foreach($products as $product)
                    <div 
                        class="bg-white shadow rounded-lg p-4 flex flex-col product-card"
                        data-category="{{ $product->category_id }}"
                    >
                        <div class="w-full h-28 bg-gray-100 rounded mb-3 flex items-center justify-center">
                            <span class="text-gray-500 text-sm">
                                <img src="{{ asset('storage/img/uploads_product_image/'. $product->image) }}" width="100px">
                            </span>
                        </div>

                        <p class="font-semibold text-gray-700 text-sm">{{ $product->name }}</p>
                        <p class="text-gray-500 text-xs mb-1"> {{ $product->cat->name }}
                                @if($product->subcategory_id != "0") >> {{ $product->getSubcategory->name }} @endif
                        </p>
                        <p class="font-bold text-gray-900">$ {{ number_format($product->price) }}</p>

                        <button 
                            type="button"
                            class="btn-add mt-3 py-2 px-3 border rounded-lg hover:bg-gray-100 text-sm"
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
        <aside class="w-72 bg-white border-l p-6 flex flex-col">
            <h3 class="text-xl font-bold mb-4">Mi Pedido</h3>

            <div id="cart-items" class="flex-1 space-y-2 text-sm overflow-y-auto"></div>

            <p class="text-xl font-bold mt-4">Total: $ <span id="cart-total">0</span></p>

            <button type="submit" class="mt-5 bg-blue-600 text-white py-3 rounded-lg text-lg w-full">
                Pagar ahora
            </button>

        </aside>

    </form>
</div>

<script>
    function filterCategory(categoryId) {
        const cards = document.querySelectorAll('.product-card');

        cards.forEach(card => {
            const cardCat = card.getAttribute('data-category');

            if (categoryId === 'all' || parseInt(cardCat) === categoryId) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }
</script>
{{-- carrito --}}
<script>
    let cart = [];
    let total = 0;

    document.addEventListener('DOMContentLoaded', () => {
        const buttons = document.querySelectorAll('.btn-add');
        const cartContainer = document.getElementById('cart-items');
        const totalSpan = document.getElementById('cart-total');
        const clearBtn = document.getElementById('clearItems');
        const itemsInput = document.getElementById('itemsInput');

        // Agregar producto
        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const name = btn.dataset.name;
                const price = parseInt(btn.dataset.price);

                const exists = cart.find(item => item.id == id);

                if (exists) {
                    exists.qty++;
                    exists.subtotal = exists.qty * exists.price;
                } else {
                    cart.push({
                        id,
                        name,
                        price,
                        qty: 1,
                        subtotal: price
                    });
                }

                updateCart();
            });
        });

        // Limpiar carrito
        clearBtn.addEventListener('click', () => {
            cart = [];
            total = 0;
            updateCart();
        });

        // 🟢 Antes de enviar, convertimos el carrito a formato del backend
        document.getElementById('orderForm').addEventListener('submit', (e) => {
            if (cart.length === 0) {
                e.preventDefault();
                alert("Debes agregar al menos un producto al pedido.");
                return;
            }

            const formatted = cart.map(item => ({
                product_id: item.id,
                quantity: item.qty,
                price: item.price,
                subtotal: item.subtotal
            }));

            document.querySelectorAll('.item-hidden').forEach(el => el.remove());
            const form = document.getElementById('orderForm');

            formatted.forEach((item, index) => {
                Object.keys(item).forEach(key => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.classList.add('item-hidden');
                    input.name = `items[${index}][${key}]`;
                    input.value = item[key];
                    form.appendChild(input);
                });
            });
        });


        // Renderizado
        function updateCart() {
            cartContainer.innerHTML = "";
            total = 0;

            cart.forEach((item, index) => {
                total += item.subtotal;

                cartContainer.innerHTML += `
                    <div class="p-3 border rounded-lg flex justify-between items-center bg-gray-50">
                        
                        <div class="w-40">
                            <p class="font-semibold">${item.name}</p>
                            <p class="text-xs text-gray-500">$ ${item.price}</p>
                        </div>

                        <div class="flex items-center space-x-1">
                            <!-- Botón Restar -->
                            <button 
                                class="qty-minus px-2 py-1 bg-red-200 rounded" 
                                data-index="${index}">
                                -
                            </button>

                            <!-- Cantidad -->
                            <span class="px-1">${item.qty}</span>

                            <!-- Botón Sumar -->
                            <button 
                                class="qty-plus px-2 py-1 bg-green-200 rounded" 
                                data-index="${index}">
                                +
                            </button>
                        </div>

                        <!-- Subtotal -->
                        <p class="font-bold w-10 text-right">$ ${item.subtotal}</p>

                        <!-- Eliminar -->
                        <button 
                            class="delete-item text-red-600 font-bold" 
                            data-index="${index}">
                            ✕
                        </button>
                    </div>
                `;
            });

            totalSpan.textContent = total;

            attachQuantityEvents();
        }

        function attachQuantityEvents() {
        // Sumar
        document.querySelectorAll('.qty-plus').forEach(btn => {
            btn.addEventListener('click', () => {
                let index = btn.dataset.index;
                cart[index].qty++;
                cart[index].subtotal = cart[index].qty * cart[index].price;
                updateCart();
            });
        });

        // Restar
        document.querySelectorAll('.qty-minus').forEach(btn => {
            btn.addEventListener('click', () => {
                let index = btn.dataset.index;

                if (cart[index].qty > 1) {
                    cart[index].qty--;
                    cart[index].subtotal = cart[index].qty * cart[index].price;
                } else {
                    cart.splice(index, 1); // Si llega a 0, eliminar
                }

                updateCart();
            });
        });

        // Eliminar
        document.querySelectorAll('.delete-item').forEach(btn => {
            btn.addEventListener('click', () => {
                let index = btn.dataset.index;
                cart.splice(index, 1);
                updateCart();
            });
        });
    }

});
</script>
{{-- JS para mostrar bancos --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const radios = document.querySelectorAll('input[name="payment_method"]');
        const bankSection = document.getElementById('bankPayment');

        radios.forEach(r => {
            r.addEventListener('change', () => {
                if (r.value === "rapida") {
                    bankSection.classList.remove('hidden');
                } else {
                    bankSection.classList.add('hidden');
                }
            });
        });
    });
</script>

@endsection
