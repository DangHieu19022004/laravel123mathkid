@extends('layouts.game')

@section('content')
    <div class="min-h-screen flex flex-col items-center bg-gradient-to-br from-pink-100 to-yellow-100 py-4 md:py-8">
        <div class="w-full max-w-xl bg-white rounded-3xl shadow-2xl p-4 md:p-8 flex flex-col items-center animate-fade-in mx-2 md:mx-0">
            <!-- Header -->
            <h1 class="text-2xl md:text-4xl font-extrabold text-pink-600 mb-2 drop-shadow text-center">Phần Bánh Còn Lại 🍰</h1>
            <div class="w-full flex flex-col items-center">
                <!-- Instructions -->
                <div class="w-full bg-yellow-50 border-l-4 border-yellow-400 p-3 md:p-4 rounded-xl mb-4 md:mb-6 animate-fade-in">
                    <h3 class="font-semibold text-yellow-700 mb-1 text-sm md:text-base">🎯 Hướng dẫn chơi:</h3>
                    <ul class="list-disc list-inside text-gray-700 text-xs md:text-base">
                        <li>Quan sát phần bánh đã ăn</li>
                        <li>Tính phần bánh còn lại</li>
                        <li>Nhập tử số và mẫu số của phần còn lại</li>
                    </ul>
                </div>
                <!-- Cake Problem -->
                <div id="level-indicator" class="text-gray-500 mb-2">Cấp độ 1/5</div>
                <div class="w-full flex flex-col items-center mb-2">
                    <div class="bg-gradient-to-br from-pink-200 to-yellow-200 rounded-2xl p-2 md:p-4 shadow-lg mb-3 md:mb-4 animate-pop-in">
                        <div class="flex justify-center">
                            <canvas id="cakeCanvas" width="180" height="180" class="mx-auto md:w-[200px] md:h-[200px] w-[150px] h-[150px]"></canvas>
                        </div>
                    </div>
                    <p id="cake-question" class="w-full md:w-4/5 font-semibold text-gray-700 mb-2 text-center transition-all duration-300">
                        <!-- JS will fill this -->
                    </p>
                </div>
                <!-- Answer Input -->
                <form id="answer-form" class="flex flex-col items-center gap-2 mb-3 md:mb-4 animate-fade-in w-full max-w-xs md:max-w-md mx-auto">
                    <div class="bg-white rounded-2xl shadow-lg border border-pink-200 px-4 py-3 w-full flex flex-row items-center gap-3 justify-center">
                        <div class="flex flex-col items-center">
                            <label for="numerator" class="text-xs text-gray-500 font-semibold mb-1">Tử số</label>
                            <input type="number" id="numerator" class="w-16 md:w-20 px-2 py-2 rounded-lg border-2 border-pink-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 text-center font-bold text-lg bg-pink-50 shadow-sm transition-all duration-200 outline-none" placeholder="0" min="0" required autocomplete="off">
                        </div>
                        <span class="text-2xl font-bold text-pink-400 mx-1 select-none">/</span>
                        <div class="flex flex-col items-center">
                            <label for="denominator" class="text-xs text-gray-500 font-semibold mb-1">Mẫu số</label>
                            <input type="number" id="denominator" class="w-16 md:w-20 px-2 py-2 rounded-lg border-2 border-pink-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 text-center font-bold text-lg bg-pink-50 shadow-sm transition-all duration-200 outline-none" placeholder="1" min="1" required autocomplete="off">
                        </div>
                    </div>
                    <button type="submit" class="w-full md:w-1/2 mt-2 md:mt-4 px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-bold rounded-xl shadow transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-pink-400 flex items-center justify-center gap-2 text-base">
                        Kiểm tra
                    </button>
                </form>
                <button id="replay-btn" class="hidden mt-2 px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold rounded-lg shadow transition-all duration-200 animate-bounce-in text-sm md:text-base">Chơi lại từ đầu</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const questions = @json($questions);

        let currentLevel = 0;

        const cakeCanvas = document.getElementById('cakeCanvas');
        const ctx = cakeCanvas.getContext('2d');
        const numeratorInput = document.getElementById('numerator');
        const denominatorInput = document.getElementById('denominator');
        const answerForm = document.getElementById('answer-form');
        const cakeQuestion = document.getElementById('cake-question');
        const levelIndicator = document.getElementById('level-indicator');
        const replayBtn = document.getElementById('replay-btn');

        function drawCake(eaten, denominator) {
            // Responsive canvas size
            let width = window.innerWidth < 500 ? 180 : 260;
            cakeCanvas.width = width;
            cakeCanvas.height = width;
            const centerX = cakeCanvas.width / 2;
            const centerY = cakeCanvas.height / 2;
            const radius = Math.min(cakeCanvas.width, cakeCanvas.height) * 0.42;
            ctx.clearRect(0, 0, cakeCanvas.width, cakeCanvas.height);
            // Draw full cake
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius, 0, 2 * Math.PI);
            ctx.fillStyle = '#FFF7F0';
            ctx.fill();
            ctx.strokeStyle = '#F472B6';
            ctx.lineWidth = 4;
            ctx.stroke();
            // Draw slices
            for (let i = 0; i < denominator; i++) {
                const angle = (i * 2 * Math.PI) / denominator;
                ctx.beginPath();
                ctx.moveTo(centerX, centerY);
                ctx.lineTo(centerX + radius * Math.cos(angle), centerY + radius * Math.sin(angle));
                ctx.strokeStyle = '#FBBF24';
                ctx.lineWidth = 2;
                ctx.stroke();
            }
            // Animate eaten slices
            for (let i = 0; i < eaten; i++) {
                const startAngle = (i * 2 * Math.PI) / denominator;
                const endAngle = ((i + 1) * 2 * Math.PI) / denominator;
                ctx.beginPath();
                ctx.moveTo(centerX, centerY);
                ctx.arc(centerX, centerY, radius, startAngle, endAngle);
                ctx.closePath();
                ctx.fillStyle = 'rgba(244, 114, 182, 0.45)';
                ctx.fill();
            }
            // Cake shine
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius * 0.7, -0.7, -0.2);
            ctx.strokeStyle = 'rgba(255,255,255,0.7)';
            ctx.lineWidth = 6;
            ctx.stroke();
        }

        function showLevel(level) {
            const q = questions[level];
            drawCake(q.eaten.numerator, q.eaten.denominator);
            cakeQuestion.innerHTML = `Đã ăn <span class="text-pink-500 font-bold">${q.eaten.numerator}/${q.eaten.denominator}</span> phần bánh.<br>Còn lại bao nhiêu phần?`;
            levelIndicator.textContent = `Cấp độ ${level + 1}/${questions.length}`;
            numeratorInput.value = '';
            denominatorInput.value = '';
            numeratorInput.disabled = false;
            denominatorInput.disabled = false;
            answerForm.querySelector('button').disabled = false;
            numeratorInput.focus();
        }

        function checkAnswer(level, num, den) {
            const correct = questions[level].remaining;
            // Compare fractions: a/b == c/d <=> a*d == b*c
            return (num * correct.denominator) === (den * correct.numerator);
        }

        function animateCorrect() {
            cakeCanvas.classList.add('animate-correct');
            setTimeout(() => cakeCanvas.classList.remove('animate-correct'), 700);
        }

        function animateWrong() {
            cakeCanvas.classList.add('animate-wrong');
            setTimeout(() => cakeCanvas.classList.remove('animate-wrong'), 700);
        }

        answerForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const num = parseInt(numeratorInput.value);
            const den = parseInt(denominatorInput.value);
            if (isNaN(num) || isNaN(den) || den <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Vui lòng nhập số hợp lệ!',
                    confirmButtonColor: '#F472B6',
                    customClass: {popup: 'animate-pop-in'}
                });
                animateWrong();
                return;
            }
            answerForm.querySelector('button').disabled = true;
            numeratorInput.disabled = true;
            denominatorInput.disabled = true;
            if (checkAnswer(currentLevel, num, den)) {
                animateCorrect();
                Swal.fire({
                    icon: 'success',
                    title: 'Đúng rồi! 🎉',
                    showConfirmButton: false,
                    timer: 1200,
                    customClass: {popup: 'animate-pop-in'}
                });
                setTimeout(() => {
                    if (currentLevel < questions.length - 1) {
                        currentLevel++;
                        showLevel(currentLevel);
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Hoàn thành tất cả cấp độ! 🏆',
                            text: 'Bạn thật xuất sắc!',
                            confirmButtonText: 'Chơi lại',
                            confirmButtonColor: '#FBBF24',
                            customClass: {popup: 'animate-pop-in'}
                        }).then(() => {
                            currentLevel = 0;
                            showLevel(currentLevel);
                        });
                        replayBtn.classList.remove('hidden');
                    }
                }, 1200);
            } else {
                animateWrong();
                Swal.fire({
                    icon: 'error',
                    title: 'Chưa đúng 🤔',
                    text: 'Hãy thử lại!',
                    showConfirmButton: false,
                    timer: 1200,
                    customClass: {popup: 'animate-pop-in'}
                });
                setTimeout(() => {
                    numeratorInput.value = '';
                    denominatorInput.value = '';
                    numeratorInput.disabled = false;
                    denominatorInput.disabled = false;
                    answerForm.querySelector('button').disabled = false;
                    numeratorInput.focus();
                }, 1200);
            }
        });

        replayBtn.addEventListener('click', function () {
            currentLevel = 0;
            showLevel(currentLevel);
            replayBtn.classList.add('hidden');
        });

        // Animations
        const style = document.createElement('style');
        style.innerHTML = `
@keyframes pop-in { 0% { transform: scale(0.7); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
@keyframes fade-in { 0% { opacity: 0; } 100% { opacity: 1; } }
@keyframes bounce-in { 0% { transform: translateY(40px); opacity: 0; } 60% { transform: translateY(-10px); opacity: 1; } 100% { transform: translateY(0); } }
@keyframes correct { 0% { box-shadow: 0 0 0 0 #FBBF24; } 50% { box-shadow: 0 0 40px 10px #FBBF24; } 100% { box-shadow: 0 0 0 0 #FBBF24; } }
@keyframes wrong { 0% { box-shadow: 0 0 0 0 #F87171; } 50% { box-shadow: 0 0 40px 10px #F87171; } 100% { box-shadow: 0 0 0 0 #F87171; } }
.animate-pop-in { animation: pop-in 0.4s cubic-bezier(.68,-0.55,.27,1.55); }
.animate-fade-in { animation: fade-in 0.7s; }
.animate-bounce-in { animation: bounce-in 0.7s; }
.animate-correct { animation: correct 0.7s; }
.animate-wrong { animation: wrong 0.7s; }
`;
        document.head.appendChild(style);

        // Redraw cake on resize for responsiveness
        window.addEventListener('resize', () => drawCake(questions[currentLevel].eaten.numerator, questions[currentLevel].eaten.denominator));

        // Start game
        showLevel(currentLevel);
    </script>
@endpush
