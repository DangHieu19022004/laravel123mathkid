@extends('layouts.game')

@section('title', 'Thống Kê và Biểu Đồ - Lớp 4')

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-teal-600">Thống Kê và Biểu Đồ - Lớp 4 📊📈</h1>
        <p class="text-lg mt-2">Học về thống kê và các loại biểu đồ!</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 max-w-4xl mx-auto">
        <!-- Game 1: Thu thập dữ liệu -->
        <a href="{{ route('games.lop4.thong_ke_bieu_do.data_collection') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">📝</div>
            <h3 class="text-xl font-bold text-teal-600 mb-2">Thu Thập Dữ Liệu</h3>
            <p class="text-gray-600">Học cách thu thập và tổ chức dữ liệu</p>
        </a>
        <!-- Game 2: Biểu đồ cột -->
        <a href="{{ route('games.lop4.thong_ke_bieu_do.bar_chart') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">📊</div>
            <h3 class="text-xl font-bold text-teal-600 mb-2">Biểu Đồ Cột</h3>
            <p class="text-gray-600">Tìm hiểu và vẽ biểu đồ cột</p>
        </a>
        <!-- Game 3: Biểu đồ đường -->
        <a href="{{ route('games.lop4.thong_ke_bieu_do.line_chart') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">📈</div>
            <h3 class="text-xl font-bold text-teal-600 mb-2">Biểu Đồ Đường</h3>
            <p class="text-gray-600">Tìm hiểu và vẽ biểu đồ đường</p>
        </a>
        <!-- Game 4: Biểu đồ tròn -->
        <a href="{{ route('games.lop4.thong_ke_bieu_do.pie_chart') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🥧</div>
            <h3 class="text-xl font-bold text-teal-600 mb-2">Biểu Đồ Tròn</h3>
            <p class="text-gray-600">Tìm hiểu và vẽ biểu đồ tròn</p>
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