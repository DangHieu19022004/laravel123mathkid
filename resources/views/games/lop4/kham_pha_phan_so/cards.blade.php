@extends('layouts.game')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 py-6 px-4">
        <!-- Game Container -->
        <div class="max-w-4xl mx-auto bg-white/90 backdrop-blur-sm rounded-2xl p-6 shadow-2xl game-container transition-opacity duration-500">
            <!-- Header Section -->
            <div class="flex flex-col items-center mb-6">
                <!-- Game Title -->
                <div class="mb-4">
                    <h1 class="text-3xl mt-4 font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                        🎮 Thẻ Bài Phân Số
                    </h1>
                </div>

                <!-- Level & Stats Bar -->
                <div class="w-full max-w-md bg-gradient-to-r from-indigo-100 to-purple-100 rounded-xl p-4 shadow-lg">
                    <!-- Level Display -->
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-indigo-700 font-medium">Cấp độ</span>
                        <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                            <span id="current-level">1</span>/5
                        </span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden mb-4">
                        <div id="progress-bar" class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-500" style="width: 20%"></div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                            <div class="text-purple-600 font-bold text-xl" id="flips">0</div>
                            <div class="text-gray-600 text-sm">Số lần lật</div>
                        </div>
                        <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                            <div class="text-indigo-600 font-bold text-xl">
                                <span id="pairs">0</span>/<span id="total-pairs">2</span>
                            </div>
                            <div class="text-gray-600 text-sm">Cặp đã tìm</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="mb-4 bg-gradient-to-r from-pink-100 to-rose-100 rounded-lg p-4 shadow">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 bg-pink-500 text-white p-1.5 rounded">
                        <span class="text-lg">💡</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-base font-semibold text-pink-800 mb-2">Cách chơi</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center space-x-2 bg-white/80 p-1.5 rounded">
                                <span class="text-pink-500">👆</span>
                                <p class="text-gray-700 m-0">Lật thẻ tìm cặp phân số bằng nhau</p>
                            </div>
                            <div class="flex items-center space-x-2 bg-white/80 p-1.5 rounded">
                                <span class="text-pink-500">🎯</span>
                                <p class="text-gray-700 m-0">Hoàn thành với ít lần lật nhất</p>
                            </div>
                            <div class="flex items-center space-x-2 bg-white/80 p-1.5 rounded">
                                <span class="text-pink-500">⭐</span>
                                <p class="text-gray-700 m-0">Vượt qua 5 cấp độ để chiến thắng</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cards Container -->
            <div class="mb-4">
                <div id="cards-grid" class="flex flex-wrap justify-center gap-2">
                    <!-- Cards will be dynamically inserted here -->
                </div>
            </div>

            <!-- Controls -->
            <div class="flex justify-center">
                <button id="resetButton" class="group relative overflow-hidden bg-gradient-to-r from-indigo-500 to-purple-500 text-white px-8 py-3 rounded-xl font-medium shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5">
                    <span class="relative z-10 flex items-center">
                        <span class="mr-2 text-xl">↺</span>
                        Chơi lại
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                </button>
            </div>
        </div>

        <!-- Floating Message -->
        <div id="message" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 min-w-[300px] max-w-[90%] transition-all duration-500 opacity-0 hidden message-transition"></div>
    </div>
@endsection

