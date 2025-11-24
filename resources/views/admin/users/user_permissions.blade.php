@extends('admin.index')
{{-- Sidebar --}}
@include('admin.layout.sidebar')

<main id="main" class="main p-6 min-h-screen">
    <div class="container mx-auto">

        <!-- Page Title -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold mb-2">Permisos de usuario: <em>{{ $u->name }}</em></h1>
            <nav class="text-gray-500 text-sm" aria-label="breadcrumb">
                <ol class="flex list-reset">
                    <li><a href="{{ url('/admin') }}" class="text-blue-600 hover:underline">Inicio</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ url('/admin/users/all') }}" class="text-blue-600 hover:underline">Usuarios</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-700">Permisos de usuario</li>
                </ol>
            </nav>
        </div>

        {{-- Messages --}}
        @if(Session::has('message'))
            <div class="mb-4 px-4 py-3 rounded {{ Session::get('typealert') == 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ Session::get('message') }}
            </div>
        @endif

        <form action="{{ url('/admin/user/'.$u->id.'/permissions') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach(user_permissions() as $key => $value)
                    <div class="bg-white p-4 rounded shadow">
                        <h2 class="text-xl font-semibold mb-3 flex items-center gap-2">{!! $value['icon'] !!} {{ $value['title'] }}</h2>
                        <div class="space-y-2">
                            @foreach($value['keys'] as $k => $v)
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="{{ $k }}" value="true" class="form-checkbox h-5 w-5 text-blue-600" @if(kvfj($u->permissions, $k)) checked @endif>
                                    <span class="text-gray-700">{{ $v }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-end space-x-3 mt-4">
                <input type="submit" value="Guardar" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition cursor-pointer">
                <a href="{{ url('/admin/users/all') }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">Atrás</a>
            </div>
        </form>

    </div>
</main>
