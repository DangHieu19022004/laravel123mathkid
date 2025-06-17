@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-4 z-10">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="hidden">{{ $configGames['title'] }}</h1>
            <div class="flex items-center justify-center gap-3 text-white text-xl md:text-2xl font-semibold">
                <span class="drop-shadow-lg text-3xl md:text-4xl font-extrabold animate-bounce-slow mb-4">🎮 Chọn Chủ Đề Game Toán Lớp 4</span>
            </div>
        </div>

        <!-- Games Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 mb-12">
            @foreach($configGames['group-game'] as $index => $game)
                <a href="{{ route($game['route']) }}" style="animation-delay: {{ $index * 0.1 }}s;"
                   class="game-card card-3d !bg-white rounded-3xl p-6 md:p-8 text-center shadow-2xl cursor-pointer animate-slide-up glass-effect">
                    <div class="text-6xl md:text-7xl mb-6 animate-float drop-shadow-lg" style="animation-delay: -{{ $index + 1 }}s;">{{ $game['icon'] }}</div>
                    <h2 class="text-xl md:text-2xl font-bold text-primary mb-4">{{ $game['title'] }}</h2>
                    <p class="text-gray-600 leading-relaxed">{{ $game['description'] }}</p>
                </a>
            @endforeach
        </div>
    </div>
@endsection
