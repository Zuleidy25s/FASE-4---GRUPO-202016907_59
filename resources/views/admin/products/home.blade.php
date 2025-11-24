@extends('admin.index')

{{-- Sidebar --}}
@include('admin.layout.sidebar')

<!-- Incluye la hoja de estilos de Fancybox -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />

<main id="main" class="main p-6 py-4 min-h-screen">
    <div class="container mx-auto">

        {{-- Mensajes de alerta --}}
        @if(Session::has('message'))
            <div class="mb-4 px-4 py-3 rounded {{ Session::get('typealert') == 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ Session::get('message') }}
            </div>
        @endif

        <!-- Page Title -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold mb-2">Productos</h1>
            <nav class="text-gray-500 text-sm" aria-label="breadcrumb">
                <ol class="list-reset flex">
                    <li><a href="{{ url('/admin') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-700">Productos</li>
                </ol>
            </nav>
        </div>

        {{-- Header con botones --}}
        <div class="flex flex-wrap justify-between items-center mb-6">
            @if(kvfj(Auth::user()->permissions, 'product_add'))
                <a href="{{ url('/admin/product/add') }}" class="px-4 py-2 border border-gray-800 rounded hover:bg-gray-800 hover:text-white transition">
                    Agregar producto
                </a>
            @endif

            <div class="relative inline-block text-left">
                <button id="btn_filter" class="inline-flex justify-center w-full px-4 py-2 border border-gray-800 rounded hover:bg-gray-800 hover:text-white transition">
                    Filtrar
                    <i class="fas fa-chevron-down ml-2"></i>
                </button>
                <ul class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow-lg hidden" id="dropdown_filter">
                    <li><a class="block px-4 py-2 hover:bg-gray-100" href="{{ url('/admin/products/1') }}">Públicos</a></li>
                    <li><a class="block px-4 py-2 hover:bg-gray-100" href="{{ url('/admin/products/0') }}">Borradores</a></li>
                    <li><a class="block px-4 py-2 hover:bg-gray-100" href="{{ url('/admin/products/trash') }}">Papelera</a></li>
                    <li><a class="block px-4 py-2 hover:bg-gray-100" href="{{ url('/admin/products/all') }}">Todos</a></li>
                </ul>
            </div>
        </div>

        {{-- Formulario de búsqueda --}}
        <div class="mb-6">
            <form action="{{ url('/admin/product/search') }}" method="POST" class="flex flex-wrap gap-4">
                @csrf
                <input type="text" name="search" class="border border-gray-300 rounded px-3 py-2 flex-1" placeholder="Ingrese su búsqueda">
                <select name="filter" class="border border-gray-300 rounded px-3 py-2">
                    <option value="0">Nombre del producto</option>
                    <option value="1">Código</option>
                </select>
                <select name="status" class="border border-gray-300 rounded px-3 py-2">
                    <option value="0">Borrador</option>
                    <option value="1">Públicos</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Buscar</button>
            </form>
        </div>

        {{-- Tabla de productos --}}
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Imagen</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nombres</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Precio min.</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($products as $p)
                    <tr>
                        <td class="px-4 py-2">{{ $p->id }}</td>
                        <td class="px-4 py-2">
                            @if($p->image)
                                <a href="{{ asset('storage/img/uploads_product_image/'. $p->image) }}" data-fancybox="gallery">
                                    <img src="{{ asset('storage/img/uploads_product_image/'. $p->image) }}" class="w-16 h-16 object-cover rounded">
                                </a>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            {{ $p->name }}
                            @if($p->status == "0")
                                <span class="ml-2 px-2 py-1 text-xs bg-blue-200 text-blue-800 rounded">Borrador</span>
                            @elseif($p->status == "1")
                                <span class="ml-2 px-2 py-1 text-xs bg-green-200 text-green-800 rounded">Publico</span>
                            @endif
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $p->cat->name }}
                                @if($p->subcategory_id != "0") >> {{ $p->getSubcategory->name }} @endif
                            </p>
                        </td>
                        <td class="px-4 py-2">{{ config('cms.currency') }}{{ $p->price }}</td>
                        <td class="px-4 py-2 flex gap-2">
							{{-- Editar --}}
							@if(kvfj(Auth::user()->permissions, 'product_edit'))
								<a href="{{ url('/admin/product/'.$p->id.'/edit') }}" 
								class="p-2 border border-gray-800 rounded hover:bg-gray-800 hover:text-white transition">
									<!-- Heroicon: Pencil -->
									<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
											d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M16.5 3.5l4 4L7 21H3v-4L16.5 3.5z"/>
									</svg>
								</a>
							@endif

							{{-- Inventario --}}
							@if(kvfj(Auth::user()->permissions, 'product_inventory'))
								<a href="{{ url('/admin/product/'.$p->id.'/inventory') }}" 
								class="p-2 border border-yellow-500 text-yellow-700 rounded hover:bg-yellow-500 hover:text-white transition">
									<!-- Heroicon: Archive Box -->
									<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
											d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0H4m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4"/>
									</svg>
								</a>
							@endif

							{{-- Eliminar / Restaurar --}}
							@if(kvfj(Auth::user()->permissions, 'product_delete'))
								@if(is_null($p->deleted_at))
									<button onclick="confirmDelete('{{ $p->id }}', event)" 
											class="p-2 border border-red-600 text-red-600 rounded hover:bg-red-600 hover:text-white transition">
										<!-- Heroicon: Trash -->
										<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
												d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2-4H7a2 2 0 00-2 2v2h14V5a2 2 0 00-2-2z"/>
										</svg>
									</button>
								@else
									<a href="{{ url('/admin/product/'.$p->id.'/restore') }}" 
									class="p-2 border border-gray-400 text-gray-700 rounded hover:bg-gray-400 hover:text-white transition">
										<!-- Heroicon: Arrow Counterclockwise -->
										<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
												d="M4 4v5h.582M20 20v-5h-.581M5.636 5.636a9 9 0 0112.728 12.728"/>
										</svg>
									</a>
								@endif
							@endif
						</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Paginación --}}
            <div class="mt-4 px-4">
                {!! $products->render() !!}
            </div>
        </div>

    </div>
</main>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

<script>
    // SweetAlert para eliminar
    function confirmDelete(id, event) {
        event.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ url("/admin/product") }}/' + id + '/delete';
            }
        });
    }

    // Inicializa Fancybox
    $(document).ready(function() {
        $("[data-fancybox='gallery']").fancybox();
        
        // Toggle dropdown filter
        $('#btn_filter').on('click', function() {
            $('#dropdown_filter').toggleClass('hidden');
        });
    });
</script>
