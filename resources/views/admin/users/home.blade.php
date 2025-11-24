@extends('admin.index')
{{-- Sidebar --}}
@include('admin.layout.sidebar')

<main id="main" class="main p-6 min-h-screen">
    <div class="container mx-auto">

        <!-- Page Title -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold mb-2">Usuarios</h1>
            <nav class="text-gray-500 text-sm" aria-label="breadcrumb">
                <ol class="flex list-reset">
                    <li><a href="{{ url('/admin') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-700">Usuarios</li>
                </ol>
            </nav>
        </div>

        <!-- Table Card -->
        <div class="bg-white p-4 rounded shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nombre</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Apellido</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Email</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Role</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Estado</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr>
                        <td class="px-4 py-2">{{ $user->id }}</td>
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->lastname }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">{{ getRoleUserArray(null,$user->role) }}</td>
                        <td class="px-4 py-2">{{ getUserStatusArray(null,$user->status) }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            @if(kvfj(Auth::user()->permissions, 'user_edit'))
                                <a href="{{ url('/admin/user/'.$user->id.'/edit') }}" class="px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition">Editar</a>
                            @endif
                            @if(kvfj(Auth::user()->permissions, 'user_permissions_get'))
                                <a href="{{ url('/admin/user/'.$user->id.'/permissions') }}" class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Permisos</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nombre</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Apellido</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Email</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Role</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Estado</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Acción</th>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</main>
