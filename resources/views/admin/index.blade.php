<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administración</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="/static/img/icon.png">
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- CSS --}}
    <link href="{{ asset('static/css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('static/css/styleResponsive.css') }}" rel="stylesheet">
    <link href="{{ asset('static/css/admin/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('static/css/admin/styleResponsive.css') }}" rel="stylesheet">
    @yield('css')

    <style>
        /* Preloader */
        #preloader {
            position: fixed;
            inset: 0;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        #preloader .spinner {
            width: 60px;
            height: 60px;
            border: 4px solid #e5e7eb;
            border-top: 4px solid #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Oculta el contenido inicialmente */
        #main-content {
            display: none;
        }
    </style>

    <!-- Bloquear renderizado hasta que cargue -->
    <script>
        document.documentElement.style.visibility = 'hidden';
    </script>
</head>
<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner"></div>
    </div>

    <!-- Contenido principal -->
    <div id="main-content">
        @yield('content')
    </div>

    {{-- Scripts --}}
    <script src="{{ asset('static/js/script.js') }}"></script>
    <script src="{{ asset('static/js/admin/scriptMaster.js') }}"></script>
    @yield('js')

    <script>
        // Mostrar contenido cuando toda la página esté cargada
        window.addEventListener('load', function() {
            // Oculta preloader
            const preloader = document.getElementById('preloader');
            preloader.style.display = 'none';

            // Muestra contenido
            const main = document.getElementById('main-content');
            main.style.display = 'block';

            // Restaurar visibilidad del documento
            document.documentElement.style.visibility = 'visible';
        });
    </script>
</body>
</html>
