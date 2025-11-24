@extends('admin.index')
{{-- Cabecera web --}}

{{-- Sidebar --}}
@include('admin.layout.sidebar')

<!-- Incluye la hoja de estilos de Fancybox -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />

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
            <h1 class="text-3xl font-bold mb-2">Producto: {{ $p->name }}</h1>
            <nav class="text-gray-500 text-sm" aria-label="breadcrumb">
                <ol class="flex space-x-2">
                    <li><a href="{{ url('/admin') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
                    <li>/</li>
                    <li><a href="{{ url('/admin/products/all') }}" class="text-blue-600 hover:underline">Productos</a></li>
                    <li>/</li>
                    <li class="text-gray-700">Editar</li>
                </ol>
            </nav>
        </div>

        <div class="flex flex-wrap -mx-4">
            <!-- Columna izquierda: formulario -->
            <div class="w-full md:w-1/2 px-4 mb-6 md:mb-0">
                <form action="/admin/product/{{ $p->id }}/edit" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium mb-1">Nombre del producto:</label>
                        <input type="text" name="name" value="{{ $p->name }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="category" class="block text-gray-700 font-medium mb-1">Categoría:</label>
                            <select name="category" id="category" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach($cats as $key => $value)
                                    <option value="{{ $key }}" {{ $p->category_id == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" id="subcategory_actual" name="subcategory_actual" value="{{ $p->subcategory_id }}">
                        </div>

                        <div>
                            <label for="subcategory" class="block text-gray-700 font-medium mb-1">Subcategoría:</label>
                            <select name="subcategory" id="subcategory" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="{{ $key }}" {{ $p->subcategory_id == $key ? 'selected' : '' }}></option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="indiscount" class="block text-gray-700 font-medium mb-1">¿En descuento?:</label>
                            <select name="indiscount" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="0" {{ $p->in_discount == 0 ? 'selected' : '' }}>No</option>
                                <option value="1" {{ $p->in_discount == 1 ? 'selected' : '' }}>Sí</option>
                            </select>
                        </div>
                        <div>
                            <label for="discount" class="block text-gray-700 font-medium mb-1">Descuento:</label>
                            <input type="number" name="discount" value="{{ $p->discount }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" min="0.00" step="any">
                        </div>
                        <div>
                            <label for="price" class="block text-gray-700 font-medium mb-1">{{ config('cms.currency') }} Precio:</label>
                            <input type="number" name="price" value="{{ $p->price }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" step="any">
                        </div>
                    </div>

                    <div class="mb-4 w-full md:w-1/2">
                        <label for="status" class="block text-gray-700 font-medium mb-1">Estado:</label>
                        <select name="status" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="0" {{ $p->status == 0 ? 'selected' : '' }}>Borrador</option>
                            <option value="1" {{ $p->status == 1 ? 'selected' : '' }}>Publico</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="code" class="block text-gray-700 font-medium mb-1">Código de sistema:</label>
                        <input type="text" name="code" value="{{ $p->code }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="discount_until_date" class="block text-gray-700 font-medium mb-1">Fecha límite de descuento:</label>
                        <input type="date" name="discount_until_date" value="{{ $p->discount_until_date }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="content" class="block text-gray-700 font-medium mb-1">Descripción:</label>
                        <textarea name="content" id="editor" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $p->content }}</textarea>
                    </div>

                    <div class="mb-4">
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Editar</button>
                    </div>
                </form>
            </div>

            <!-- Columna derecha: galería e imágenes -->
            <div class="w-full md:w-1/2 px-4">
                {{-- Mensajes de error --}}
                <div id="error-messages" class="text-red-600 mb-4"></div>

                {{-- Panel de Dropzone --}}
                @include('admin.components.dropzone')

                {{-- Galería de imágenes --}}
                @if(isset($images) && count($images) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                        @foreach($images as $image)
                            <div class="bg-white p-2 rounded shadow">
                                <a href="{{ asset('storage/img/uploads_product/'. $image->file_path) }}" data-fancybox="gallery">
                                    <img src="{{ asset('storage/img/uploads_product/'. $image->file_path) }}" class="w-full h-40 object-cover rounded" alt="{{ $image->file_name }}">
                                </a>
                                <form method="POST" action="{{ route('product.gallery.destroy', ['productId' => $productId, 'imageId' => $image->id]) }}" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">Eliminar</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

<script>
    $(document).ready(function(){
        $("[data-fancybox='gallery']").fancybox();
        editor_init('content');
    });

    function editor_init(field){
        CKEDITOR.replace(field,{
            toolbar: [
                { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', '-', 'Undo', 'Redo' ]},
                { name: 'basicstyles', items: ['Bold', 'Italic', 'BulletedList', 'Strike', 'Image', 'link', 'Unlink', 'Blockquote' ]},
                { name: 'document', items: ['CodeSnippet', 'EmojiPanel', 'preview', 'Source'] }
            ]
        });
    }
</script>
