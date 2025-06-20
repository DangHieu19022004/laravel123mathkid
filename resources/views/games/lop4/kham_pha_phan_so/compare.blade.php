@extends('layouts.game')

@section('content')
    <div class="flex flex-col items-center min-h-screen bg-gradient-to-br from-green-100 via-cyan-50 to-blue-100">
        <div class="w-full max-w-2xl p-6 bg-white rounded-3xl shadow-xl mt-8 py-16 animate-fade-in">

            <!-- Header -->
            <div class="text-center mb-6 z-10">
                <h1 class="text-4xl font-extrabold text-green-700 tracking-tight mb-3">
                    Khu Vườn Phân Số 🌿
                </h1>
                <div id="level-card" class="inline-block bg-white/80 backdrop-blur-sm rounded-full py-2 px-5 shadow-lg">
                    <h2 class="text-xl font-semibold text-green-800">
                        Cấp độ <span id="level-display" class="font-bold text-orange-500">1</span>/5
                    </h2>
                </div>
            </div>

            <!-- Game Board -->
            <div class="w-full">
                <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-4 rounded-lg mb-6 shadow-sm">
                    <h3 class="font-bold mb-2">🎯 Hướng dẫn chơi:</h3>
                    <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                        <li>Bé hãy so sánh hai phân số ở hai bên.</li>
                        <li>Chọn một trong ba dấu (lớn hơn, bé hơn, hoặc bằng) ở giữa.</li>
                        <li>Nếu cần, bé có thể nhẩm quy đồng mẫu số để tìm ra đáp án đúng nhé!</li>
                    </ul>
                </div>

                <!-- Comparison Arena -->
                <div class="flex justify-between items-center w-full">

                    <!-- Left Fraction Card -->
                    <div class="flex-1">
                        <div id="left-card" class="bg-yellow-50 border-4 border-yellow-300 rounded-2xl shadow-lg p-4 sm:p-8 flex flex-col items-center justify-center transition-all duration-300 w-40 h-52 sm:w-48 sm:h-60 mx-auto" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23a7f3d0\' fill-opacity=\'0.2\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                            <span class="text-5xl sm:text-6xl font-bold text-orange-600" id="left-numerator"></span>
                            <div class="w-16 sm:w-20 h-1.5 bg-yellow-500 rounded-full my-2"></div>
                            <span class="text-5xl sm:text-6xl font-bold text-orange-600" id="left-denominator"></span>
                        </div>
                    </div>

                    <!-- Operator Controls -->
                    <div class="px-4 sm:px-8 h-48 flex flex-col justify-center items-center">
                        <div id="operator-buttons" class="flex flex-col gap-y-3">
                            <button class="w-14 h-14 sm:w-16 sm:h-16 bg-white border-2 border-gray-300 rounded-full flex items-center justify-center text-3xl font-bold text-gray-600 transition-all duration-200 hover:bg-green-500 hover:text-white hover:border-green-500 hover:scale-110 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none" data-symbol="<">&lt;</button>
                            <button class="w-14 h-14 sm:w-16 sm:h-16 bg-white border-2 border-gray-300 rounded-full flex items-center justify-center text-3xl font-bold text-gray-600 transition-all duration-200 hover:bg-green-500 hover:text-white hover:border-green-500 hover:scale-110 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none" data-symbol="=">=</button>
                            <button class="w-14 h-14 sm:w-16 sm:h-16 bg-white border-2 border-gray-300 rounded-full flex items-center justify-center text-3xl font-bold text-gray-600 transition-all duration-200 hover:bg-green-500 hover:text-white hover:border-green-500 hover:scale-110 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none" data-symbol=">">&gt;</button>
                        </div>
                        <div id="message" class="hidden text-center"></div>
                    </div>

                    <!-- Right Fraction Card -->
                    <div class="flex-1">
                        <div id="right-card" class="bg-yellow-50 border-4 border-yellow-300 rounded-2xl shadow-lg p-4 sm:p-8 flex flex-col items-center justify-center transition-all duration-300 w-40 h-52 sm:w-48 sm:h-60 mx-auto" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23a7f3d0\' fill-opacity=\'0.2\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                            <span class="text-5xl sm:text-6xl font-bold text-orange-600" id="right-numerator"></span>
                            <div class="w-16 sm:w-20 h-1.5 bg-yellow-500 rounded-full my-2"></div>
                            <span class="text-5xl sm:text-6xl font-bold text-orange-600" id="right-denominator"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <div class="text-center mt-4">
                <button id="resetButton" class="bg-white/80 text-gray-700 font-semibold py-2 px-6 rounded-full shadow-md hover:bg-white transition-colors">
                    Chơi lại từ đầu
                </button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card-correct {
            @apply transform scale-105 border-green-400 ring-4 ring-green-200;
            animation: wiggle 0.6s;
        }

        .card-incorrect {
            @apply transform scale-95 border-red-400 ring-4 ring-red-200;
            animation: shake 0.6s;
        }

        @keyframes wiggle {
            0% {
                transform: rotate(-3deg) scale(1.05);
            }
            25% {
                transform: rotate(3deg) scale(1.05);
            }
            50% {
                transform: rotate(-3deg) scale(1.05);
            }
            75% {
                transform: rotate(3deg) scale(1.05);
            }
            100% {
                transform: rotate(0) scale(1.05);
            }
        }

        @keyframes shake {
            0%, 100% {
                transform: translateX(0) scale(0.95);
            }
            20%, 60% {
                transform: translateX(-8px) scale(0.95);
            }
            40%, 80% {
                transform: translateX(8px) scale(0.95);
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const questions = @json($questions);

            const levelCard = document.getElementById('level-card');
            const levelDisplay = document.getElementById('level-display');

            const leftCard = document.getElementById('left-card');
            const leftNumerator = document.getElementById('left-numerator');
            const leftDenominator = document.getElementById('left-denominator');

            const rightCard = document.getElementById('right-card');
            const rightNumerator = document.getElementById('right-numerator');
            const rightDenominator = document.getElementById('right-denominator');

            const operatorButtonsContainer = document.getElementById('operator-buttons');
            const buttons = operatorButtonsContainer.querySelectorAll('[data-symbol]');
            const messageDiv = document.getElementById('message');
            const resetButton = document.getElementById('resetButton');

            let currentLevel = 1;
            let isAnswered = false;

            const MESSAGE_BASE_CLASSES = 'text-2xl font-bold p-4 rounded-lg';
            const SUCCESS_CLASSES = `${MESSAGE_BASE_CLASSES} text-green-600`;
            const DANGER_CLASSES = `${MESSAGE_BASE_CLASSES} text-red-600`;
            const COMPLETE_CLASSES = `text-xl sm:text-2xl font-bold p-4 rounded-lg bg-yellow-100 text-yellow-800`;

            function clearCardStyles() {
                leftCard.classList.remove('card-correct', 'card-incorrect');
                rightCard.classList.remove('card-correct', 'card-incorrect');
            }

            function loadQuestion(level) {
                clearCardStyles();
                levelCard.classList.remove('hidden');
                operatorButtonsContainer.classList.remove('hidden');
                messageDiv.classList.add('hidden');
                resetButton.classList.add('hidden');

                if (!questions[level]) {
                    operatorButtonsContainer.classList.add('hidden');
                    messageDiv.className = COMPLETE_CLASSES;
                    messageDiv.innerHTML = 'Chúc mừng bé đã hoàn thành tất cả các cấp độ! 🏆';
                    buttons.forEach(btn => btn.disabled = true);
                    levelCard.classList.add('hidden');
                    resetButton.classList.remove('hidden');
                    isAnswered = true;
                    return;
                }

                const question = questions[level];
                levelDisplay.textContent = level;

                leftNumerator.textContent = question.left.numerator;
                leftDenominator.textContent = question.left.denominator;

                rightNumerator.textContent = question.right.numerator;
                rightDenominator.textContent = question.right.denominator;

                isAnswered = false;
                buttons.forEach(btn => btn.disabled = false);
            }

            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    if (isAnswered) return;

                    const selectedSymbol = this.dataset.symbol;
                    isAnswered = true;
                    buttons.forEach(btn => btn.disabled = true);

                    const correctSymbol = questions[currentLevel].correct_symbol;

                    operatorButtonsContainer.classList.add('hidden');
                    messageDiv.classList.remove('hidden');

                    if (selectedSymbol === correctSymbol) {
                        messageDiv.className = SUCCESS_CLASSES;
                        messageDiv.innerHTML = 'Đúng rồi! 🎉';
                        leftCard.classList.add('card-correct');
                        rightCard.classList.add('card-correct');


                        if (typeof confetti !== 'undefined') {
                            confetti({particleCount: 150, spread: 90, origin: {y: 0.6}});
                        }

                        currentLevel++;
                        setTimeout(() => {
                            loadQuestion(currentLevel);
                        }, 2000);
                    } else {
                        messageDiv.className = DANGER_CLASSES;
                        messageDiv.innerHTML = 'Chưa đúng. Thử lại nhé! 🤔';
                        leftCard.classList.add('card-incorrect');
                        rightCard.classList.add('card-incorrect');

                        setTimeout(() => {
                            isAnswered = false;
                            buttons.forEach(btn => btn.disabled = false);
                            operatorButtonsContainer.classList.remove('hidden');
                            messageDiv.classList.add('hidden');
                            clearCardStyles();
                        }, 2000);
                    }
                });
            });

            resetButton.addEventListener('click', function () {
                currentLevel = 1;
                loadQuestion(currentLevel);
            });

            loadQuestion(currentLevel);
        });
    </script>
@endpush
