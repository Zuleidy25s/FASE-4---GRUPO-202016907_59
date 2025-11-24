@extends('admin.index')
{{-- Sidebar --}}
@include('admin.layout.sidebar')

<main id="main" class="main p-4 sm:p-6 min-h-screen bg-gray-50"> {{-- Fondo gris claro para sensación profesional --}}
    <div class="container mx-auto">
        
        {{-- 1. Page Title & Breadcrumb --}}
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Panel de Administración</h1>
            <nav class="text-gray-500 text-sm" aria-label="breadcrumb">
                <ol class="flex list-reset items-center">
                    <li><a href="{{ url('/admin') }}" class="text-indigo-600 hover:text-indigo-800 transition duration-150">Inicio</a></li>
                    <li><span class="mx-2 text-gray-400">/</span></li>
                    <li class="text-gray-700 font-medium">Dashboard</li>
                </ol>
            </nav>
        </div>

        {{-- 2. HEADER/WELCOME BANNER --}}
        <div class="bg-white shadow-lg rounded-xl p-6 lg:p-8 mb-8 border-t-4 border-indigo-600">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-1">
                        ¡Bienvenido de nuevo, {{ Auth::user()->name }}!!
                    </h2>
                    <p class="text-gray-600">
                        Este es el **Panel de Administración de KOMIREZO**. Mantente al tanto de tus métricas clave.
                    </p>
                </div>
                {{-- Opcional: Agregar un botón de acción rápida --}}
                <div class="mt-4 md:mt-0">
                    <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-150">
                        Ver Pedidos Recientes
                    </a>
                </div>
            </div>
        </div>
        
        {{-- 3. SUMMARY STATS CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            {{-- Card 1: Pedidos Totales --}}
            <div class="bg-white p-5 rounded-xl shadow-md flex items-center justify-between hover:shadow-lg transition duration-200">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Pedidos Hoy</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">128</p>
                </div>
                <div class="p-3 bg-indigo-100 rounded-full text-indigo-600">
                    {{-- Icono: Shopping Bag (Pedidos) --}}
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
            </div>

            {{-- Card 2: Ingresos Totales --}}
            <div class="bg-white p-5 rounded-xl shadow-md flex items-center justify-between hover:shadow-lg transition duration-200">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Ingresos (Semana)</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">$1,500.50</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full text-green-600">
                    {{-- Icono: Money/Dollar (Ingresos) --}}
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 4v2m0 2v2m-6-3h12a2 2 0 002-2v-4a2 2 0 00-2-2H6a2 2 0 00-2 2v4a2 2 0 002 2z"></path></svg>
                </div>
            </div>

            {{-- Card 3: Nuevos Usuarios --}}
            <div class="bg-white p-5 rounded-xl shadow-md flex items-center justify-between hover:shadow-lg transition duration-200">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Nuevos Clientes</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">45</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                    {{-- Icono: Users (Clientes) --}}
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2c0-.523-.213-1.056-.566-1.488m0 0a1.88 1.88 0 010-2.224m-2.585-.16a1.942 1.942 0 00-2.34-2.852c-.672.482-1.298 1.353-1.82 2.302m-1.748-2.61a1.942 1.942 0 00-2.34-2.852c-.672.482-1.298 1.353-1.82 2.302M12 11a4 4 0 100-8 4 4 0 000 8zM5 19v-1a4 4 0 014-4h6a4 4 0 014 4v1"></path></svg>
                </div>
            </div>

            {{-- Card 4: Productos Populares (Ejemplo) --}}
            <div class="bg-white p-5 rounded-xl shadow-md flex items-center justify-between hover:shadow-lg transition duration-200">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Envíos Pendientes</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">7</p>
                </div>
                <div class="p-3 bg-red-100 rounded-full text-red-600">
                    {{-- Icono: Alert (Pendiente) --}}
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856a2 2 0 001.76-2.551L14.707 5.76A2 2 0 0012.946 4H11.054a2 2 0 00-1.76 1.76L4.278 17.449A2 2 0 006.039 20z"></path></svg>
                </div>
            </div>
            
        </div>
        
        {{-- 4. Sección de Gráficos / Tablas (Ejemplo de estructura) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
            
            {{-- Gráfico Principal (2/3 de ancho en LG) --}}
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Rendimiento Semanal</h3>
                <div class="h-64 flex items-center justify-center text-gray-400 border border-dashed rounded-lg">
                    [Espacio para Gráfico de Líneas/Barras]
                </div>
            </div>

            {{-- Lista de Actividad Reciente (1/3 de ancho en LG) --}}
            <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Actividad Reciente</h3>
                <ul class="space-y-3 text-sm">
                    <li class="p-2 border-l-4 border-indigo-500 bg-gray-50 rounded">
                        Nuevo pedido #234 - Domicilio
                    </li>
                    <li class="p-2 border-l-4 border-green-500 bg-gray-50 rounded">
                        Pago completado por Cliente X
                    </li>
                    <li class="p-2 border-l-4 border-red-500 bg-gray-50 rounded">
                        Stock bajo: Producto Y
                    </li>
                    <li class="p-2 border-l-4 border-indigo-500 bg-gray-50 rounded">
                        Pedido #233 enviado
                    </li>
                </ul>
            </div>

        </div>

        
    </div>

</main>