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
            <h1 class="text-3xl font-bold mb-2">Categoría</h1>
            <nav class="text-gray-500 text-sm" aria-label="breadcrumb">
                <ol class="flex list-reset">
                    <li><a href="{{ url('/admin') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-700">Categoría</li>
                </ol>
            </nav>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Agregar Categoría --}}
            <div class="bg-white p-4 rounded shadow">
                <h4 class="text-center p-2 mb-4 bg-gray-100 rounded">Agregar categoría</h4>

                @if(kvfj(Auth::user()->permissions, 'category_add'))
                <form action="{{ url('/admin/category/add/'.$module) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block mb-1 font-medium">Nombre categoría:</label>
                        <input type="text" name="name" class="border border-gray-300 rounded px-3 py-2 w-full">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Categoría Padre:</label>
                        <select name="parent" class="border border-gray-300 rounded px-3 py-2 w-full">
                            <option value="0">Sin categoría padre</option>
                            @foreach($cats as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Módulo:</label>
                        <select name="module" class="border border-gray-300 rounded px-3 py-2 w-full bg-gray-100 cursor-not-allowed" disabled>
                            @foreach(getModulesArray() as $key => $value)
                                <option value="{{ $key }}" {{ $module == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="w-full px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-900 transition">Guardar</button>
                </form>
                @endif
            </div>

            {{-- Listado de Categorías --}}
            <div class="md:col-span-2 bg-white p-4 rounded shadow">
                {{-- Filtros de módulos --}}
                <nav class="flex space-x-2 mb-4 bg-gray-100 p-2 rounded">
                    @foreach(getModulesArray() as $m => $k)
                        <a href="{{ url('/admin/categories/'.$m) }}" class="px-3 py-1 rounded hover:bg-gray-200 {{ $module == $m ? 'bg-gray-300 font-medium' : '' }}">
                            {{ $k }}
                        </a>
                    @endforeach
                </nav>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nombre</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($cats as $cat)
                                <tr>
                                    <td class="px-4 py-2">{{ $cat->id }}</td>
                                    <td class="px-4 py-2">{{ $cat->name }}</td>
                                    <td class="px-4 py-2 flex gap-2">
                                        @if(kvfj(Auth::user()->permissions, 'category_subs'))
                                            <a href="{{ url('/admin/category/'.$cat->id.'/subs') }}" class="px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition">Subcategoría</a>
                                        @endif
                                        @if(kvfj(Auth::user()->permissions, 'category_edit'))
                                            <a href="{{ url('/admin/category/'.$cat->id.'/edit') }}" class="px-2 py-1 bg-gray-800 text-white rounded hover:bg-gray-900 transition">Editar</a>
                                        @endif
                                        @if(kvfj(Auth::user()->permissions, 'category_delete'))
                                            <a href="{{ url('/admin/category/'.$cat->id.'/delete') }}" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">Eliminar</a>
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
