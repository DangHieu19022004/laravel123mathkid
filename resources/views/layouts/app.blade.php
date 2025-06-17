<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

     {!! SEO::generate(true) !!}

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-gradient-to-br from-primary via-primary-light to-primary-dark min-h-screen overflow-x-hidden relative">

<!-- Navbar -->
@include('layouts.header')

<!-- Main Content -->
@yield('content')

<!-- Footer -->
@include('layouts.footer')

<!-- jQuery nếu cần -->
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>

@stack('scripts')

</body>
</html>
