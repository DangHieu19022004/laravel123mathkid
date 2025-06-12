@extends('layouts.game')

@section('title', 'Đo lường và Đơn vị - Lớp 4')

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600">Đo lường và Đơn vị - Lớp 4 📏⚖️</h1>
        <p class="text-lg mt-2">Chọn một trò chơi để luyện tập</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
        <!-- Game 1 -->
        <a href="{{ route('games.lop4.dailuongvadoluong.fruit_weighing') }}" 
           class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">⚖️🍎</div>
            <h3 class="text-xl font-bold text-blue-600 mb-2">Cân Táo Cân Cam</h3>
            <p class="text-gray-600">Luyện tập cân bằng khối lượng với trái cây</p>
        </a>

        <!-- Game 2 -->
        <a href="{{ route('games.lop4.dailuongvadoluong.time_adventure') }}" 
           class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">⏰</div>
            <h3 class="text-xl font-bold text-blue-600 mb-2">Thời Gian Phiêu Lưu</h3>
            <p class="text-gray-600">Tính toán khoảng thời gian giữa hai mốc</p>
        </a>

        <!-- Game 3 -->
        <a href="{{ route('games.lop4.dailuongvadoluong.unit_conversion') }}" 
           class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🔄</div>
            <h3 class="text-xl font-bold text-blue-600 mb-2">Chuyển Đổi Đơn Vị Thần Tốc</h3>
            <p class="text-gray-600">Thực hành chuyển đổi giữa các đơn vị đo lường</p>
        </a>

        <!-- Game 4 -->
        <a href="{{ route('games.lop4.dailuongvadoluong.distance_comparison') }}" 
           class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🏎️</div>
            <h3 class="text-xl font-bold text-blue-600 mb-2">Cuộc Đua Đơn Vị Đo</h3>
            <p class="text-gray-600">So sánh các khoảng cách với đơn vị khác nhau</p>
        </a>

        <!-- Game 5 -->
        <a href="{{ route('games.lop4.dailuongvadoluong.weight_sorting') }}" 
           class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">📊</div>
            <h3 class="text-xl font-bold text-blue-600 mb-2">Xếp Hàng Theo Khối Lượng</h3>
            <p class="text-gray-600">Sắp xếp các vật theo thứ tự khối lượng</p>
        </a>

        <!-- Game 6 -->
        <a href="{{ route('games.lop4.dailuongvadoluong.precision_timing') }}" 
           class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">⏱️</div>
            <h3 class="text-xl font-bold text-blue-600 mb-2">Bấm Giờ Chuẩn</h3>
            <p class="text-gray-600">Luyện tập ước lượng thời gian chính xác</p>
        </a>

        <!-- Game 7 -->
        <a href="{{ route('games.lop4.dailuongvadoluong.conversion_table') }}" 
           class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">📝</div>
            <h3 class="text-xl font-bold text-blue-600 mb-2">Bảng Quy Đổi</h3>
            <p class="text-gray-600">Hoàn thành bảng quy đổi đơn vị</p>
        </a>

        <!-- Game 8 -->
        <a href="{{ route('games.lop4.dailuongvadoluong.length_measurement') }}" 
           class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">📏</div>
            <h3 class="text-xl font-bold text-blue-600 mb-2">Đo Độ Dài</h3>
            <p class="text-gray-600">Thực hành đo và ước lượng độ dài</p>
        </a>

        <!-- Game 9 -->
        <a href="{{ route('games.lop4.dailuongvadoluong.weight_estimation') }}" 
           class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">⚖️</div>
            <h3 class="text-xl font-bold text-blue-600 mb-2">Ước Lượng Khối Lượng</h3>
            <p class="text-gray-600">Luyện tập ước lượng khối lượng vật thể</p>
        </a>

        <!-- Game 10 -->
        <a href="{{ route('games.lop4.dailuongvadoluong.time_comparison') }}" 
           class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🕒</div>
            <h3 class="text-xl font-bold text-blue-600 mb-2">So Sánh Thời Gian</h3>
            <p class="text-gray-600">So sánh các khoảng thời gian khác nhau</p>
        </a>

        <!-- Game 11 -->
        <a href="{{ route('games.lop4.dailuongvadoluong.volume_measurement') }}" 
           class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🥛</div>
            <h3 class="text-xl font-bold text-blue-600 mb-2">Đo Dung Tích</h3>
            <p class="text-gray-600">Thực hành đo và ước lượng dung tích</p>
        </a>

        <!-- Game 12 -->
        <a href="{{ route('games.lop4.dailuongvadoluong.perimeter_calculation') }}" 
           class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">📐</div>
            <h3 class="text-xl font-bold text-blue-600 mb-2">Tính Chu Vi</h3>
            <p class="text-gray-600">Luyện tập tính chu vi các hình học</p>
        </a>

        <!-- Game 13 -->
        <a href="{{ route('games.lop4.dailuongvadoluong.area_calculation') }}" 
           class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🟥</div>
            <h3 class="text-xl font-bold text-blue-600 mb-2">Tính Diện Tích</h3>
            <p class="text-gray-600">Thực hành tính diện tích các hình học</p>
        </a>

        <!-- Game 14 -->
        <a href="{{ route('games.lop4.dailuongvadoluong.angle_measurement') }}" 
           class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">📐</div>
            <h3 class="text-xl font-bold text-blue-600 mb-2">Đo Góc</h3>
            <p class="text-gray-600">Luyện tập đo và ước lượng góc</p>
        </a>

        <!-- Game 15 -->
        <a href="{{ route('games.lop4.dailuongvadoluong.advanced_time') }}" 
           class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">⏰</div>
            <h3 class="text-xl font-bold text-blue-600 mb-2">Thời Gian Nâng Cao</h3>
            <p class="text-gray-600">Giải các bài toán thời gian phức tạp</p>
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