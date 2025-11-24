<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Komirezo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="routeName" content="{{ Route::currentRouteName() }}">
    <meta name="currency" content="{{ Config::get('cms.currency') }}">
	<meta name="auth" content="{{ Auth::check() }}">
    {{-- favicon --}}
    <link rel="icon" type="image/x-icon" href="/static/img/icon.png">
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- CSS Styles --}}
    <link href="{{ asset('static/css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('static/css/styleResponsive.css') }}" rel="stylesheet">
    <link href="{{ asset('static/css/connect/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:wght@400;500;700&display=swap">

</head>
<body>
    {{-- Home --}}
    {{-- Cabecera web --}}
    @include('layout.nav.head')
    

    <div class="">
        @yield('content')
    </div>

    <footer class="footer mt-auto py-3 text-center" style="background-color: #f3f3f3;">
        <div class="container">
          <span class=" text-dark">© 2025 Komirezo. Todos los derechos reservados.</span>
        </div>
    </footer>
      

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    {{-- Custom Scripts --}}
    <script src="{{ asset('static/js/script.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
