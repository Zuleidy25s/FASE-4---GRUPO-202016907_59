@extends('admin.index')
{{-- sidebar --}}
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
            <h1 class="text-2xl font-bold mb-2">Inventario - {{ $product->name }}</h1>
            <nav class="text-gray-500 text-sm" aria-label="breadcrumb">
                <ol class="flex space-x-2">
                    <li><a href="{{ url('/admin') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
                    <li>/</li>
                    <li><a href="{{ url('/admin/products/all') }}" class="text-blue-600 hover:underline">Productos</a></li>
                    <li>/</li>
                    <li class="text-gray-700">Inventario: {{ $product->name }}</li>
                </ol>
            </nav>
        </div>

        <div class="flex flex-wrap -mx-4">
            <!-- Columna izquierda: crear inventario -->
            <div class="w-full md:w-1/4 px-4 mb-6 md:mb-0">
                <div class="bg-gray-200 px-3 py-2 rounded mb-4 font-medium">Crear inventario</div>

                <div class="bg-white p-4 rounded shadow">
                    <form action="{{ url('/admin/product/'.$product->id.'/inventory') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Nombre:</label>
                            <input type="text" name="name" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Cantidad en inventario:</label>
                            <input type="number" name="inventory" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Precio ({{ config('cms.currency') }}):</label>
                            <input type="number" name="price" required placeholder="{{ config('cms.currency') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Inventario sin límite:</label>
                            <select name="limited" id="limited" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="0" selected>Limitado</option>
                                <option value="1">Ilimitado</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Inventario mínimo:</label>
                            <input type="number" required name="minimum" placeholder="Stock" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Columna derecha: tabla de inventario -->
            <div class="w-full md:w-3/4 px-4">
                <div class="bg-white p-4 rounded shadow">
                    <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-gray-700 font-medium">ID</th>
                                <th class="px-4 py-2 text-left text-gray-700 font-medium">Nombre</th>
                                <th class="px-4 py-2 text-left text-gray-700 font-medium">Existencias</th>
                                <th class="px-4 py-2 text-left text-gray-700 font-medium">Mínimo</th>
                                <th class="px-4 py-2 text-left text-gray-700 font-medium">Precio</th>
                                <th class="px-4 py-2 text-left text-gray-700 font-medium">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($product->getInventory as $inventory)
                                <tr>
                                    <td class="px-4 py-2">{{ $inventory->id }}</td>
                                    <td class="px-4 py-2">{{ $inventory->name }}</td>
                                    <td class="px-4 py-2">
                                        @if($inventory->limited == "1")
                                            Ilimitado
                                        @else
                                            {{ $inventory->quantity }}
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if($inventory->limited == "1")
                                            Ilimitado
                                        @else
                                            {{ $inventory->minimum }}
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">{{ config('cms.currency') }} {{ $inventory->price }}</td>
                                    <td class="px-4 py-2 flex gap-2">
                                        @if(kvfj(Auth::user()->permissions, 'product_inventory_edit'))
                                            <a href="{{ url('/admin/product/'.$inventory->id.'/edit_inventory') }}" 
                                               class="px-3 py-1 border border-gray-800 text-gray-800 rounded hover:bg-gray-800 hover:text-white transition">
                                                Editar
                                            </a>
                                        @endif
                                        @if(kvfj(Auth::user()->permissions, 'product_inventory_delete'))
                                            <a href="{{ url('/admin/product/'.$inventory->id.'/delete_inventory') }}" 
                                               class="px-3 py-1 border border-red-600 text-red-600 rounded hover:bg-red-600 hover:text-white transition">
                                                Eliminar
                                            </a>
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
