@extends('admin.index')
{{-- Cabecera web --}}
{{-- sidebar --}}
@include('admin.layout.sidebar')

<main id="main" class="main py-10 px-4">
    <div class="container mx-auto">

        <h1 class="text-3xl font-bold text-gray-700 mb-6">Gastos e Inversiones</h1>

        {{-- Datos de prueba --}}
        @php
            $registros = [
                ['id'=>1, 'tipo'=>'Gasto', 'descripcion'=>'Compra de Sillas', 'fecha'=>'2025-11-01', 'monto'=>50000, 'categoria'=>'Mobiliario'],
                ['id'=>2, 'tipo'=>'Inversión', 'descripcion'=>'Alquiler Salón Comunal', 'fecha'=>'2025-11-02', 'monto'=>200000, 'categoria'=>'Salones'],
                ['id'=>3, 'tipo'=>'Gasto', 'descripcion'=>'Pago de Servicios', 'fecha'=>'2025-11-03', 'monto'=>30000, 'categoria'=>'Servicios'],
                ['id'=>4, 'tipo'=>'Inversión', 'descripcion'=>'Venta de Productos', 'fecha'=>'2025-11-04', 'monto'=>120000, 'categoria'=>'Productos'],
                ['id'=>5, 'tipo'=>'Gasto', 'descripcion'=>'Compra de Materiales', 'fecha'=>'2025-11-05', 'monto'=>40000, 'categoria'=>'Materiales'],
            ];

            $totalGastos = collect($registros)->where('tipo', 'Gasto')->sum('monto');
            $totalInversiones = collect($registros)->where('tipo', 'Inversión')->sum('monto');
            $saldoActual = $totalInversiones - $totalGastos;
        @endphp

        {{-- Mini dashboard --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-red-100 text-red-800 px-6 py-4 rounded shadow">
                <h2 class="text-xl font-semibold">Total Gastos</h2>
                <p class="text-2xl font-bold">${{ number_format($totalGastos,0,',','.') }}</p>
            </div>
            <div class="bg-green-100 text-green-800 px-6 py-4 rounded shadow">
                <h2 class="text-xl font-semibold">Total Inversiones</h2>
                <p class="text-2xl font-bold">${{ number_format($totalInversiones,0,',','.') }}</p>
            </div>
            <div class="bg-blue-100 text-blue-800 px-6 py-4 rounded shadow">
                <h2 class="text-xl font-semibold">Saldo Actual</h2>
                <p class="text-2xl font-bold">${{ number_format($saldoActual,0,',','.') }}</p>
            </div>
        </div>

        {{-- Botón agregar --}}
        <div class="flex justify-end mb-4">
            <button 
                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
                onclick="alert('Agregar nuevo registro de gasto/inversión')">
                + Nuevo Registro
            </button>
        </div>

        {{-- Tabla de registros --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($registros as $registro)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $registro['id'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $registro['tipo'] == 'Gasto' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $registro['tipo'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $registro['descripcion'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $registro['fecha'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($registro['monto'],0,',','.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $registro['categoria'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <button class="text-blue-600 hover:text-blue-900 mr-2" onclick="alert('Editar registro {{ $registro['id'] }}')">Editar</button>
                                <button class="text-red-600 hover:text-red-900" onclick="alert('Eliminar registro {{ $registro['id'] }}')">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</main>
