@extends('layouts.game')

@section('content')
    <div class="min-h-screen flex flex-col items-center bg-gradient-to-br from-blue-100 to-yellow-100 py-8">
        <div class="w-full max-w-xl bg-white rounded-3xl shadow-2xl p-8 flex flex-col items-center">
            <h2 class="mb-2 text-3xl font-extrabold text-blue-600 tracking-tight text-center flex items-center gap-2">
                <span>Bấm Giờ Chuẩn Không Cần Chỉnh</span>
                <span class="text-4xl">⏲️</span>
            </h2>
            <div class="text-lg text-gray-700 mb-2">Bấm nút <b>Bắt đầu</b> và sau đúng
                <span id="target-duration">10</span> giây bấm <b>Dừng</b></div>
            <div class="mb-2 text-base font-semibold text-blue-700">Màn chơi: <span id="level">1</span> /
                <span id="total-levels">5</span></div>
            <div class="w-full bg-blue-100 rounded-xl h-4 mb-6 overflow-hidden">
                <div class="h-full bg-gradient-to-r from-blue-400 to-green-400 rounded-xl transition-all duration-500" id="progress-bar-inner"></div>
            </div>
            <div class="flex justify-center mb-8 w-full">
                <svg id="clock" width="220" height="220" viewBox="0 0 220 220">
                    <circle cx="110" cy="110" r="100" stroke="#e5e7eb" stroke-width="8" fill="#fff"/>
                    <g id="ticks"></g>
                    <line id="second-hand" x1="110" y1="110" x2="110" y2="30" stroke="red" stroke-width="4" stroke-linecap="round"/>
                    <circle cx="110" cy="110" r="8" fill="#222"/>
                </svg>
            </div>
            <div class="flex flex-wrap gap-4 justify-center w-full mb-6">
                <button id="start" class="px-8 py-3 rounded-xl text-lg font-bold bg-green-500 text-white shadow hover:bg-green-600 transition">Bắt đầu</button>
                <button id="stop" class="px-8 py-3 rounded-xl text-lg font-bold bg-red-500 text-white shadow hover:bg-red-600 transition" disabled>Dừng</button>
                <button id="next-level" class="px-8 py-3 rounded-xl text-lg font-bold bg-blue-500 text-white shadow hover:bg-blue-600 transition hidden">Màn tiếp theo</button>
                <button id="reset-game" class="px-8 py-3 rounded-xl text-lg font-bold bg-yellow-400 text-white shadow hover:bg-yellow-500 transition">Chơi lại từ đầu</button>
            </div>
            <div class="w-full max-w-md bg-blue-50 rounded-xl shadow p-6 mb-4 text-center" id="result" style="display:none;">
                <div class="mb-2 text-lg font-semibold">Thời gian của bạn: <span id="time-taken">0</span> giây</div>
                <div class="text-base">Độ lệch: <span id="difference">0</span> giây</div>
            </div>
            <div class="w-full max-w-md bg-white rounded-xl shadow p-6">
                <h3 class="text-xl font-bold mb-4 text-center text-blue-700">Thành tích của bạn</h3>
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div>
                        <div class="text-sm text-gray-600">Lần chính xác nhất</div>
                        <div class="text-xl font-bold text-green-600" id="best-score">-</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600">Số lần thử</div>
                        <div class="text-xl font-bold" id="attempts">0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/js/sweetalert2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const questions = @json($questions);
            let currentLevel = 0;
            const totalLevels = questions.length;

            const startBtn = document.getElementById('start');
            const stopBtn = document.getElementById('stop');
            const nextLevelBtn = document.getElementById('next-level');
            const resetGameBtn = document.getElementById('reset-game');
            const resultDiv = document.getElementById('result');
            const timeTakenSpan = document.getElementById('time-taken');
            const differenceSpan = document.getElementById('difference');
            const bestScoreSpan = document.getElementById('best-score');
            const attemptsSpan = document.getElementById('attempts');
            const secondHand = document.getElementById('second-hand');
            const ticksGroup = document.getElementById('ticks');
            const targetDurationSpan = document.getElementById('target-duration');
            const levelSpan = document.getElementById('level');
            const totalLevelsSpan = document.getElementById('total-levels');
            const progressBarInner = document.getElementById('progress-bar-inner');

            totalLevelsSpan.textContent = totalLevels;

            if (ticksGroup.childNodes.length === 0) {
                for (let i = 0; i < 60; i++) {
                    const tick = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                    const angle = (i * 6) * Math.PI / 180;
                    const r1 = 92, r2 = i % 5 === 0 ? 80 : 86;
                    const x1 = 110 + r1 * Math.sin(angle);
                    const y1 = 110 - r1 * Math.cos(angle);
                    const x2 = 110 + r2 * Math.sin(angle);
                    const y2 = 110 - r2 * Math.cos(angle);
                    tick.setAttribute('x1', x1);
                    tick.setAttribute('y1', y1);
                    tick.setAttribute('x2', x2);
                    tick.setAttribute('y2', y2);
                    tick.setAttribute('stroke', '#bbb');
                    tick.setAttribute('stroke-width', i % 5 === 0 ? 3 : 1);
                    ticksGroup.appendChild(tick);
                }
            }

            let startTime = null;
            let timerInterval = null;
            let attempts = 0;
            let bestScore = Infinity;

            function setLevel(levelIdx) {
                currentLevel = levelIdx;
                targetDurationSpan.textContent = questions[currentLevel].target;
                levelSpan.textContent = currentLevel + 1;
                progressBarInner.style.width = ((currentLevel) / (totalLevels - 1) * 100) + '%';
                secondHand.setAttribute('transform', 'rotate(0 110 110)');
                resultDiv.style.display = 'none';
                startBtn.disabled = false;
                stopBtn.disabled = true;
                nextLevelBtn.classList.add('hidden');
                Swal.fire({
                    title: `Màn ${currentLevel + 1}`,
                    text: `Bấm đúng ${questions[currentLevel].target} giây!`,
                    icon: 'info',
                    timer: 1200,
                    showConfirmButton: false,
                    customClass: {popup: 'swal2-popup swal2-rounded'}
                });
            }

            function updateSecondHand() {
                if (!startTime) return;
                const elapsed = (Date.now() - startTime) / 1000;
                const degrees = ((elapsed % 60) * 6);
                secondHand.setAttribute('transform', `rotate(${degrees} 110 110)`);
            }

            function startTimer() {
                startTime = Date.now();
                startBtn.disabled = true;
                stopBtn.disabled = false;
                resultDiv.style.display = 'none';
                timerInterval = setInterval(updateSecondHand, 100);
                Swal.fire({
                    title: 'Đếm thời gian',
                    text: `Đếm ${questions[currentLevel].target} giây trong đầu và bấm Dừng!`,
                    icon: 'info',
                    timer: 1200,
                    showConfirmButton: false,
                    customClass: {popup: 'swal2-popup swal2-rounded'}
                });
            }

            function stopTimer() {
                const endTime = Date.now();
                const timeTaken = (endTime - startTime) / 1000;
                const difference = Math.abs(timeTaken - questions[currentLevel].target);
                clearInterval(timerInterval);
                startBtn.disabled = false;
                stopBtn.disabled = true;
                attempts++;
                timeTakenSpan.textContent = timeTaken.toFixed(2);
                differenceSpan.textContent = difference.toFixed(2);
                attemptsSpan.textContent = attempts;
                resultDiv.style.display = '';
                if (difference < bestScore) {
                    bestScore = difference;
                    bestScoreSpan.textContent = difference.toFixed(2) + 's';
                }
                if (difference <= questions[currentLevel].allowedError) {
                    Swal.fire({
                        title: '🎉 Chính xác!',
                        text: 'Bạn đã qua màn này!',
                        icon: 'success',
                        timer: 1200,
                        showConfirmButton: false,
                        customClass: {popup: 'swal2-popup swal2-rounded'}
                    });
                    if (currentLevel < totalLevels - 1) {
                        nextLevelBtn.classList.remove('hidden');
                    } else {
                        setTimeout(() => {
                            Swal.fire({
                                title: '🏆 Chúc mừng!',
                                text: 'Bạn đã hoàn thành tất cả màn chơi!',
                                icon: 'success',
                                confirmButtonText: 'Chơi lại',
                                customClass: {popup: 'swal2-popup swal2-rounded'}
                            }).then(() => {
                                currentLevel = 0;
                                attempts = 0;
                                bestScore = Infinity;
                                bestScoreSpan.textContent = '-';
                                attemptsSpan.textContent = '0';
                                setLevel(currentLevel);
                            });
                        }, 1200);
                    }
                } else {
                    Swal.fire({
                        title: '⏳ Chưa chuẩn lắm!',
                        html: 'Hãy thử lại nhé!<br><span class="text-base">Mẹo: Hãy đếm nhịp đều "một, hai, ba..." hoặc thử công thức: Thời gian = Số lần đếm x 1 giây!</span>',
                        icon: 'warning',
                        timer: 1800,
                        showConfirmButton: false,
                        customClass: {popup: 'swal2-popup swal2-rounded'}
                    });
                }
                secondHand.setAttribute('transform', 'rotate(0 110 110)');
            }

            startBtn.addEventListener('click', startTimer);
            stopBtn.addEventListener('click', stopTimer);
            nextLevelBtn.addEventListener('click', function () {
                if (currentLevel < totalLevels - 1) {
                    currentLevel++;
                    setLevel(currentLevel);
                }
            });
            resetGameBtn.addEventListener('click', function () {
                currentLevel = 0;
                attempts = 0;
                bestScore = Infinity;
                bestScoreSpan.textContent = '-';
                attemptsSpan.textContent = '0';
                setLevel(currentLevel);
            });

            setLevel(currentLevel);
        });
    </script>
@endpush
