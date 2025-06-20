@extends('layouts.game')

@section('title', 'Bí Ẩn Hình Học - Lớp 4')

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-purple-700">Bí Ẩn Hình Học - Lớp 4 📐🟦</h1>
        <p class="text-lg mt-2">Khám phá các trò chơi hình học thú vị!</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 max-w-4xl mx-auto">
        <!-- Game 1: Diện tích -->
        <a href="{{ route('games.lop4.bi_an_hinh_hoc.area_calculation') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🟥</div>
            <h3 class="text-xl font-bold text-purple-700 mb-2">Tính Diện Tích</h3>
            <p class="text-gray-600">Thực hành tính diện tích các hình học</p>
            <div class="level-progress mt-3">
                <div class="level-label">Level: <span id="area-level-label">-</span>/5</div>
                <div class="progress-bar-outer">
                    <div class="progress-bar-inner" id="area-progress-bar" style="width:0%"></div>
                </div>
            </div>
        </a>
        <!-- Game 2: Chu vi -->
        <a href="{{ route('games.lop4.bi_an_hinh_hoc.perimeter_calculation') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">📏</div>
            <h3 class="text-xl font-bold text-purple-700 mb-2">Tính Chu Vi</h3>
            <p class="text-gray-600">Luyện tập tính chu vi các hình học</p>
            <div class="level-progress mt-3">
                <div class="level-label">Level: <span id="perimeter-level-label">-</span>/5</div>
                <div class="progress-bar-outer">
                    <div class="progress-bar-inner" id="perimeter-progress-bar" style="width:0%"></div>
                </div>
            </div>
        </a>
        <!-- Game 3: Đo góc -->
        <a href="{{ route('games.lop4.bi_an_hinh_hoc.angle_measurement') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">📐</div>
            <h3 class="text-xl font-bold text-purple-700 mb-2">Đo Góc</h3>
            <p class="text-gray-600">Luyện tập đo và ước lượng góc</p>
            <div class="level-progress mt-3">
                <div class="level-label">Level: <span id="angle-level-label">-</span>/5</div>
                <div class="progress-bar-outer">
                    <div class="progress-bar-inner" id="angle-progress-bar" style="width:0%"></div>
                </div>
            </div>
        </a>
        <!-- Game 4: Đo dung tích -->
        <a href="{{ route('games.lop4.bi_an_hinh_hoc.volume_measurement') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🥛</div>
            <h3 class="text-xl font-bold text-purple-700 mb-2">Đo Dung Tích</h3>
            <p class="text-gray-600">Thực hành đo và ước lượng dung tích</p>
            <div class="level-progress mt-3">
                <div class="level-label">Level: <span id="volume-level-label">-</span>/5</div>
                <div class="progress-bar-outer">
                    <div class="progress-bar-inner" id="volume-progress-bar" style="width:0%"></div>
                </div>
            </div>
        </a>
        <!-- Game: Đo Diện Tích -->
        <a href="{{ route('games.lop4.bi_an_hinh_hoc.area_measurement') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🟦📏</div>
            <h3 class="text-xl font-bold text-purple-700 mb-2">Đo Diện Tích</h3>
            <p class="text-gray-600">Chọn hình có diện tích lớn nhất/nhỏ nhất</p>
            <div class="level-progress mt-3">
                <div class="level-label">Level: <span id="area-measurement-level-label">-</span>/5</div>
                <div class="progress-bar-outer">
                    <div class="progress-bar-inner" id="area-measurement-progress-bar" style="width:0%"></div>
                </div>
            </div>
        </a>
    </div>
</div>

<style>
.game-card {
    transition: all 0.3s ease;
}
.game-card:hover {
    transform: translateY(-5px);
}
.game-card .text-4xl {
    text-align: center;
}
.level-progress {
    margin-top: 0.5rem;
}
.level-label {
    font-size: 0.95rem;
    color: #4f46e5;
    margin-bottom: 0.2rem;
    font-weight: 500;
}
.progress-bar-outer {
    width: 100%;
    height: 12px;
    background: #e0e7ff;
    border-radius: 8px;
    overflow: hidden;
}
.progress-bar-inner {
    height: 100%;
    background: linear-gradient(90deg, #a78bfa, #6366f1);
    border-radius: 8px 0 0 8px;
    transition: width 0.4s cubic-bezier(.4,2,.6,1);
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lấy level từ localStorage, nếu chưa có thì là 1
    function getLevel(key) {
        let val = parseInt(localStorage.getItem(key));
        if (isNaN(val) || val < 1) return 1;
        return Math.min(val, 5);
    }
    let areaLevel = getLevel('areaGameLevel');
    let perimeterLevel = getLevel('perimeterLevel');
    let angleLevel = getLevel('angleMeasurementLevel');
    let volumeLevel = getLevel('volumeMeasurementLevel');
    let areaMeasurementLevel = getLevel('areaMeasurementLevel');
    // Hiển thị label
    document.getElementById('area-level-label').textContent = areaLevel;
    document.getElementById('perimeter-level-label').textContent = perimeterLevel;
    document.getElementById('angle-level-label').textContent = angleLevel;
    document.getElementById('volume-level-label').textContent = volumeLevel;
    document.getElementById('area-measurement-level-label').textContent = areaMeasurementLevel;
    // Hiển thị progress bar
    document.getElementById('area-progress-bar').style.width = (areaLevel/5*100) + '%';
    document.getElementById('perimeter-progress-bar').style.width = (perimeterLevel/5*100) + '%';
    document.getElementById('angle-progress-bar').style.width = (angleLevel/5*100) + '%';
    document.getElementById('volume-progress-bar').style.width = (volumeLevel/5*100) + '%';
    document.getElementById('area-measurement-progress-bar').style.width = (areaMeasurementLevel/5*100) + '%';
});
</script>
@endsection