@extends('index')

@section('content')
<!-- Incluye la hoja de estilos de Fancybox -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />

<style>
    .selected-btn {
        background-color: #034fa0; /* Color de fondo deseado */
        color: #fff; /* Color de texto deseado */
        border: none !important;
    }

    .btn-quantity {
        width: 20px;
        height: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0;
    }
</style>

<div class="product_single">
    <div class="inside">
        <div class="container my-4">
            {{-- banner close and share --}}
            <div class="row mt-4 mb-3">
                <div class="col">
                    <a href="{{ url('/')}}">
                        <i class="bi bi-arrow-left text-dark h2 btn-shadow-product"></i>
                    </a>
                </div>
                <div class="col d-flex justify-content-end">
                    <a href="#" class="btn-shadow-product">
                        <i class="bi bi-heart text-dark h4"></i>
                    </a>
                    <a href="" class="btn-shadow-product">
                        <i class="bi bi-share text-dark h4"></i>
                    </a>
                </div>
            </div>

            <div class="row">
            
                <!-- Imagen de producto y galeria de ese producto !-->
                <div class="col-md-4">
                    <div id="productCarousel" class="carousel slide w-100" data-ride="carousel">
                        <!-- Indicadores -->
                        <ol class="carousel-indicators">
                            <li data-target="#productCarousel" data-slide-to="0" class="active" style="border-radius: 100% !important; width: 8px; height: 8px;"></li>
                            @if(count($product->getGallery) > 0)
                                @foreach($product->getGallery as $index => $gallery)
                                    <li data-target="#productCarousel" data-slide-to="{{ $index + 1 }}" style="border-radius: 100% !important; width: 8px; height: 8px;"></li>
                                @endforeach
                            @endif
                        </ol>
                        
                        <div class="carousel-inner" style="border-radius: 6px !important; overflow: hidden;">
                            <div class="carousel-item active">
                                <a href="{{ url('/storage/img/uploads_product_image/'.$product->image) }}" data-fancybox="gallery">
                                    <img src="{{ url('/storage/img/uploads_product_image/'.$product->image) }}" 
                                         class="d-block w-100" style="height: 500px !important;">
                                </a>
                            </div>
                            @if(count($product->getGallery) > 0)
                                @foreach($product->getGallery as $gallery)
                                    <div class="carousel-item">
                                        <a href="{{ url('storage/img/uploads_product/'. $gallery->file_path) }}" data-fancybox="gallery">
                                            <img src="{{ asset('storage/img/uploads_product/'. $gallery->file_path) }}" 
                                                 class="d-block w-100" style="height: 500px !important;">
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                {{-- Informacion de producto --}}
                <div class="col-md-8">
                    {{-- Información de product  --}}
                    <div class="d-flex flex-column flex-sm-row border-bottom m-2">
                        <h2 class="title font-weight-bold">{{ $product->name }}</h2>
                        <div class="col my-1 d-flex justify-content-sm-end justify-content-start">
                            <span>
                                <em class="font-weight-bold">Ref:</em> 
                                {{ $product->code }}
                            </span>
                            @php
                                $specificInventory = $product->getInventory()->orderBy('created_at', 'desc')->first();
                            @endphp
                            <span class="">{{ $specificInventory ? $specificInventory->quantity : 'N/A' }} <em>Articulos</em></span>
                        </div>
                    </div>
                    {{-- banner de categorias --}}
                    <div class=" mx-3">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item" style="font-size: 0.8em;">
                                    {{ $product->cat->name }} / @if($product->subcategory_id != "0")
                                    {{ $product->getSubcategory->name }}
                                @endif
                            </li>
                            <!-- Puedes añadir más elementos de lista aquí -->
                        </ul>
                    </div>
                    {{-- description order --}}
                    <div class="">
                        <div class="">
                            <form action="{{ url('/cart/product/' . $product->id . '/add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="inventory_id" id="inventory_id" value="">
                                <input type="hidden" name="variant_id" id="variant_id" value="">
                            
                                <!-- Resto del formulario -->
                                <div class="my-3 mx-3">
                                    <span class="text-info font-weight-bold" style="font-size: 1.6em;">$ {{ number_format($product->price, 2, '.', ',') }}</span>
                                    <span class="font-weight-bold mx-3" style="font-size: 1.6em; text-decoration: line-through; opacity: 0.5;">$ {{ number_format($product->price / 2, 2, '.', ',') }}</span>
                                </div>
                            
                                <div class="content my-3 mx-3">
                                    {!! html_entity_decode($product->content) !!}
                                </div>
                            
                                <div class="container mt-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="font-weight-bold">Opciones de producto:</h5>
                                            <div class="btn-group" role="group" aria-label="Inventarios">
                                                @foreach ($product->getInventory as $inventory)
                                                    <button type="button" class="btn btn-outline-dark inventory-btn" data-inventory-id="{{ $inventory->id }}" name="inventory">
                                                        {{ $inventory->name }} ${{ $inventory->price }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                            
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <h5 class="font-weight-bold">Selecciona tu talla:</h5>
                                            <div class="btn-group" role="group" aria-label="Tallas" id="variants-container">
                                                <span class="text-muted">Selecciona un inventario primero.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="my-4 mx-3 d-flex align-items-center">
                                    <button type="button" class="btn btn-outline-dark btn-quantity" id="decrease-quantity">
                                        <i class="bi bi-dash-circle"></i>
                                    </button>
                                    <input 
                                        type="number" 
                                        name="quantity" 
                                        value="1" 
                                        min="1"
                                        class="text-center mx-2" 
                                        style="width: 60px; border-radius: 5px; border: none;" 
                                        id="add_to_cart_quantity"
                                    >
                                    <button type="button" class="btn btn-outline-dark btn-quantity" id="increase-quantity">
                                        <i class="bi bi-plus-circle"></i>
                                    </button>
                                </div>
                            
                                <div class="mx-3">
                                    <button type="submit" class="btn btn-info">Agregar al carrito</button>
                                    <a href="/" class="btn btn-success">WhatsApp</a>
                                </div>
                            </form>
                        </div> 
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluye la biblioteca de jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Incluye la biblioteca de Fancybox -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const decreaseButton = document.getElementById('decrease-quantity');
        const increaseButton = document.getElementById('increase-quantity');
        const quantityInput = document.getElementById('add_to_cart_quantity');
        const inventoryIdInput = document.getElementById('inventory_id');
        const variantIdInput = document.getElementById('variant_id');

        decreaseButton.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });

        increaseButton.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
        });

        const inventoryButtons = document.querySelectorAll('.inventory-btn');
        const variantsContainer = document.getElementById('variants-container');
        let selectedInventoryId = null;
        let selectedVariantId = null;

        inventoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remover la clase 'selected-btn' de todos los botones de inventario
                inventoryButtons.forEach(btn => btn.classList.remove('selected-btn'));
                // Agregar la clase 'selected-btn' al botón seleccionado
                this.classList.add('selected-btn');

                selectedInventoryId = this.getAttribute('data-inventory-id');
                inventoryIdInput.value = selectedInventoryId;

                // Limpiar el contenedor de variantes
                variantsContainer.innerHTML = '';

                // Buscar las variantes del inventario seleccionado
                @foreach ($product->getInventory as $inventory)
                    if (selectedInventoryId == '{{ $inventory->id }}') {
                        @if ($inventory->getVariants->isNotEmpty())
                            @foreach ($inventory->getVariants as $variant)
                                {
                                    const variantButton = document.createElement('button');
                                    variantButton.type = 'button';
                                    variantButton.className = 'variant-btn p-1 px-2 mx-1 border-0';
                                    variantButton.innerText = '{{ $variant->name }}';
                                    variantButton.setAttribute('data-variant-id', '{{ $variant->id }}');
                                    variantsContainer.appendChild(variantButton);
                                }
                            @endforeach
                        @else
                            variantsContainer.innerHTML = '<span class="text-danger">No hay variantes disponibles para este inventario.</span>';
                        @endif
                    }
                @endforeach

                // Agregar evento click a los nuevos botones de variante
                const variantButtons = document.querySelectorAll('.variant-btn');
                variantButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Remover la clase 'selected-btn' de todos los botones de variante
                        variantButtons.forEach(btn => btn.classList.remove('selected-btn'));
                        // Agregar la clase 'selected-btn' al botón seleccionado
                        this.classList.add('selected-btn');

                        selectedVariantId = this.getAttribute('data-variant-id');
                        variantIdInput.value = selectedVariantId;
                    });
                });
            });
        });
    });
