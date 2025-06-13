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
        </a>
        <!-- Game 2: Chu vi -->
        <a href="{{ route('games.lop4.bi_an_hinh_hoc.perimeter_calculation') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">📏</div>
            <h3 class="text-xl font-bold text-purple-700 mb-2">Tính Chu Vi</h3>
            <p class="text-gray-600">Luyện tập tính chu vi các hình học</p>
        </a>
        <!-- Game 3: Đo góc -->
        <a href="{{ route('games.lop4.bi_an_hinh_hoc.angle_measurement') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">📐</div>
            <h3 class="text-xl font-bold text-purple-700 mb-2">Đo Góc</h3>
            <p class="text-gray-600">Luyện tập đo và ước lượng góc</p>
        </a>
        <!-- Game 4: Đo dung tích -->
        <a href="{{ route('games.lop4.bi_an_hinh_hoc.volume_measurement') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🥛</div>
            <h3 class="text-xl font-bold text-purple-700 mb-2">Đo Dung Tích</h3>
            <p class="text-gray-600">Thực hành đo và ước lượng dung tích</p>
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
</style>
@endsection 