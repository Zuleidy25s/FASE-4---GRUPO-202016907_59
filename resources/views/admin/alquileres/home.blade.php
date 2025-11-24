@extends('admin.index')
{{-- Cabecera web --}}
{{-- sidebar --}}
@include('admin.layout.sidebar')

<main id="main" class="main py-10 px-4">
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-700">Alquileres</h1>
            @if(kvfj(Auth::user()->permissions, 'alquiler_add'))
            <button 
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                onclick="alert('Agregar alquiler - formulario modal aquí')">
                + Agregar Alquiler
            </button>
            @endif
        </div>

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Reserva</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo Entrega</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total a Pagar</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de prueba --}}
                    @php
                        $alquileres = [
                            ['id'=>1, 'usuario'=>'Juan Perez', 'fecha'=>'2025-12-01', 'estado'=>'Pendiente Pago', 'tipo_entrega'=>'Retiro en el lugar', 'total'=>150000],
                            ['id'=>2, 'usuario'=>'Maria Gomez', 'fecha'=>'2025-12-05', 'estado'=>'Confirmado', 'tipo_entrega'=>'Servicio a Domicilio', 'total'=>300000],
                            ['id'=>3, 'usuario'=>'Carlos Lopez', 'fecha'=>'2025-12-10', 'estado'=>'Cancelado', 'tipo_entrega'=>'Retiro en el lugar', 'total'=>50000],
                        ];
                    @endphp

                    @foreach($alquileres as $alquiler)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $alquiler['id'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $alquiler['usuario'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $alquiler['fecha'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $alquiler['estado'] == 'Confirmado' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $alquiler['estado'] == 'Pendiente Pago' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $alquiler['estado'] == 'Cancelado' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $alquiler['estado'] == 'Completado' ? 'bg-blue-100 text-blue-800' : '' }}
                                ">
                                    {{ $alquiler['estado'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $alquiler['tipo_entrega'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($alquiler['total'],0,',','.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if(kvfj(Auth::user()->permissions, 'alquiler_edit'))
                                    <button class="text-blue-600 hover:text-blue-900 mr-2" onclick="alert('Editar Alquiler {{ $alquiler['id'] }}')">Editar</button>
                                @endif
                                @if(kvfj(Auth::user()->permissions, 'alquiler_delete'))    
                                    <button class="text-red-600 hover:text-red-900" onclick="alert('Eliminar Alquiler {{ $alquiler['id'] }}')">Eliminar</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>