</script>

{{-- Si hay mensajes en la sesión, los mostrará usando SweetAlert --}}
@if(Session::has('message'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var type = "{{ Session::get('typealert') }}";
            var message = "{{ Session::get('message') }}";

            // Configuración de las alertas
            var alertConfig = {
                success: {
                    icon: 'success',
                    title: '¡Éxito!',
                    color: '#28a745'  // Color verde para éxito
                },
                error: {
                    icon: 'error',
                    title: 'Error',
                    color: '#dc3545'  // Color rojo para error
                },
                warning: {
                    icon: 'warning',
                    title: 'Advertencia',
                    color: '#ffc107'  // Color amarillo para advertencia
                },
                info: {
                    icon: 'error',
                    title: 'Error',
                    color: '#dc3545'  // Color azul para información
                }
            };

            // Obtén la configuración correspondiente al tipo de alerta
            var config = alertConfig[type] || alertConfig.info;  // Usa configuración de 'info' por defecto

            Swal.fire({
                icon: config.icon,
                title: config.title,
                text: message,
                showConfirmButton: true,
                timer: 5000,
                customClass: {
                    title: 'swal-title',
                    container: 'swal-container'
                },
                willOpen: () => {
                    Swal.getContainer().querySelector('.swal-title').style.color = config.color;
                }
            });
        });
    </script>
@endif

@endsection
