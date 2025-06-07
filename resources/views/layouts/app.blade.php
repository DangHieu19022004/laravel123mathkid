<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Toán Lớp 4</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: #f8fafc;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .game-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .btn-game {
            background: #10b981;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 9999px;
            border: none;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        .btn-game:hover {
            background: #059669;
            color: white;
            transform: translateY(-2px);
        }
        .cake-container {
            width: 400px;
            height: 400px;
            margin: 0 auto;
        }
        .cake-piece {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .cake-piece:hover {
            transform: scale(1.05);
            filter: brightness(1.1);
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(-5%); }
            50% { transform: translateY(0); }
        }
        .animate-bounce {
            animation: bounce 1s infinite;
        }
    </style>

    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">Game Toán Lớp 4</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('games.lop4.phanso') }}">Phân Số</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Canvas Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    @stack('scripts')
</body>
</html> 