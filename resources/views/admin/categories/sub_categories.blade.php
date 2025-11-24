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
            <h1 class="text-3xl font-bold mb-2">Sub categoría <strong>{{ $category->name }}</strong></h1>
            <nav class="text-gray-500 text-sm" aria-label="breadcrumb">
                <ol class="flex list-reset">
                    <li><a href="{{ url('/admin') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ url('/admin/categories/0') }}" class="text-blue-600 hover:underline">Categoría</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-700">Sub Categoría {{ $category->name }}</li>
                </ol>
            </nav>
        </div>

        <div class="bg-white p-4 rounded shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nombre</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($category->getSubCategories as $cat)
                        <tr>
                            <td class="px-4 py-2">{{ $cat->name }}</td>
                            <td class="px-4 py-2 flex gap-2">
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
</main>
