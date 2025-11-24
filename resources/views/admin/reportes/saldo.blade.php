@extends('admin.index')
@include('admin.layout.sidebar')

<main id="main" class="main py-10 px-4">
    <div class="container mx-auto">

        <h1 class="text-3xl font-bold text-gray-700 mb-6">Saldo Total y Reportes Financieros</h1>

        {{-- DATOS DE PRUEBA --}}
        @php
            $ingresos = 450000;
            $egresos  = 160000;
            $saldo    = $ingresos - $egresos;

            $movimientos = [
                ['fecha' => '2025-11-20', 'tipo' => 'Ingreso', 'descripcion' => 'Venta de productos', 'monto' => 150000],
                ['fecha' => '2025-11-21', 'tipo' => 'Egreso', 'descripcion' => 'Compra de materiales', 'monto' => 50000],
                ['fecha' => '2025-11-22', 'tipo' => 'Ingreso', 'descripcion' => 'Alquiler del salón comunal', 'monto' => 300000],
                ['fecha' => '2025-11-23', 'tipo' => 'Egreso', 'descripcion' => 'Pago servicios públicos', 'monto' => 110000],
            ];
        @endphp

        {{-- === DASHBOARD === --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <div class="bg-green-100 border-l-4 border-green-600 px-6 py-4 rounded shadow">
                <h2 class="text-xl font-semibold text-green-700">Total Ingresos</h2>
                <p class="text-3xl font-bold text-green-800">${{ number_format($ingresos,0,',','.') }}</p>
            </div>

            <div class="bg-red-100 border-l-4 border-red-600 px-6 py-4 rounded shadow">
                <h2 class="text-xl font-semibold text-red-700">Total Egresos</h2>
                <p class="text-3xl font-bold text-red-800">${{ number_format($egresos,0,',','.') }}</p>
            </div>

            <div class="bg-blue-100 border-l-4 border-blue-600 px-6 py-4 rounded shadow">
                <h2 class="text-xl font-semibold text-blue-700">Saldo Total</h2>
                <p class="text-3xl font-bold text-blue-800">${{ number_format($saldo,0,',','.') }}</p>
            </div>

        </div>

        {{-- === BOTONES DE ACCIÓN === --}}
        <div class="flex flex-wrap gap-4 mb-8">

            <button class="bg-blue-600 text-white px-5 py-2 rounded shadow hover:bg-blue-700">
                📄 Descargar PDF
            </button>

            <button class="bg-green-600 text-white px-5 py-2 rounded shadow hover:bg-green-700">
                📊 Descargar Excel
            </button>

            <button class="bg-purple-600 text-white px-5 py-2 rounded shadow hover:bg-purple-700">
                📈 Ver Mediciones / Estadísticas
            </button>

            <button class="bg-gray-700 text-white px-5 py-2 rounded shadow hover:bg-gray-800">
                ⚙️ Configurar Reportes
            </button>

        </div>

        {{-- === GRAFICO SIMULADO === --}}
        <div class="bg-white p-6 rounded shadow mb-10">
            <h2 class="text-xl font-bold mb-4">Gráfica de Ingresos vs Egresos (Simulación)</h2>

            <div class="w-full h-52 bg-gray-100 rounded flex items-end p-4 gap-6">

                <div class="w-1/2">
                    <div class="bg-green-500 w-full h-[80%] rounded"></div>
                    <p class="text-center mt-2 font-semibold text-green-700">Ingresos</p>
                </div>

                <div class="w-1/2">
                    <div class="bg-red-500 w-full h-[40%] rounded"></div>
                    <p class="text-center mt-2 font-semibold text-red-700">Egresos</p>
                </div>

            </div>
        </div>

        {{-- === TABLA DETALLADA === --}}
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($movimientos as $m)
                        <tr>
                            <td class="px-6 py-4">{{ $m['fecha'] }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded text-white text-sm font-semibold
                                    {{ $m['tipo'] == 'Ingreso' ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ $m['tipo'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $m['descripcion'] }}</td>
                            <td class="px-6 py-4 font-bold">${{ number_format($m['monto'],0,',','.') }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</main>
