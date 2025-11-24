<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="routeName" content="{{ Route::currentRouteName() }}">
    {{-- favicon --}}
    <link rel="icon" type="image/x-icon" href="/static/img/icon.png">
    {{-- Bootstrap 4 --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    {{-- CSS Styles --}}
    <link href="{{ asset('static/css/connect/style.css') }}" rel="stylesheet">
</head>
<body>

    @section('content')
    @show
    
    {{-- Script Bootstrap 4 --}}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    {{-- Custom Scripts --}}
    <script src="{{ asset('static/js/connect/script.js') }}"></script>
</body>
</html>