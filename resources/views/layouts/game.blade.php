<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Toán Lớp 4</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .game-container {
            min-height: calc(100vh - 160px);
        }
        
        .footer {
            background-color: #343a40;
            color: white;
            padding: 1rem 0;
            margin-top: 2rem;
        }
        
        /* Animation classes */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .bounce {
            animation: bounce 0.5s ease-in-out;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        /* Custom game styles */
        .game-card {
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .game-card:hover {
            transform: translateY(-5px);
        }
        
        .progress {
            height: 10px;
            border-radius: 5px;
        }
        
        .badge {
            padding: 0.5em 1em;
            border-radius: 20px;
        }
    </style>
    
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

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (if needed) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Custom Scripts -->
    <script>
        // Common game functions
        function showSuccess(message) {
            return Swal.fire({
                icon: 'success',
                title: 'Tuyệt vời!',
                text: message,
                confirmButtonText: 'Tiếp tục'
            });
        }

        function showError(message) {
            return Swal.fire({
                icon: 'error',
                title: 'Chưa đúng!',
                text: message,
                confirmButtonText: 'Thử lại'
            });
        }

        // Add animation to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.game-card');
            cards.forEach(card => {
                card.classList.add('fade-in');
            });
        });
    </script>

    <!-- SweetAlert2 for better alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @yield('scripts')
</body>
</html> 