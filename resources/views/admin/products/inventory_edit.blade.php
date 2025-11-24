@extends('admin.index')
{{-- Sidebar --}}
@include('admin.layout.sidebar')

<main id="main" class="main p-6 min-h-screen">
    <div class="container mx-auto">

        {{-- Messages --}}
        @if(Session::has('message'))
            <div class="mb-4 px-4 py-3 rounded {{ Session::get('typealert') == 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ Session::get('message') }}
            </div>
        @endif

        <!-- Page Title -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold mb-2">Editar - {{ $inventory->name }}</h1>
            <nav class="text-gray-500 text-sm" aria-label="breadcrumb">
                <ol class="flex list-reset">
                    <li><a href="{{ url('/admin') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ url('/admin/products/all') }}" class="text-blue-600 hover:underline">Productos</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ url('/admin/product/'.$inventory->getProduct->id.'/inventory') }}" class="text-blue-600 hover:underline">{{ $inventory->getProduct->name }}</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-700">Editar Inventario</li>
                </ol>
            </nav>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Formulario Editar Inventario --}}
            <div class="bg-white p-4 rounded shadow">
                <span class="block bg-gray-100 px-2 py-1 font-medium mb-4">Editar inventario</span>

                <form action="{{ url('/admin/product/'.$inventory->id.'/edit_inventory') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block mb-1 font-medium">Nombre:</label>
                        <input type="text" name="name" value="{{ $inventory->name }}" required class="border border-gray-300 rounded px-3 py-2 w-full">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Cantidad en inventario:</label>
                        <input type="number" name="inventory" value="{{ $inventory->quantity }}" required class="border border-gray-300 rounded px-3 py-2 w-full">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Precio ({{ config('cms.currency') }}):</label>
                        <input type="number" name="price" value="{{ $inventory->price }}" required class="border border-gray-300 rounded px-3 py-2 w-full">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Inventario sin límite:</label>
                        <select id="limited" name="limited" class="border border-gray-300 rounded px-3 py-2 w-full">
                            <option value="0" {{ $inventory->limited == 0 ? 'selected' : '' }}>Limitado</option>
                            <option value="1" {{ $inventory->limited == 1 ? 'selected' : '' }}>Ilimitado</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Inventario mínimo:</label>
                        <input type="number" name="minimum" value="{{ $inventory->minimum }}" required class="border border-gray-300 rounded px-3 py-2 w-full">
                    </div>

                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Actualizar</button>
                </form>
            </div>

            {{-- Variantes --}}
            <div class="md:col-span-2 bg-white p-4 rounded shadow">
                <span class="block mb-4 text-lg font-semibold">Variantes</span>

                {{-- Form Variantes --}}
                <form action="{{ url('/admin/product/'.$inventory->id.'/variant_product') }}" method="POST" class="flex flex-wrap gap-2 mb-4">
                    @csrf
                    <input type="text" name="name" placeholder="Nombre variante" class="border border-gray-300 rounded px-3 py-2 flex-1">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Guardar</button>
                </form>

                {{-- Tabla Variantes --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nombre variante</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($inventory->getVariants as $variant)
                                <tr>
                                    <td class="px-4 py-2">{{ $variant->id }}</td>
                                    <td class="px-4 py-2">{{ $variant->name }}</td>
                                    <td class="px-4 py-2">
                                        @if(kvfj(Auth::user()->permissions, 'variant_delete'))
                                            <a href="{{ url('/admin/product/'.$variant->id.'/variant/delete') }}" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">Eliminar</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</main>
