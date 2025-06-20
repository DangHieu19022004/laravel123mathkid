@extends('layouts.game')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-600">Xếp Hàng Theo Khối Lượng 📦</h1>
            <p class="text-lg mt-2">Kéo và thả các vật để xếp theo thứ tự khối lượng tăng dần</p>
        </div>

        <div class="max-w-2xl mx-auto mb-8">
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded shadow text-gray-700">
                <div class="font-bold text-yellow-700 mb-1 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-500 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"/>
                    </svg>
                    Hướng dẫn chơi
                </div>
                <ul class="list-disc pl-5 text-base">
                    <li><b>Mục tiêu:</b> Xếp các vật theo thứ tự khối lượng tăng dần (từ nhẹ nhất đến nặng nhất).</li>
                    <li>
                        <b>Kéo/thả:</b> Nhấn vào vật ở trên để đưa xuống khu vực xếp hàng bên dưới. Có thể kéo thả để thay đổi vị trí các vật đã chọn.
                    </li>
                    <li><b>Xóa vật:</b> Nhấn nút
                        <span class="inline-block text-red-500 font-bold">✖</span> trên vật đã chọn để bỏ vật đó khỏi khu vực xếp hàng.
                    </li>
                    <li><b>Kiểm tra:</b> Sau khi xếp đủ số vật, nhấn
                        <span class="inline-block bg-green-500 text-white px-2 py-1 rounded">Kiểm tra</span> để xem kết quả.
                    </li>
                    <li><b>Chuyển màn:</b> Nếu đúng, nhấn
                        <span class="inline-block bg-blue-500 text-white px-2 py-1 rounded">Tiếp tục ▶</span> để sang màn tiếp theo.
                    </li>
                    <li><b>Chơi lại:</b> Nhấn
                        <span class="inline-block bg-blue-500 text-white px-2 py-1 rounded">Chơi lại</span> để làm lại từ đầu.
                    </li>
                </ul>
            </div>
        </div>

        <div class="max-w-3xl mx-auto">
            <!-- Khu vực xếp hàng -->
            <div id="sorting-area" class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <div class="flex flex-wrap gap-4 justify-center" id="items-container">
                    <!-- Items will be generated here -->
                </div>
            </div>

            <!-- Khu vực thả -->
            <div id="drop-area" class="min-h-[200px] bg-blue-50 rounded-xl p-6 mb-8">
                <div class="text-center text-gray-500 mb-4">Kéo các vật vào đây và xếp theo thứ tự tăng dần</div>
                <div class="flex flex-wrap gap-4 justify-center" id="sorted-container"></div>
            </div>

            <!-- Điều khiển -->
            <div class="flex justify-center gap-4">
                <button id="check" class="bg-green-500 text-white px-8 py-3 rounded-lg text-lg font-bold hover:bg-green-600">
                    Kiểm tra
                </button>
                <button id="new-game" class="bg-blue-500 text-white px-8 py-3 rounded-lg text-lg font-bold hover:bg-blue-600">
                    Chơi lại
                </button>
            </div>
        </div>

        <!-- Thông báo -->
        <div id="message" class="fixed top-4 right-4 p-4 rounded-lg text-white font-bold hidden"></div>
    </div>
@endsection

