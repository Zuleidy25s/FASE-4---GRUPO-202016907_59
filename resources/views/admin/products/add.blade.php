@extends('admin.index')

{{-- Sidebar --}}
@include('admin.layout.sidebar')

<main id="main" class="main p-6 py-4 min-h-screen">
    <div class="container mx-auto">

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

        <div class="bg-white p-6 rounded shadow">
            <form action="{{ url('/admin/product/add') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nombre y Categorías --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <input type="text" name="name" placeholder="Nombre del producto" class="border border-gray-300 rounded px-3 py-2 w-full" required>

                    <div>
                        <label for="category" class="block mb-1 font-medium">Categoría:</label>
                        <select name="category" id="category" class="border border-gray-300 rounded px-3 py-2 w-full">
                            @foreach($cats as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" id="subcategory_actual" name="subcategory_actual">
                    </div>

                    <div>
                        <label for="subcategory" class="block mb-1 font-medium">Subcategoría:</label>
                        <select name="subcategory" id="subcategory" class="border border-gray-300 rounded px-3 py-2 w-full" required>
                            <!-- Subcategorías se llenarán dinámicamente -->
                        </select>
                    </div>
                </div>

                {{-- Imagen y descuentos --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label for="image" class="block mb-1 font-medium">Imagen Destacada:</label>
                        <input type="file" name="image" id="image" accept="image/*" class="w-full border border-gray-300 rounded px-2 py-2">
                    </div>

                    <div>
                        <label for="indiscount" class="block mb-1 font-medium">¿En descuento?:</label>
                        <select name="indiscount" class="border border-gray-300 rounded px-3 py-2 w-full">
                            <option value="0">No</option>
                            <option value="1">Sí</option>
                        </select>
                    </div>

                    <div>
                        <label for="discount" class="block mb-1 font-medium">Descuento:</label>
                        <input type="number" name="discount" min="0" step="any" class="border border-gray-300 rounded px-3 py-2 w-full">
                    </div>

                    <div>
                        <label for="code" class="block mb-1 font-medium">Código de sistema:</label>
                        <input type="text" name="code" class="border border-gray-300 rounded px-3 py-2 w-full">
                    </div>
                </div>

                {{-- Descripción --}}
                <div class="mb-4">
                    <label for="content" class="block mb-1 font-medium">Descripción:</label>
                    <textarea name="content" id="editor" class="border border-gray-300 rounded px-3 py-2 w-full h-32"></textarea>
                </div>

                {{-- Botón Guardar --}}
                <div>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Guardar</button>
                </div>
            </form>
        </div>

    </div>
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    $(document).ready(function(){
        CKEDITOR.replace('content',{
            toolbar: [
                { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', '-', 'Undo', 'Redo' ]},
                { name: 'basicstyles', items: ['Bold', 'Italic', 'BulletedList', 'Strike', 'Image', 'link', 'Unlink', 'Blockquote' ]},
                { name: 'document', items: ['CodeSnippet', 'EmojiPanel', 'preview', 'Source'] }
            ]
        });
    });
</script>
