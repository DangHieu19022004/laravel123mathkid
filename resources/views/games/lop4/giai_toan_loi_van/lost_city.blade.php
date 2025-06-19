@extends('layouts.game')

@push('styles')
    <style>
        /* Keyframe animations */
        @keyframes fade-in {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            10%, 30%, 50%, 70%, 90% {
                transform: translateX(-5px);
            }
            20%, 40%, 60%, 80% {
                transform: translateX(5px);
            }
        }

        /* Animation classes */
        .animate-fade-in {
            animation: fade-in 0.8s ease-out;
        }

        .animate-slide-up {
            animation: slide-up 0.8s ease-out;
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .shake {
            animation: shake 0.5s ease-in-out;
        }

        /* Animation delays */
        .animation-delay-100 {
            animation-delay: 0.1s;
        }

        .animation-delay-200 {
            animation-delay: 0.2s;
        }

        .animation-delay-300 {
            animation-delay: 0.3s;
        }

        .animation-delay-400 {
            animation-delay: 0.4s;
        }

        .animation-delay-500 {
            animation-delay: 0.5s;
        }

        .animation-delay-600 {
            animation-delay: 0.6s;
        }

        .animation-delay-700 {
            animation-delay: 0.7s;
        }

        .animation-delay-800 {
            animation-delay: 0.8s;
        }

        .animation-delay-900 {
            animation-delay: 0.9s;
        }

        .animation-delay-1000 {
            animation-delay: 1s;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
@endpush

@section('game_content')
    <div class="h-fit bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-6 relative overflow-hidden">
        <!-- Background decorative elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute top-40 left-40 w-80 h-80 bg-indigo-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Header with enhanced styling -->
            <div class="text-center mb-6 animate-fade-in">
                <div class="flex items-center justify-center space-x-3 mb-4">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 via-purple-500 to-indigo-600 rounded-full shadow-2xl transform hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent animate-slide-up pt-4">
                        Thành Phố Bí Ẩn
                    </h1>
                </div>
                <p class="text-base sm:text-lg text-gray-700 max-w-2xl mx-auto leading-relaxed animate-slide-up animation-delay-200">
                    Điền số thích hợp vào chỗ trống để hoàn thiện các tên đường và khám phá thành phố bí ẩn!
                </p>
            </div>

            <!-- Enhanced Level Display -->
            <div class="flex justify-center mb-6 animate-fade-in animation-delay-300">
                <div class="bg-white/80 backdrop-blur-sm rounded-xl px-4 sm:px-6 py-3 shadow-xl border border-white/20">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center space-x-2">
                            <div class="w-6 h-6 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Cấp độ:</span>
                        </div>
                        <span class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent" id="current-level">1</span>
                        <span class="text-gray-400 text-lg">/</span>
                        <span class="text-lg sm:text-xl text-gray-600 font-medium">5</span>
                    </div>
                </div>
            </div>

            <!-- Enhanced Progress Bar -->
            <div class="max-w-md mx-auto mb-6 animate-fade-in animation-delay-400">
                <div class="bg-gray-200/50 backdrop-blur-sm rounded-full h-2.5 overflow-hidden shadow-inner border border-gray-300/30">
                    <div id="progress-bar" class="bg-gradient-to-r from-blue-500 via-purple-500 to-indigo-600 h-full transition-all duration-700 ease-out rounded-full shadow-lg" style="width: 0%"></div>
                </div>
            </div>

            <!-- Enhanced Game Container -->
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-2xl border border-white/30 overflow-hidden animate-fade-in animation-delay-500">
                <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 px-4 sm:px-6 py-4">
                    <h2 class="text-lg sm:text-xl font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m-6 3l6-3"></path>
                        </svg>
                        Bản đồ thành phố
                    </h2>
                </div>

                <div class="p-4 sm:p-6">
                    <div id="city-map" class="space-y-4">
                        <!-- Câu hỏi sẽ được render bằng JavaScript -->
                    </div>

                    <!-- Enhanced Action Buttons -->
                    <div class="flex flex-col sm:flex-row justify-center items-center space-y-3 sm:space-y-0 sm:space-x-4 mt-6">
                        <button id="check-answer" class="w-full sm:w-auto bg-gradient-to-r from-blue-500 via-purple-500 to-indigo-600 hover:from-blue-600 hover:via-purple-600 hover:to-indigo-700 text-white font-bold py-3 px-6 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-200 flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-105">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-base">Kiểm tra đáp án</span>
                        </button>

                        <button id="next-level" class="w-full sm:w-auto bg-gradient-to-r from-green-500 via-emerald-500 to-teal-600 hover:from-green-600 hover:via-emerald-600 hover:to-teal-700 text-white font-bold py-3 px-6 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-200 flex items-center justify-center space-x-2 hidden transform hover:scale-105">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            <span class="text-base">Tiếp theo</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Enhanced Navigation Buttons -->
            <div class="flex flex-col sm:flex-row justify-center items-center space-y-3 sm:space-y-0 sm:space-x-4 mt-6">
                <button id="reset-btn" class="w-full sm:w-auto bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-700 font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center space-x-2 transform hover:scale-105">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span class="text-base">Chơi lại từ đầu</span>
                </button>

                <button id="reset-questions-btn" class="w-full sm:w-auto bg-gradient-to-r from-orange-100 to-red-200 hover:from-orange-200 hover:to-red-300 text-orange-700 font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center space-x-2 transform hover:scale-105">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span class="text-base">Đổi câu hỏi mới</span>
                </button>

                <a href="{{ route('game.lop4.word_problem_solving.overview') }}" class="w-full sm:w-auto bg-gradient-to-r from-blue-100 to-indigo-200 hover:from-blue-200 hover:to-indigo-300 text-blue-700 font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center space-x-2 transform hover:scale-105">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="text-base">Quay lại danh sách</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Game configuration
            const GAME_CONFIG = {
                totalLevels: 5,
                scorePerLevel: 10,
                localStorageKey: 'lostCityGameState'
            };

            // Game state
            let gameState = {
                currentLevel: 1,
                questions: @json($questions, JSON_THROW_ON_ERROR),
                completedLevels: [],
                score: 0
            };

            // DOM elements
            const elements = {
                currentLevel: document.getElementById('current-level'),
                progressBar: document.getElementById('progress-bar'),
                cityMap: document.getElementById('city-map'),
                checkAnswer: document.getElementById('check-answer'),
                nextLevel: document.getElementById('next-level'),
                resetBtn: document.getElementById('reset-btn'),
                resetQuestionsBtn: document.getElementById('reset-questions-btn')
            };

            // Initialize game
            function initGame() {
                loadGameState();
                updateDisplay();
                renderQuestion();
                bindEvents();
            }

            // Load game state from localStorage
            function loadGameState() {
                const savedState = localStorage.getItem(GAME_CONFIG.localStorageKey);
                if (savedState) {
                    try {
                        const parsed = JSON.parse(savedState);
                        gameState = {...gameState, ...parsed};
                    } catch (e) {
                        console.warn('Failed to parse saved game state:', e);
                    }
                }
            }

            // Save game state to localStorage
            function saveGameState() {
                try {
                    localStorage.setItem(GAME_CONFIG.localStorageKey, JSON.stringify(gameState));
                } catch (e) {
                    console.warn('Failed to save game state:', e);
                }
            }

            // Update display elements
            function updateDisplay() {
                elements.currentLevel.textContent = gameState.currentLevel;
                elements.progressBar.style.width = `${(gameState.currentLevel - 1) * 20}%`;
            }

            // Render current question
            function renderQuestion() {
                const question = gameState.questions[gameState.currentLevel];
                if (!question) return;

                elements.cityMap.innerHTML = `
                    <div class="bg-gradient-to-r from-gray-50/80 to-blue-50/80 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 hover:shadow-lg hover:scale-[1.01] transition-all duration-300 transform hover:border-blue-300/50 animate-slide-up animation-delay-100">
                        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between mb-4 space-y-3 lg:space-y-0">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 via-purple-500 to-indigo-600 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
                                    <span class="text-white font-bold text-base">${gameState.currentLevel}</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800">${question.name}</h3>
                            </div>
                            <button type="button" class="hint-btn bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center justify-center space-x-2 w-full lg:w-auto shadow-lg hover:shadow-xl transform hover:scale-105" data-hint="${question.hint}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                                <span class="font-semibold text-sm">Gợi ý</span>
                            </button>
                        </div>
                        <p class="text-gray-700 mb-4 leading-relaxed text-sm sm:text-base">${question.description}</p>
                        <div class="flex items-center space-x-3">
                            <div class="flex-1">
                                <input type="text" class="street-input w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-3 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 text-base font-medium placeholder-gray-400 bg-white/80 backdrop-blur-sm shadow-inner" placeholder="Nhập đáp án..." autocomplete="off" aria-label="Đáp án cho ${question.name}">
                            </div>
                        </div>
                    </div>
                `;

                bindQuestionEvents();
            }

            // Bind events for question elements
            function bindQuestionEvents() {
                const hintBtn = document.querySelector('.hint-btn');
                const input = document.querySelector('.street-input');

                if (hintBtn) {
                    hintBtn.addEventListener('click', showHint);
                }

                if (input) {
                    input.addEventListener('input', handleInputChange);
                    input.addEventListener('keypress', handleKeyPress);
                }
            }

            // Show hint
            function showHint() {
                const hint = this.dataset.hint;
                showAlert('💡 Gợi ý', hint, 'info');
            }

            // Handle input change
            function handleInputChange() {
                const hasValue = this.value.trim() !== '';
                this.classList.toggle('border-green-300', hasValue);
                this.classList.toggle('border-red-500', !hasValue);
            }

            // Handle key press
            function handleKeyPress(e) {
                if (e.key === 'Enter') {
                    checkAnswer();
                }
            }

            // Check answer
            function checkAnswer() {
                const input = document.querySelector('.street-input');
                const answer = input.value.trim();
                const currentQuestion = gameState.questions[gameState.currentLevel];

                if (!validateInput(answer, input)) return;

                const isCorrect = validateAnswer(answer, currentQuestion.answer);

                if (isCorrect) {
                    handleCorrectAnswer(input);
                } else {
                    handleIncorrectAnswer(input);
                }
            }

            // Validate input
            function validateInput(answer, input) {
                if (!answer) {
                    showInputError(input, '⚠️ Chưa hoàn thành', 'Vui lòng nhập đáp án!');
                    return false;
                }

                if (!/^\d+(\.\d+)?$/.test(answer)) {
                    showInputError(input, '⚠️ Định dạng không đúng', 'Vui lòng nhập một số hợp lệ!');
                    return false;
                }

                return true;
            }

            // Show input error
            function showInputError(input, title, message) {
                input.classList.add('border-red-500', 'shake');
                setTimeout(() => input.classList.remove('shake'), 500);
                showAlert(title, message, 'warning');
            }

            // Validate answer
            function validateAnswer(userAnswer, correctAnswer) {
                const userAnswerNumeric = parseFloat(userAnswer);
                const correctAnswerNumeric = parseFloat(correctAnswer);
                return !isNaN(userAnswerNumeric) && Math.abs(userAnswerNumeric - correctAnswerNumeric) < 0.01;
            }

            // Handle correct answer
            function handleCorrectAnswer(input) {
                resetInput(input);
                updateScore();

                if (gameState.currentLevel < GAME_CONFIG.totalLevels) {
                    nextLevel();
                } else {
                    showGameComplete();
                }
            }

            // Handle incorrect answer
            function handleIncorrectAnswer(input) {
                input.classList.remove('border-green-300');
                input.classList.add('border-red-500', 'shake');
                setTimeout(() => input.classList.remove('shake'), 500);
                input.focus();
                input.select();
                showAlert('⛔️ Chưa đúng!', 'Hãy thử lại!', 'error');
            }

            // Reset input
            function resetInput(input) {
                input.value = '';
                input.classList.remove('border-red-500', 'border-green-300');
                input.classList.add('border-gray-300');
            }

            // Update score
            function updateScore() {
                if (!gameState.completedLevels.includes(gameState.currentLevel)) {
                    gameState.completedLevels.push(gameState.currentLevel);
                    gameState.score += GAME_CONFIG.scorePerLevel;
                }
            }

            // Next level
            function nextLevel() {
                showAlert('🎉 Chính xác!', 'Bạn đã trả lời đúng!', 'success').then(() => {
                    gameState.currentLevel++;
                    saveGameState();
                    updateDisplay();
                    renderQuestion();
                });
            }

            // Show game complete
            function showGameComplete() {
                showAlert('🏆 Hoàn thành!', `Bạn đã hoàn thành tất cả cấp độ với ${gameState.score} điểm!`, 'success').then(() => {
                    resetGame();
                });
            }

            // Reset game (keep questions)
            function resetGame() {
                gameState.currentLevel = 1;
                gameState.completedLevels = [];
                gameState.score = 0;
                saveGameState();
                updateDisplay();
                renderQuestion();
            }

            // Reset questions
            function resetQuestions() {
                const questionKeys = Object.keys(gameState.questions);
                const shuffledKeys = questionKeys.sort(() => Math.random() - 0.5).slice(0, 5);

                const newQuestions = {};
                shuffledKeys.forEach((key, index) => {
                    newQuestions[index + 1] = gameState.questions[key];
                });

                gameState.questions = newQuestions;
                gameState.currentLevel = 1;
                gameState.completedLevels = [];
                gameState.score = 0;
                saveGameState();
                updateDisplay();
                renderQuestion();
            }

            // Show alert (with SweetAlert2 fallback)
            function showAlert(title, text, type = 'info') {
                if (typeof Swal !== 'undefined') {
                    const config = {
                        title,
                        text,
                        confirmButtonText: 'Đã hiểu',
                        confirmButtonColor: getButtonColor(type)
                    };

                    if (type === 'confirm') {
                        config.showCancelButton = true;
                        config.cancelButtonText = 'Không, giữ nguyên';
                        config.cancelButtonColor = '#6B7280';
                    }

                    return Swal.fire(config);
                } else {
                    alert(`${title}\n${text}`);
                    return Promise.resolve();
                }
            }

            // Get button color based on type
            function getButtonColor(type) {
                const colors = {
                    success: '#10B981',
                    error: '#EF4444',
                    warning: '#F59E0B',
                    info: '#3B82F6'
                };
                return colors[type] || colors.info;
            }

            // Bind all events
            function bindEvents() {
                elements.checkAnswer.addEventListener('click', checkAnswer);
                elements.nextLevel.addEventListener('click', () => {
                    if (gameState.currentLevel < GAME_CONFIG.totalLevels) {
                        gameState.currentLevel++;
                        saveGameState();
                        updateDisplay();
                        renderQuestion();
                    }
                });

                elements.resetBtn.addEventListener('click', () => {
                    showAlert('🔄 Chơi lại từ đầu?', 'Bạn có chắc muốn bắt đầu lại từ cấp độ 1?', 'confirm').then((result) => {
                        if (result.isConfirmed) {
                            resetGame();
                        }
                    });
                });

                elements.resetQuestionsBtn.addEventListener('click', () => {
                    showAlert('🔄 Đổi câu hỏi mới?', 'Bạn có chắc muốn đổi câu hỏi mới và chơi lại từ đầu?', 'confirm').then((result) => {
                        if (result.isConfirmed) {
                            resetQuestions();
                            showAlert('✅ Đã đổi câu hỏi!', 'Câu hỏi mới đã được tạo. Chúc bạn may mắn!', 'success');
                        }
                    });
                });
            }

            // Initialize the game
            initGame();
        });
    </script>
@endpush
