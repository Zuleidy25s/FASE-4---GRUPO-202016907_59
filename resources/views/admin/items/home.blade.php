@extends('admin.index')

@include('admin.layout.sidebar')

<main id="main" class="main py-10 px-4">
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Catálogo de Ítems Disponibles</h2>
            @if(kvfj(Auth::user()->permissions, 'item_add'))
                <a href="{{ route('admin.items.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Agregar Ítem</a>
            @endif
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($items->count())
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow rounded">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Nombre</th>
                        <th class="py-3 px-6 text-left">Tipo de Servicio</th>
                        <th class="py-3 px-6 text-left">Costo Unitario</th>
                        <th class="py-3 px-6 text-left">Disponibles</th>
                        <th class="py-3 px-6 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @foreach($items as $item)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $item->nombre_item }}</td>
                        <td class="py-3 px-6">{{ $item->tipo_servicio }}</td>
                        <td class="py-3 px-6">${{ number_format($item->costo_unitario, 2) }}</td>
                        <td class="py-3 px-6">{{ $item->cantidad_total }}</td>
                        <td class="py-3 px-6 text-center flex justify-center space-x-2">
                           @if(kvfj(Auth::user()->permissions, 'item_delete'))
                            <form action="" method="POST"
                                onsubmit="return confirm('¿Deseas eliminar este ítem?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                    Eliminar
                                </button>
                            </form>
                            @endif        
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <p class="text-gray-500 mt-4">No hay ítems disponibles.</p>
        @endif
    </div>
</main>
