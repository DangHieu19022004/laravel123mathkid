@extends('layouts.game')

@section('game_content')
    <div class="container mx-auto px-4 py-8 relative z-10">
        <!-- Header Section -->
        <div class="text-center mb-12 animate-slide-up">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 pt-4">
                {{ $title }}
            </h1>
            <div class="flex justify-center items-center mb-4">
                <div class="text-3xl animate-bounce-slow">🎓</div>
                <p class="text-xl md:text-2xl text-white ml-3 font-nunito">
                    {{ $description }}
                </p>
                <div class="text-3xl animate-bounce-slow ml-3" style="animation-delay: 0.5s;">📚</div>
            </div>
            <div class="w-24 h-1 bg-gradient-to-r from-purple-500 to-pink-500 mx-auto rounded-full animate-pulse"></div>
        </div>

        <!-- Games Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach($listInfoGame as $gameInfo)
                <div class="animate-slide-up" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                    <a href="{{ route($gameInfo['route']) }}"
                       class="game-card group block bg-gradient-to-br from-white to-purple-50 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:scale-105 hover:-translate-y-2 border-2 border-transparent hover:border-purple-300 overflow-hidden h-full flex flex-col">

                        <!-- Card Header with Icon -->
                        <div class="p-6 text-center relative flex-shrink-0">
                            <div class="text-6xl mb-4 group-hover:animate-wiggle transition-all duration-300 transform group-hover:scale-110">
                                {{ $gameInfo['icon'] }}
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="px-6 pb-6 flex-1 flex flex-col">
                            <h3 class="text-xl font-bold text-purple-700 mb-3 group-hover:text-purple-800 transition-colors duration-300 font-nunito flex-shrink-0">
                                {{ $gameInfo['title'] }}
                            </h3>
                            <p class="text-gray-600 group-hover:text-gray-700 transition-colors duration-300 leading-relaxed flex-1 min-h-[4.5rem]">
                                {{ $gameInfo['description'] }}
                            </p>
                        </div>

                        <!-- Play Button -->
                        <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                            <div class="bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-full p-2 shadow-lg">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Bottom Decoration -->
        <div class="text-center mt-12 animate-slide-up" style="animation-delay: 0.8s;">
            <div class="flex justify-center items-center space-x-4 mb-4">
                <div class="text-2xl animate-bounce-slow">🎨</div>
                <div class="text-2xl animate-bounce-slow" style="animation-delay: 0.3s;">🎲</div>
                <div class="text-2xl animate-bounce-slow" style="animation-delay: 0.6s;">🎪</div>
                <div class="text-2xl animate-bounce-slow" style="animation-delay: 0.9s;">🎯</div>
            </div>
            <p class="text-gray-500 font-nunito">Hãy chọn một trò chơi để bắt đầu khám phá!</p>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .game-card {
            position: relative;
            backdrop-filter: blur(10px);
        }

        .game-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }

        .game-card:hover::before {
            transform: translateX(100%);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #8b5cf6, #ec4899);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #7c3aed, #db2777);
        }

        /* Animations */
        @keyframes cardLoad {
            0% {
                opacity: 0;
                transform: translateY(20px) scale(0.9);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .animate-slide-up {
            animation: cardLoad 0.6s ease-out forwards;
        }

        @keyframes gentlePulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .animate-pulse {
            animation: gentlePulse 2s ease-in-out infinite;
        }

        @keyframes bounce-slow {
            0%, 20%, 53%, 80%, 100% {
                transform: translate3d(0, 0, 0);
            }
            40%, 43% {
                transform: translate3d(0, -8px, 0);
            }
            70% {
                transform: translate3d(0, -4px, 0);
            }
            90% {
                transform: translate3d(0, -2px, 0);
            }
        }

        .animate-bounce-slow {
            animation: bounce-slow 2s ease-in-out infinite;
        }

        @keyframes wiggle {
            0%, 7% {
                transform: rotateZ(0);
            }
            15% {
                transform: rotateZ(-15deg);
            }
            20% {
                transform: rotateZ(10deg);
            }
            25% {
                transform: rotateZ(-10deg);
            }
            30% {
                transform: rotateZ(6deg);
            }
            35% {
                transform: rotateZ(-4deg);
            }
            40%, 100% {
                transform: rotateZ(0);
            }
        }

        .animate-wiggle {
            animation: wiggle 0.6s ease-in-out;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const gameCards = document.querySelectorAll('.game-card');

            gameCards.forEach(card => {
                card.addEventListener('click', function () {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });
        });
    </script>
@endpush
