@extends('admin.index')
{{-- Cabecera web --}}
{{-- sidebar --}}
@include('admin.layout.sidebar')

<main id="main" class="main py-10 px-4">
    <div class="container mx-auto">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-700">Personas Comunales</h1>
            <button 
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                onclick="alert('Agregar nueva persona comunal - formulario modal aquí')">
                + Nuevo Miembro
            </button>
        </div>

        {{-- Tabla de miembros --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre Completo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo de Acceso</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Beneficios</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de prueba --}}
                    @php
                        $miembros = [
                            ['id'=>1, 'nombre'=>'Juan Perez', 'documento'=>'CC 123456789', 'acceso'=>'Administrador', 'beneficios'=>'Acceso a Salón Comunal, Alquileres Gratis'],
                            ['id'=>2, 'nombre'=>'Maria Gomez', 'documento'=>'CC 987654321', 'acceso'=>'Miembro', 'beneficios'=>'Descuento en Alquileres'],
                            ['id'=>3, 'nombre'=>'Carlos Lopez', 'documento'=>'CC 456123789', 'acceso'=>'Miembro', 'beneficios'=>'Participación en Reuniones'],
                            ['id'=>4, 'nombre'=>'Ana Martinez', 'documento'=>'CC 321654987', 'acceso'=>'Coordinador', 'beneficios'=>'Acceso a Recursos Especiales, Alquileres Gratis'],
                        ];
                    @endphp

                    @foreach($miembros as $miembro)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $miembro['id'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $miembro['nombre'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $miembro['documento'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $miembro['acceso'] == 'Administrador' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $miembro['acceso'] == 'Coordinador' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $miembro['acceso'] == 'Miembro' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                    {{ $miembro['acceso'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $miembro['beneficios'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <button class="text-blue-600 hover:text-blue-900 mr-2" onclick="alert('Editar miembro {{ $miembro['id'] }}')">Editar</button>
                                <button class="text-red-600 hover:text-red-900" onclick="alert('Eliminar miembro {{ $miembro['id'] }}')">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>
</main>
