<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--    {!! SEO::generate(true) !!}--}}
    <link type="image/x-icon" rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/game.css') }}">

    @yield('styles')
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="fas fa-calculator"></i> Toán Lớp 4
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('games.lop4.index') }}">
                        <i class="fas fa-gamepad"></i> Trò Chơi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-book"></i> Bài Học
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-chart-bar"></i> Tiến Độ
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="game-container">
    @yield('game_content')
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container text-center">
        <p class="mb-0">© 2024 Toán Lớp 4 - Học Toán Vui</p>
    </div>
</footer>

<script type="text/javascript" src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>

@include('layouts.require_js._game')

@yield('scripts')

</body>

</html>
