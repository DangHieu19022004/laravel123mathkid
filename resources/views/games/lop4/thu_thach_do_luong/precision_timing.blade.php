@extends('layouts.game')

@section('title', 'Bấm Giờ Chuẩn Không Cần Chỉnh')

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600">Bấm Giờ Chuẩn Không Cần Chỉnh ⏲️</h1>
        <p class="text-lg mt-2">Bấm nút "Bắt đầu" và sau đúng <span id="target-duration">10</span> giây bấm "Dừng"</p>
        <div class="mt-2 text-base text-gray-700">Màn chơi: <span id="level">1</span> / 5</div>
    </div>

    <div class="max-w-2xl mx-auto">
        <!-- SVG Đồng hồ -->
        <div class="flex justify-center mb-8">
            <svg id="clock" width="300" height="300" viewBox="0 0 300 300">
                <!-- Vòng ngoài -->
                <circle cx="150" cy="150" r="140" stroke="#e5e7eb" stroke-width="8" fill="#fff"/>
                <!-- Vạch chia -->
                <g id="ticks"></g>
                <!-- Kim giây -->
                <line id="second-hand" x1="150" y1="150" x2="150" y2="40" stroke="red" stroke-width="4" stroke-linecap="round"/>
                <!-- Chấm giữa -->
                <circle cx="150" cy="150" r="8" fill="#222"/>
            </svg>
        </div>

        <!-- Điều khiển -->
        <div class="flex justify-center gap-4 mb-8 flex-wrap">
            <button id="start" class="bg-green-500 text-white px-8 py-3 rounded-lg text-lg font-bold hover:bg-green-600">
                Bắt đầu
            </button>
            <button id="stop" class="bg-red-500 text-white px-8 py-3 rounded-lg text-lg font-bold hover:bg-red-600" disabled>
                Dừng
            </button>
            <button id="next-level" class="bg-blue-500 text-white px-8 py-3 rounded-lg text-lg font-bold hover:bg-blue-600 hidden">
                Màn tiếp theo
            </button>
            <button id="reset-game" class="bg-yellow-500 text-white px-8 py-3 rounded-lg text-lg font-bold hover:bg-yellow-600">
                Chơi lại từ đầu
            </button>
            <a href="{{ route('games.lop4.dailuongvadoluong.index') }}" class="bg-gray-500 text-white px-8 py-3 rounded-lg text-lg font-bold hover:bg-gray-600 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại
            </a>
        </div>

        <!-- Kết quả -->
        <div id="result" class="text-center text-xl font-bold mb-8 hidden">
            <div class="mb-2">Thời gian của bạn: <span id="time-taken">0</span> giây</div>
            <div class="text-lg">Độ lệch: <span id="difference">0</span> giây</div>
        </div>

        <!-- Thành tích -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold mb-4 text-center">Thành tích của bạn</h3>
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

    <!-- Thông báo -->
    <div id="message" class="fixed top-4 right-4 p-4 rounded-lg text-white font-bold hidden"></div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Các màn chơi với độ khó tăng dần
    const levels = [
        { target: 10, allowedError: 0.5 },
        { target: 20, allowedError: 0.5 },
        { target: 30, allowedError: 0.7 },
        { target: 45, allowedError: 1 },
        { target: 60, allowedError: 1 }
    ];
    let currentLevel = parseInt(localStorage.getItem('precisionTimingLevel') || '0');
    const totalLevels = levels.length;

    const startBtn = document.getElementById('start');
    const stopBtn = document.getElementById('stop');
    const nextLevelBtn = document.getElementById('next-level');
    const resetGameBtn = document.getElementById('reset-game');
    const resultDiv = document.getElementById('result');
    const timeTakenSpan = document.getElementById('time-taken');
    const differenceSpan = document.getElementById('difference');
    const bestScoreSpan = document.getElementById('best-score');
    const attemptsSpan = document.getElementById('attempts');
    const messageEl = document.getElementById('message');
    const secondHand = document.getElementById('second-hand');
    const ticksGroup = document.getElementById('ticks');
    const targetDurationSpan = document.getElementById('target-duration');
    const levelSpan = document.getElementById('level');

    // Vẽ vạch chia trên đồng hồ SVG
    if (ticksGroup.childNodes.length === 0) {
        for (let i = 0; i < 60; i++) {
            const tick = document.createElementNS('http://www.w3.org/2000/svg', 'line');
            const angle = (i * 6) * Math.PI / 180;
            const r1 = 130, r2 = i % 5 === 0 ? 120 : 125;
            const x1 = 150 + r1 * Math.sin(angle);
            const y1 = 150 - r1 * Math.cos(angle);
            const x2 = 150 + r2 * Math.sin(angle);
            const y2 = 150 - r2 * Math.cos(angle);
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
        targetDurationSpan.textContent = levels[currentLevel].target;
        levelSpan.textContent = currentLevel + 1;
        // Reset kim giây
        secondHand.setAttribute('transform', 'rotate(0 150 150)');
        resultDiv.classList.add('hidden');
        startBtn.disabled = false;
        stopBtn.disabled = true;
        nextLevelBtn.classList.add('hidden');
        showMessage(`Màn ${currentLevel + 1}: Bấm đúng ${levels[currentLevel].target} giây!`, 'bg-blue-500');
    }

    function updateSecondHand() {
        if (!startTime) return;
        const elapsed = (Date.now() - startTime) / 1000;
        const degrees = ((elapsed % 60) * 6);
        secondHand.setAttribute('transform', `rotate(${degrees} 150 150)`);
    }

    function startTimer() {
        startTime = Date.now();
        startBtn.disabled = true;
        stopBtn.disabled = false;
        resultDiv.classList.add('hidden');
        timerInterval = setInterval(updateSecondHand, 100);
        showMessage(`Đếm ${levels[currentLevel].target} giây trong đầu và bấm Dừng!`, 'bg-blue-500');
    }

    function stopTimer() {
        const endTime = Date.now();
        const timeTaken = (endTime - startTime) / 1000;
        const difference = Math.abs(timeTaken - levels[currentLevel].target);
        clearInterval(timerInterval);
        startBtn.disabled = false;
        stopBtn.disabled = true;
        attempts++;
        // Cập nhật kết quả
        timeTakenSpan.textContent = timeTaken.toFixed(2);
        differenceSpan.textContent = difference.toFixed(2);
        attemptsSpan.textContent = attempts;
        resultDiv.classList.remove('hidden');
        // Cập nhật thành tích tốt nhất
        if (difference < bestScore) {
            bestScore = difference;
            bestScoreSpan.textContent = difference.toFixed(2) + 's';
        }
        // Hiển thị thông báo dựa trên độ chính xác
        if (difference <= levels[currentLevel].allowedError) {
            showMessage('🎉 Chính xác! Bạn đã qua màn này!', 'bg-green-500');
            if (currentLevel < totalLevels - 1) {
                nextLevelBtn.classList.remove('hidden');
            } else {
                showMessage('🏆 Chúc mừng! Bạn đã hoàn thành tất cả màn chơi!', 'bg-green-600');
            }
        } else {
            showMessage('⏳ Chưa chuẩn lắm, thử lại nhé!\nMẹo: Hãy đếm nhịp đều "một, hai, ba..." hoặc thử công thức: Thời gian = Số lần đếm x 1 giây!', 'bg-yellow-500');
        }
        // Reset kim giây về vị trí 0
        secondHand.setAttribute('transform', 'rotate(0 150 150)');
    }

    function showMessage(text, className) {
        messageEl.textContent = text;
        messageEl.className = `fixed top-4 right-4 p-4 rounded-lg text-white font-bold ${className}`;
        messageEl.classList.remove('hidden');
        setTimeout(() => {
            if (!messageEl.classList.contains('hidden')) {
                messageEl.classList.add('hidden');
            }
        }, 3000);
    }

    startBtn.addEventListener('click', startTimer);
    stopBtn.addEventListener('click', stopTimer);
    nextLevelBtn.addEventListener('click', function() {
        if (currentLevel < totalLevels - 1) {
            currentLevel++;
            localStorage.setItem('precisionTimingLevel', currentLevel);
            setLevel(currentLevel);
        }
    });
    resetGameBtn.addEventListener('click', function() {
        currentLevel = 0;
        localStorage.removeItem('precisionTimingLevel');
        attempts = 0;
        bestScore = Infinity;
        bestScoreSpan.textContent = '-';
        attemptsSpan.textContent = '0';
        setLevel(currentLevel);
    });

    // Khởi tạo màn đầu tiên
    setLevel(currentLevel);
});
</script>
@endsection 