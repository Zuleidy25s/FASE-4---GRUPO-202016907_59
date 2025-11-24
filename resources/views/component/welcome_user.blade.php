@extends('index')

@section('content')

<div class="w-full max-w-5xl mx-auto py-10 px-4">

    {{-- HEADER / HERO --}}
    <div class="text-center mb-10">
        <h1 class="text-5xl md:text-6xl font-extrabold text-indigo-700 mb-4">
            KOMIREZO
        </h1>

        <h2 class="text-3xl md:text-4xl font-bold text-gray-800">
            ¿Cómo quieres disfrutar tu pedido?
        </h2>
        <p class="text-gray-500 mt-2">
            Elige una opción para continuar
        </p>
    </div>

    {{-- OPCIONES DESKTOP --}}
    <div class="hidden md:flex justify-center gap-10 mt-8">

        {{-- Comer Aquí --}}
        <a href="{{ route('order.create-type', ['type' => 1]) }}"
           class="group block w-64 bg-white shadow-md hover:shadow-xl transition rounded-2xl p-6 text-center">
            
            <div class="w-full h-32 bg-gray-200 rounded-lg mb-4 group-hover:opacity-80 transition flex items-center justify-center">
                {{-- Icono: Mesa o Plato --}}
                <svg class="w-16 h-16 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
            </div>

            <h4 class="text-xl font-bold text-gray-800">Comer Aquí</h4>
            <p class="text-gray-500 text-sm mt-1">Listo para disfrutar en mesa</p>
        </a>

        {{-- Para llevar --}}
        <a href="{{ route('order.create-type', ['type' => 2]) }}"
           class="group block w-64 bg-white shadow-md hover:shadow-xl transition rounded-2xl p-6 text-center">
            
            <div class="w-full h-32 bg-gray-200 rounded-lg mb-4 group-hover:opacity-80 transition flex items-center justify-center">
                {{-- Icono: Bolsa para llevar --}}
                <svg class="w-16 h-16 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>

            <h4 class="text-xl font-bold text-gray-800">Para llevar</h4>
            <p class="text-gray-500 text-sm mt-1">Empacado para llevar contigo</p>
        </a>

    </div>

    {{-- OPCIONES MÓVIL --}}
    <div class="grid grid-cols-2 gap-4 md:hidden mt-8">

        {{-- Para recoger --}}
        <a href="{{ route('order.create-type-mobil', ['type' => 3]) }}"
           class="group bg-white shadow-md hover:shadow-lg transition rounded-xl p-3 text-center flex flex-col justify-between h-48"> {{-- Se agregó 'h-48' y 'flex flex-col justify-between' para altura adecuada y centrado vertical --}}

            <div class="w-full h-24 bg-gray-200 rounded-md mb-2 group-hover:opacity-80 flex items-center justify-center">
                {{-- Icono: Recoger/Click and Collect --}}
                <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
            </div>

            <div>
                <h6 class="text-base font-bold text-gray-800">Para Recoger</h6>
                <small class="text-gray-500 text-xs">Pasa por la zona express</small>
            </div>
        </a>

        {{-- Domicilio --}}
        <a href="{{ route('order.create-type-mobil', ['type' => 4]) }}"
           class="group bg-white shadow-md hover:shadow-lg transition rounded-xl p-3 text-center flex flex-col justify-between h-48"> {{-- Se agregó 'h-48' y 'flex flex-col justify-between' para altura adecuada y centrado vertical --}}

            <div class="w-full h-24 bg-gray-200 rounded-md mb-2 group-hover:opacity-80 flex items-center justify-center">
                {{-- Icono: Repartidor/Envío --}}
                <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2c0-.523-.213-1.056-.566-1.488m0 0a1.88 1.88 0 010-2.224m-12.723 5.378h15.546c.542 0 1-.458 1-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v14c0 .542.458 1 1 1zM7 14h6" />
                </svg>
            </div>

            <div>
                <h6 class="text-base font-bold text-gray-800">Domicilio</h6>
                <small class="text-gray-500 text-xs">Lo llevamos a tu puerta</small>
            </div>
        </a>

    </div>
    
    {{-- SECCIÓN: PLANIFICAR REUNIONES (Se mantiene con los estilos de la imagen original) --}}
    <div class="mt-12 border-2 border-gray-200 shadow rounded md:hidden">
        <div class="p-3 border-b-2 border-gray-800">
            <h3 class="text-xl font-bold text-gray-800 tracking-wider">
                PLANIFICA TUS REUNIONES:
            </h3>
        </div>
        
        <div class="p-6 text-center">
            <div class="flex justify-center mb-4">
                {{-- Icono de Calendario --}}
                <svg class="w-10 h-10 text-gray-800" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>

            <p class="text-xl font-bold text-gray-800 tracking-wider mb-2">
                ENCARGOS Y EVENTOS
            </p>
            <p class="text-gray-600 mb-6">
                Agenda tus pedidos para fechas futuras:
            </p>

            <a href="#" {{-- Agrega aquí la ruta de agendamiento --}}
               class="shadow rounded inline-block px-8 py-3 font-bold text-lg text-gray-800 border-2 border-gray-200 hover:bg-gray-100 transition duration-150"
               style="letter-spacing: 0.1em; padding-left: 2rem; padding-right: 2rem;">
                AGENDAR
            </a>
        </div>
    </div>
    {{-- FIN SECCIÓN PLANIFICAR REUNIONES --}}

</div>

{{-- MENÚ INFERIOR MÓVIL --}}
<div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 shadow-md md:hidden">
    <div class="flex justify-around py-3">
        <a href="#" class="flex flex-col items-center text-indigo-600">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round"
                 stroke-linejoin="round" d="M12 8v4l3 3"></path></svg>
            <span class="text-xs">Reuniones</span>
        </a>
        <a href="#" class="flex flex-col items-center text-indigo-600">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round"
                 stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
            <span class="text-xs">Tareas</span>
        </a>
        <a href="#" class="flex flex-col items-center text-indigo-600">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round"
                 stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"></path></svg>
            <span class="text-xs">Perfil</span>
        </a>
    </div>
</div>

@endsection