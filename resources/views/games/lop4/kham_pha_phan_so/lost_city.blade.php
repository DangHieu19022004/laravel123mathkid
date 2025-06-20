@extends('layouts.game')

@section('content')
    <div class="min-h-screen flex flex-col items-center bg-gradient-to-br from-blue-100 via-yellow-50 to-green-100 py-8">
        <div class="w-full max-w-2xl bg-white/90 rounded-3xl shadow-xl p-8 flex flex-col items-center">
            <h1 class="text-4xl font-extrabold text-blue-700 mb-2 flex items-center gap-2">
                <span>Thành Phố Bị Lạc</span> <span class="text-3xl">🏙️</span>
            </h1>
            <p class="text-lg text-gray-600 mb-6 text-center">Điền số thích hợp vào chỗ trống để hoàn thiện các tên đường!</p>

            <div class="w-full flex flex-row items-center justify-between my-4 gap-4">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-pink-400 via-yellow-300 to-green-400 text-white font-bold text-lg shadow animate-bounce-slow">
                        <span class="mr-2">Cấp độ</span>
                        <span id="current-level" class="text-2xl font-extrabold drop-shadow">1</span>
                        <span class="mx-1 text-lg font-bold">/5</span>
                        <span class="ml-1">🎯</span>
                    </span>
                </div>
                <div class="flex-1 flex items-center">
                    <div class="relative w-full h-5 bg-gray-200 rounded-full overflow-hidden shadow">
                        <div id="progress-bar" class="absolute left-0 top-0 h-5 bg-gradient-to-r from-blue-400 via-green-300 to-yellow-300 rounded-full animate-progress-stripes transition-all duration-700" style="width: 0%"></div>
                        <div class="absolute inset-0 flex items-center justify-center text-xs font-bold text-gray-500">Tiến trình</div>
                    </div>
                </div>
            </div>

            <div class="mb-4 w-full flex flex-col items-center">
                <div class="w-full flex flex-col gap-4" id="city-map"></div>
            </div>

            <div class="w-full flex flex-col items-center mb-4">
                <div class="flex gap-4 w-full justify-center">
                    <button id="check-answer" class="px-7 py-3 rounded-full bg-gradient-to-r from-green-400 via-lime-400 to-blue-400 text-white font-extrabold shadow-lg text-lg flex items-center gap-2 transition-all duration-200 hover:scale-110 hover:from-green-500 hover:to-blue-500 focus:ring-4 focus:ring-green-200 active:scale-95 ">
                        <span>✅</span> <span>Kiểm tra</span>
                    </button>
                    <button id="next-level" class="px-7 py-3 rounded-full bg-gradient-to-r from-pink-400 via-yellow-300 to-orange-400 text-white font-extrabold shadow-lg text-lg flex items-center gap-2 transition-all duration-200 hover:scale-110 hover:from-pink-500 hover:to-orange-500 focus:ring-4 focus:ring-pink-200 active:scale-95 hidden ">
                        <span>➡️</span> <span>Tiếp theo</span>
                    </button>
                    <button id="resetBtn" class="px-7 py-3 rounded-full bg-gradient-to-r from-blue-200 via-purple-200 to-pink-200 text-blue-700 font-extrabold shadow-lg text-lg flex items-center gap-2 transition-all duration-200 hover:scale-110 hover:from-blue-300 hover:to-pink-300 focus:ring-4 focus:ring-blue-100 active:scale-95">
                        <span>🔄</span> <span>Chơi lại từ đầu</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Tạo lại logic sinh câu hỏi và lưu tiến trình ở client
        const LEVELS = 5;
        let level = parseInt(localStorage.getItem('lostCityLevel') || '1');
        let question = null;

        function generateLostCityQuestion(level) {
            const ranges = [
                {min: 2, max: 10}, {min: 10, max: 20}, {min: 20, max: 50}, {min: 30, max: 100}, {min: 50, max: 200}
            ];
            const range = ranges[level - 1];
            const streets = [];
            for (let i = 0; i < 3; i++) {
                let total, divisor, result;
                do {
                    total = rand(range.min, range.max);
                    let divisors = [];
                    for (let d = 2; d <= Math.min(12, total); d++) {
                        if (total % d === 0) divisors.push(d);
                    }
                    if (divisors.length) {
                        divisor = divisors[Math.floor(Math.random() * divisors.length)];
                        result = total / divisor;
                        if (result >= 2 && result <= (range.max / 2)) break;
                    }
                } while (true);
                const questionTypes = [
                    {desc: `Một phần ___ của ${total} là ${result}`, hint: `${result} = ${total} ÷ ___`},
                    {desc: `Khi chia ${total} cho ___ thì được ${result}`, hint: `${total} ÷ ___ = ${result}`},
                    {desc: `Số ___ là số chia khi chia ${total} được ${result}`, hint: `${total} ÷ ___ = ${result}`}
                ];
                let qType = level <= 2 ? questionTypes[0] : (level <= 4 ? questionTypes[1] : questionTypes[2]);
                const streetNames = [
                    {name: 'Đường Phân Số', icon: '🔢'}, {name: 'Phố Toán Học', icon: '📐'}, {
                        name: 'Ngõ Số Học',
                        icon: '📏'
                    },
                    {name: 'Đường Tính Toán', icon: '➗'}, {name: 'Phố Chia Số', icon: '✖️'}, {
                        name: 'Ngõ Phép Tính',
                        icon: '➕'
                    },
                    {name: 'Đường Số Học', icon: '📊'}, {name: 'Phố Toán Tư Duy', icon: '🎯'}, {
                        name: 'Ngõ Suy Luận',
                        icon: '🎲'
                    }
                ];
                const streetName = streetNames[Math.floor(Math.random() * streetNames.length)];
                streets.push({
                    id: i + 1,
                    name: streetName.name + ' ' + streetName.icon,
                    description: qType.desc,
                    answer: String(divisor),
                    hint: qType.hint
                });
            }
            return {
                level,
                streets,
                hint: [
                    'Hãy tìm số chia để có kết quả đúng',
                    'Thử chia số lớn cho số nhỏ hơn',
                    'Tìm số chia phù hợp để được kết quả',
                    'Suy luận từ kết quả để tìm số chia',
                    'Vận dụng kỹ năng tính toán nâng cao'
                ][level - 1]
            };
        }

        function rand(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        function renderGame() {
            question = generateLostCityQuestion(level);
            document.getElementById('current-level').textContent = level;
            // Progress bar
            document.getElementById('progress-bar').style.width = ((level - 1) * 100 / (LEVELS - 1)) + '%';
            // Render streets
            const cityMap = document.getElementById('city-map');
            cityMap.innerHTML = '';
            question.streets.forEach((street, idx) => {
                const div = document.createElement('div');
                div.className = 'flex flex-col md:flex-row items-center gap-4 bg-blue-50 border-l-4 border-blue-300 rounded-xl p-4 shadow';
                div.innerHTML = `
            <div class="flex-1 flex flex-col items-start">
                <div class="text-lg font-bold text-blue-700 flex items-center gap-2 mb-1">${street.name}</div>
                <div class="text-base text-gray-700 mb-2">${street.description}</div>
                <div class="flex gap-2 items-center w-full">
                    <input type="number" class="street-input w-max px-3 py-2 rounded border border-blue-300 focus:ring-2 focus:ring-blue-400 outline-none text-lg font-semibold" data-id="${street.id}" placeholder="Điền số">
                    <button type="button" class="hint-btn px-3 py-2 rounded bg-yellow-200 text-yellow-900 font-bold hover:bg-yellow-300 transition" data-hint="${street.hint}">💡 Gợi ý</button>
                </div>
            </div>
        `;
                cityMap.appendChild(div);
            });
            // Reset buttons
            document.getElementById('check-answer').classList.remove('hidden');
            document.getElementById('next-level').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            renderGame();
            // Hint
            document.getElementById('city-map').addEventListener('click', function (e) {
                if (e.target.classList.contains('hint-btn')) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Gợi ý',
                        text: e.target.dataset.hint,
                        background: '#fffbea',
                    });
                }
            });
            // Check answer
            document.getElementById('check-answer').addEventListener('click', function () {
                const answers = {};
                document.querySelectorAll('.street-input').forEach((input, idx) => {
                    answers[idx] = input.value.trim();
                });
                let correct = true;
                question.streets.forEach((street, idx) => {
                    if (answers[idx] !== street.answer) correct = false;
                });
                if (correct) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Chính xác!',
                        text: 'Bạn đã tìm đúng tất cả các con số!',
                        background: '#f0fff4',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        if (level < LEVELS) {
                            document.getElementById('check-answer').classList.add('hidden');
                            document.getElementById('next-level').classList.remove('hidden');
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Chúc mừng!',
                                text: 'Bạn đã hoàn thành tất cả các cấp độ!',
                                confirmButtonText: 'Chơi lại',
                                background: '#f0f9ff',
                            }).then(() => {
                                level = 1;
                                localStorage.setItem('lostCityLevel', '1');
                                renderGame();
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Chưa đúng!',
                        text: 'Hãy thử lại nhé!',
                        background: '#fffbea',
                    });
                }
            });
            // Next level
            document.getElementById('next-level').addEventListener('click', function () {
                level++;
                localStorage.setItem('lostCityLevel', String(level));
                renderGame();
            });
            // Reset
            document.getElementById('resetBtn').addEventListener('click', function (e) {
                e.preventDefault();
                level = 1;
                localStorage.setItem('lostCityLevel', '1');
                renderGame();
            });
        });
    </script>
@endpush

@push('styles')
<style>
@keyframes progress-stripes {
  0% { background-position: 0 0; }
  100% { background-position: 40px 0; }
}
.animate-progress-stripes {
  background-image: repeating-linear-gradient(135deg,rgba(255,255,255,0.2) 0 10px,transparent 10px 20px);
  background-size: 40px 40px;
  animation: progress-stripes 1s linear infinite;
}
@keyframes bounce-slow {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-8px); }
}
.animate-bounce-slow {
  animation: bounce-slow 1.2s infinite;
}
</style>
@endpush
