<div class="w-full bg-gray-100">

    @if (Auth::check())
        <div class="w-full bg-gray-100">
            <div class="flex items-center gap-3 flex-wrap py-3 px-4 text-sm text-gray-700">

                <a href="#" class="hover:text-black">Quiénes somos</a>
                <span class="text-gray-400">|</span>

                <a href="#" class="hover:text-black">Contacto</a>
                <span class="text-gray-400">|</span>

                <a href="#" class="hover:text-black">Ayuda</a>
                <span class="text-gray-400">|</span>

                <a href="{{ url('/') }}" class="hover:text-black">Inicio</a>
                <span class="text-gray-400">|</span>

                <!-- Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button 
                        @click="open = !open"
                        class="px-2 py-1 hover:text-black flex items-center gap-1"
                    >
                        {{ Auth::user()->name }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div 
                        x-show="open"
                        @click.away="open = false"
                        class="absolute mt-2 bg-white shadow-lg rounded-lg w-40 z-50 py-2"
                    >
                        <a href="{{ url('/account/edit') }}" class="block px-4 py-2 hover:bg-gray-100">Perfil</a>

                        @if (Auth::user()->role == 1)
                        <a href="{{ url('/admin') }}" class="block px-4 py-2 hover:bg-gray-100">Administración</a>
                        @endif

                        <div class="border-t my-2"></div>

                        <a href="{{ url('/logout') }}" class="block px-4 py-2 hover:bg-gray-100 text-red-600">Cerrar sesión</a>
                    </div>
                </div>

            </div>
        </div>

    @else

        <div class="flex items-center gap-3 flex-wrap py-3 px-4 text-sm text-gray-700">

            <a href="#" class="hover:text-black">Quiénes somos</a>
            <span class="text-gray-400">|</span>

            <a href="#" class="hover:text-black">Contacto</a>
            <span class="text-gray-400">|</span>

            <a href="#" class="hover:text-black">Ayuda</a>
            <span class="text-gray-400">|</span>

            <a href="{{ url('/register') }}" class="hover:text-black">Únete a nosotros</a>
            <span class="text-gray-400">|</span>

            <a href="{{ url('/login') }}" class="hover:text-black">Iniciar sesión</a>
        </div>

    @endif

</div>
