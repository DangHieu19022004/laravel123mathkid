@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h1 class="text-3xl font-bold text-center text-orange-600 mb-8">Chọn Chủ Đề Game Toán Lớp 4</h1>
    <div class="row justify-content-center">
        <!-- Chủ đề 1: Số Tự Nhiên và Các Phép Tính -->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <a href="/games/lop4/so-tu-nhien-va-cac-phep-tinh" class="game-topic-card d-block p-4 text-center shadow rounded-xl h-100" style="background: #e6f0ff; text-decoration: none;">
                <div style="font-size: 2.5rem;">🔢</div>
                <div class="mt-2 font-bold text-lg text-primary">Số Tự Nhiên và Các Phép Tính</div>
            </a>
        </div>
        <!-- Chủ đề 2: Khám Phá Thế Giới Phân Số -->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <a href="/games/lop4/kham-pha-phan-so" class="game-topic-card d-block p-4 text-center shadow rounded-xl h-100" style="background: #f0fff0; text-decoration: none;">
                <div style="font-size: 2.5rem;">🥧</div>
                <div class="mt-2 font-bold text-lg text-green-700">Khám Phá Thế Giới Phân Số</div>
            </a>
        </div>
        <!-- Chủ đề 3: Bí Ẩn Hình Học -->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <a href="/games/lop4/bi-an-hinh-hoc" class="game-topic-card d-block p-4 text-center shadow rounded-xl h-100" style="background: #f3e6ff; text-decoration: none;">
                <div style="font-size: 2.5rem;">📐</div>
                <div class="mt-2 font-bold text-lg text-purple-700">Bí Ẩn Hình Học</div>
            </a>
        </div>
        <!-- Chủ đề 4: Thử Thách Đo Lường -->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <a href="/games/lop4/thu-thach-do-luong" class="game-topic-card d-block p-4 text-center shadow rounded-xl h-100" style="background: #fff7e6; text-decoration: none;">
                <div style="font-size: 2.5rem;">📏⚖️⏳</div>
                <div class="mt-2 font-bold text-lg text-orange-700">Thử Thách Đo Lường</div>
            </a>
        </div>
        <!-- Chủ đề 5: Giải Toán Có Lời Văn Siêu Đẳng -->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <a href="/games/lop4/giai-toan-loi-van" class="game-topic-card d-block p-4 text-center shadow rounded-xl h-100" style="background: #e6ffe6; text-decoration: none;">
                <div style="font-size: 2.5rem;">💡</div>
                <div class="mt-2 font-bold text-lg text-success">Giải Toán Có Lời Văn Siêu Đẳng</div>
            </a>
        </div>
        <!-- Chủ đề 6: Yếu tố Thống kê: Biểu đồ và Số liệu -->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <a href="/games/lop4/thong-ke-bieu-do" class="game-topic-card d-block p-4 text-center shadow rounded-xl h-100" style="background: #fffbe6; text-decoration: none;">
                <div style="font-size: 2.5rem;">📊</div>
                <div class="mt-2 font-bold text-lg text-warning">Yếu tố Thống kê: Biểu đồ và Số liệu</div>
            </a>
        </div>
        <!-- Chủ đề 7: Dãy số có quy luật (Tìm quy luật) -->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <a href="/games/lop4/day-so-quy-luat" class="game-topic-card d-block p-4 text-center shadow rounded-xl h-100" style="background: #fff0f6; text-decoration: none;">
                <div style="font-size: 2.5rem;">🧠</div>
                <div class="mt-2 font-bold text-lg text-pink-700">Dãy số có quy luật (Tìm quy luật)</div>
            </a>
        </div>
    </div>
</div>
<style>
    .game-topic-card {
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .game-topic-card:hover {
        box-shadow: 0 6px 24px rgba(0,0,0,0.13);
        transform: translateY(-6px) scale(1.03);
    }
</style>
@endsection 