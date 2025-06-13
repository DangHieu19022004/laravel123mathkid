@extends('layouts.game')

@section('title', 'Thử Thách Đo Lường - Lớp 4')

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-orange-600">Thử Thách Đo Lường - Lớp 4 📏⚖️</h1>
        <p class="text-lg mt-2">Học về các đơn vị đo lường qua các thử thách thú vị!</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 max-w-4xl mx-auto">
        <!-- Game 1: Đo độ dài -->
        <a href="{{ route('games.lop4.thu_thach_do_luong.length_measurement') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">📏</div>
            <h3 class="text-xl font-bold text-orange-600 mb-2">Đo Độ Dài</h3>
            <p class="text-gray-600">Luyện tập đo và chuyển đổi đơn vị độ dài</p>
        </a>
        <!-- Game 2: Đo khối lượng -->
        <a href="{{ route('games.lop4.thu_thach_do_luong.weight_measurement') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">⚖️</div>
            <h3 class="text-xl font-bold text-orange-600 mb-2">Đo Khối Lượng</h3>
            <p class="text-gray-600">Luyện tập đo và chuyển đổi đơn vị khối lượng</p>
        </a>
        <!-- Game 3: Đo thời gian -->
        <a href="{{ route('games.lop4.thu_thach_do_luong.time_measurement') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">⏰</div>
            <h3 class="text-xl font-bold text-orange-600 mb-2">Đo Thời Gian</h3>
            <p class="text-gray-600">Luyện tập đọc và tính toán thời gian</p>
        </a>
        <!-- Game 4: Tính tiền -->
        <a href="{{ route('games.lop4.thu_thach_do_luong.money_calculation') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">💰</div>
            <h3 class="text-xl font-bold text-orange-600 mb-2">Tính Tiền</h3>
            <p class="text-gray-600">Luyện tập tính toán với tiền tệ</p>
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