<aside id="sidebar"
    class="fixed left-0 top-0 h-screen w-72 bg-gray-100 shadow-lg transition-transform transform lg:translate-x-0 -translate-x-full z-50 flex flex-col">

    {{-- BOTÓN MOBILE --}}
    <button id="sidebar-toggle-btn"
        class="absolute -right-12 top-4 bg-gray-800 p-3 rounded-full shadow lg:hidden flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" 
            class="h-6 w-6 text-white" fill="none" 
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    
    {{-- ENCABEZADO FIJO DEL USUARIO --}}
    <div class="p-4 border-b bg-white shadow-sm flex-shrink-0">
        <div class="font-bold text-gray-800 text-lg">{{ Auth::user()->name }}</div>
        <div class="text-xs text-gray-600">{{ Auth::user()->email }}</div>
        <div class="text-xs text-gray-600">{{ Auth::user()->phone }}</div>
        <a href="#" class="text-blue-600 text-xs underline mt-1 inline-block">Ver perfil</a>
        <a href="{{ route('home') }}" class="text-blue-600 text-xs underline mt-1 inline-block">Inicio</a>
        <a href="{{ url('/logout') }}" class="text-blue-600 text-xs underline mt-1 inline-block">Cerra sesión</a>
    </div>

    {{-- CONTENIDO SCROLLEABLE --}}
    <div class="flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-200">

        @include('admin.layout.session')

        {{-- MENÚ --}}
        <ul class="px-4 py-3 space-y-1">

            {{-- Administración --}}
            <li class="text-xs font-semibold text-white bg-gray-800 px-2 py-1 rounded">Administración</li>
            @if(kvfj(Auth::user()->permissions, 'dashboard'))
            <li>
                <a href="{{ url('admin') }}"
                    class="block py-2 px-2 rounded hover:bg-gray-200 transition nav-link lk-dashboard">
                    Dashboard
                </a>
            </li>
            @endif

            @if(kvfj(Auth::user()->permissions, 'user_list'))
            <li>
                <a href="{{ url('/admin/users/all') }}"
                    class="block py-2 px-2 rounded hover:bg-gray-200 transition nav-link lk-user_list lk-user_edit_get lk-user_permissions_get">
                    Usuarios
                </a>
            </li>
            @endif

            {{-- Punto Gastronomico --}}
            <li class="text-xs font-semibold text-white bg-gray-800 px-2 py-1 rounded mt-4">Punto gastronómico</li>

            @if(kvfj(Auth::user()->permissions, 'categories'))
            <li>
                <a href="{{ url('/admin/categories/0') }}"
                    class="block py-2 px-2 rounded hover:bg-gray-200 transition nav-link lk-categories">
                    Categorías
                </a>
            </li>
            @endif

            @if(kvfj(Auth::user()->permissions, 'products'))
            <li>
                <a href="{{ url('/admin/products/all') }}"
                    class="block py-2 px-2 rounded hover:bg-gray-200 transition nav-link lk-products">
                    Productos
                </a>
            </li>
            @endif

            @if(kvfj(Auth::user()->permissions, 'order_list'))
            <li>
                <a href="{{ route('admin.orders.index') }}"
                    class="block py-2 px-2 rounded hover:bg-gray-200 transition nav-link lk-orders_list">
                    Órdenes
                </a>
            </li>
            @endif

            {{-- Alquiler --}}
            <li class="text-xs font-semibold text-white bg-gray-800 px-2 py-1 rounded mt-4">Alquiler / Enseres / Salón</li>
            @if(kvfj(Auth::user()->permissions, 'item_list'))     
            <li>
                <a href="{{ route('admin.items.index') }}"
                    class="block py-2 px-2 rounded hover:bg-gray-200 transition nav-link">
                    Items
                </a>
            </li>
            @endif
            @if(kvfj(Auth::user()->permissions, 'alquiler_list'))
            <li>
                <a href="{{ route('admin.alquileres.home') }}"
                    class="block py-2 px-2 rounded hover:bg-gray-200 transition nav-link">
                    Alquiler
                </a>
            </li>
            @endif
            {{-- Billetera --}}
            <li class="text-xs font-semibold text-white bg-gray-800 px-2 py-1 rounded mt-4">Billetera / Comunal</li>
            @if(kvfj(Auth::user()->permissions, 'billetera_list'))
            <li>
                <a href="{{ route('admin.billetera.home') }}"
                    class="block py-2 px-2 rounded hover:bg-gray-200 transition nav-link">
                    Ingresos / Egresos
                </a>
            </li>
            @endif
                @if(kvfj(Auth::user()->permissions, 'billetera_comunal'))
            <li>
                <a href="{{ route('admin.billetera.comunal') }}"
                    class="block py-2 px-2 rounded hover:bg-gray-200 transition nav-link">
                    Comunales
                </a>
            </li>
            @endif
            {{-- Reportes --}}
            <li class="text-xs font-semibold text-white bg-gray-800 px-2 py-1 rounded mt-4">Reportes</li>
                @if(kvfj(Auth::user()->permissions, 'reporte_list'))
            <li>
                <a href="{{ route('admin.reporte.home') }}"
                    class="block py-2 px-2 rounded hover:bg-gray-200 transition nav-link">
                    Reporte Ingresos/Egresos
                </a>
            </li>
            @endif
            @if(kvfj(Auth::user()->permissions, 'reporte_gastos'))
            <li>
                <a href="{{ route('admin.reporte.consult') }}"
                    class="block py-2 px-2 rounded hover:bg-gray-200 transition nav-link">
                    Consultar Gastos / Inversiones
                </a>
            </li>
            @endif
            @if(kvfj(Auth::user()->permissions, 'reporte_total'))
            <li>
                <a href="{{ route('admin.reporte.saldo') }}"
                    class="block py-2 px-2 rounded hover:bg-gray-200 transition nav-link">
                    Consultar Saldo Total
                </a>
            </li>
            @endif
            {{-- Configuración --}}
            <li class="text-xs font-semibold text-white bg-gray-800 px-2 py-1 rounded mt-4">Configuración</li>

            @if(kvfj(Auth::user()->permissions, 'settings'))
            <li>
                <a href="{{ url('/admin/settings') }}"
                    class="block py-2 px-2 rounded hover:bg-gray-200 transition nav-link lk-settings">
                    Configuración
                </a>
            </li>
            @endif

        </ul>

    </div> {{-- FIN DEL SCROLLABLE --}}
</aside>

<div id="sidebar-overlay"
     class="fixed inset-0 bg-black opacity-0 pointer-events-none transition-opacity duration-300 z-40 lg:hidden">
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebar-toggle-btn');
        const overlay = document.getElementById('sidebar-overlay'); // Agregamos el overlay

        function toggleSidebar() {
            // 1. Toggle del Sidebar (Muestra / Oculta)
            sidebar.classList.toggle('-translate-x-full');
            
            // 2. Toggle del Overlay (Hace que la capa negra aparezca o desaparezca)
            overlay.classList.toggle('opacity-0');    // Oculta completamente
            overlay.classList.toggle('opacity-50');   // Muestra con opacidad (el "fondo blanco" que viste)
            overlay.classList.toggle('pointer-events-none'); // Permite que se haga clic en lo que está debajo
        }

        if (sidebar && toggleBtn && overlay) {
            // Abrir/Cerrar al hacer clic en el botón de hamburguesa
            toggleBtn.addEventListener('click', toggleSidebar);
            
            // Cerrar al hacer clic en el overlay (el fondo negro/transparente)
            overlay.addEventListener('click', toggleSidebar);
        }
    });
</script>