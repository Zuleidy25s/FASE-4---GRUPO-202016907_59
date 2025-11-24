@extends('admin.index')

@include('admin.layout.sidebar')

<main class="main py-10 px-4">
    <div class="container mx-auto max-w-lg">
        <h2 class="text-2xl font-bold mb-6">Agregar Nuevo Ítem</h2>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.items.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded shadow">
            @csrf
            <div>
                <label class="block font-semibold mb-1">Nombre</label>
                <input type="text" name="nombre_item" class="w-full border px-3 py-2 rounded" value="{{ old('nombre_item') }}" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Tipo de Servicio</label>
                <select name="tipo_servicio" class="w-full border px-3 py-2 rounded" required>
                    <option value="">Selecciona</option>
                    <option value="Comunal" {{ old('tipo_servicio')=='Comunal' ? 'selected' : '' }}>Comunal</option>
                    <option value="Enseres" {{ old('tipo_servicio')=='Enseres' ? 'selected' : '' }}>Enseres</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">Descripción</label>
                <textarea name="descripcion" class="w-full border px-3 py-2 rounded" rows="4">{{ old('descripcion') }}</textarea>
            </div>

            <div>
                <label class="block font-semibold mb-1">Costo Unitario</label>
                <input type="number" name="costo_unitario" step="0.01" class="w-full border px-3 py-2 rounded" value="{{ old('costo_unitario') }}" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Cantidad Total</label>
                <input type="number" name="cantidad_total" class="w-full border px-3 py-2 rounded" value="{{ old('cantidad_total', 1) }}" required>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('admin.items.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Guardar</button>
            </div>
        </form>
    </div>
</main>
