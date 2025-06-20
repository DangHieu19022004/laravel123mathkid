@extends('layouts.game')

@section('content')
    <div class="min-h-screen flex flex-col items-center bg-gradient-to-br from-blue-100 to-yellow-100 py-8">
        <div class="w-full max-w-2xl bg-white rounded-3xl shadow-2xl p-8 flex flex-col items-center">
            <h2 class="mb-4 text-3xl font-extrabold text-blue-600 tracking-tight text-center flex items-center gap-2">
                <span>So Sánh Thời Gian</span>
                <span class="text-4xl">⏰</span>
            </h2>
            <div class="mb-2 text-base font-semibold text-blue-700" id="level-label"></div>
            <div class="w-full bg-blue-100 rounded-xl h-4 mb-6 overflow-hidden">
                <div class="h-full bg-gradient-to-r from-blue-400 to-green-400 rounded-xl transition-all duration-500" id="progress-bar-inner"></div>
            </div>
            <div class="text-lg text-gray-700 mb-4 text-center">Kéo thả các khoảng thời gian bên dưới để sắp xếp
                <span class="font-semibold text-blue-700">từ ngắn đến dài</span>, sau đó nhấn <b>Kiểm tra</b>.
            </div>
            <div id="time-container" class="flex flex-col gap-4 w-full mb-8"></div>
            <button id="check" class="w-full py-3 rounded-xl text-lg font-bold bg-gradient-to-r from-blue-400 to-green-400 text-white shadow hover:from-green-400 hover:to-blue-400 transition mb-2">Kiểm tra</button>
            <button id="next-level" class="w-full py-3 rounded-xl text-lg font-bold bg-gradient-to-r from-green-400 to-blue-400 text-white shadow hover:from-blue-400 hover:to-green-400 transition mb-2 hidden">Tiếp tục ▶</button>
            <button id="reset-game" class="w-full py-3 rounded-xl text-lg font-bold bg-gradient-to-r from-yellow-400 to-pink-400 text-white shadow hover:from-pink-400 hover:to-yellow-400 transition mb-2 hidden">Chơi lại 🔄</button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const questions = @json($questions);
        let level = 1;
        let maxLevel = questions.length;

        const timeContainer = document.getElementById('time-container');
        const levelLabel = document.getElementById('level-label');
        const progressBarInner = document.getElementById('progress-bar-inner');
        const checkBtn = document.getElementById('check');
        const nextBtn = document.getElementById('next-level');
        const resetBtn = document.getElementById('reset-game');

        function renderLevel() {
            levelLabel.textContent = `Câu ${level} / ${maxLevel}`;
            progressBarInner.style.width = ((level - 1) / (maxLevel - 1) * 100) + '%';
            renderTimes(questions[level - 1].times);
            nextBtn.classList.add('hidden');
            resetBtn.classList.add('hidden');
            checkBtn.disabled = false;
        }

        function renderTimes(times) {
            timeContainer.innerHTML = times.map((time, idx) => `
        <div class=\"bg-blue-50 p-4 rounded-xl cursor-move shadow hover:shadow-lg transition border-2 border-transparent hover:border-blue-400 flex items-center gap-3 drag-item\" draggable=\"true\" data-index=\"${idx}\">\n            <svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-7 w-7 text-blue-400 flex-shrink-0\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z\" /></svg>\n            <p class=\"text-lg text-center flex-1\">${time.hours} giờ ${time.minutes} phút</p>\n        </div>
    `).join('');
            addDragEvents();
        }

        function addDragEvents() {
            const items = timeContainer.getElementsByClassName('drag-item');
            let draggedItem = null;
            for (let item of items) {
                item.addEventListener('dragstart', function () {
                    draggedItem = item;
                    setTimeout(() => item.classList.add('opacity-50', 'ring-4', 'ring-blue-300'), 0);
                });
                item.addEventListener('dragend', function () {
                    draggedItem = null;
                    item.classList.remove('opacity-50', 'ring-4', 'ring-blue-300');
                });
                item.addEventListener('dragover', function (e) {
                    e.preventDefault();
                    this.classList.add('ring-2', 'ring-blue-400');
                });
                item.addEventListener('dragleave', function (e) {
                    this.classList.remove('ring-2', 'ring-blue-400');
                });
                item.addEventListener('drop', function (e) {
                    e.preventDefault();
                    this.classList.remove('ring-2', 'ring-blue-400');
                    if (this !== draggedItem) {
                        let allItems = [...timeContainer.getElementsByClassName('drag-item')];
                        let draggedIndex = allItems.indexOf(draggedItem);
                        let droppedIndex = allItems.indexOf(this);
                        if (draggedIndex < droppedIndex) {
                            this.parentNode.insertBefore(draggedItem, this.nextSibling);
                        } else {
                            this.parentNode.insertBefore(draggedItem, this);
                        }
                    }
                });
            }
        }

        function checkAnswer() {
            const answer = [];
            const items = timeContainer.getElementsByClassName('drag-item');
            for (let item of items) {
                answer.push(parseInt(item.dataset.index));
            }
            // Tính tổng phút cho từng times
            const times = questions[level - 1].times;
            const userOrder = answer.map(idx => times[idx].hours * 60 + times[idx].minutes);
            const correctOrder = [...times].map(t => t.hours * 60 + t.minutes).sort((a, b) => a - b);
            const isCorrect = userOrder.every((val, i) => val === correctOrder[i]);
            checkBtn.disabled = true;
            if (isCorrect) {
                Swal.fire({
                    icon: 'success',
                    title: 'Chính xác!',
                    text: 'Thứ tự các khoảng thời gian đã đúng.',
                    timer: 1200,
                    showConfirmButton: false,
                    customClass: {popup: 'swal2-popup swal2-rounded'}
                });
                if (level < maxLevel) {
                    nextBtn.classList.remove('hidden');
                } else {
                    resetBtn.classList.remove('hidden');
                    Swal.fire({
                        icon: 'success',
                        title: 'Chúc mừng!',
                        text: 'Bạn đã hoàn thành tất cả các cấp độ!',
                        confirmButtonText: 'Chơi lại',
                        customClass: {popup: 'swal2-popup swal2-rounded'}
                    }).then(() => {
                        resetBtn.classList.remove('hidden');
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Sai rồi!',
                    text: 'Hãy thử sắp xếp lại.',
                    timer: 1200,
                    showConfirmButton: false,
                    customClass: {popup: 'swal2-popup swal2-rounded'}
                });
                checkBtn.disabled = false;
            }
        }

        checkBtn.addEventListener('click', checkAnswer);
        nextBtn.addEventListener('click', function () {
            if (level < maxLevel) {
                level++;
                renderLevel();
            }
        });
        resetBtn.addEventListener('click', function () {
            level = 1;
            renderLevel();
        });

        renderLevel();
    </script>
@endpush
