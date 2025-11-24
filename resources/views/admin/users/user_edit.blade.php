@extends('admin.index')
{{-- Sidebar --}}
@include('admin.layout.sidebar')

<main id="main" class="main p-6 min-h-screen">
    <div class="container mx-auto">

        <!-- Page Title -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold mb-2">Editar usuario: {{ $u->name }} {{ $u->lastname }}</h1>
            <nav class="text-gray-500 text-sm" aria-label="breadcrumb">
                <ol class="flex list-reset">
                    <li><a href="{{ url('/admin') }}" class="text-blue-600 hover:underline">Inicio</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ url('/admin/users/all') }}" class="text-blue-600 hover:underline">Usuarios</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-700">Editar usuario: <em>{{ $u->name }}</em></li>
                </ol>
            </nav>
        </div>

        {{-- Messages --}}
        @if(Session::has('message'))
            <div class="mb-4 px-4 py-3 rounded {{ Session::get('typealert') == 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ Session::get('message') }}
            </div>
        @endif

        <!-- Card -->
        <div class="bg-white shadow rounded p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- User Info -->
                <div class="space-y-4">

                    {{-- Avatar --}}
                    {{-- 
                    <div class="flex justify-center">
                        @if(is_null($u->avatar))
                            <img src="{{ url('/static/images/default-avatar.png') }}" class="w-32 h-32 rounded-full">
                        @else
                            <img src="{{ url('/uploads_users/'.$u->id.'/'.$u->avatar) }}" class="w-32 h-32 rounded-full">
                        @endif
                    </div>
                    --}}

                    <div class="space-y-2">
                        <p><span class="font-semibold">Nombre:</span> {{ $u->name }} {{ $u->lastname }}</p>
                        <p><span class="font-semibold">Estado del usuario:</span> {{ getUserStatusArray(null,$u->status) }}</p>
                        <p><span class="font-semibold">Correo electrónico:</span> {{ $u->email }}</p>
                        <p><span class="font-semibold">Fecha de registro:</span> {{ $u->created_at }}</p>
                        <p><span class="font-semibold">Role de usuario:</span> {{ getRoleUserArray(null,$u->role) }}</p>
                    </div>

                    {{-- Action Button --}}
                    @if(kvfj(Auth::user()->permissions, 'user_banned'))
                        @if($u->status == "100")
                            <a href="{{ url('/admin/user/'.$u->id.'/banned') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Activar Usuario</a>
                        @else
                            <a href="{{ url('/admin/user/'.$u->id.'/banned') }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">Suspender Usuario</a>
                        @endif
                    @endif

                </div>

                <!-- Edit Form -->
                <div class="bg-gray-50 p-4 rounded shadow-sm">
                    <form action="/admin/user/{{ $u->id }}/edit" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block font-semibold mb-2">Tipo de usuario:</label>
                            <select name="user_type" class="w-full border border-gray-300 rounded px-3 py-2">
                                @foreach(getRoleUserArray('list', null) as $key => $value)
                                    <option value="{{ $key }}" {{ $key == $u->role ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Guardar</button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</main>