@section('styles')
    <style>
        .item.draggable {
            transition: box-shadow 0.2s, transform 0.2s;
            box-shadow: 0 2px 8px #60a5fa22;
            cursor: grab;
            user-select: none;
        }

        .item.draggable:active {
            transform: scale(1.08) rotate(-2deg);
            box-shadow: 0 8px 24px #38bdf822;
        }

        .item.draggable:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 24px #38bdf822;
        }

        .item.border-green-500 {
            border-color: #22c55e !important;
            background: #dcfce7;
            animation: bounce 0.5s;
        }

        @keyframes bounce {
            0% {
                transform: scale(1);
            }
            30% {
                transform: scale(1.12) translateY(-8px);
            }
            60% {
                transform: scale(0.98) translateY(2px);
            }
            100% {
                transform: scale(1);
            }
        }

        .shake {
            animation: shake 0.5s;
        }

        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            25% {
                transform: translateX(-10px);
            }
            75% {
                transform: translateX(10px);
            }
        }

        .button, .bg-green-500, .bg-blue-500 {
            transition: all 0.18s cubic-bezier(.4, 2, .55, .44);
            border-radius: 1.5rem;
            font-weight: 700;
            font-size: 1.15rem;
            box-shadow: 0 2px 8px #60a5fa22;
            outline: none;
        }

        .bg-green-500:hover, .bg-blue-500:hover {
            transform: scale(1.08) translateY(-2px);
            box-shadow: 0 8px 24px #4ade8033;
        }

        #message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.95);
            min-width: 260px;
            padding: 1.2rem 2rem 1.2rem 2.5rem;
            border-radius: 1.5rem;
            color: #fff;
            font-weight: bold;
            font-size: 1.2rem;
            opacity: 0;
            z-index: 50;
            box-shadow: 0 8px 32px #0002;
            display: flex;
            align-items: center;
            gap: 0.7em;
            pointer-events: none;
            transition: all 0.35s cubic-bezier(.4, 2, .55, .44);
        }

        #message.show {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1.05);
            pointer-events: auto;
        }

        #message.correct {
            background: linear-gradient(90deg, #4ade80 60%, #38bdf8 100%);
            box-shadow: 0 8px 32px #4ade8033;
        }

        #message.incorrect {
            background: linear-gradient(90deg, #f87171 60%, #fbbf24 100%);
            box-shadow: 0 8px 32px #f8717133;
            animation: shake 0.4s;
        }

        #message .icon {
            font-size: 2rem;
            margin-right: 0.5em;
        }

        .remove-btn {
            background: none;
            border: none;
            cursor: pointer;
            outline: none;
            position: absolute;
            top: 6px;
            right: 6px;
            padding: 0;
            line-height: 1;
        }

        .sortable-item {
            position: relative;
            transition: box-shadow 0.2s, transform 0.2s;
            box-shadow: 0 2px 8px #60a5fa22;
            cursor: grab;
            user-select: none;
            margin-bottom: 8px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Lấy danh sách câu hỏi từ controller
        const questions = @json($questions);

        let level = 0;
        let currentItems = [];

        function convertToGrams(value, unit) {
            return unit === 'kg' ? value * 1000 : value;
        }

        function shuffle(array) {
            return array.map(v => [Math.random(), v]).sort((a, b) => a[0] - b[0]).map(x => x[1]);
        }

        function renderGame() {
            const itemsContainer = document.getElementById('items-container');
            const sortedContainer = document.getElementById('sorted-container');
            itemsContainer.innerHTML = '';
            sortedContainer.innerHTML = '';
            const q = questions[level];
            currentItems = shuffle(q.map((item, idx) => ({...item, idx})));
            currentItems.forEach((item, idx) => {
                const div = document.createElement('div');
                div.className = 'item draggable cursor-pointer bg-white border-2 border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow mb-2';
                div.setAttribute('data-idx', item.idx);
                div.setAttribute('data-weight', convertToGrams(item.value, item.unit));
                div.innerHTML = `<div class="text-2xl mb-2">Vật ${idx + 1}</div><div class="text-sm font-bold">${item.value} ${item.unit}</div>`;
                div.onclick = function () {
                    if (sortedContainer.children.length >= currentItems.length) return;
                    const clone = div.cloneNode(true);
                    clone.classList.remove('draggable');
                    clone.classList.add('sortable-item');
                    const removeBtn = document.createElement('button');
                    removeBtn.innerHTML = '✖';
                    removeBtn.className = 'remove-btn ml-2 text-red-500 text-lg font-bold hover:text-red-700';
                    removeBtn.onclick = function (e) {
                        e.stopPropagation();
                        div.style.display = '';
                        clone.remove();
                    };
                    clone.appendChild(removeBtn);
                    sortedContainer.appendChild(clone);
                    div.style.display = 'none';
                };
                itemsContainer.appendChild(div);
            });
            initSortable();
        }

        function initSortable() {
            const sortedContainer = document.getElementById('sorted-container');
            let dragged = null;
            sortedContainer.addEventListener('dragstart', function (e) {
                if (e.target.classList.contains('sortable-item')) {
                    dragged = e.target;
                    setTimeout(() => dragged.classList.add('opacity-50'), 0);
                }
            });
            sortedContainer.addEventListener('dragend', function (e) {
                if (dragged) {
                    dragged.classList.remove('opacity-50');
                    dragged = null;
                }
            });
            sortedContainer.addEventListener('dragover', function (e) {
                e.preventDefault();
                const afterElement = getDragAfterElement(sortedContainer, e.clientY);
                if (afterElement == null) {
                    sortedContainer.appendChild(dragged);
                } else {
                    sortedContainer.insertBefore(dragged, afterElement);
                }
            });
            sortedContainer.addEventListener('mousedown', function (e) {
                const item = e.target.closest('.sortable-item');
                if (item) {
                    item.setAttribute('draggable', 'true');
                }
            });
            sortedContainer.addEventListener('mouseup', function (e) {
                const item = e.target.closest('.sortable-item');
                if (item) {
                    item.removeAttribute('draggable');
                }
            });
        }

        function getDragAfterElement(container, y) {
            const draggableElements = [...container.querySelectorAll('.sortable-item:not(.opacity-50)')];
            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;
                if (offset < 0 && offset > closest.offset) {
                    return {offset: offset, element: child};
                } else {
                    return closest;
                }
            }, {offset: Number.NEGATIVE_INFINITY}).element;
        }

        function checkOrder() {
            const sortedContainer = document.getElementById('sorted-container');
            const items = [...sortedContainer.querySelectorAll('.sortable-item')];
            if (items.length < currentItems.length) {
                Swal.fire({
                    icon: 'info',
                    title: 'Chưa đủ!',
                    text: 'Hãy xếp tất cả các vật vào khu vực xếp hàng!',
                    confirmButtonColor: '#2563eb'
                });
                sortedContainer.classList.add('shake');
                setTimeout(() => sortedContainer.classList.remove('shake'), 500);
                return;
            }
            // Lấy thứ tự đúng (theo khối lượng tăng dần)
            const q = questions[level];
            const sortedByWeight = q.map((item, idx) => ({...item, idx, gram: convertToGrams(item.value, item.unit)}))
                .sort((a, b) => a.gram - b.gram);
            const correctOrder = sortedByWeight.map(item => item.idx);
            const userOrder = items.map(item => parseInt(item.getAttribute('data-idx')));
            const isCorrect = userOrder.every((v, i) => v === correctOrder[i]);
            if (isCorrect) {
                Swal.fire({
                    icon: 'success',
                    title: 'Chính xác!',
                    text: level < questions.length - 1 ? 'Bạn đã xếp đúng thứ tự! Tiếp tục nào!' : 'Bạn đã hoàn thành tất cả các cấp độ!',
                    confirmButtonColor: '#22c55e',
                    showDenyButton: level < questions.length - 1,
                    denyButtonText: 'Tiếp tục ▶',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isDenied && level < questions.length - 1) {
                        level++;
                        renderGame();
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Chưa đúng!',
                    text: 'Hãy thử lại nhé!',
                    confirmButtonColor: '#f87171'
                });
                sortedContainer.classList.add('shake');
                setTimeout(() => sortedContainer.classList.remove('shake'), 500);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('check').onclick = checkOrder;
            document.getElementById('new-game').onclick = function () {
                level = 0;
                renderGame();
            };
            renderGame();
        });
    </script>
@endsection
