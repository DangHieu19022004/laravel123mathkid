@extends('layouts.game')

@section('title', 'Dãy Số Quy Luật - Lớp 4')

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-green-600">Dãy Số Quy Luật - Lớp 4 🔢✨</h1>
        <p class="text-lg mt-2">Khám phá các quy luật thú vị trong dãy số!</p>
    </div>
    <div class="max-w-2xl mx-auto">
        <!-- Game: Nhận biết quy luật -->
        <a href="{{ route('games.lop4.day_so_quy_luat.pattern') }}" class="game-card bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow block">
            <div class="text-5xl mb-6 text-center">🎯</div>
            <h3 class="text-2xl font-bold text-green-600 mb-4 text-center">Nhận Biết Quy Luật</h3>
            <p class="text-gray-600 text-center text-lg">Luyện tập nhận biết và tìm quy luật trong dãy số</p>
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
</style>
@endsection 