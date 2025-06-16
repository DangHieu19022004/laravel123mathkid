@extends('layouts.game')

@section('title', 'Thử Thách Đo Lường - Lớp 4')

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-orange-600">Thử Thách Đo Lường - Lớp 4 📏⚖️</h1>
        <p class="text-lg mt-2">Học về các đơn vị đo lường qua các thử thách thú vị!</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 max-w-4xl mx-auto">
        <!-- Game: Đo Độ Dài -->
        <a href="{{ route('games.lop4.dailuongvadoluong.length_measurement') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">📏</div>
            <h3 class="text-xl font-bold text-orange-600 mb-2">Đo Độ Dài</h3>
            <p class="text-gray-600">Luyện tập đo và chuyển đổi đơn vị độ dài</p>
        </a>
        <!-- Game: Cân Táo Cân Cam -->
        <a href="{{ route('games.lop4.dailuongvadoluong.fruit_weighing') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🍏🍊</div>
            <h3 class="text-xl font-bold text-orange-600 mb-2">Cân Táo Cân Cam</h3>
            <p class="text-gray-600">So sánh khối lượng các loại quả</p>
        </a>
        <!-- Game: Chuyển Đổi Đơn Vị Thần Tốc -->
        <a href="{{ route('games.lop4.dailuongvadoluong.unit_conversion') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🔄</div>
            <h3 class="text-xl font-bold text-orange-600 mb-2">Chuyển Đổi Đơn Vị Thần Tốc</h3>
            <p class="text-gray-600">Chuyển đổi nhanh các đơn vị đo lường</p>
        </a>
        <!-- Game: Bảng Quy Đổi -->
        <a href="{{ route('games.lop4.dailuongvadoluong.conversion_table') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">📊</div>
            <h3 class="text-xl font-bold text-orange-600 mb-2">Bảng Quy Đổi</h3>
            <p class="text-gray-600">Luyện tập bảng quy đổi các đơn vị</p>
        </a>
        <!-- Game: Cuộc Đua Đơn Vị Đo -->
        <a href="{{ route('games.lop4.dailuongvadoluong.distance_comparison') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🏁</div>
            <h3 class="text-xl font-bold text-orange-600 mb-2">Cuộc Đua Đơn Vị Đo</h3>
            <p class="text-gray-600">So sánh các khoảng cách</p>
        </a>
        <!-- Game: Xếp Hàng Theo Khối Lượng -->
        <a href="{{ route('games.lop4.dailuongvadoluong.weight_sorting') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">📦</div>
            <h3 class="text-xl font-bold text-orange-600 mb-2">Xếp Hàng Theo Khối Lượng</h3>
            <p class="text-gray-600">Sắp xếp vật theo khối lượng</p>
        </a>
        <!-- Game: Bấm Giờ Chuẩn -->
        <a href="{{ route('games.lop4.dailuongvadoluong.precision_timing') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">⏱️</div>
            <h3 class="text-xl font-bold text-orange-600 mb-2">Bấm Giờ Chuẩn</h3>
            <p class="text-gray-600">Luyện tập đo thời gian chính xác</p>
        </a>
        <!-- Game: Thời Gian Nâng Cao -->
        <a href="{{ route('games.lop4.dailuongvadoluong.advanced_time') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">⏳</div>
            <h3 class="text-xl font-bold text-orange-600 mb-2">Thời Gian Nâng Cao</h3>
            <p class="text-gray-600">Thử thách về thời gian nâng cao</p>
        </a>
        <!-- Game: Thời Gian Phiêu Lưu -->
        <a href="{{ route('games.lop4.dailuongvadoluong.time_adventure') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🚀</div>
            <h3 class="text-xl font-bold text-orange-600 mb-2">Thời Gian Phiêu Lưu</h3>
            <p class="text-gray-600">Phiêu lưu với các bài toán thời gian</p>
        </a>
        <!-- Game: So Sánh Thời Gian -->
        <a href="{{ route('games.lop4.dailuongvadoluong.time_comparison') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">⏰</div>
            <h3 class="text-xl font-bold text-orange-600 mb-2">So Sánh Thời Gian</h3>
            <p class="text-gray-600">So sánh các khoảng thời gian</p>
        </a>
        <!-- Game: Ước Lượng Khối Lượng -->
        <a href="{{ route('games.lop4.dailuongvadoluong.weight_estimation') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">⚖️</div>
            <h3 class="text-xl font-bold text-orange-600 mb-2">Ước Lượng Khối Lượng</h3>
            <p class="text-gray-600">Ước lượng khối lượng vật thể</p>
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