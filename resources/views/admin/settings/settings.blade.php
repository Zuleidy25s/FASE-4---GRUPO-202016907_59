@extends('admin.index')

@include('admin.layout.sidebar')

<main id="main" class="ml-0 lg:ml-72 p-6 bg-gray-100 min-h-screen">

    <div class="container mx-auto">

        <!-- Título de página -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Productos</h1>

            <nav class="mt-2">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li>
                        <a href="{{ url('/admin') }}" class="hover:text-blue-600">Dashboard</a>
                    </li>
                    <li>/</li>
                    <li class="font-semibold text-gray-800">Productos</li>
                </ol>
            </nav>
        </div>

        <!-- Contenedor -->
        <div class="bg-white shadow rounded-xl p-6">
            <div class="border-b pb-4 mb-4">
                <h2 class="text-xl font-semibold text-gray-700 flex items-center gap-2">
                    <i class="fas fa-cogs"></i> Configuraciones
                </h2>
            </div>

            <form action="{{ url('/admin/settings/add') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Primera fila -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre de la tienda:</label>
                        <input type="text" name="name"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300"
                            value="{{ Config::get('cms.name') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Moneda:</label>
                        <input type="text" name="currency"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300"
                            value="{{ Config::get('cms.currency') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Teléfono:</label>
                        <input type="number" name="company_phone"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300"
                            value="{{ Config::get('cms.company_phone') }}">
                    </div>
                </div>

                <!-- Segunda fila -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Ubicaciones:</label>
                        <input type="text" name="map"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300"
                            value="{{ Config::get('cms.map') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Modo mantenimiento:</label>
                        <select name="maintenance_mode"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300">
                            <option value="0" @if(Config::get('cms.maintenance_mode') == '0') selected @endif>
                                Desactivado
                            </option>
                            <option value="1" @if(Config::get('cms.maintenance_mode') == '1') selected @endif>
                                Activado
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Tercera fila -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Productos por página:
                        </label>
                        <input type="number" name="products_per_page"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300"
                            value="{{ Config::get('cms.products_per_page') }}" min="1" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Productos random por página:
                        </label>
                        <input type="number" name="products_per_page_random"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300"
                            value="{{ Config::get('cms.products_per_page_random') }}" min="1" required>
                    </div>
                </div>

                <!-- Botón -->
                <div class="pt-4">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white rounded-lg px-6 py-2 font-semibold shadow">
                        Guardar
                    </button>
                </div>

            </form>
        </div>

    </div>
</main>
