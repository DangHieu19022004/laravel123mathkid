@extends('layouts.game')

@section('title', 'Giải Toán Lời Văn - Lớp 4')

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600">Giải Toán Lời Văn - Lớp 4 📝✏️</h1>
        <p class="text-lg mt-2">Luyện tập giải các bài toán có lời văn!</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 max-w-4xl mx-auto">
        <!-- Game 1: Lost City -->
        <a href="{{ route('games.lop4.giai_toan_loi_van.lost_city') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">🏰</div>
            <h3 class="text-xl font-bold text-blue-600 mb-2">Thành Phố Bí Ẩn</h3>
            <p class="text-gray-600">Giải các bài toán để khám phá thành phố bí ẩn</p>
        </a>
        <!-- Game 2: Word Problem -->
        <a href="{{ route('games.lop4.giai_toan_loi_van.word_problem') }}" class="game-card bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-4xl mb-4">📚</div>
            <h3 class="text-xl font-bold text-blue-600 mb-2">Bài Toán Lời Văn</h3>
            <p class="text-gray-600">Giải các bài toán có lời văn với nhiều cấp độ</p>
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effect to cards
    const cards = document.querySelectorAll('.game-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.transition = 'transform 0.3s ease';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>

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