@push('styles')
    <style>
        .transform-style-3d {
            transform-style: preserve-3d;
        }

        .backface-hidden {
            backface-visibility: hidden;
        }

        .rotate-y-180 {
            transform: rotateY(180deg);
        }

        /* Card styles */
        #cards-grid > div {
            width: 100px;
            height: 150px;
        }

        @media (min-width: 640px) {
            #cards-grid > div {
                width: 120px;
                height: 180px;
            }
        }

        .message-transition {
            transition: opacity 0.5s ease-in-out;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Constants
        const QUESTIONS = @json($questions, JSON_THROW_ON_ERROR);
        const ANIMATION_DURATION = {
            FLIP: 500,
            UNFLIP: 1000,
            LEVEL_TRANSITION: 500,
            MESSAGE: 3000,
            CONFETTI: 1500,
            MATCH_CELEBRATION: 1000,
            LEVEL_COMPLETE: 2000,
            FINAL_PAIR_DELAY: 1000
        };
        const MAX_LEVEL = 5;

        // Game state
        let currentLevel = 1;
        let currentQuestion = QUESTIONS[currentLevel];
        let hasFlippedCard = false;
        let lockBoard = false;
        let processingMatch = false;
        let firstCard = null;
        let secondCard = null;
        let flips = 0;
        let pairs = 0;
        let matchedPairs = [];
        let messageTimeout = null;
        let isLevelTransitioning = false;

        // DOM Elements
        const elements = {
            progressBar: document.getElementById('progress-bar'),
            currentLevel: document.getElementById('current-level'),
            totalPairs: document.getElementById('total-pairs'),
            flips: document.getElementById('flips'),
            pairs: document.getElementById('pairs'),
            cardsGrid: document.getElementById('cards-grid'),
            message: document.getElementById('message'),
            resetButton: document.getElementById('resetButton')
        };

        function updateProgressBar() {
            if (!elements.progressBar) return;
            const progress = ((currentLevel - 1) * 100) / MAX_LEVEL;
            elements.progressBar.style.width = `${progress}%`;
        }

        function updateGameStats() {
            if (!elements.currentLevel || !elements.totalPairs || !elements.flips || !elements.pairs) return;
            elements.currentLevel.textContent = currentLevel;
            elements.totalPairs.textContent = currentQuestion.pairs.length;
            elements.flips.textContent = flips;
            elements.pairs.textContent = pairs;
        }

        function createCardElement(card) {
            const cardElement = document.createElement('div');
            cardElement.className = 'relative w-full aspect-[2/3] transform-style-3d transition-all duration-500 cursor-pointer hover:scale-102';
            cardElement.dataset.id = card.id;
            cardElement.dataset.pairId = card.pairId;

            cardElement.innerHTML = `
                <div class="absolute w-full h-full transform-style-3d">
                    <div class="absolute w-full h-full flex items-center justify-center text-xl sm:text-2xl rounded-xl shadow-lg bg-gradient-to-br from-blue-500 to-blue-600 text-white backface-hidden">
                        <span class="text-2xl sm:text-3xl">❓</span>
                    </div>
                    <div class="absolute w-full h-full flex items-center justify-center text-xl sm:text-2xl rounded-xl shadow-lg bg-white border-2 border-blue-400 text-blue-600 transform rotate-y-180 backface-hidden">
                        ${card.numerator}/${card.denominator}
                    </div>
                </div>
            `;

            cardElement.addEventListener('click', flipCard);
            return cardElement;
        }

        function shuffleCards(cards) {
            return [...cards].sort(() => Math.random() - 0.5);
        }

        function initGame() {
            try {
                if (!currentQuestion || !currentQuestion.cards) {
                    throw new Error('Invalid question data');
                }

                updateProgressBar();
                updateGameStats();

                if (elements.cardsGrid) {
                    elements.cardsGrid.innerHTML = '';
                    const shuffledCards = shuffleCards(currentQuestion.cards);
                    shuffledCards.forEach(card => {
                        elements.cardsGrid.appendChild(createCardElement(card));
                    });
                }

                resetGame();
            } catch (error) {
                console.error('Error initializing game:', error);
                showMessage('error', `
                    <div class="bg-red-100 border-2 border-red-400 text-red-700 p-4 rounded-xl shadow-lg">
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl sm:text-3xl">⚠️</span>
                            <div>
                                <h4 class="font-bold mb-1">Lỗi khởi tạo game</h4>
                                <p class="mb-0 text-sm sm:text-base">Vui lòng tải lại trang và thử lại.</p>
                            </div>
                        </div>
                    </div>
                `);
            }
        }

        function flipCard() {
            if (lockBoard || processingMatch) return;
            if (this === firstCard) return;

            this.style.transform = 'rotateY(180deg)';
            flips++;
            updateGameStats();

            if (!hasFlippedCard) {
                hasFlippedCard = true;
                firstCard = this;
                return;
            }

            secondCard = this;
            lockBoard = true;
            checkForMatch();
        }

        function checkForMatch() {
            if (!firstCard || !secondCard) {
                lockBoard = false;
                return;
            }

            processingMatch = true;
            const isMatch = firstCard.dataset.pairId === secondCard.dataset.pairId;

            if (isMatch) {
                handleMatch();
            } else {
                handleMismatch();
            }
        }

        function playCelebrationAnimation(card1, card2) {
            const isFinalPair = pairs >= currentQuestion.pairs.length;

            [card1, card2].forEach(card => {
                card.classList.add(
                    'ring-4',
                    'ring-green-400',
                    'ring-opacity-50',
                    'animate-pulse',
                    'shadow-lg',
                    'shadow-green-200'
                );

                // Add special effect for final pair
                if (isFinalPair) {
                    card.classList.add(
                        'ring-yellow-400',
                        'ring-opacity-75',
                        'animate-bounce'
                    );
                }

                if (typeof confetti === 'function') {
                    const rect = card.getBoundingClientRect();
                    const x = (rect.left + rect.width / 2) / window.innerWidth;
                    const y = (rect.top + rect.height / 2) / window.innerHeight;

                    confetti({
                        particleCount: isFinalPair ? 50 : 30,
                        spread: isFinalPair ? 30 : 20,
                        origin: {x, y},
                        colors: isFinalPair ? ['#FFD700', '#FFA500', '#4ade80', '#22c55e'] : ['#4ade80', '#22c55e', '#16a34a'],
                        ticks: isFinalPair ? 80 : 50
                    });
                }
            });
        }

        function handleMatch() {
            firstCard.removeEventListener('click', flipCard);
            secondCard.removeEventListener('click', flipCard);

            pairs++;
            updateGameStats();

            const matchedFirst = firstCard;
            const matchedSecond = secondCard;

            matchedPairs.push([
                parseInt(matchedFirst.dataset.id),
                parseInt(matchedSecond.dataset.id)
            ]);

            resetBoard();

            setTimeout(() => {
                playCelebrationAnimation(matchedFirst, matchedSecond);

                [matchedFirst, matchedSecond].forEach(card => {
                    const frontIcon = card.querySelector('.backface-hidden span');
                    if (frontIcon && frontIcon.textContent === '❓') {
                        frontIcon.textContent = '✅';
                    }
                });
            }, ANIMATION_DURATION.UNFLIP);

            // Check if this is the final pair
            const isFinalPair = pairs >= currentQuestion.pairs.length;

            // Use longer delay for final pair to let player see the completion
            const celebrationDuration = isFinalPair ?
                ANIMATION_DURATION.MATCH_CELEBRATION + ANIMATION_DURATION.FINAL_PAIR_DELAY :
                ANIMATION_DURATION.MATCH_CELEBRATION;

            // Show small notification for final pair
            if (isFinalPair) {
                setTimeout(() => {
                    showMessage('success', `
                        <div class="bg-yellow-100 border-2 border-yellow-400 text-yellow-700 p-3 rounded-lg shadow-lg">
                            <div class="flex items-center space-x-2">
                                <span class="text-xl">🎉</span>
                                <span class="font-medium">Hoàn thành cấp độ ${currentLevel}!</span>
                            </div>
                        </div>
                    `);
                }, ANIMATION_DURATION.MATCH_CELEBRATION);
            }

            setTimeout(() => {
                if (isFinalPair && !isLevelTransitioning) {
                    handleLevelComplete();
                } else {
                    lockBoard = false;
                    processingMatch = false;
                }
            }, celebrationDuration);
        }

        function handleMismatch() {
            setTimeout(() => {
                if (firstCard) firstCard.style.transform = 'rotateY(0deg)';
                if (secondCard) secondCard.style.transform = 'rotateY(0deg)';

                setTimeout(() => {
                    resetBoard();
                    lockBoard = false;
                    processingMatch = false;
                }, 300);
            }, ANIMATION_DURATION.UNFLIP);
        }

        function handleLevelComplete() {
            if (isLevelTransitioning) return;
            isLevelTransitioning = true;
            lockBoard = true;
            processingMatch = true;

            if (currentLevel < MAX_LEVEL) {
                showMessage('success', `
                    <div class="bg-green-100 border-2 border-green-400 text-green-700 p-4 sm:p-6 rounded-xl shadow-lg transform hover:scale-102 transition-transform duration-300">
                        <div class="flex items-center space-x-3">
                            <span class="text-3xl sm:text-4xl">🏆</span>
                            <div>
                                <h4 class="font-bold text-base sm:text-lg mb-2">Chúc mừng!</h4>
                                <p class="mb-2 text-sm sm:text-base">Bạn đã hoàn thành xuất sắc cấp độ ${currentLevel}!</p>
                                <div class="flex items-center justify-center mt-3">
                                    <div class="animate-pulse bg-green-500 text-white px-4 py-2 rounded-lg">
                                        Đang chuyển sang cấp độ ${currentLevel + 1}...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `);

                if (typeof confetti === 'function') {
                    confetti({
                        particleCount: 100,
                        spread: 70,
                        origin: {y: 0.6}
                    });
                }

                setTimeout(() => {
                    // Reset cards before transitioning to next level
                    document.querySelectorAll('[data-pair-id]').forEach(card => {
                        card.removeEventListener('click', flipCard);
                        card.style.transform = 'rotateY(0deg)';
                        card.classList.remove(
                            'ring-4',
                            'ring-green-400',
                            'ring-yellow-400',
                            'ring-opacity-50',
                            'ring-opacity-75',
                            'transition-opacity',
                            'duration-500',
                            'animate-pulse',
                            'animate-bounce',
                            'shadow-lg',
                            'shadow-green-200'
                        );
                        // Reset icon to ❓
                        const frontIcon = card.querySelector('.backface-hidden span');
                        if (frontIcon) frontIcon.textContent = '❓';
                        card.addEventListener('click', flipCard);
                    });

                    fadeOutGameContainer(() => {
                        currentLevel++;
                        currentQuestion = QUESTIONS[currentLevel];
                        isLevelTransitioning = false;
                        initGame();
                        fadeInGameContainer();
                    });
                }, ANIMATION_DURATION.LEVEL_COMPLETE);

            } else {
                showMessage('success', `
                    <div class="bg-gradient-to-r from-yellow-100 to-yellow-200 border-2 border-yellow-400 text-yellow-700 p-4 sm:p-6 rounded-xl shadow-lg transform hover:scale-102 transition-transform duration-300">
                        <div class="flex items-center space-x-3">
                            <span class="text-3xl sm:text-4xl">👑</span>
                            <div>
                                <h4 class="font-bold text-base sm:text-lg mb-2">Xuất sắc!</h4>
                                <p class="mb-2 text-sm sm:text-base">Bạn đã chinh phục thành công tất cả các cấp độ!</p>
                                <div class="flex flex-col items-center gap-2 mt-3">
                                    <div class="text-lg font-bold text-yellow-600">Điểm số của bạn:</div>
                                    <div class="text-2xl font-bold text-yellow-700">${calculateScore()}/100</div>
                                    <button onclick="initGame()" class="mt-2 bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg transition-colors duration-200">
                                        Chơi lại từ đầu
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `);

                if (typeof confetti === 'function') {
                    const duration = 3000;
                    const end = Date.now() + duration;

                    const frame = () => {
                        confetti({
                            particleCount: 2,
                            angle: 60,
                            spread: 55,
                            origin: {x: 0},
                            colors: ['#FFD700', '#FFA500']
                        });
                        confetti({
                            particleCount: 2,
                            angle: 120,
                            spread: 55,
                            origin: {x: 1},
                            colors: ['#FFD700', '#FFA500']
                        });

                        if (Date.now() < end) {
                            requestAnimationFrame(frame);
                        }
                    };
                    frame();
                }
            }
        }

        function calculateScore() {
            const baseScore = 100;
            const flipPenalty = Math.min(flips * 2, 30);
            return Math.max(baseScore - flipPenalty, 60);
        }

        function fadeOutGameContainer(callback) {
            const container = document.querySelector('.game-container');
            if (!container) return;

            container.style.opacity = '0';

            setTimeout(() => {
                if (callback) callback();
            }, ANIMATION_DURATION.LEVEL_TRANSITION);
        }

        function fadeInGameContainer() {
            const container = document.querySelector('.game-container');
            if (!container) return;

            setTimeout(() => {
                container.style.opacity = '1';
            }, 100);
        }

        function showMessage(type, html) {
            if (!elements.message) return;

            if (messageTimeout) {
                clearTimeout(messageTimeout);
                messageTimeout = null;
            }

            if (!elements.message.classList.contains('hidden')) {
                elements.message.classList.add('opacity-0');
                setTimeout(() => {
                    showNewMessage();
                }, 300);
            } else {
                showNewMessage();
            }

            function showNewMessage() {
                elements.message.classList.remove('hidden');
                elements.message.innerHTML = html;

                elements.message.offsetHeight;
                elements.message.classList.remove('opacity-0');

                if (!html.includes('Bấm "Câu tiếp theo"') && !html.includes('chinh phục thành công')) {
                    messageTimeout = setTimeout(() => {
                        elements.message.classList.add('opacity-0');
                        setTimeout(() => {
                            elements.message.classList.add('hidden');
                            messageTimeout = null;
                        }, 300);
                    }, ANIMATION_DURATION.MESSAGE);
                }
            }
        }

        function resetBoard() {
            [hasFlippedCard, firstCard, secondCard] = [false, null, null];
            lockBoard = false;
            processingMatch = false;
        }

        function resetGame() {
            lockBoard = false;
            processingMatch = false;
            isLevelTransitioning = false;
            pairs = 0;
            flips = 0;
            updateGameStats();
            matchedPairs = [];

            document.querySelectorAll('[data-pair-id]').forEach(card => {
                card.style.transform = 'rotateY(0deg)';
                card.classList.remove(
                    'ring-4',
                    'ring-green-400',
                    'ring-yellow-400',
                    'ring-opacity-50',
                    'ring-opacity-75',
                    'transition-opacity',
                    'duration-500',
                    'animate-pulse',
                    'animate-bounce',
                    'shadow-lg',
                    'shadow-green-200'
                );
                // Reset icon to ❓
                const frontIcon = card.querySelector('.backface-hidden span');
                if (frontIcon) frontIcon.textContent = '❓';
                card.addEventListener('click', flipCard);
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            try {
                initGame();
                elements.resetButton?.addEventListener('click', initGame);
            } catch (error) {
                console.error('Error setting up game:', error);
            }
        });
    </script>
@endpush
