@extends('layouts.game')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-200 via-green-100 to-yellow-100 py-8">
        <div class="w-full max-w-xl bg-white/80 rounded-3xl shadow-xl p-8 flex flex-col items-center">
            <h1 class="text-4xl font-extrabold text-green-700 mb-2 flex items-center gap-2">
                <span>Dọn Vườn Tối Giản</span> <span class="text-3xl">🌱</span>
            </h1>
            <p class="text-lg text-gray-600 mb-6 text-center">Rèn luyện kỹ năng rút gọn phân số qua trò chơi trực quan, sinh động!</p>
            <div class="flex flex-col items-center w-full">
                <div class="mb-4 w-full flex flex-col items-center">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-base font-semibold text-blue-700 bg-blue-100 rounded px-3 py-1">Cấp độ <span id="level">1</span>/5</span>
                    </div>
                    <div class="text-xl font-bold text-pink-600">Rút gọn phân số: <span id="fraction">2/4</span></div>
                </div>
                <div class="w-full flex flex-col items-center mb-4">
                    <div class="mb-2 text-base text-gray-700 bg-yellow-50 border-l-4 border-yellow-400 px-4 py-2 rounded shadow">
                        <span class="font-semibold">Hướng dẫn:</span> Chọn các ô cây tương ứng hoặc chọn đáp án đúng bên dưới để rút gọn phân số!
                    </div>
                    <div id="garden-grid" class="grid gap-2 bg-green-50 rounded-xl shadow-inner p-4 transition-all duration-300"></div>
                </div>
                <div class="w-full flex flex-col items-center mb-4">
                    <div id="options-row" class="flex flex-wrap gap-4 justify-center w-full"></div>
                </div>
                <button id="resetBtn" class="mt-2 px-6 py-2 rounded-full bg-gradient-to-r from-green-400 to-blue-400 text-white font-bold shadow hover:scale-105 transition">Chơi lại từ đầu</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const QUESTIONS = @json(array_values($questions));
        let level = 1;
        let selectedCells = 0;

        function renderGame() {
            const q = QUESTIONS[level - 1];
            document.getElementById('level').textContent = level;
            document.getElementById('fraction').textContent = `${q.numerator}/${q.denominator}`;
            renderGrid(q);
            renderOptions(q);
        }

        function renderGrid(q) {
            const grid = document.getElementById('garden-grid');
            grid.innerHTML = '';
            grid.style.gridTemplateRows = `repeat(${q.gridRows}, minmax(0, 1fr))`;
            grid.style.gridTemplateColumns = `repeat(${q.gridCols}, minmax(0, 1fr))`;
            selectedCells = q.numerator;
            for (let i = 0; i < q.denominator; i++) {
                const cell = document.createElement('div');
                cell.className = `flex items-center justify-center text-3xl font-bold rounded-xl aspect-square w-14 h-14 cursor-pointer border-2 border-green-300 bg-white shadow transition-all duration-200 hover:scale-110 ${i < q.numerator ? 'bg-green-200 border-green-500 scale-105' : ''}`;
                cell.innerHTML = i < q.numerator ? '🌱' : '';
                cell.dataset.index = i;
                if (i < q.numerator) cell.classList.add('selected');
                cell.addEventListener('click', function () {
                    cell.classList.toggle('bg-green-200');
                    cell.classList.toggle('border-green-500');
                    cell.classList.toggle('scale-105');
                    cell.classList.toggle('selected');
                    if (cell.classList.contains('selected')) {
                        cell.innerHTML = '🌱';
                        selectedCells++;
                    } else {
                        cell.innerHTML = '';
                        selectedCells--;
                    }
                    checkGridSelection(q);
                });
                grid.appendChild(cell);
            }
        }

        function renderOptions(q) {
            let options = [
                [q.simplifiedNumerator, q.simplifiedDenominator],
                [q.numerator + 1, q.denominator],
                [q.numerator, q.denominator - 1],
                [q.simplifiedNumerator + 1, q.simplifiedDenominator]
            ];
            options = shuffle(options);
            const row = document.getElementById('options-row');
            row.innerHTML = '';
            options.forEach(opt => {
                const btn = document.createElement('button');
                btn.className = 'w-32 py-4 rounded-2xl bg-gradient-to-br from-pink-200 via-yellow-100 to-green-200 text-xl font-bold text-green-800 border-2 border-green-300 shadow-lg hover:from-green-200 hover:to-pink-100 hover:scale-105 transition fraction-option';
                btn.dataset.numerator = opt[0];
                btn.dataset.denominator = opt[1];
                btn.textContent = `${opt[0]}/${opt[1]}`;
                btn.addEventListener('click', function () {
                    checkAnswer(opt[0], opt[1], q);
                });
                row.appendChild(btn);
            });
        }

        function checkGridSelection(q) {
            if (selectedCells > 0 && selectedCells <= q.denominator) {
                const options = document.querySelectorAll('.fraction-option');
                options.forEach(option => {
                    const numerator = parseInt(option.dataset.numerator);
                    const denominator = parseInt(option.dataset.denominator);
                    if (selectedCells === numerator && q.denominator === denominator) {
                        checkAnswer(numerator, denominator, q);
                    }
                });
            }
        }

        function checkAnswer(numerator, denominator, q) {
            const correct = numerator === q.simplifiedNumerator && denominator === q.simplifiedDenominator;
            if (correct) {
                Swal.fire({
                    icon: 'success',
                    title: '🎉 Tuyệt vời!',
                    html: `<div class='text-lg'>Phân số <b>${numerator}/${denominator}</b> là dạng tối giản của <b>${q.numerator}/${q.denominator}</b></div>`,
                    showConfirmButton: false,
                    timer: 1800,
                    background: '#f0fff4',
                });
                if (level < QUESTIONS.length) {
                    setTimeout(() => {
                        level++;
                        renderGame();
                    }, 1800);
                } else {
                    setTimeout(() => {
                        Swal.fire({
                            icon: 'info',
                            title: 'Hoàn thành!',
                            html: '<div class="text-lg">Bạn đã hoàn thành tất cả các cấp độ! 🎊</div>',
                            confirmButtonText: 'Chơi lại',
                            background: '#f0f9ff',
                        }).then(() => {
                            level = 1;
                            renderGame();
                        });
                    }, 1800);
                }
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: '⚠️ Hãy thử lại!',
                    html: `<div class='text-lg'>Phân số <b>${numerator}/${denominator}</b> chưa phải là dạng tối giản.<br><hr><span class='text-base'>💡 Gợi ý: Tìm ước số chung lớn nhất của tử số và mẫu số.</span></div>`,
                    timer: 1800,
                    showConfirmButton: false,
                    background: '#fffbea',
                });
            }
        }

        function shuffle(array) {
            let currentIndex = array.length, randomIndex;
            while (currentIndex !== 0) {
                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex--;
                [array[currentIndex], array[randomIndex]] = [array[randomIndex], array[currentIndex]];
            }
            return array;
        }

        document.addEventListener('DOMContentLoaded', function () {
            renderGame();
            document.getElementById('resetBtn').addEventListener('click', function (e) {
                e.preventDefault();
                level = 1;
                renderGame();
            });
        });
    </script>
@endpush
