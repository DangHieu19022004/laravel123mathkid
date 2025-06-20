@extends('layouts.game')

@section('content')
    <div class="font-nunito min-h-screen bg-gradient-to-br from-primary via-primary-light to-primary-dark py-8 px-4">
        <div id="game-container" class="game-container bg-white max-w-2xl rounded-3xl shadow-xl p-8">
            <!-- Header -->
            <div class="flex flex-col items-center justify-center text-center mb-4">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-2">
                    <circle cx="20" cy="20" r="18" fill="#FFD966" stroke="#F6C244" stroke-width="2"/>
                    <path d="M20 20 L20 2 A18 18 0 0 1 38 20 Z" fill="#F6C244"/>
                    <circle cx="20" cy="20" r="5" fill="#fff3"/>
                </svg>
                <h1 class="text-4xl md:text-5xl font-extrabold gradient-text drop-shadow-lg">Chia Đều Bánh</h1>
            </div>
            <div class="my-2 text-white bg-primary-dark/80 rounded-full px-6 py-2 shadow-lg w-fit mx-auto text-center">
                Cấp độ: <span id="level"></span> / 5
            </div>
            <!-- Game Area -->
            <main>
                <!-- Instructions -->
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg mb-4 max-w-xl mx-auto">
                    <div class="flex items-center justify-center gap-3">
                        <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#3B82F6" stroke-width="2" fill="#e0f2fe"/>
                            <rect x="11" y="10" width="2" height="6" rx="1" fill="#3B82F6"/>
                            <rect x="11" y="7" width="2" height="2" rx="1" fill="#3B82F6"/>
                        </svg>
                        <div>
                            <p class="font-bold">Hướng dẫn:</p>
                            <p class="text-sm">Quan sát, tính toán và điền kết quả vào ô trống nhé!</p>
                        </div>
                    </div>
                </div>

                <!-- Problem Statement -->
                <div id="problem-statement" class="text-center mb-4"></div>

                <!-- Visualization -->
                <div class="flex flex-col md:flex-row justify-center items-center space-y-8 md:space-y-0 md:space-x-8 mb-8">
                    <!-- Cake Visualization -->
                    <div class="text-center">
                        <h3 class="font-bold text-gray-600 mb-4 text-xl">Phần bánh hiện có</h3>
                        <div id="cake-visual" class="relative w-48 h-48 mx-auto"></div>
                    </div>
                    <!-- People Visualization -->
                    <div class="text-center">
                        <h3 class="font-bold text-gray-600 mb-4 text-xl">Số người được chia</h3>
                        <div id="people-visual" class="flex justify-center items-center flex-wrap gap-4"></div>
                    </div>
                </div>

                <!-- Answer Input Card -->
                <form id="answer-form" class="flex flex-col items-center gap-2 mb-3 animate-fade-in w-full max-w-xs md:max-w-md mx-auto mt-8">
                    <div class="bg-white rounded-2xl shadow-lg border border-blue-200 px-4 py-3 w-full flex flex-row items-center gap-3 justify-center">
                        <div class="flex flex-col items-center">
                            <label for="numerator" class="text-xs text-gray-500 font-semibold mb-1">Tử số</label>
                            <input type="number" id="numerator" class="w-16 md:w-20 px-2 py-2 rounded-lg border-2 border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-center font-bold text-lg bg-blue-50 shadow-sm transition-all duration-200 outline-none" placeholder="0" min="0" required autocomplete="off">
                        </div>
                        <span class="text-2xl font-bold text-blue-400 mx-1 select-none">/</span>
                        <div class="flex flex-col items-center">
                            <label for="denominator" class="text-xs text-gray-500 font-semibold mb-1">Mẫu số</label>
                            <input type="number" id="denominator" class="w-16 md:w-20 px-2 py-2 rounded-lg border-2 border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-center font-bold text-lg bg-blue-50 shadow-sm transition-all duration-200 outline-none" placeholder="1" min="1" required autocomplete="off">
                        </div>
                    </div>
                    <button type="submit" id="check-btn" class="w-full md:w-1/2 mt-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white font-bold rounded-full shadow transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400 flex items-center justify-center gap-2 text-base">
                        Kiểm tra
                    </button>
                </form>
            </main>

            <!-- Controls -->
            <footer class="text-center mt-8">
                <button id="reset-btn" class="btn-secondary">
                    Chơi lại từ đầu
                </button>
            </footer>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const questions = @json($questions);
        const TOTAL_LEVELS = questions.length;

        function getCurrentLevel() {
            return parseInt(localStorage.getItem('fair_share_level') || '1');
        }

        function setCurrentLevel(level) {
            localStorage.setItem('fair_share_level', level);
        }

        function resetProgress() {
            setCurrentLevel(1);
        }

        function renderLevel(level) {
            const q = questions[level - 1];
            document.getElementById('level').textContent = q.level;
            // Problem statement
            document.getElementById('problem-statement').innerHTML = `
        <p class="text-xl text-gray-700 leading-relaxed">
            Có một chiếc bánh
            <span class="font-bold text-indigo-600">${q.total.numerator}/${q.total.denominator}</span>,
            chia đều cho <span class="font-bold text-pink-500">${q.people}</span> bạn.<br>
            Mỗi bạn sẽ được bao nhiêu phần bánh?
        </p>
    `;
            // Cake visual (SVG)
            const cakeDiv = document.getElementById('cake-visual');
            cakeDiv.innerHTML = '';
            const cakeParts = q.visualization.cake_parts;
            const usedParts = q.visualization.used_parts;
            let svg = `<svg width="192" height="192" viewBox="0 0 192 192" xmlns="http://www.w3.org/2000/svg">`;
            for (let i = 0; i < cakeParts; i++) {
                const angle = (i * 360) / cakeParts;
                const nextAngle = ((i + 1) * 360) / cakeParts;
                const largeArc = (nextAngle - angle) > 180 ? 1 : 0;
                const r = 90, cx = 96, cy = 96;
                const x1 = cx + r * Math.cos((angle - 90) * Math.PI / 180);
                const y1 = cy + r * Math.sin((angle - 90) * Math.PI / 180);
                const x2 = cx + r * Math.cos((nextAngle - 90) * Math.PI / 180);
                const y2 = cy + r * Math.sin((nextAngle - 90) * Math.PI / 180);
                svg += `<path d="M${cx},${cy} L${x1},${y1} A${r},${r} 0 ${largeArc} 1 ${x2},${y2} Z" fill="${i < usedParts ? '#FFD966' : '#e5e7eb'}" stroke="#F6C244" stroke-width="2"/>`;
            }
            svg += `<circle cx="96" cy="96" r="30" fill="#fff6"/>`;
            svg += `</svg>`;
            cakeDiv.innerHTML = svg;
            // People visual (SVG)
            const peopleDiv = document.getElementById('people-visual');
            peopleDiv.innerHTML = '';
            for (let i = 0; i < q.people; i++) {
                peopleDiv.innerHTML += `<span><svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="24" cy="16" r="8" fill="#f472b6"/><ellipse cx="24" cy="36" rx="14" ry="10" fill="#fbcfe8"/><ellipse cx="24" cy="36" rx="8" ry="6" fill="#f472b6"/></svg></span>`;
            }
            document.getElementById('numerator').value = '';
            document.getElementById('denominator').value = '';
            document.getElementById('numerator').disabled = false;
            document.getElementById('denominator').disabled = false;
            document.getElementById('check-btn').disabled = false;
        }

        function showToast(msg, type = 'success') {
            // Simple toast, không dùng CDN
            let toast = document.createElement('div');
            toast.textContent = msg;
            toast.className = 'fixed top-8 left-1/2 transform -translate-x-1/2 px-6 py-3 rounded-xl font-nunito text-lg shadow-lg z-50 fade-in ' + (type === 'success' ? 'bg-green-400 text-white' : (type === 'error' ? 'bg-red-400 text-white' : 'bg-yellow-300 text-gray-800'));
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = 0;
                setTimeout(() => toast.remove(), 600);
            }, 1800);
        }

        function handleCorrect(level) {
            document.getElementById('check-btn').disabled = true;
            document.getElementById('numerator').disabled = true;
            document.getElementById('denominator').disabled = true;
            showToast('Chính xác! Tuyệt vời!', 'success');
            // Simple confetti effect (CSS/JS)
            for (let i = 0; i < 18; i++) {
                let conf = document.createElement('div');
                conf.className = 'confetti';
                conf.style.left = (50 + Math.random() * 40 - 20) + '%';
                conf.style.background = `hsl(${Math.random() * 360},80%,70%)`;
                conf.style.animationDelay = (Math.random() * 0.5) + 's';
                document.body.appendChild(conf);
                setTimeout(() => conf.remove(), 1200);
            }
            setTimeout(() => {
                if (level < TOTAL_LEVELS) {
                    setCurrentLevel(level + 1);
                    renderLevel(level + 1);
                } else {
                    setTimeout(() => {
                        if (confirm('Chúc mừng bạn đã vượt qua tất cả các cấp độ!\nBạn có muốn chơi lại không?')) {
                            resetProgress();
                            renderLevel(1);
                        }
                    }, 400);
                }
            }, 1200);
        }

        function handleIncorrect() {
            const form = document.getElementById('answer-form');
            form.classList.add('animate-shake');
            setTimeout(() => form.classList.remove('animate-shake'), 500);
            if (window.navigator.vibrate) window.navigator.vibrate(200);
            showToast('Chưa đúng rồi! Hãy thử lại nào!', 'error');
            document.getElementById('numerator').value = '';
            document.getElementById('denominator').value = '';
            document.getElementById('numerator').focus();
        }

        document.addEventListener('DOMContentLoaded', function () {
            let level = getCurrentLevel();
            if (level < 1 || level > TOTAL_LEVELS) level = 1;
            renderLevel(level);
            document.getElementById('answer-form').addEventListener('submit', function (e) {
                e.preventDefault();
                const q = questions[getCurrentLevel() - 1];
                const userNumerator = parseInt(document.getElementById('numerator').value);
                const userDenominator = parseInt(document.getElementById('denominator').value);
                if (isNaN(userNumerator) || isNaN(userDenominator)) {
                    showToast('Bạn vui lòng điền đầy đủ tử số và mẫu số nhé.', 'warning');
                    return;
                }
                // Kiểm tra tương đương phân số
                const isCorrect = userNumerator * q.answer.denominator === userDenominator * q.answer.numerator;
                if (isCorrect) {
                    handleCorrect(q.level);
                } else {
                    handleIncorrect();
                }
            });
            document.getElementById('reset-btn').addEventListener('click', function () {
                if (confirm('Bạn chắc chắn muốn chơi lại?')) {
                    resetProgress();
                    renderLevel(1);
                }
            });
            // Confetti CSS
            const style = document.createElement('style');
            style.innerHTML = `
    .confetti {
        position: fixed;
        top: 0;
        width: 12px;
        height: 18px;
        border-radius: 3px;
        opacity: 0.85;
        z-index: 9999;
        pointer-events: none;
        animation: confetti-fall 1.1s cubic-bezier(.6,.2,.4,1.1) forwards;
    }
    @keyframes confetti-fall {
        0% { transform: translateY(-40px) rotate(-10deg) scale(0.7); }
        80% { opacity: 1; }
        100% { transform: translateY(90vh) rotate(30deg) scale(1.1); opacity: 0; }
    }
    `;
            document.head.appendChild(style);
        });
    </script>
@endpush
