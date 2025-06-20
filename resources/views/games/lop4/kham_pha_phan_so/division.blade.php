@extends('layouts.game')

@section('content')
    <div class="flex flex-col items-center min-h-screen bg-gradient-to-br from-blue-100 via-green-50 to-yellow-100">
        <div class="w-full max-w-xl p-6 bg-white rounded-3xl shadow-2xl mt-10 mb-8 animate-fade-in">
            <!-- Header -->
            <div class="text-center mb-6">
                <h1 class="text-3xl font-extrabold text-blue-600 mb-2">Chia Phân Số 📊</h1>
                <div class="inline-block px-6 py-2 bg-blue-100 rounded-full shadow text-lg font-semibold text-blue-700 mb-2">
                    Cấp độ <span id="current-level">1</span>/5
                </div>
                <p class="text-gray-500 mt-2">Tính phép chia phân số và nhập kết quả rút gọn!</p>
            </div>
            <!-- Instructions -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg mb-6">
                <h3 class="font-bold text-yellow-700 mb-1">🎯 Hướng dẫn chơi:</h3>
                <ul class="list-disc list-inside text-gray-700 text-base">
                    <li>Tính kết quả phép chia phân số</li>
                    <li>Nhập tử số và mẫu số của kết quả</li>
                    <li>Rút gọn phân số nếu có thể</li>
                </ul>
            </div>
            <!-- Game Area -->
            <div class="flex flex-col items-center">
                <!-- Division Problem -->
                <div class="bg-blue-50 rounded-xl shadow p-4 mb-4 w-full text-center">
                    <span class="text-2xl font-bold text-blue-700" id="problem-text"></span>
                </div>
                <!-- Answer Input -->
                <form id="answer-form" class="flex flex-col items-center gap-2 mb-4 w-full justify-center">
                    <div class="flex flex-row items-center">
                        <input type="number" class="w-40 h-12 px-3 py-2 border-2 border-blue-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 font-bold text-blue-700" id="numerator" placeholder="Tử số" min="1" required>
                        <div class="mx-2 text-2xl text-blue-200">/</div>
                        <input type="number" class="w-40 h-12 px-3 py-2 border-2 border-blue-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 font-bold text-blue-700" id="denominator" placeholder="Mẫu số" min="1" required>
                    </div>
                    <button type="submit"
                        class="mt-4 py-3 px-6 bg-gradient-to-r from-blue-500 to-cyan-400 hover:from-blue-600 hover:to-cyan-500 text-white font-bold rounded-full shadow-xl flex items-center gap-1 text-xl transition-all duration-200 focus:ring-4 focus:ring-blue-200">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Kiểm tra
                    </button>

                    <div class="text-center mt-3">
                        <button id="reset-btn"
                            class="inline-flex items-center gap-1 px-4 py-2 rounded-full text-blue-500 bg-blue-50 hover:bg-blue-100 hover:underline font-semibold text-base transition-all duration-150">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582M20 20v-5h-.581M5.582 9A7.003 7.003 0 0112 5c3.314 0 6.127 2.388 6.918 5.5M18.418 15A7.003 7.003 0 0112 19c-3.314 0-6.127-2.388-6.918-5.5"/>
                            </svg>
                            Chơi lại từ đầu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const QUESTIONS = @json($questions);

        let currentLevel = 1;
        const maxLevel = Object.keys(QUESTIONS).length;

        function renderQuestion(level) {
            const q = QUESTIONS[level];
            document.getElementById('current-level').textContent = level;
            document.getElementById('problem-text').textContent = `${q.dividend.numerator}/${q.dividend.denominator}  ÷  ${q.divisor.numerator}/${q.divisor.denominator}  =`;
            document.getElementById('numerator').value = '';
            document.getElementById('denominator').value = '';
            document.getElementById('numerator').disabled = false;
            document.getElementById('denominator').disabled = false;
            document.querySelector('#answer-form button[type="submit"]').disabled = false;
            document.getElementById('numerator').focus();
        }

        function isCorrectAnswer(user, validAnswers) {
            for (const ans of validAnswers) {
                if (user.numerator * ans.denominator === user.denominator * ans.numerator) {
                    return true;
                }
            }
            return false;
        }

        document.addEventListener('DOMContentLoaded', function () {
            renderQuestion(currentLevel);

            const form = document.getElementById('answer-form');
            const numeratorInput = document.getElementById('numerator');
            const denominatorInput = document.getElementById('denominator');
            const resetBtn = document.getElementById('reset-btn');

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const userAnswer = {
                    numerator: parseInt(numeratorInput.value),
                    denominator: parseInt(denominatorInput.value)
                };
                numeratorInput.disabled = true;
                denominatorInput.disabled = true;
                form.querySelector('button').disabled = true;

                const validAnswers = QUESTIONS[currentLevel].answers;
                const correct = isCorrectAnswer(userAnswer, validAnswers);

                if (correct) {
                    Swal.fire({
                        icon: 'success',
                        title: '🎉 Đúng rồi!',
                        text: currentLevel < maxLevel ? 'Bạn sẽ lên cấp tiếp theo!' : 'Bạn đã hoàn thành tất cả cấp độ!',
                        showConfirmButton: false,
                        timer: 1500,
                        background: '#f0f9ff',
                        color: '#2563eb',
                        didOpen: () => {
                            if (typeof confetti !== 'undefined') {
                                confetti({particleCount: 100, spread: 70, origin: {y: 0.6}});
                            }
                        }
                    }).then(() => {
                        if (currentLevel < maxLevel) {
                            currentLevel++;
                            renderQuestion(currentLevel);
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Chưa đúng!',
                        text: 'Hãy thử lại và nhớ rút gọn phân số nhé!',
                        background: '#fffbea',
                        color: '#d97706',
                        showConfirmButton: false,
                        timer: 1800
                    }).then(() => {
                        numeratorInput.disabled = false;
                        denominatorInput.disabled = false;
                        form.querySelector('button').disabled = false;
                        numeratorInput.value = '';
                        denominatorInput.value = '';
                        numeratorInput.focus();
                    });
                }
            });

            resetBtn.addEventListener('click', function () {
                currentLevel = 1;
                renderQuestion(currentLevel);
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .animate-fade-in {
            animation: fade-in 0.7s;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush
