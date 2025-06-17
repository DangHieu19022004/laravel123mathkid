<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- {!! SEO::generate(true) !!} --}}
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-gradient-to-br from-yellow-50 via-white to-blue-50 text-gray-800 font-sans min-h-screen flex flex-col">

<!-- Navbar -->
<nav class="bg-white shadow-sm border-b border-gray-200">
    <div class="container mx-auto px-4 py-4 flex items-center justify-between">
        <a href="/" class="text-2xl font-extrabold text-orange-600 tracking-wide hover:opacity-80 transition-all">
            🎓 Game Toán Lớp 4
        </a>
        <div class="hidden md:flex items-center gap-4">
            <a href="/" class="text-sm font-medium text-gray-600 hover:text-orange-600 transition">Trang chủ</a>
            <a href="#games" class="text-sm font-medium text-gray-600 hover:text-orange-600 transition">Chủ đề</a>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="flex-grow">
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-white mt-8 py-6 text-center text-sm text-gray-500 border-t border-gray-100">
    © {{ date('Y') }} Game Toán Lớp 4. Được phát triển với ❤️.
</footer>

<!-- jQuery nếu cần -->
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>

@stack('scripts')

</body>
</html>
