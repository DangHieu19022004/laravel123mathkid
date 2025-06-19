@extends('layouts.game')

@section('game_content')
    <div class="flex items-center justify-center min-h-[80vh]">
        <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-lg border-2 border-blue-400 animate-fade-in">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-extrabold text-blue-700 drop-shadow mb-2 flex items-center justify-center gap-2">
                    <span class="animate-bounce">📏🔵</span> Tính Chu Vi
                </h1>
                <p class="text-gray-600 text-lg">Câu hỏi <span id="levelDisplay">1</span> /
                    <span id="maxLevelDisplay">5</span></p>
            </div>
            <div id="questionBox" class="text-center mb-8"></div>
            <div class="flex items-center justify-center gap-2 mb-6">
                <input id="answerInput" type="number" step="any" class="w-40 p-4 border-2 border-blue-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 text-center text-xl font-semibold shadow transition-all duration-300" placeholder="Nhập chu vi">
                <span id="unitDisplay" class="font-bold text-blue-700 text-xl"></span>
            </div>
            <div class="flex justify-center gap-4 mb-2">
                <button id="checkBtn" class="w-40 h-14 bg-gradient-to-r from-green-400 to-green-600 text-white rounded-xl hover:scale-105 active:scale-95 transition text-lg font-bold flex items-center justify-center gap-2 shadow-lg focus:outline-none focus:ring-2 focus:ring-green-300">
                    <span>✔️</span>Kiểm tra
                </button>
                <button id="resetBtn" class="w-40 h-14 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white rounded-xl hover:scale-105 active:scale-95 transition text-lg font-bold flex items-center justify-center gap-2 shadow-lg focus:outline-none focus:ring-2 focus:ring-yellow-300">
                    <span>🔄</span>Chơi lại
                </button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
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
        const unitDisplay = document.getElementById('unitDisplay');
        const checkBtn = document.getElementById('checkBtn');
        const resetBtn = document.getElementById('resetBtn');

        maxLevelDisplay.textContent = questions.length;

        function calcPerimeter(q) {
            const s = q.sides;
            switch (q.shape) {
                case 'hình vuông':
                    return s[0] * 4;
                case 'hình chữ nhật':
                    return (s[0] + s[1]) * 2;
                case 'tam giác đều':
                    return s[0] * 3;
                case 'hình thang':
                    return s.reduce((a, b) => a + b, 0);
                case 'ngũ giác đều':
                    return s[0] * 5;
                default:
                    return null;
            }
        }

        function renderQuestion(idx) {
            const q = questions[idx];
            levelDisplay.textContent = q.level;
            unitDisplay.textContent = q.unit;
            answerInput.value = '';
            answerInput.classList.remove('border-red-400', 'border-green-400');
            // Render hình + thông số
            let html = '<div id="shapeBox" class="inline-block p-4">';
            switch (q.shape) {
                case 'hình vuông':
                    html += `<div class='w-32 h-32 border-4 border-blue-500 bg-gradient-to-br from-blue-200 to-blue-400 mx-auto rounded-md animate-shape'></div><p class='mt-3 text-lg font-semibold text-blue-700'>Cạnh = <span class='text-pink-600'>${q.sides[0]}</span> cm</p>`;
                    break;
                case 'hình chữ nhật':
                    html += `<div class='w-40 h-28 border-4 border-blue-500 bg-gradient-to-br from-blue-200 to-blue-400 mx-auto rounded animate-shape'></div><p class='mt-3 text-lg font-semibold text-blue-700'>Dài = <span class='text-pink-600'>${q.sides[0]}</span> cm, Rộng = <span class='text-pink-600'>${q.sides[1]}</span> cm</p>`;
                    break;
                case 'tam giác đều':
                    html += `<div class='relative w-32 h-32 mx-auto animate-shape'><div class='absolute top-0 left-1/2 transform -translate-x-1/2 border-l-[50px] border-r-[50px] border-b-[87px] border-l-transparent border-r-transparent border-b-blue-500 bg-blue-50'></div></div><p class='mt-3 text-lg font-semibold text-blue-700'>Cạnh = <span class='text-pink-600'>${q.sides[0]}</span> cm</p>`;
                    break;
                case 'hình thang':
                    html += `<div class='relative w-40 h-28 mx-auto animate-shape'><div class='absolute inset-0 border-4 border-blue-500 transform skew-x-12 bg-gradient-to-br from-blue-200 to-blue-400 rounded'></div></div><p class='mt-3 text-lg font-semibold text-blue-700'>Đáy trên = <span class='text-pink-600'>${q.sides[0]}</span> cm, Đáy dưới = <span class='text-pink-600'>${q.sides[1]}</span> cm<br>Cạnh bên = <span class='text-pink-600'>${q.sides[2]}</span> cm, <span class='text-pink-600'>${q.sides[3]}</span> cm</p>`;
                    break;
                case 'ngũ giác đều':
                    html += `<div class='relative w-32 h-32 mx-auto animate-shape'><div class='absolute inset-0 border-4 border-blue-500 transform rotate-18 bg-gradient-to-br from-blue-200 to-blue-400'></div></div><p class='mt-3 text-lg font-semibold text-blue-700'>Cạnh = <span class='text-pink-600'>${q.sides[0]}</span> cm</p>`;
                    break;
                default:
                    html += `<p class='mt-3 text-lg text-red-600'>Không xác định hình học</p>`;
            }
            html += '</div>';
            questionBox.innerHTML = html;
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
            const correct = calcPerimeter(q);
            if (correct === null) {
                Swal.fire({icon: 'error', title: 'Không xác định được đáp án!'});
                return;
            }
            if (Math.abs(ans - correct) < 1e-6) {
                answerInput.classList.remove('border-red-400');
                answerInput.classList.add('border-green-400');
                shapeBox.classList.remove('animate-shape-wrong');
                shapeBox.classList.add('animate-shape-correct');
                setTimeout(() => shapeBox.classList.remove('animate-shape-correct'), 800);
                if (currentIdx < questions.length - 1) {
                    Swal.fire({icon: 'success', title: '🎉 Chính xác!', showConfirmButton: false, timer: 3000});
                    setTimeout(() => {
                        currentIdx++;
                        renderQuestion(currentIdx);
                    }, 3000);
                } else {
                    Swal.fire({
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
                    text: `Đáp án đúng là ${correct} ${q.unit}`,
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
