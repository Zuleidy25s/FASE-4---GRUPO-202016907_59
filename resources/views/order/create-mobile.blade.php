@extends('index')

@section('content')

<div class="w-full min-h-screen bg-gray-100 flex flex-col">
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- HEADER FIJO ARRIBA --}}
    <div class="w-full bg-white shadow px-4 py-3 flex items-center justify-between z-10">
        <div>
            <h1 class="text-xl font-bold text-gray-700">Crear Pedido</h1>
            <p class="text-xs text-gray-500 ">Tipo: <strong class="rounded-full bg-[#57F527] p-1 text-xs">{{ $typeEnum }}</strong></p>
        </div>

        <a href="{{ route('home') }}" class="text-blue-600 text-sm hover:underline">
            ← Volver
        </a>
    </div>

    {{-- FORMULARIO PRINCIPAL --}}
    <form id="orderForm" action="{{ route('order.store-mobile') }}" method="POST" class="flex flex-col flex-1 pb-20 lg:flex-row lg:pb-0">
        @csrf
        <input type="hidden" name="type" value="{{ $typeEnum }}">

        {{-- SIDEBAR IZQUIERDO (Desktop) --}}
        <aside class="w-64 bg-white border-r p-6 hidden lg:block">
            <h2 class="text-lg font-bold mb-4 text-gray-700">Categorías</h2>
            <ul class="space-y-2">
                <li>
                    <button onclick="filterCategory('all')" type="button" class="w-full py-2 px-3 rounded-lg bg-blue-100 hover:bg-blue-200 text-left text-blue-800 font-semibold">
                        TODOS
                    </button>
                </li>
                @foreach($categories as $cat)
                    <li>
                        <button onclick="filterCategory({{ $cat->id }})" type="button" class="w-full py-2 px-3 rounded-lg bg-gray-50 hover:bg-gray-200 text-left text-gray-600">
                            {{ $cat->name }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="mt-10 space-y-3">
                <button type="button" id="clearItems" class="w-full py-2 border rounded-lg text-gray-700">Limpiar Pedido</button>
                <a href="{{ route('order.select-mobile') }}" class="block w-full py-2 text-center border rounded-lg text-red-600">Cancelar</a>
            </div>
        </aside>

        {{-- CONTENIDO CENTRAL --}}
        <div class="flex-1 p-4 lg:p-6 overflow-y-auto">

            {{-- DATOS DEL CLIENTE --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 bg-white p-4 rounded-lg shadow-sm">
                <h2 class="col-span-1 md:col-span-3 text-lg font-bold text-gray-700 mb-2 border-b pb-2">Datos del Cliente</h2>
                <div>
                    <label class="text-sm text-gray-600 font-medium">Nombre del cliente</label>
                    <input type="text" name="customer_name" required class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 text-sm" value="{{ old('customer_name') }}">
                </div>
                <div>
                    <label class="text-sm text-gray-600 font-medium">Teléfono</label>
                    <input type="text" name="customer_phone" class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 text-sm" value="{{ old('customer_phone') }}">
                </div>
                <div>
                    <label class="text-sm text-gray-600 font-medium">Email</label>
                    <input type="email" name="customer_email" class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 text-sm" value="{{ old('customer_email') }}">
                </div>
            </div>

            {{-- MÉTODO DE PAGO --}}
            <div class="mb-6 bg-white p-4 rounded-lg shadow-sm">
                <label class="text-lg font-bold text-gray-700 mb-2 block border-b pb-2">Forma de pago</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-2">
                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" value="rapida" class="peer hidden" {{ old('payment_method')=='rapida' ? 'checked':'' }}>
                        <div class="p-3 border rounded-lg text-sm text-center peer-checked:border-blue-500 peer-checked:bg-blue-50">Pago rápido (online)</div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" value="manual" class="peer hidden" {{ old('payment_method')=='manual' ? 'checked':'' }}>
                        <div class="p-3 border rounded-lg text-sm text-center peer-checked:border-blue-500 peer-checked:bg-blue-50">Pago en punto</div>
                    </label>
                </div>
            </div>

            {{-- PASARELA DE BANCOS --}}
            <div id="bankPayment" class="hidden bg-white shadow border p-5 rounded-lg mb-6">
                <h3 class="font-bold text-gray-700 mb-3 border-b pb-2">Selecciona tu banco</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach(['Bancolombia', 'Nequi', 'Davivienda', 'BBVA','Banco de Bogotá', 'Banco Agrario', 'AV Villas', 'PSE'] as $bank)
                        <label class="cursor-pointer">
                            <input type="radio" name="bank" value="{{ $bank }}" class="hidden peer">
                            <div class="border rounded-lg p-3 text-center text-xs peer-checked:border-blue-500 peer-checked:bg-blue-50">{{ $bank }}</div>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- FILTRO DE CATEGORÍAS EN MÓVIL --}}
            <div class="mb-4 lg:hidden">
                <label for="mobile-category-filter" class="text-sm font-medium text-gray-700 block mb-1">Filtrar por Categoría</label>
                <select id="mobile-category-filter" onchange="filterCategory(this.value)" class="w-full p-2 border rounded-lg bg-white text-gray-700">
                    <option value="all">TODAS las categorías</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- PRODUCTOS --}}
            <h2 class="text-xl font-bold text-gray-700 mb-4">Productos</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-4 lg:gap-6">
                @foreach($products as $product)
                    <div class="bg-white shadow rounded-lg p-3 flex flex-col product-card" data-category="{{ $product->category_id }}">
                        <div class="w-full h-20 sm:h-28 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('storage/img/uploads_product_image/'. $product->image) }}" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain">
                        </div>
                        <p class="font-semibold text-gray-700 text-sm truncate">{{ $product->name }}</p>
                        <p class="text-gray-500 text-xs mb-1 hidden sm:block">{{ $product->cat->name }}
                                @if($product->subcategory_id != "0") >> {{ $product->getSubcategory->name }} @endif</p>
                        <p class="font-bold text-gray-900 text-base">$ {{ number_format($product->price) }}</p>
                        <button type="button" class="btn-add mt-2 py-2 px-3 border border-blue-500 text-blue-600 rounded-lg hover:bg-blue-50 text-xs sm:text-sm transition duration-150" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}">
                            Añadir
                        </button>
                    </div>
                @endforeach
            </div>

        </div>

        {{-- CARRITO / SIDEBAR (Desktop) --}}
        <aside class="w-72 bg-white border-l p-6 hidden lg:flex lg:flex-col">
            <h3 class="text-xl font-bold mb-4">Mi Pedido</h3>
            <div id="cart-items" class="flex-1 space-y-2 text-sm overflow-y-auto">
                <p class="text-gray-500 text-center mt-10">Tu pedido está vacío.</p>
            </div>
            <p class="text-xl font-bold mt-4">Total: $ <span id="cart-total-desktop">0</span></p>
            <button type="submit" class="mt-5 bg-blue-600 text-white py-3 rounded-lg text-lg w-full">Pagar ahora</button>
        </aside>

        {{-- MODAL / OFF-CANVAS DEL CARRITO PARA MÓVIL --}}
        <div id="mobileCartModal" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden" onclick="closeMobileCart()">
            <div class="bg-white absolute bottom-0 left-0 right-0 h-3/4 rounded-t-lg p-6 flex flex-col" onclick="event.stopPropagation()">
                <div class="flex justify-between items-center border-b pb-3 mb-4">
                    <h3 class="text-2xl font-bold">Mi Pedido</h3>
                    <button type="button" onclick="closeMobileCart()" class="text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
                </div>
                <div id="cart-items-mobile" class="flex-1 space-y-3 text-sm overflow-y-auto mb-4">
                    <p class="text-gray-500 text-center mt-10">Tu pedido está vacío.</p>
                </div>
                <div class="mt-auto border-t pt-4">
                    <div class="flex justify-between items-center mb-3">
                        <p class="text-xl font-bold">Total:</p>
                        <p class="text-2xl font-extrabold text-blue-600">$ <span id="modal-cart-total">0</span></p>
                    </div>
                    <button type="button" id="clearItemsMobile" class="w-full py-2 border rounded-lg text-red-600 hover:bg-red-50">Limpiar Pedido</button>
                </div>
            </div>
        </div>

    </form>

    {{-- BARRA INFERIOR FIJA PARA MÓVIL --}}
    <div id="mobile-cart-bar" class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-2xl p-3 flex justify-between items-center z-20 lg:hidden">
        <div class="flex flex-col">
            <p class="text-sm text-gray-600">Total del Pedido</p>
            <p class="text-xl font-bold text-gray-800">$ <span id="cart-total-mobile">0</span></p>
        </div>
        <div class="flex gap-2">
            <button type="button" id="openMobileCart" class="bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold text-base shadow-md disabled:opacity-50" disabled>
                Ver Pedido (<span id="cart-count-mobile">0</span>)
            </button>
            <button type="submit" form="orderForm" class="bg-green-600 text-white py-2 px-4 rounded-lg font-semibold text-base shadow-md">
                Pagar ahora
            </button>
        </div>
    </div>

