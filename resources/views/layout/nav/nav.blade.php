<nav class="navbar navbar-expand-md navbar-light">
    <div class="container-fluid"> 

        <a class="navbar-brand" href="javascript:void(0)">Logo</a>

        <div class="order-md-last d-flex mx-4 my-2"> 
            <a class="mx-2" href="#">
                <form class="d-flex">
                    <input class="form-control search-web" style="width: 180px" type="text" placeholder="Buscar">
                </form>  
            </a>

            @if (Auth::check())

            @else:
                {{-- icon heart --}}
                <a class="heart-style-responsive" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#333" class="bi bi-heart mt-2 mx-2" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                    </svg>
                </a>
            @endif

            {{-- icon cart --}}
            <a class="cart-style-responsive" href="{{ url('/cart') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#333" class="bi bi-bag mt-1" viewBox="0 0 16 16">
                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
                </svg>
                <span class="bg-danger text-white rounded position-absolute text-center" style="width: 15px; height: 16px; font-size: 11px;">3</span>
            </a>

            {{-- name user, menu responsive --}}
            @if (Auth::check())
                <span class="dropdown cart-style-responsive droptown-movile" style="margin-right: 0px;">
                    <a class="dropdown-toggle p-2 prop-user mx-1 "  type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }} 
                        <span>

                        </span>
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="dropdownMenuButton">
                        <!-- Agrega aquí las opciones del dropdown -->
                        <a class="dropdown-item" href="{{ url('/account/edit') }}">Cuenta</a>
                        <a class="dropdown-item" href="#">Configuración</a>
                        @if (Auth::user()->role == 1)
                            <a class="dropdown-item" href="{{ url('/admin') }}">Administración</a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('/logout') }}">Cerrar sesión</a>
                    </div>
                </span>
            @else:
                {{-- icon user --}}
                <a class="user-style-responsive" href="{{ url('login') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="34" fill="#333" class="bi bi-person mx-2" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                    </svg>
                </a>
            @endif

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto nav-movile pl-5">
                <!-- Botón para cerrar el Navbar Collapse -->
                <button id="cerrarNavbar" class="navbar-toggler btn-close" type="button" aria-label="Cerrar navegación">
                    <span class="font-weight-bold">X</span>
                </button>

                <li class="nav-item">
                    <a class="nav-link font-weight-bold text-dark" href="#">Novedades y destacados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold text-dark" href="#">Tecnología</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold text-dark" href="#">Hogar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold text-dark" href="#">Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold text-dark" href="#">Ofertas</a>
                </li>
            </ul>
        </div>
    </div>
</nav>