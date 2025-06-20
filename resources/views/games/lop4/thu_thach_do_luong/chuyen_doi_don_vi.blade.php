@extends('layouts.game')

@section('content')
    <div class="unit-conversion-bg flex flex-col items-center min-h-screen py-8">
        <div class="w-full max-w-xl bg-white rounded-3xl shadow-2xl p-8 flex flex-col items-center">
            <h2 class="mb-4 text-3xl font-extrabold text-blue-600 tracking-tight text-center flex items-center gap-2" style="font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;">
                <span>Chuyển Đổi Đơn Vị Thần Tốc</span>
                <span class="text-4xl">🔁</span>
            </h2>
            <div class="level-label mb-2" id="level-label"></div>
            <div class="level-bar mb-6">
                <div class="level-bar-inner" id="level-bar-inner"></div>
            </div>
            <div class="text-2xl font-bold mb-2">Điểm: <span id="score">0</span></div>
            <div class="text-sm text-gray-600 mb-6">Trả lời đúng: +10 điểm | Trả lời sai: -5 điểm</div>
            <div class="bg-blue-50 rounded-xl shadow-lg p-6 mb-8 w-full">
                <div class="flex items-center justify-center text-2xl font-bold gap-4">
                    <span id="value1">1500</span>
                    <span id="unit1">g</span>
                    <span>=</span>
                    <div class="relative">
                        <input type="text" id="answer"
                               class="w-32 text-center border-b-2 border-blue-500 focus:outline-none focus:border-blue-700 bg-transparent text-2xl font-bold" autocomplete="off"
                               placeholder="?">
                    </div>
                    <span id="unit2">kg</span>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4 mb-8 w-full max-w-xs mx-auto">
                <button class="num-btn bg-white border border-blue-200 p-4 rounded-xl text-2xl font-bold shadow hover:bg-blue-100 transition">7</button>
                <button class="num-btn bg-white border border-blue-200 p-4 rounded-xl text-2xl font-bold shadow hover:bg-blue-100 transition">8</button>
                <button class="num-btn bg-white border border-blue-200 p-4 rounded-xl text-2xl font-bold shadow hover:bg-blue-100 transition">9</button>
                <button class="num-btn bg-white border border-blue-200 p-4 rounded-xl text-2xl font-bold shadow hover:bg-blue-100 transition">4</button>
                <button class="num-btn bg-white border border-blue-200 p-4 rounded-xl text-2xl font-bold shadow hover:bg-blue-100 transition">5</button>
                <button class="num-btn bg-white border border-blue-200 p-4 rounded-xl text-2xl font-bold shadow hover:bg-blue-100 transition">6</button>
                <button class="num-btn bg-white border border-blue-200 p-4 rounded-xl text-2xl font-bold shadow hover:bg-blue-100 transition">1</button>
                <button class="num-btn bg-white border border-blue-200 p-4 rounded-xl text-2xl font-bold shadow hover:bg-blue-100 transition">2</button>
                <button class="num-btn bg-white border border-blue-200 p-4 rounded-xl text-2xl font-bold shadow hover:bg-blue-100 transition">3</button>
                <button class="num-btn bg-white border border-blue-200 p-4 rounded-xl text-2xl font-bold shadow hover:bg-blue-100 transition">0</button>
                <button class="num-btn bg-white border border-blue-200 p-4 rounded-xl text-2xl font-bold shadow hover:bg-blue-100 transition">.</button>
                <button id="backspace" class="bg-red-100 border border-red-200 p-4 rounded-xl text-2xl font-bold shadow hover:bg-red-200 transition">❌</button>
            </div>
            <div class="flex justify-center gap-4 w-full">
                <button id="check" class="bg-green-500 text-white px-8 py-3 rounded-xl text-lg font-bold shadow hover:bg-green-600 transition">Kiểm tra</button>
                <button id="next-btn" class="bg-blue-500 text-white px-8 py-3 rounded-xl text-lg font-bold shadow hover:bg-blue-600 transition hidden">Câu hỏi tiếp theo</button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        body {
            background: linear-gradient(135deg, #e3f2fd 0%, #fceabb 100%);
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
        }

        .unit-conversion-bg {
            background: linear-gradient(135deg, #e3f2fd 0%, #fceabb 100%);
        }

        .level-bar {
            width: 100%;
            background: #e3f2fd;
            border-radius: 1.2rem;
            height: 18px;
            box-shadow: 0 2px 8px 0 rgba(33, 150, 243, 0.08);
            overflow: hidden;
        }

        .level-bar-inner {
            height: 100%;
            background: linear-gradient(90deg, #42a5f5 0%, #29b6f6 100%);
            border-radius: 1.2rem;
            transition: width 0.5s cubic-bezier(.4, 2, .6, 1);
        }

        .level-label {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1976d2;
            letter-spacing: 1px;
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
        }

        .swal2-popup.swal2-rounded {
            border-radius: 1.5rem !important;
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
            font-size: 1.1rem;
            box-shadow: 0 8px 32px 0 rgba(33, 150, 243, 0.10);
        }

        .swal2-title {
            color: #1976d2 !important;
            font-weight: 700;
            font-size: 1.5rem !important;
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
        }

        .swal2-icon-success {
            color: #43e97b !important;
            border-color: #43e97b !important;
        }

        .swal2-icon-error {
            color: #ff5858 !important;
            border-color: #ff5858 !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const questions = @json($questions);
        let level = 1;
        let maxLevel = questions.length;
        let score = 0;
        let correctAnswer = 0;

        window.onload = function () {
            Swal.fire({
                title: 'Hướng dẫn',
                html: `<div style='font-size:1.15rem;line-height:1.6'><b>Điền kết quả đúng vào ô trống</b> để chuyển đổi đơn vị.<br>Hoàn thành tất cả level để trở thành "bậc thầy chuyển đổi"!<br><br><span style='font-size:2rem;'>🔁📏⚖️</span></div>`,
                icon: 'info',
                confirmButtonText: 'Bắt đầu chơi',
                customClass: {popup: 'swal2-popup swal2-rounded'}
            });
            renderQuestion();
        };

        function renderQuestion() {
            document.getElementById('level-label').innerHTML = `Level <span style='color:#1565c0'>${level}</span> / ${maxLevel}`;
            document.getElementById('level-bar-inner').style.width = ((level - 1) / maxLevel * 100) + '%';
            const q = questions[level - 1];
            document.getElementById('value1').textContent = q.value;
            document.getElementById('unit1').textContent = q.fromUnit;
            document.getElementById('unit2').textContent = q.toUnit;
            document.getElementById('answer').value = '';
            correctAnswer = getCorrectAnswer(q);
            document.getElementById('next-btn').classList.add('hidden');
        }

        function getCorrectAnswer(q) {
            // Đơn giản hóa cho các trường hợp phổ biến
            if (q.fromUnit === 'm' && q.toUnit === 'km') return q.value / 1000;
            if (q.fromUnit === 'km' && q.toUnit === 'm') return q.value * 1000;
            if (q.fromUnit === 'g' && q.toUnit === 'kg') return q.value / 1000;
            if (q.fromUnit === 'kg' && q.toUnit === 'g') return q.value * 1000;
            if (q.fromUnit === 'ml' && q.toUnit === 'l') return q.value / 1000;
            if (q.fromUnit === 'l' && q.toUnit === 'ml') return q.value * 1000;
            return q.options[0]; // fallback
        }

        function checkAnswer() {
            const userAnswer = parseFloat(document.getElementById('answer').value);
            const isCorrect = Math.abs(userAnswer - correctAnswer) < 0.001;
            if (isCorrect) {
                Swal.fire({
                    icon: 'success',
                    title: `Level ${level} hoàn thành!`,
                    html: '<span style="font-size:1.2rem">Bạn đã chọn đúng!<br>Tiếp tục level tiếp theo nhé!</span>',
                    showConfirmButton: false,
                    timer: 1200,
                    timerProgressBar: true,
                    customClass: {popup: 'swal2-popup swal2-rounded'}
                }).then(() => {
                    score += 10;
                    if (level < maxLevel) {
                        level++;
                        renderQuestion();
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: '🎉 Hoàn thành tất cả level! 🎉',
                            html: '<span style="font-size:1.2rem">Bạn đã trở thành bậc thầy chuyển đổi!<br>👏👏👏</span>',
                            confirmButtonText: 'Chơi lại',
                            customClass: {popup: 'swal2-popup swal2-rounded'},
                            didOpen: () => {
                                confetti();
                            }
                        }).then(() => {
                            level = 1;
                            score = 0;
                            renderQuestion();
                        });
                    }
                    document.getElementById('score').textContent = score;
                });
                document.getElementById('next-btn').classList.remove('hidden');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Chưa đúng!',
                    html: `<span style='font-size:1.1rem'>Hãy thử lại nhé! Đáp án đúng là <b>${correctAnswer}</b></span>`,
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    customClass: {popup: 'swal2-popup swal2-rounded'}
                });
                score = Math.max(0, score - 5);
                document.getElementById('score').textContent = score;
            }
        }

        document.querySelectorAll('.num-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                if (btn.textContent === '.' && document.getElementById('answer').value.includes('.')) return;
                document.getElementById('answer').value += btn.textContent;
            });
        });
        document.getElementById('backspace').addEventListener('click', () => {
            const ans = document.getElementById('answer');
            ans.value = ans.value.slice(0, -1);
        });
        document.getElementById('answer').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                checkAnswer();
            }
        });
        document.getElementById('check').addEventListener('click', checkAnswer);
        document.getElementById('next-btn').addEventListener('click', function () {
            if (level < maxLevel) {
                level++;
                renderQuestion();
            } else {
                level = 1;
                score = 0;
                renderQuestion();
            }
        });

        function confetti() {
            if (document.getElementById('confetti-canvas')) return;
            const canvas = document.createElement('canvas');
            canvas.id = 'confetti-canvas';
            canvas.style.position = 'fixed';
            canvas.style.left = 0;
            canvas.style.top = 0;
            canvas.style.width = '100vw';
            canvas.style.height = '100vh';
            canvas.style.pointerEvents = 'none';
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            document.body.appendChild(canvas);
            const ctx = canvas.getContext('2d');
            const pieces = [];
            for (let i = 0; i < 120; i++) {
                pieces.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * -canvas.height,
                    r: 6 + Math.random() * 8,
                    d: 2 + Math.random() * 2,
                    color: `hsl(${Math.random() * 360},90%,60%)`,
                    tilt: Math.random() * 10,
                    tiltAngle: 0
                });
            }
            let frame = 0;

            function draw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                for (let p of pieces) {
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.r, 0, 2 * Math.PI);
                    ctx.fillStyle = p.color;
                    ctx.fill();
                }
                update();
                frame++;
                if (frame < 120) {
                    requestAnimationFrame(draw);
                } else {
                    document.body.removeChild(canvas);
                }
            }

            function update() {
                for (let p of pieces) {
                    p.y += p.d + Math.random() * 2;
                    p.x += Math.sin(frame / 10 + p.tilt) * 2;
                }
            }

            draw();
        }
    </script>
@endpush
