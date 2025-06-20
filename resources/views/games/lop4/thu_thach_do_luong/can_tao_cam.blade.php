@extends('layouts.game')

@section('content')
    <div class="fruit-weighing-bg flex flex-col items-center min-h-screen py-8">
        <div class="w-full max-w-xl bg-white rounded-3xl shadow-2xl p-8 flex flex-col items-center">
            <h2 class="mb-4 text-3xl font-extrabold text-orange-600 tracking-tight text-center flex items-center gap-2" style="font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;">
                <span>Cân Táo Cân Cam</span>
                <span class="text-4xl">🍎🍊</span>
            </h2>
            <div class="level-label" id="level-label"></div>
            <div class="level-bar">
                <div class="level-bar-inner" id="level-bar-inner"></div>
            </div>
            <div class="mb-4 text-center">
                <span id="question-title" class="text-lg font-semibold text-gray-700"></span>
            </div>
            <div class="flex justify-center mb-8 w-full">
                <div id="scale" class="relative w-full max-w-lg h-[260px] mx-auto">
                    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
                        <div class="w-4 h-[120px] bg-gray-700 mx-auto"></div>
                        <div class="w-[320px] h-2 bg-gray-700 -mt-2"></div>
                    </div>
                    <div id="left-plate" class="absolute left-[30px] top-[140px] w-[110px] h-[70px] border-4 border-gray-700 rounded-lg bg-white transition-all duration-500 flex flex-col items-center justify-center">
                        <div class="fruit-emoji text-4xl" id="left-emoji"></div>
                        <div class="weight-label text-base font-bold mt-1" id="left-weight"></div>
                    </div>
                    <div id="right-plate" class="absolute right-[30px] top-[140px] w-[110px] h-[70px] border-4 border-gray-700 rounded-lg bg-white transition-all duration-500 flex flex-col items-center justify-center">
                        <div class="fruit-emoji text-4xl" id="right-emoji"></div>
                        <div class="weight-label text-base font-bold mt-1" id="right-weight"></div>
                    </div>
                </div>
            </div>
            <div class="flex gap-4 mt-4">
                <button class="choose-btn px-6 py-3 rounded-xl bg-orange-100 font-bold text-lg text-orange-700 border-2 border-orange-300 hover:bg-orange-200 transition" id="btn-left">Bên trái nặng hơn</button>
                <button class="choose-btn px-6 py-3 rounded-xl bg-orange-100 font-bold text-lg text-orange-700 border-2 border-orange-300 hover:bg-orange-200 transition" id="btn-equal">Hai bên bằng nhau</button>
                <button class="choose-btn px-6 py-3 rounded-xl bg-orange-100 font-bold text-lg text-orange-700 border-2 border-orange-300 hover:bg-orange-200 transition" id="btn-right">Bên phải nặng hơn</button>
            </div>
            <button id="next-btn" class="hidden mt-6 px-8 py-3 bg-gradient-to-r from-orange-400 to-yellow-300 text-white rounded-xl text-lg font-bold shadow hover:from-yellow-300 hover:to-orange-400 transition-all">Câu hỏi tiếp theo</button>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        body {
            background: linear-gradient(135deg, #fffbe6 0%, #ffe0f7 100%);
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
        }

        .fruit-weighing-bg {
            background: linear-gradient(135deg, #fffbe6 0%, #ffe0f7 100%);
        }

        .level-bar {
            width: 100%;
            background: #ffe0f7;
            border-radius: 1.2rem;
            height: 18px;
            margin-bottom: 1.2rem;
            box-shadow: 0 2px 8px 0 rgba(255, 152, 0, 0.08);
            overflow: hidden;
        }

        .level-bar-inner {
            height: 100%;
            background: linear-gradient(90deg, #ff9800 0%, #ffd54f 100%);
            border-radius: 1.2rem;
            transition: width 0.5s cubic-bezier(.4, 2, .6, 1);
        }

        .level-label {
            font-size: 1.1rem;
            font-weight: 700;
            color: #ff9800;
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
        }

        .choose-btn {
            min-width: 120px;
            box-shadow: 0 2px 8px 0 rgba(255, 152, 0, 0.08);
        }

        .choose-btn.selected {
            border-color: #ff9800;
            background: #ffe0b2;
            color: #d84315;
            transform: scale(1.06);
        }

        #next-btn {
            background: linear-gradient(90deg, #ff9800 0%, #ffd54f 100%);
            color: #fff;
            border: none;
            border-radius: 1.5rem;
            font-size: 1.2rem;
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
            font-weight: 700;
            box-shadow: 0 4px 16px 0 rgba(255, 152, 0, 0.18);
            transition: background 0.2s, transform 0.15s;
            outline: none;
        }

        #next-btn:hover, #next-btn:focus {
            background: linear-gradient(90deg, #ffd54f 0%, #ff9800 100%);
            transform: scale(1.05);
        }

        @media (max-width: 640px) {
            .w-full.max-w-xl {
                padding: 1.2rem !important;
            }

            .fruit-emoji {
                font-size: 2.2rem !important;
            }

            .choose-btn {
                font-size: 1rem;
                padding: 0.7rem 1.2rem;
            }
        }

        .swal2-popup.swal2-rounded {
            border-radius: 1.5rem !important;
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
            font-size: 1.1rem;
            box-shadow: 0 8px 32px 0 rgba(255, 152, 0, 0.10);
        }

        .swal2-title {
            color: #ff9800 !important;
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

        window.onload = function () {
            Swal.fire({
                title: 'Hướng dẫn',
                html: `<div style='font-size:1.15rem;line-height:1.6'><b>Chọn đáp án đúng</b> cho mỗi lần cân.<br>Quan sát cân và chọn bên nặng hơn, hoặc hai bên bằng nhau.<br>Hoàn thành tất cả level để trở thành "bậc thầy cân đo"!<br><br><span style='font-size:2rem;'>🍎🍊⚖️</span></div>`,
                icon: 'info',
                confirmButtonText: 'Bắt đầu chơi',
                customClass: {popup: 'swal2-popup swal2-rounded'}
            });
            renderQuestion();
        };

        function renderQuestion() {
            document.getElementById('level-label').innerHTML = `Level <span style='color:#e65100'>${level}</span> / ${maxLevel}`;
            document.getElementById('level-bar-inner').style.width = ((level - 1) / maxLevel * 100) + '%';
            const q = questions[level - 1];
            // Hiển thị trái/phải
            document.getElementById('left-emoji').textContent = getFruitEmoji(q.leftFruit.type);
            document.getElementById('right-emoji').textContent = getFruitEmoji(q.rightFruit.type);
            document.getElementById('left-weight').textContent = formatWeight(q.leftFruit.weight, q.units);
            document.getElementById('right-weight').textContent = formatWeight(q.rightFruit.weight, q.units);
            document.getElementById('question-title').innerHTML = 'Bên nào nặng hơn?';
            document.getElementById('left-plate').style.transform = 'translateY(0)';
            document.getElementById('right-plate').style.transform = 'translateY(0)';
            document.querySelectorAll('.choose-btn').forEach(btn => btn.classList.remove('selected'));
            document.getElementById('next-btn').classList.add('hidden');
        }

        function getFruitEmoji(type) {
            if (type === 'apple') return '🍎';
            if (type === 'orange') return '🍊';
            if (type === 'pear') return '🍐';
            if (type === 'watermelon') return '🍉';
            if (type === 'banana') return '🍌';
            return '❓';
        }

        function formatWeight(w, unit) {
            if (unit === 'kg' && w < 1) return (w * 1000) + 'g';
            if (unit === 'kg') return w + 'kg';
            return w + 'g';
        }

        // Xử lý chọn đáp án
        ['btn-left', 'btn-equal', 'btn-right'].forEach(id => {
            document.getElementById(id).onclick = function () {
                document.querySelectorAll('.choose-btn').forEach(btn => btn.classList.remove('selected'));
                this.classList.add('selected');
                checkAnswer(id);
            };
        });

        function checkAnswer(btnId) {
            const q = questions[level - 1];
            let answer = '';
            if (q.leftFruit.weight > q.rightFruit.weight) answer = 'btn-left';
            else if (q.leftFruit.weight < q.rightFruit.weight) answer = 'btn-right';
            else answer = 'btn-equal';
            // Hiệu ứng nghiêng cân
            const tilt = 18;
            if (answer === 'btn-left') {
                document.getElementById('left-plate').style.transform = `translateY(${tilt}px)`;
                document.getElementById('right-plate').style.transform = `translateY(-${tilt}px)`;
            } else if (answer === 'btn-right') {
                document.getElementById('left-plate').style.transform = `translateY(-${tilt}px)`;
                document.getElementById('right-plate').style.transform = `translateY(${tilt}px)`;
            } else {
                document.getElementById('left-plate').style.transform = 'translateY(0)';
                document.getElementById('right-plate').style.transform = 'translateY(0)';
            }
            // Thông báo
            if (btnId === answer) {
                if (level < maxLevel) {
                    Swal.fire({
                        icon: 'success',
                        title: `Level ${level} hoàn thành!`,
                        html: '<span style="font-size:1.2rem">Bạn đã chọn đúng!<br>Tiếp tục level tiếp theo nhé!</span>',
                        showConfirmButton: false,
                        timer: 1200,
                        timerProgressBar: true,
                        customClass: {popup: 'swal2-popup swal2-rounded'}
                    }).then(() => {
                        level++;
                        renderQuestion();
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: '🎉 Hoàn thành tất cả level! 🎉',
                        html: '<span style="font-size:1.2rem">Bạn đã trở thành bậc thầy cân đo!<br>👏👏👏</span>',
                        confirmButtonText: 'Chơi lại',
                        customClass: {popup: 'swal2-popup swal2-rounded'},
                        didOpen: () => {
                            confetti();
                        }
                    }).then(() => {
                        level = 1;
                        renderQuestion();
                    });
                }
                document.getElementById('next-btn').classList.remove('hidden');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Chưa đúng!',
                    html: '<span style="font-size:1.1rem">Hãy thử lại nhé!</span>',
                    showConfirmButton: false,
                    timer: 1200,
                    timerProgressBar: true,
                    customClass: {popup: 'swal2-popup swal2-rounded'}
                });
            }
        }

        document.getElementById('next-btn').onclick = function () {
            if (level < maxLevel) {
                level++;
                renderQuestion();
            } else {
                level = 1;
                renderQuestion();
            }
        };

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