</div>


<script>
    // **********************************************
    // Lógica de Filtrado (Se usa para desktop y el select móvil)
    // **********************************************
    function filterCategory(categoryId) {
        const cards = document.querySelectorAll('.product-card');
        const catId = categoryId === 'all' ? 'all' : parseInt(categoryId);

        cards.forEach(card => {
            const cardCat = parseInt(card.getAttribute('data-category'));

            if (catId === 'all' || cardCat === catId) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }

    // **********************************************
    // Lógica del Carrito
    // **********************************************
    let cart = [];
    let total = 0;

    document.addEventListener('DOMContentLoaded', () => {
        const buttons = document.querySelectorAll('.btn-add');
        const cartContainerDesktop = document.getElementById('cart-items');
        const cartContainerMobile = document.getElementById('cart-items-mobile');
        const totalSpanDesktop = document.getElementById('cart-total-desktop');
        const totalSpanMobile = document.getElementById('cart-total-mobile');
        const modalTotalSpan = document.getElementById('modal-cart-total');
        const cartCountMobile = document.getElementById('cart-count-mobile');
        const clearBtnDesktop = document.getElementById('clearItems');
        const clearBtnMobile = document.getElementById('clearItemsMobile');
        const openMobileCartBtn = document.getElementById('openMobileCart');

        // Función para agregar producto
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
                    cart.push({ id, name, price, qty: 1, subtotal: price });
                }

                updateCart();
            });
        });

        // Limpiar carrito (Desktop y Mobile)
        const clearCart = () => {
             if (confirm("¿Estás seguro de que quieres limpiar todo el pedido?")) {
                cart = [];
                total = 0;
                updateCart();
                closeMobileCart(); // Cerrar modal al limpiar
            }
        };

        clearBtnDesktop.addEventListener('click', clearCart);
        clearBtnMobile.addEventListener('click', clearCart);
        

        // Pre-envío del formulario
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

            // Limpiar inputs antiguos y añadir los nuevos
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


        // Renderizado del carrito
        function updateCart() {
            cartContainerDesktop.innerHTML = "";
            cartContainerMobile.innerHTML = "";
            total = 0;

            if (cart.length === 0) {
                cartContainerDesktop.innerHTML = `<p class="text-gray-500 text-center mt-10">Tu pedido está vacío.</p>`;
                cartContainerMobile.innerHTML = `<p class="text-gray-500 text-center mt-10">Tu pedido está vacío.</p>`;
                openMobileCartBtn.disabled = true;
            } else {
                openMobileCartBtn.disabled = false;
            }

            cart.forEach((item, index) => {
                total += item.subtotal;

                const itemHtml = (isMobile) => `
                    <div class="p-3 border rounded-lg flex justify-between items-center bg-gray-50">
                        <div class="w-2/5 pr-1">
                            <p class="font-semibold text-sm">${item.name}</p>
                            <p class="text-xs text-gray-500">$ ${item.price}</p>
                        </div>
                        <div class="flex items-center space-x-1">
                            <button class="qty-minus px-2 py-1 bg-red-200 rounded text-sm" data-index="${index}">-</button>
                            <span class="px-1 text-sm">${item.qty}</span>
                            <button class="qty-plus px-2 py-1 bg-green-200 rounded text-sm" data-index="${index}">+</button>
                        </div>
                        <p class="font-bold w-1/5 text-right text-sm">$ ${item.subtotal}</p>
                        <button class="delete-item text-red-600 font-bold ml-2 text-lg" data-index="${index}">✕</button>
                    </div>
                `;
                
                cartContainerDesktop.innerHTML += itemHtml(false);
                cartContainerMobile.innerHTML += itemHtml(true);
            });

            totalSpanDesktop.textContent = total;
            totalSpanMobile.textContent = total;
            modalTotalSpan.textContent = total;
            cartCountMobile.textContent = cart.length;

            attachQuantityEvents();
        }

        function attachQuantityEvents() {
            // Eventos para sumar, restar y eliminar (funcionan en ambos contenedores)
            const updateItemQuantity = (index, change) => {
                if (cart[index]) {
                    cart[index].qty += change;
                    if (cart[index].qty <= 0) {
                        cart.splice(index, 1);
                    } else {
                        cart[index].subtotal = cart[index].qty * cart[index].price;
                    }
                    updateCart();
                }
            };
            
            const deleteItem = (index) => {
                cart.splice(index, 1);
                updateCart();
            }

            document.querySelectorAll('.qty-plus').forEach(btn => {
                btn.onclick = () => updateItemQuantity(btn.dataset.index, 1);
            });

            document.querySelectorAll('.qty-minus').forEach(btn => {
                btn.onclick = () => updateItemQuantity(btn.dataset.index, -1);
            });

            document.querySelectorAll('.delete-item').forEach(btn => {
                btn.onclick = () => deleteItem(btn.dataset.index);
            });
        }
        
        // Inicializar
        updateCart();
    });

    // **********************************************
    // Lógica de Modal / Off-Canvas Móvil
    // **********************************************
    
    const mobileCartModal = document.getElementById('mobileCartModal');
    const openMobileCartBtn = document.getElementById('openMobileCart');

    function openMobileCart() {
        if (cart.length > 0) {
            mobileCartModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); // Para evitar el scroll del fondo
        }
    }

    function closeMobileCart() {
        mobileCartModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    openMobileCartBtn.addEventListener('click', openMobileCart);


    // **********************************************
    // JS para mostrar bancos
    // **********************************************
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
        
        // Ejecutar al inicio por si hay un valor pre-seleccionado con old()
        const initialPaymentMethod = document.querySelector('input[name="payment_method"]:checked')?.value;
         if (initialPaymentMethod === "rapida") {
            bankSection.classList.remove('hidden');
        }
    });
</script>

@endsection