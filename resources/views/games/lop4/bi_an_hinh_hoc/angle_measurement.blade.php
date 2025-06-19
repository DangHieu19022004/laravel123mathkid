@extends('layouts.game')

@section('game_content')
    <div class="relative min-h-[80vh] flex justify-center items-center overflow-hidden">
        <div class="relative z-10 bg-white/90 rounded-3xl shadow-2xl p-8 w-full max-w-lg border-4 border-gradient-animated animate-fade-in">
            <div class="text-center mb-6">
                <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-yellow-400 to-blue-500 drop-shadow mb-2 flex items-center justify-center gap-2 animate-title-bounce">
                    <span class="animate-spin-slow">📐</span> Đo Góc <span class="animate-bounce">🧭</span>
                </h1>
                <p class="text-gray-700 text-lg font-bold tracking-wide animate-fade-in">
                    Câu hỏi <span id="levelDisplay" class="text-pink-500 font-extrabold text-2xl">1</span> /
                    <span id="maxLevelDisplay" class="text-blue-500 font-extrabold text-2xl">5</span>
                </p>
            </div>
            <div id="questionBox" class="text-center mb-8"></div>
            <div class="flex items-center justify-center gap-2 mb-6">
                <input id="answerInput" type="number" step="any" class="w-max p-3 border-2 border-blue-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-pink-300 text-center text-lg font-semibold shadow transition-all duration-300 bg-gradient-to-r from-blue-100 via-pink-100 to-yellow-100 animate-input-glow" placeholder="Nhập số đo (độ)">
            </div>
            <div class="flex justify-center gap-4 mb-2">
                <button id="checkBtn" class="w-40 h-14 bg-gradient-to-r from-green-400 via-yellow-300 to-pink-400 text-white rounded-xl hover:scale-110 active:scale-95 transition text-lg font-bold flex items-center justify-center gap-2 shadow-lg focus:outline-none focus:ring-4 focus:ring-pink-200 animate-btn-wave relative overflow-hidden">
                    <span class="animate-pulse">✔️</span>Kiểm tra
                </button>
                <button id="resetBtn" class="w-40 h-14 bg-gradient-to-r from-yellow-400 via-pink-400 to-blue-400 text-white rounded-xl hover:scale-110 active:scale-95 transition text-lg font-bold flex items-center justify-center gap-2 shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-200 animate-btn-wave relative overflow-hidden">
                    <span class="animate-spin-slow">🔄</span>Chơi lại
                </button>
            </div>
            <div id="particleBox" class="pointer-events-none absolute inset-0 z-20"></div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Animated border gradient */
        .border-gradient-animated {
            border-image: linear-gradient(135deg, #f472b6, #facc15, #60a5fa, #a5b4fc, #f472b6) 1;
            animation: border-rotate 4s linear infinite;
        }

        @keyframes border-rotate {
            0% {
                border-image-source: linear-gradient(135deg, #f472b6, #facc15, #60a5fa, #a5b4fc, #f472b6);
            }
            100% {
                border-image-source: linear-gradient(495deg, #f472b6, #facc15, #60a5fa, #a5b4fc, #f472b6);
            }
        }

        /* Title bounce */
        .animate-title-bounce {
            animation: title-bounce 2.2s infinite cubic-bezier(.68, -0.55, .27, 1.55);
        }

        @keyframes title-bounce {
            0%, 100% {
                transform: translateY(0);
            }
            20% {
                transform: translateY(-12px) scale(1.08);
            }
            40% {
                transform: translateY(6px) scale(0.98);
            }
            60% {
                transform: translateY(-4px) scale(1.04);
            }
            80% {
                transform: translateY(2px) scale(0.99);
            }
        }

        /* Input glow */
        .animate-input-glow {
            animation: input-glow 2.5s ease-in-out infinite alternate;
        }

        @keyframes input-glow {
            from {
                box-shadow: 0 0 0 0 #f472b6;
            }
            to {
                box-shadow: 0 0 16px 4px #f472b6;
            }
        }

        /* Button wave */
        .animate-btn-wave::before {
            content: '';
            position: absolute;
            left: -50%;
            top: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, #fff7 0%, #fff0 80%);
            opacity: 0.3;
            animation: btn-wave 2.5s linear infinite;
            z-index: 1;
        }

        @keyframes btn-wave {
            0% {
                transform: scale(0.8) rotate(0deg);
                opacity: 0.3;
            }
            50% {
                transform: scale(1.1) rotate(180deg);
                opacity: 0.5;
            }
            100% {
                transform: scale(0.8) rotate(360deg);
                opacity: 0.3;
            }
        }

        /* Spin slow */
        .animate-spin-slow {
            animation: spin 3.5s linear infinite;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        /* Wiggle degree sign */
        .animate-wiggle {
            animation: wiggle 1.5s infinite;
        }

        @keyframes wiggle {
            0%, 100% {
                transform: rotate(-10deg);
            }
            50% {
                transform: rotate(10deg);
            }
        }

        /* Shape correct/wrong (unchanged) */
        @keyframes shape-correct {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 #22c55e44;
            }
            50% {
                transform: scale(1.12);
                box-shadow: 0 0 30px 10px #22c55e44;
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 #22c55e44;
            }
        }

        @keyframes shape-wrong {
            0% {
                transform: translateX(0);
            }
            20% {
                transform: translateX(-10px);
            }
            40% {
                transform: translateX(10px);
            }
            60% {
                transform: translateX(-8px);
            }
            80% {
                transform: translateX(8px);
            }
            100% {
                transform: translateX(0);
            }
        }

        .animate-shape-correct {
            animation: shape-correct 0.7s;
        }

        .animate-shape-wrong {
            animation: shape-wrong 0.5s;
        }

        /* Fade in */
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.7s;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const questions = @json($questions);
        let currentIdx = 0;

        const levelDisplay = document.getElementById('levelDisplay');
        const maxLevelDisplay = document.getElementById('maxLevelDisplay');
        const questionBox = document.getElementById('questionBox');
        const answerInput = document.getElementById('answerInput');
        const checkBtn = document.getElementById('checkBtn');
        const resetBtn = document.getElementById('resetBtn');
        const particleBox = document.getElementById('particleBox');

        maxLevelDisplay.textContent = questions.length;

        function renderQuestion(idx) {
            const q = questions[idx];
            levelDisplay.textContent = idx + 1;
            answerInput.value = '';
            answerInput.classList.remove('border-red-400', 'border-green-400');
            // Render thông tin góc
            let html = `<div id='shapeBox' class='inline-block p-4 border-4 border-gradient-animated rounded-2xl bg-gradient-to-br from-blue-100 via-pink-100 to-yellow-100 shadow-xl transition-all duration-300 animate-fade-in'>`;
            html += `<div class='text-5xl mb-2 animate-spin-slow'>📐</div>`;
            html += `<div class='text-lg font-bold text-pink-600 mb-2 animate-title-bounce'>${q.angle_type}</div>`;
            html += `<div class='text-gray-700 font-semibold animate-fade-in'>Hãy nhập số đo (độ) của góc này (sai số ±${q.tolerance}°)</div>`;
            html += '</div>';
            questionBox.innerHTML = html;
        }

        // Particle effect for correct answer
        function showParticles() {
            if (!particleBox) return;
            particleBox.innerHTML = '';
            for (let i = 0; i < 24; i++) {
                const p = document.createElement('div');
                const colorArr = ['#f472b6', '#facc15', '#60a5fa', '#a5b4fc', '#34d399', '#f87171'];
                const color = colorArr[Math.floor(Math.random() * colorArr.length)];
                const size = Math.random() * 12 + 8;
                const left = Math.random() * 90 + 5;
                const top = Math.random() * 60 + 20;
                const duration = Math.random() * 0.7 + 0.8;
                p.style.position = 'absolute';
                p.style.left = left + '%';
                p.style.top = top + '%';
                p.style.width = size + 'px';
                p.style.height = size + 'px';
                p.style.borderRadius = '50%';
                p.style.background = color;
                p.style.opacity = 0.7;
                p.style.zIndex = 30;
                p.style.pointerEvents = 'none';
                p.style.transform = 'scale(0.7)';
                p.style.transition = `all ${duration}s cubic-bezier(.68,-0.55,.27,1.55)`;
                particleBox.appendChild(p);
                setTimeout(() => {
                    p.style.transform = 'scale(1.7) translateY(-60px)';
                    p.style.opacity = 0;
                }, 10);
            }
            setTimeout(() => {
                particleBox.innerHTML = '';
            }, 1500);
        }

        checkBtn.addEventListener('click', function () {
            const q = questions[currentIdx];
            const ans = parseFloat(answerInput.value);
            const shapeBox = document.getElementById('shapeBox');
            if (isNaN(ans)) {
                answerInput.classList.add('border-red-400');
                Swal.fire({icon: 'warning', title: 'Bạn chưa nhập đáp án!', confirmButtonText: 'OK'});
                return;
            }
            if (Math.abs(ans - q.actual_angle) <= q.tolerance) {
                answerInput.classList.remove('border-red-400');
                answerInput.classList.add('border-green-400');
                shapeBox.classList.remove('animate-shape-wrong');
                shapeBox.classList.add('animate-shape-correct');
                showParticles();
                setTimeout(() => shapeBox.classList.remove('animate-shape-correct'), 800);
                if (currentIdx < questions.length - 1) {
                    Swal.fire({icon: 'success', title: '🎉 Chính xác!', showConfirmButton: false, timer: 1200});
                    setTimeout(() => {
                        currentIdx++;
                        renderQuestion(currentIdx);
                    }, 1200);
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: '🎉 Hoàn thành!',
                        text: 'Bạn đã hoàn thành tất cả câu hỏi!',
                        confirmButtonText: 'Chơi lại'
                    }).then(() => {
                        currentIdx = 0;
                        renderQuestion(currentIdx);
                    });
                }
            } else {
                answerInput.classList.remove('border-green-400');
                answerInput.classList.add('border-red-400');
                shapeBox.classList.remove('animate-shape-correct');
                shapeBox.classList.add('animate-shape-wrong');
                setTimeout(() => shapeBox.classList.remove('animate-shape-wrong'), 600);
                Swal.fire({
                    title: '❌ Sai!',
                    text: `Đáp án đúng là ${q.actual_angle}° (sai số ±${q.tolerance}°)`,
                    confirmButtonText: 'OK'
                });
            }
        });

        resetBtn.addEventListener('click', function () {
            currentIdx = 0;
            renderQuestion(currentIdx);
        });

        document.addEventListener('DOMContentLoaded', function () {
            renderQuestion(currentIdx);
        });
    </script>
@endpush
