@extends('layouts.game')

@section('title', 'Khám Phá Phân Số - Lớp 4')

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-purple-600">Khám Phá Phân Số - Lớp 4 🍕🔢</h1>
        <p class="text-lg mt-2">Học về phân số qua các trò chơi thú vị!</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 max-w-4xl mx-auto">
        <a href="{{ route('games.lop4.kham-pha-phan-so.apple') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🍏</div>
            <h3 class="text-xl font-bold text-purple-600 mb-2">Chia Táo</h3>
            <p class="text-gray-600">Chia táo thành các phần bằng nhau</p>
        </a>
        <a href="{{ route('games.lop4.kham-pha-phan-so.balance') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">⚖️</div>
            <h3 class="text-xl font-bold text-purple-600 mb-2">Cân Bằng</h3>
            <p class="text-gray-600">So sánh hai vế phân số</p>
        </a>
        <a href="{{ route('games.lop4.kham-pha-phan-so.bracket') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🧩</div>
            <h3 class="text-xl font-bold text-purple-600 mb-2">Điền Dấu Ngoặc</h3>
            <p class="text-gray-600">Điền dấu ngoặc đúng vào biểu thức phân số</p>
        </a>
        <a href="{{ route('games.lop4.kham-pha-phan-so.cake') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🍰</div>
            <h3 class="text-xl font-bold text-purple-600 mb-2">Chia Bánh</h3>
            <p class="text-gray-600">Chia bánh thành các phần bằng nhau</p>
        </a>
        <a href="{{ route('games.lop4.kham-pha-phan-so.cards') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🃏</div>
            <h3 class="text-xl font-bold text-purple-600 mb-2">Thẻ Bài Phân Số</h3>
            <p class="text-gray-600">Ghép thẻ bài phân số đúng</p>
        </a>
        <a href="{{ route('games.lop4.kham-pha-phan-so.compare') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🔍</div>
            <h3 class="text-xl font-bold text-purple-600 mb-2">So Sánh Phân Số</h3>
            <p class="text-gray-600">So sánh các phân số</p>
        </a>
        <a href="{{ route('games.lop4.kham-pha-phan-so.division') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">➗</div>
            <h3 class="text-xl font-bold text-purple-600 mb-2">Chia Phân Số</h3>
            <p class="text-gray-600">Thực hiện phép chia phân số</p>
        </a>
        <a href="{{ route('games.lop4.kham-pha-phan-so.equal_groups') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">👥</div>
            <h3 class="text-xl font-bold text-purple-600 mb-2">Nhóm Phân Số Bằng Nhau</h3>
            <p class="text-gray-600">Phân loại các phân số bằng nhau</p>
        </a>
        <a href="{{ route('games.lop4.kham-pha-phan-so.fair_share') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🎯</div>
            <h3 class="text-xl font-bold text-purple-600 mb-2">Chia Đều</h3>
            <p class="text-gray-600">Chia đều các phần cho mọi người</p>
        </a>
        <a href="{{ route('games.lop4.kham-pha-phan-so.garden') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🌱</div>
            <h3 class="text-xl font-bold text-purple-600 mb-2">Vườn Phân Số</h3>
            <p class="text-gray-600">Trồng cây với phân số</p>
        </a>
        <a href="{{ route('games.lop4.kham-pha-phan-so.lost_city') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🏙️</div>
            <h3 class="text-xl font-bold text-purple-600 mb-2">Thành Phố Mất Tích</h3>
            <p class="text-gray-600">Khám phá thành phố với phân số</p>
        </a>
        <a href="{{ route('games.lop4.kham-pha-phan-so.pattern') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🔢</div>
            <h3 class="text-xl font-bold text-purple-600 mb-2">Dãy Quy Luật</h3>
            <p class="text-gray-600">Tìm quy luật phân số</p>
        </a>
        <a href="{{ route('games.lop4.kham-pha-phan-so.phanso') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🔣</div>
            <h3 class="text-xl font-bold text-purple-600 mb-2">Phân Số</h3>
            <p class="text-gray-600">Các bài tập phân số tổng hợp</p>
        </a>
        <a href="{{ route('games.lop4.kham-pha-phan-so.remaining_cake') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🍩</div>
            <h3 class="text-xl font-bold text-purple-600 mb-2">Miếng Bánh Còn Lại</h3>
            <p class="text-gray-600">Tìm phần bánh còn lại</p>
        </a>
        <a href="{{ route('games.lop4.kham-pha-phan-so.sentence') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">✍️</div>
            <h3 class="text-xl font-bold text-purple-600 mb-2">Ghép Câu Phân Số</h3>
            <p class="text-gray-600">Ghép câu đúng với phân số</p>
        </a>
        <a href="{{ route('games.lop4.kham-pha-phan-so.sky') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">☁️</div>
            <h3 class="text-xl font-bold text-purple-600 mb-2">Bầu Trời Phân Số</h3>
            <p class="text-gray-600">Khám phá bầu trời với phân số</p>
        </a>
        <a href="{{ route('games.lop4.kham-pha-phan-so.tower') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🏰</div>
            <h3 class="text-xl font-bold text-purple-600 mb-2">Tháp Phân Số</h3>
            <p class="text-gray-600">Xây tháp với phân số</p>
        </a>
        <a href="{{ route('games.lop4.kham-pha-phan-so.word_hunt') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🔎</div>
            <h3 class="text-xl font-bold text-purple-600 mb-2">Săn Từ Phân Số</h3>
            <p class="text-gray-600">Tìm từ liên quan đến phân số</p>
        </a>
        <a href="{{ route('games.lop4.kham-pha-phan-so.word_problem') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">📖</div>
            <h3 class="text-xl font-bold text-purple-600 mb-2">Bài Toán Lời Văn</h3>
            <p class="text-gray-600">Giải toán có lời văn với phân số</p>
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