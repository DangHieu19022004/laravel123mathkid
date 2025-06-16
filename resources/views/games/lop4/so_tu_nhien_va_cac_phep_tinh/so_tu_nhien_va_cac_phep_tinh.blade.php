@extends('layouts.game')

@section('title', 'Số Tự Nhiên và Các Phép Tính - Lớp 4')

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-indigo-600">Số Tự Nhiên và Các Phép Tính - Lớp 4 🔢✨</h1>
        <p class="text-lg mt-2">Học về số tự nhiên và các phép tính cơ bản!</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 max-w-4xl mx-auto">
        <!-- Game 1: Giá trị hàng -->
        <a href="{{ route('games.lop4.so_tu_nhien_va_cac_phep_tinh.number_place_value') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🔍</div>
            <h3 class="text-xl font-bold text-indigo-600 mb-2">Giá Trị Hàng</h3>
            <p class="text-gray-600">Tìm hiểu về giá trị các hàng trong số tự nhiên</p>
        </a>
        <!-- Game 2: Cộng trừ -->
        <a href="{{ route('games.lop4.so_tu_nhien_va_cac_phep_tinh.addition_subtraction') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">➕➖</div>
            <h3 class="text-xl font-bold text-indigo-600 mb-2">Cộng Trừ</h3>
            <p class="text-gray-600">Luyện tập phép cộng và phép trừ</p>
        </a>
        <!-- Game 3: Nhân chia -->
        <a href="{{ route('games.lop4.so_tu_nhien_va_cac_phep_tinh.multiplication_division') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">✖️➗</div>
            <h3 class="text-xl font-bold text-indigo-600 mb-2">Nhân Chia</h3>
            <p class="text-gray-600">Luyện tập phép nhân và phép chia</p>
        </a>
        <!-- Game 4: Phép tính hỗn hợp -->
        <a href="{{ route('games.lop4.so_tu_nhien_va_cac_phep_tinh.mixed_operations') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🧮</div>
            <h3 class="text-xl font-bold text-indigo-600 mb-2">Phép Tính Hỗn Hợp</h3>
            <p class="text-gray-600">Thực hành các phép tính kết hợp</p>
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