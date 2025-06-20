@extends('layouts.game')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 via-pink-100 to-yellow-100 py-8">
        <div class="w-full max-w-2xl mx-auto">
            <!-- Card Game -->
            <div class="rounded-3xl shadow-2xl bg-white/80 border-4 border-blue-200 px-6 py-8 relative">
                <!-- Tiêu đề & Hướng dẫn -->
                <div class="flex flex-col items-center mb-6">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-500 via-pink-500 to-yellow-400 drop-shadow animate-glow flex items-center gap-2">
                        <span>Biểu Thức Ngoặc</span> <span class="text-3xl">🎯</span>
                    </h1>
                    <!-- Hướng dẫn toggle -->
                    <button id="toggle-guide" class="mt-4 px-4 py-2 rounded-full bg-gradient-to-r from-yellow-300 to-pink-300 text-blue-900 font-bold shadow hover:from-yellow-400 hover:to-pink-400 transition flex items-center gap-2">
                        <span id="guide-arrow">▼</span> Hướng dẫn chơi
                    </button>
                    <div id="guide-content" class="mt-3 w-full bg-gradient-to-br from-blue-50 via-pink-50 to-yellow-50 border border-blue-200 rounded-xl p-4 text-base text-gray-700 shadow-lg animate-fadein">
                        <ul class="list-disc pl-5 space-y-1">
                            <li><b>Luật chơi:</b> Chọn đáp án đúng cho giá trị của biểu thức có ngoặc.</li>
                            <li><b>Cách tính:</b> <span class="text-blue-700">Tính trong ngoặc trước</span>, sau đó
                                <span class="text-pink-700">nhân/chia</span>, cuối cùng
                                <span class="text-yellow-700">cộng/trừ</span>.
                            </li>
                            <li><b>Mẹo:</b> Đọc kỹ biểu thức, xác định thứ tự thực hiện phép tính, chú ý dấu ngoặc!</li>
                            <li>Mỗi cấp độ chỉ có <b>1 đáp án đúng</b>. Chọn đúng để lên cấp tiếp theo!</li>
                        </ul>
                    </div>
                </div>
                <!-- Cấp độ & Biểu thức -->
                <div class="flex flex-col items-center mb-8">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-lg font-bold text-purple-500">Cấp độ</span>
                        <span id="level-label" class="text-2xl font-extrabold bg-gradient-to-r from-blue-400 via-pink-400 to-yellow-400 bg-clip-text text-transparent drop-shadow-lg"></span>
                        <span class="text-lg">/5 ⭐</span>
                    </div>
                    <div class="w-full flex justify-center">
                        <div class="px-6 py-4 rounded-2xl shadow-lg bg-gradient-to-r from-yellow-100 to-pink-100 border-2 border-yellow-300 text-center">
                            <span id="expression-label" class="text-xl md:text-2xl font-bold text-blue-700"></span>
                        </div>
                    </div>
                </div>
                <!-- Đáp án -->
                <div id="options-area" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8"></div>
                <!-- Thông báo -->
                <div id="message" class="hidden text-center text-lg font-bold rounded-2xl py-3 px-4 mb-4"></div>
                <!-- Nút chơi lại -->
                <div class="flex flex-col items-center gap-2">
                    <button id="reset-btn" class="px-8 py-3 rounded-full bg-gradient-to-r from-green-400 to-blue-400 text-white font-bold text-xl shadow-lg hover:from-green-500 hover:to-blue-500 transition flex items-center gap-2">
                        <span>🔄</span> Chơi lại từ đầu
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Mảng câu hỏi truyền từ backend
        let questions = @json($questions);
        let currentLevel = 1;

        // Toggle hướng dẫn
        document.addEventListener('DOMContentLoaded', function () {
            const guideBtn = document.getElementById('toggle-guide');
            const guideContent = document.getElementById('guide-content');
            const guideArrow = document.getElementById('guide-arrow');
            let guideVisible = true;
            guideBtn.onclick = function () {
                guideVisible = !guideVisible;
                guideContent.style.display = guideVisible ? 'block' : 'none';
                guideArrow.textContent = guideVisible ? '▼' : '▲';
            };
            renderQuestion();
            document.getElementById('reset-btn').onclick = resetGame;
        });

        function renderQuestion() {
            const q = questions[currentLevel - 1];
            document.getElementById('level-label').textContent = currentLevel;
            document.getElementById('expression-label').textContent = `Tính giá trị của biểu thức: ${q.expression}`;
            // Render options
            const optionsArea = document.getElementById('options-area');
            optionsArea.innerHTML = '';
            q.options.forEach(option => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'option-btn w-full py-6 rounded-2xl font-extrabold text-2xl shadow-md bg-gradient-to-br from-blue-100 via-pink-100 to-yellow-100 border-2 border-blue-200 text-blue-700 hover:scale-105 hover:from-yellow-200 hover:to-pink-100 transition-all duration-200 focus:outline-none mb-2';
                btn.innerHTML = `<span class='inline-block align-middle'>${option.numerator}</span><span class='mx-1 text-lg font-normal'>/</span><span class='inline-block align-middle'>${option.denominator}</span>`;
                btn.onclick = () => checkAnswer(option, btn);
                optionsArea.appendChild(btn);
            });
            // Reset message
            const messageDiv = document.getElementById('message');
            messageDiv.className = 'hidden text-center text-lg font-bold rounded-2xl py-3 px-4 mb-4';
            messageDiv.textContent = '';
        }

        function checkAnswer(answer, btn) {
            const q = questions[currentLevel - 1];
            const correct = answer.numerator == q.answer.numerator && answer.denominator == q.answer.denominator;
            const messageDiv = document.getElementById('message');
            const buttons = document.querySelectorAll('.option-btn');
            // Disable all buttons
            buttons.forEach(b => b.disabled = true);
            if (correct) {
                btn.classList.add('ring-4', 'ring-green-400', 'animate-bounce');
                messageDiv.className = 'block text-green-700 bg-green-100 border-2 border-green-300 text-center text-lg font-bold rounded-2xl py-3 px-4 mb-4 animate-fadein shadow-lg';
                messageDiv.innerHTML = '<span class="text-2xl">🎉</span> Tuyệt vời! Đáp án chính xác!';
                if (typeof confetti !== 'undefined') {
                    confetti({
                        particleCount: 120,
                        spread: 70,
                        origin: {y: 0.6},
                        colors: ['#f472b6', '#fde68a', '#38bdf8', '#4ade80', '#fbbf24']
                    });
                }
                if (currentLevel < questions.length) {
                    setTimeout(() => {
                        btn.classList.remove('ring-4', 'ring-green-400', 'animate-bounce');
                        currentLevel++;
                        renderQuestion();
                    }, 1800);
                }
            } else {
                btn.classList.add('ring-4', 'ring-red-400', 'animate-shake');
                messageDiv.className = 'block text-red-700 bg-red-100 border-2 border-red-300 text-center text-lg font-bold rounded-2xl py-3 px-4 mb-4 animate-fadein shadow-lg';
                messageDiv.innerHTML = `
                    <span class="text-2xl">⚠️</span> Đáp án chưa chính xác.<br>
                    <span class="text-base font-normal">💡 Gợi ý: Tính trong ngoặc trước, nhân/chia trước, cộng/trừ sau.</span>
                `;
                setTimeout(() => {
                    btn.classList.remove('ring-4', 'ring-red-400', 'animate-shake');
                    messageDiv.className = 'hidden text-center text-lg font-bold rounded-2xl py-3 px-4 mb-4';
                    buttons.forEach(b => b.disabled = false);
                }, 1800);
            }
        }

        function resetGame() {
            currentLevel = 1;
            renderQuestion();
        }
    </script>
@endpush

@push('styles')
    <style>
        .animate-glow {
            text-shadow: 0 0 8px #f472b6, 0 0 16px #38bdf8;
            animation: glow 1.5s infinite alternate;
        }

        @keyframes glow {
            from {
                text-shadow: 0 0 8px #f472b6, 0 0 16px #38bdf8;
            }
            to {
                text-shadow: 0 0 16px #fde68a, 0 0 32px #38bdf8;
            }
        }

        .animate-bounce {
            animation: bounce 0.5s;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .animate-shake {
            animation: shake 0.4s;
        }

        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            20% {
                transform: translateX(-8px);
            }
            40% {
                transform: translateX(8px);
            }
            60% {
                transform: translateX(-6px);
            }
            80% {
                transform: translateX(6px);
            }
        }

        .animate-fadein {
            animation: fadein 0.7s;
        }

        @keyframes fadein {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
@endpush
