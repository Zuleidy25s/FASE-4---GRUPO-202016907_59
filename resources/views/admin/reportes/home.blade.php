@extends('admin.index')
{{-- Cabecera web --}}
{{-- sidebar --}}
@include('admin.layout.sidebar')

<main id="main" class="main py-10 px-4">
    <div class="container mx-auto">

        <h1 class="text-3xl font-bold text-gray-700 mb-6">Reporte de Ingresos y Egresos</h1>

        {{-- Datos de prueba --}}
        @php
            $registros = [
                ['id'=>1, 'tipo'=>'Ingreso', 'descripcion'=>'Alquiler Salón Comunal', 'fecha'=>'2025-11-01', 'monto'=>200000],
                ['id'=>2, 'tipo'=>'Egreso', 'descripcion'=>'Compra de Sillas', 'fecha'=>'2025-11-02', 'monto'=>50000],
                ['id'=>3, 'tipo'=>'Ingreso', 'descripcion'=>'Venta de Productos', 'fecha'=>'2025-11-03', 'monto'=>120000],
                ['id'=>4, 'tipo'=>'Egreso', 'descripcion'=>'Pago de Servicios', 'fecha'=>'2025-11-04', 'monto'=>30000],
                ['id'=>5, 'tipo'=>'Ingreso', 'descripcion'=>'Alquiler Salón Comunal', 'fecha'=>'2025-11-05', 'monto'=>150000],
                ['id'=>6, 'tipo'=>'Egreso', 'descripcion'=>'Compra de Materiales', 'fecha'=>'2025-11-06', 'monto'=>40000],
            ];

            $totalIngresos = collect($registros)->where('tipo', 'Ingreso')->sum('monto');
            $totalEgresos  = collect($registros)->where('tipo', 'Egreso')->sum('monto');
            $saldoActual   = $totalIngresos - $totalEgresos;

            // Preparar datos para gráfico
            $fechas = collect($registros)->pluck('fecha')->map(fn($f)=> $f)->toArray();
            $ingresosPorFecha = collect($registros)->map(fn($r)=> $r['tipo']=='Ingreso' ? $r['monto'] : 0)->toArray();
            $egresosPorFecha  = collect($registros)->map(fn($r)=> $r['tipo']=='Egreso' ? $r['monto'] : 0)->toArray();
        @endphp

        {{-- Mini dashboard --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-green-100 text-green-800 px-6 py-4 rounded shadow">
                <h2 class="text-xl font-semibold">Total Ingresos</h2>
                <p class="text-2xl font-bold">${{ number_format($totalIngresos,0,',','.') }}</p>
            </div>
            <div class="bg-red-100 text-red-800 px-6 py-4 rounded shadow">
                <h2 class="text-xl font-semibold">Total Egresos</h2>
                <p class="text-2xl font-bold">${{ number_format($totalEgresos,0,',','.') }}</p>
            </div>
            <div class="bg-blue-100 text-blue-800 px-6 py-4 rounded shadow">
                <h2 class="text-xl font-semibold">Saldo Actual</h2>
                <p class="text-2xl font-bold">${{ number_format($saldoActual,0,',','.') }}</p>
            </div>
        </div>

        {{-- Gráfica de Ingresos vs Egresos --}}
        <div class="bg-white shadow rounded-lg p-4 mb-6">
            <canvas id="reporteChart" height="100"></canvas>
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
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($registros as $registro)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $registro['id'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $registro['tipo']=='Ingreso' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $registro['tipo'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $registro['descripcion'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $registro['fecha'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($registro['monto'],0,',','.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('reporteChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($fechas) !!},
                datasets: [
                    {
                        label: 'Ingresos',
                        data: {!! json_encode($ingresosPorFecha) !!},
                        backgroundColor: 'rgba(34,197,94,0.7)',
                        borderColor: 'rgba(34,197,94,1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Egresos',
                        data: {!! json_encode($egresosPorFecha) !!},
                        backgroundColor: 'rgba(239,68,68,0.7)',
                        borderColor: 'rgba(239,68,68,1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>

</main>
