@extends('layouts.game')

@push('styles')
    <style>
        body {
            background: linear-gradient(45deg, #ff9a9e 0%, #fecfef 50%, #fecfef 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Enhanced Animations */
        @keyframes bounce {
            0%, 20%, 53%, 80%, 100% {
                transform: translate3d(0, 0, 0);
            }
            40%, 43% {
                transform: translate3d(0, -30px, 0);
            }
            70% {
                transform: translate3d(0, -15px, 0);
            }
            90% {
                transform: translate3d(0, -4px, 0);
            }
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

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            33% {
                transform: translateY(-20px) rotate(5deg);
            }
            66% {
                transform: translateY(-10px) rotate(-5deg);
            }
        }

        @keyframes sparkle {
            0%, 100% {
                opacity: 0;
                transform: scale(0) rotate(0deg);
            }
            50% {
                opacity: 1;
                transform: scale(1) rotate(180deg);
            }
        }

        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.4);
            }
            50% {
                box-shadow: 0 0 30px rgba(59, 130, 246, 0.8), 0 0 40px rgba(139, 92, 246, 0.6);
            }
        }

        @keyframes slide-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scale-in {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-bounce {
            animation: bounce 1s infinite;
        }

        .animate-wiggle {
            animation: wiggle 1s ease-in-out;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .animate-slide-in-up {
            animation: slide-in-up 0.6s ease-out;
        }

        .animate-scale-in {
            animation: scale-in 0.5s ease-out;
        }

        /* Enhanced Components */
        .cartoon-card {
            background: linear-gradient(135deg, #fff 0%, #f0f9ff 100%);
            border-radius: 25px;
            border: 4px solid #3b82f6;
            box-shadow: 0 10px 0 #1e40af,
            0 20px 40px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            animation: slide-in-up 0.8s ease-out;
        }

        .cartoon-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        .option-bubble {
            background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
            border: 3px solid #e2e8f0;
            border-radius: 20px;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
            overflow: hidden;
            cursor: pointer;
            animation: scale-in 0.6s ease-out;
        }

        .option-bubble:nth-child(1) {
            animation-delay: 0.1s;
        }

        .option-bubble:nth-child(2) {
            animation-delay: 0.2s;
        }

        .option-bubble:nth-child(3) {
            animation-delay: 0.3s;
        }

        .option-bubble:nth-child(4) {
            animation-delay: 0.4s;
        }

        .option-bubble::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
            transition: left 0.6s;
        }

        .option-bubble:hover::before {
            left: 100%;
        }

        .option-bubble:hover {
            transform: translateY(-8px) scale(1.05);
            border-color: #3b82f6;
            box-shadow: 0 8px 0 #1e40af,
            0 15px 30px rgba(59, 130, 246, 0.3);
        }

        .option-bubble.correct {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            border-color: #22c55e;
            box-shadow: 0 8px 0 #15803d,
            0 15px 30px rgba(34, 197, 94, 0.3);
            animation: bounce 0.6s ease-in-out;
        }

        .option-bubble.incorrect {
            background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
            border-color: #ef4444;
            box-shadow: 0 8px 0 #dc2626,
            0 15px 30px rgba(239, 68, 68, 0.3);
            animation: wiggle 0.6s ease-in-out;
        }

        .option-bubble.correct .option-label {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: white;
            box-shadow: 0 4px 0 #15803d;
        }

        .option-bubble.incorrect .option-label {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 4px 0 #b91c1c;
        }

        /* Enhanced Progress Bar */
        .progress-container {
            background: #e2e8f0;
            border-radius: 15px;
            border: 3px solid #3b82f6;
            box-shadow: inset 0 4px 0 #1e40af;
            overflow: hidden;
            animation: scale-in 0.8s ease-out;
        }

        .progress-bar {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899);
            border-radius: 12px;
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .progress-bar::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: sparkle 2s ease-in-out infinite;
        }

        /* Enhanced Buttons */
        .fun-button {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            border: 3px solid #1e40af;
            border-radius: 20px;
            box-shadow: 0 6px 0 #1e40af,
            0 12px 24px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            animation: scale-in 0.7s ease-out;
        }

        .fun-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s;
        }

        .fun-button:hover::before {
            left: 100%;
        }

        .fun-button:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 0 #1e40af,
            0 16px 32px rgba(0, 0, 0, 0.15);
        }

        .fun-button:active {
            transform: translateY(-2px);
            box-shadow: 0 4px 0 #1e40af,
            0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .next-button {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-color: #047857;
            box-shadow: 0 6px 0 #047857,
            0 12px 24px rgba(16, 185, 129, 0.2);
        }

        .next-button:hover {
            box-shadow: 0 8px 0 #047857,
            0 16px 32px rgba(16, 185, 129, 0.3);
        }

        .reset-button {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border-color: #b45309;
            box-shadow: 0 6px 0 #b45309,
            0 12px 24px rgba(245, 158, 11, 0.2);
        }

        .reset-button:hover {
            box-shadow: 0 8px 0 #b45309,
            0 16px 32px rgba(245, 158, 11, 0.3);
        }

        /* Floating Elements */
        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .floating-element {
            position: absolute;
            font-size: 2rem;
            animation: float 4s ease-in-out infinite;
        }

        .element-1 {
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .element-2 {
            top: 20%;
            right: 10%;
            animation-delay: 1s;
        }

        .element-3 {
            bottom: 30%;
            left: 15%;
            animation-delay: 2s;
        }

        .element-4 {
            bottom: 20%;
            right: 5%;
            animation-delay: 3s;
        }

        /* Level Badge Enhancement */
        .level-badge {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            border: 3px solid #1e40af;
            box-shadow: 0 6px 0 #1e40af,
            0 12px 24px rgba(59, 130, 246, 0.3);
            animation: pulse-glow 2s ease-in-out infinite;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .cartoon-card {
                border-radius: 20px;
                margin: 0.5rem;
            }

            .option-bubble {
                border-radius: 15px;
            }

            .floating-element {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 640px) {
            .cartoon-card {
                border-radius: 16px;
                margin: 0.25rem;
                padding: 0.75rem;
            }

            .option-bubble {
                border-radius: 12px;
                padding: 0.5rem;
            }

            .floating-element {
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .cartoon-card {
                border-radius: 14px;
                margin: 0.25rem;
                padding: 0.5rem;
                border-width: 2px;
            }

            .option-bubble {
                border-radius: 10px;
                padding: 0.375rem;
                border-width: 2px;
            }

            .floating-elements {
                display: none;
            }
        }
    </style>
@endpush

@section('game_content')
    <div class="min-h-screen p-4 relative overflow-hidden">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-6">
                <div class="cartoon-card p-6 mb-4">
                    <h1 class="text-4xl md:text-5xl font-bold text-blue-600 mb-3">
                        🧮 Giải Toán Lời Văn
                    </h1>
                    <p class="text-lg text-gray-700 max-w-3xl mx-auto font-medium">
                        Rèn luyện kỹ năng giải toán qua các bài toán thực tế thú vị! 🎯
                    </p>
                </div>
            </div>

            <!-- Main Game Container -->
            <div class="cartoon-card p-6">
                <!-- Level and Progress Section -->
                <div class="flex items-center justify-between mb-6 p-4 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl border-2 border-blue-300 animate-slide-in-up">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <div class="level-badge w-16 h-16 rounded-full flex items-center justify-center text-xl font-bold text-white">
                                <span id="current-level">1</span>
                            </div>
                        </div>
                        <div>
                            <div class="text-lg font-bold text-gray-800">Cấp độ</div>
                            <div class="text-sm text-gray-600" id="level-label">1/5</div>
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="text-lg font-bold text-gray-800 mb-2">Tiến độ</div>
                        <div class="progress-container w-64 h-4">
                            <div id="progress-bar" class="progress-bar h-full" style="width: 0%"></div>
                        </div>
                        <div class="text-sm text-gray-600 mt-1" id="progress-text">0%</div>
                    </div>
                </div>

                <!-- Question Section -->
                <div class="mb-6 animate-slide-in-up">
                    <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl p-6 border-2 border-yellow-300 shadow-lg">
                        <div class="flex items-start space-x-4">
                            <div class="bg-gradient-to-br from-yellow-400 to-orange-500 text-white rounded-lg w-12 h-12 flex items-center justify-center text-xl font-bold shadow-lg border-2 border-yellow-600 flex-shrink-0 animate-pulse">
                                🤔
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                                    <span class="mr-2">📝</span>
                                    Câu hỏi
                                </h3>
                                <p id="question-text" class="text-base text-gray-700 leading-relaxed font-medium"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Options Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <button class="option-bubble p-4 text-left focus:outline-none" data-index="0">
                        <div class="flex items-center space-x-4">
                            <span class="option-label bg-gradient-to-br from-blue-100 to-blue-200 text-blue-700 rounded-lg w-10 h-10 flex items-center justify-center font-bold text-base shadow-md border-2 border-blue-300">A</span>
                            <span class="option-content text-gray-700 font-medium text-base"></span>
                        </div>
                    </button>
                    <button class="option-bubble p-4 text-left focus:outline-none" data-index="1">
                        <div class="flex items-center space-x-4">
                            <span class="option-label bg-gradient-to-br from-green-100 to-green-200 text-green-700 rounded-lg w-10 h-10 flex items-center justify-center font-bold text-base shadow-md border-2 border-green-300">B</span>
                            <span class="option-content text-gray-700 font-medium text-base"></span>
                        </div>
                    </button>
                    <button class="option-bubble p-4 text-left focus:outline-none" data-index="2">
                        <div class="flex items-center space-x-4">
                            <span class="option-label bg-gradient-to-br from-purple-100 to-purple-200 text-purple-700 rounded-lg w-10 h-10 flex items-center justify-center font-bold text-base shadow-md border-2 border-purple-300">C</span>
                            <span class="option-content text-gray-700 font-medium text-base"></span>
                        </div>
                    </button>
                    <button class="option-bubble p-4 text-left focus:outline-none" data-index="3">
                        <div class="flex items-center space-x-4">
                            <span class="option-label bg-gradient-to-br from-red-100 to-red-200 text-red-700 rounded-lg w-10 h-10 flex items-center justify-center font-bold text-base shadow-md border-2 border-red-300">D</span>
                            <span class="option-content text-gray-700 font-medium text-base"></span>
                        </div>
                    </button>
                </div>

                <!-- Explanation Section -->
                <div id="explanation" class="hidden mb-6 animate-slide-in-up">
                    <div class="bg-gradient-to-br from-pink-50 to-purple-50 border-l-4 border-pink-400 rounded-xl p-4 shadow-lg">
                        <div class="flex items-start space-x-4">
                            <div class="bg-gradient-to-br from-pink-400 to-purple-500 text-white rounded-lg w-10 h-10 flex items-center justify-center text-base font-bold shadow-md flex-shrink-0 animate-wiggle">
                                💡
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-pink-800 mb-2 text-base">Giải thích</h4>
                                <p class="text-pink-700 leading-relaxed text-sm"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button id="next-btn" class="hidden flex-1 fun-button next-button text-white font-bold py-3 px-6 text-base focus:outline-none">
                        <span class="flex items-center justify-center space-x-3">
                            <span class="text-xl">➡️</span>
                            <span>Tiếp theo</span>
                        </span>
                    </button>
                    <button id="reset-btn" class="flex-1 fun-button reset-button text-white font-bold py-3 px-6 text-base focus:outline-none">
                        <span class="flex items-center justify-center space-x-3">
                            <span class="text-xl">🔄</span>
                            <span>Chơi lại</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const allQuestions = @json($allQuestions);

        class WordProblemGame {
            constructor() {
                this.currentLevel = 1;
                this.maxLevel = 5;
                this.isAnswered = false;
                this.currentQuestion = null;
                this.init();
            }

            init() {
                this.cacheDom();
                this.bindEvents();
                this.loadQuestion();
            }

            cacheDom() {
                this.levelEl = document.getElementById('current-level');
                this.levelLabel = document.getElementById('level-label');
                this.progressBar = document.getElementById('progress-bar');
                this.progressText = document.getElementById('progress-text');
                this.questionText = document.getElementById('question-text');
                this.optionBtns = document.querySelectorAll('.option-bubble');
                this.explanation = document.getElementById('explanation');
                this.nextBtn = document.getElementById('next-btn');
                this.resetBtn = document.getElementById('reset-btn');
            }

            bindEvents() {
                this.optionBtns.forEach(btn => btn.onclick = (e) => this.handleAnswer(e));
                this.nextBtn.onclick = () => this.nextQuestion();
                this.resetBtn.onclick = () => this.resetGame();
            }

            loadQuestion() {
                const questions = allQuestions[this.currentLevel];
                const idx = Math.floor(Math.random() * questions.length);
                this.currentQuestion = questions[idx];
                this.renderQuestion();
                this.isAnswered = false;
                this.nextBtn.classList.add('hidden');
                this.explanation.classList.add('hidden');
                this.resetOptionStyles();
            }

            resetOptionStyles() {
                this.optionBtns.forEach((btn, i) => {
                    btn.disabled = false;
                    btn.className = 'option-bubble p-4 text-left focus:outline-none';
                    const label = btn.querySelector('.option-label');
                    const colors = ['blue', 'green', 'purple', 'red'];
                    label.className = `option-label bg-gradient-to-br from-${colors[i]}-100 to-${colors[i]}-200 text-${colors[i]}-700 rounded-lg w-10 h-10 flex items-center justify-center font-bold text-base shadow-md border-2 border-${colors[i]}-300`;
                });
            }

            renderQuestion() {
                this.levelEl.textContent = this.currentLevel;
                this.levelLabel.textContent = `${this.currentLevel}/${this.maxLevel}`;

                const progressPercent = (this.currentLevel - 1) / (this.maxLevel - 1) * 100;
                this.progressBar.style.width = `${progressPercent}%`;
                this.progressText.textContent = `${Math.round(progressPercent)}%`;

                this.questionText.textContent = this.currentQuestion.question;

                this.optionBtns.forEach((btn, i) => {
                    btn.querySelector('.option-content').textContent = this.currentQuestion.options[i] || '';
                });

                this.explanation.querySelector('p').textContent = this.currentQuestion.explanation;
            }

            handleAnswer(e) {
                if (this.isAnswered) return;

                const btn = e.currentTarget;
                const idx = +btn.dataset.index;
                const answer = this.currentQuestion.options[idx];
                this.isAnswered = true;

                // Disable all options
                this.optionBtns.forEach(b => b.disabled = true);

                // Mark correct answer
                this.optionBtns.forEach((b, i) => {
                    if (this.currentQuestion.options[i] === this.currentQuestion.answer) {
                        b.classList.add('correct');
                    }
                });

                // Check if answer is correct
                if (answer === this.currentQuestion.answer) {
                    btn.classList.add('correct');
                    this.showSuccessNotification();
                } else {
                    btn.classList.add('incorrect');
                    this.showErrorNotification();
                }

                this.showExplanation();

                if (this.currentLevel < this.maxLevel) {
                    this.nextBtn.classList.remove('hidden');
                } else {
                    this.nextBtn.querySelector('span span').textContent = 'Kết thúc';
                    this.nextBtn.classList.remove('hidden');
                }
            }

            showSuccessNotification() {
                Swal.fire({
                    icon: 'success',
                    title: '🎉 Chính xác!',
                    text: 'Bạn đã trả lời đúng! Thật tuyệt vời! 🌟',
                    showConfirmButton: false,
                    timer: 2000,
                    background: '#f0fdf4',
                    color: '#166534',
                    customClass: {
                        popup: 'animate-bounce-in'
                    }
                });
            }

            showErrorNotification() {
                Swal.fire({
                    icon: 'error',
                    title: '😅 Sai rồi!',
                    text: 'Không sao đâu! Hãy xem giải thích để hiểu rõ hơn nhé! 💡',
                    showConfirmButton: false,
                    timer: 2500,
                    background: '#fef2f2',
                    color: '#991b1b',
                    customClass: {
                        popup: 'animate-wiggle'
                    }
                });
            }

            showExplanation() {
                this.explanation.classList.remove('hidden');
                this.explanation.classList.add('animate-slide-in-up');
            }

            nextQuestion() {
                if (this.currentLevel < this.maxLevel) {
                    this.currentLevel++;
                    this.loadQuestion();
                } else {
                    this.showCompletionAlert();
                }
            }

            showCompletionAlert() {
                Swal.fire({
                    icon: 'success',
                    title: '🎉 Chúc mừng!',
                    text: 'Bạn đã hoàn thành tất cả các cấp độ! Thật tuyệt vời! 🌟',
                    confirmButtonText: '🔄 Chơi lại',
                    showCancelButton: true,
                    cancelButtonText: '❌ Đóng',
                    background: '#f0fdf4',
                    color: '#166534',
                    customClass: {
                        popup: 'animate-bounce-in'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.resetGame();
                    }
                });
            }

            resetGame() {
                Swal.fire({
                    title: '🤔 Xác nhận',
                    text: 'Bạn có chắc muốn chơi lại? Tất cả tiến độ sẽ bị mất.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: '✅ Có, chơi lại',
                    cancelButtonText: '❌ Không',
                    background: '#fef7ff',
                    color: '#581c87',
                    customClass: {
                        popup: 'animate-bounce-in'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.currentLevel = 1;
                        this.loadQuestion();
                        this.nextBtn.querySelector('span span').textContent = 'Tiếp theo';

                        Swal.fire({
                            icon: 'success',
                            title: '🎉 Đã reset!',
                            text: 'Trò chơi đã được khởi tạo lại. Chúc bạn may mắn! 🍀',
                            timer: 2000,
                            showConfirmButton: false,
                            background: '#f0fdf4',
                            color: '#166534',
                            customClass: {
                                popup: 'animate-bounce-in'
                            }
                        });
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', () => new WordProblemGame());
    </script>
@endpush
