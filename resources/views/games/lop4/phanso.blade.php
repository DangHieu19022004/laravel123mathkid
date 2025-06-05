@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center display-4 mb-5">Game Toán Học Lớp 4 🎮</h1>

    <div class="row g-4">
        <!-- Cake Game Card -->
        <div class="col-md-4">
            <div class="card h-100 game-card">
                <div class="card-body text-center">
                    <div class="game-icon mb-3 display-1">🎂</div>
                    <h2 class="card-title h4">Chia Bánh Sinh Nhật</h2>
                    <p class="card-text text-muted mb-3">Học phân số qua việc chia bánh sinh nhật</p>
                    <div class="difficulty mb-3">
                        <span class="badge bg-success">Dễ</span>
                        <span class="badge bg-primary">Phân số</span>
                        <span class="badge bg-info">Chia đều</span>
                    </div>
                    <div class="progress mb-3" style="height: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                             style="width: {{ ($cakeLevel-1) * 20 }}%"></div>
                    </div>
                    <div class="level-info mb-3">
                        <small class="text-muted">Cấp độ {{ $cakeLevel }}/5</small>
                    </div>
                    <a href="{{ route('games.lop4.phanso.cake') }}" class="btn btn-primary w-100">
                        {{ $cakeLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Apple Game Card -->
        <div class="col-md-4">
            <div class="card h-100 game-card">
                <div class="card-body text-center">
                    <div class="game-icon mb-3 display-1">🍎</div>
                    <h2 class="card-title h4">Chia Táo</h2>
                    <p class="card-text text-muted mb-3">Học phép chia qua việc chia táo vào các nhóm</p>
                    <div class="difficulty mb-3">
                        <span class="badge bg-warning text-dark">Trung bình</span>
                        <span class="badge bg-primary">Phép chia</span>
                        <span class="badge bg-info">Nhóm</span>
                    </div>
                    <div class="progress mb-3" style="height: 10px;">
                        <div class="progress-bar bg-warning" role="progressbar" 
                             style="width: {{ ($appleLevel-1) * 20 }}%"></div>
                    </div>
                    <div class="level-info mb-3">
                        <small class="text-muted">Cấp độ {{ $appleLevel }}/5</small>
                    </div>
                    <a href="{{ route('games.lop4.phanso.apple') }}" class="btn btn-primary w-100">
                        {{ $appleLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Bracket Game Card -->
        <div class="col-md-4">
            <div class="card h-100 game-card">
                <div class="card-body text-center">
                    <div class="game-icon mb-3 display-1">🎯</div>
                    <h2 class="card-title h4">Biểu Thức Ngoặc</h2>
                    <p class="card-text text-muted mb-3">Học cách tính biểu thức có dấu ngoặc</p>
                    <div class="difficulty mb-3">
                        <span class="badge bg-danger">Khó</span>
                        <span class="badge bg-primary">Biểu thức</span>
                        <span class="badge bg-info">Thứ tự tính</span>
                    </div>
                    <div class="progress mb-3" style="height: 10px;">
                        <div class="progress-bar bg-danger" role="progressbar" 
                             style="width: {{ ($bracketLevel-1) * 20 }}%"></div>
                    </div>
                    <div class="level-info mb-3">
                        <small class="text-muted">Cấp độ {{ $bracketLevel }}/5</small>
                    </div>
                    <a href="{{ route('games.lop4.phanso.bracket') }}" class="btn btn-primary w-100">
                        {{ $bracketLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.game-card {
    transition: transform 0.3s ease;
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.game-card:hover {
    transform: translateY(-5px);
}
.game-icon {
    animation: bounce 2s infinite;
}
@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}
</style>
@endpush
@endsection 