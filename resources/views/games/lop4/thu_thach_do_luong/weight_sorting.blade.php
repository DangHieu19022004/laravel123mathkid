@extends('layouts.game')

@section('title', 'Xếp Hàng Theo Khối Lượng')

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600">Xếp Hàng Theo Khối Lượng 📦</h1>
        <p class="text-lg mt-2">Kéo và thả các vật để xếp theo thứ tự khối lượng tăng dần</p>
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
    0% { transform: scale(1); }
    30% { transform: scale(1.12) translateY(-8px); }
    60% { transform: scale(0.98) translateY(2px); }
    100% { transform: scale(1); }
}
.shake {
    animation: shake 0.5s;
}
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-10px); }
    75% { transform: translateX(10px); }
}
.button, .bg-green-500, .bg-blue-500 {
    transition: all 0.18s cubic-bezier(.4,2,.55,.44);
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
    transform: translate(-50%,-50%) scale(0.95);
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
    transition: all 0.35s cubic-bezier(.4,2,.55,.44);
}
#message.show {
    opacity: 1;
    transform: translate(-50%,-50%) scale(1.05);
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
document.addEventListener('DOMContentLoaded', function() {
    const itemsContainer = document.getElementById('items-container');
    const sortedContainer = document.getElementById('sorted-container');
    const checkBtn = document.getElementById('check');
    const newGameBtn = document.getElementById('new-game');
    const messageEl = document.getElementById('message');

    // Danh sách các vật phẩm có thể có
    const items = [
        { name: '🍎 Táo', weight: 200, unit: 'g' },
        { name: '🥛 Hộp sữa', weight: 1, unit: 'kg' },
        { name: '🍚 Bao gạo', weight: 5, unit: 'kg' },
        { name: '🍊 Cam', weight: 150, unit: 'g' },
        { name: '🍐 Lê', weight: 180, unit: 'g' },
        { name: '🥥 Dừa', weight: 1.5, unit: 'kg' },
        { name: '📦 Thùng', weight: 2, unit: 'kg' },
        { name: '🍉 Dưa hấu', weight: 3, unit: 'kg' },
        { name: '🥔 Khoai tây', weight: 300, unit: 'g' },
        { name: '📚 Sách', weight: 500, unit: 'g' }
    ];

    let currentItems = [];
    let level = 1;
    let maxLevel = 3;

    function convertToGrams(weight, unit) {
        return unit === 'kg' ? weight * 1000 : weight;
    }

    function getLevelConfig(level) {
        if (level === 1) {
            return {
                num: 5,
                showWeight: true,
                hideWeight: [],
                itemsPool: items
            };
        } else if (level === 2) {
            // Vật gần khối lượng nhau
            return {
                num: 7,
                showWeight: true,
                hideWeight: [],
                itemsPool: [
                    { name: '🍎 Táo', weight: 200, unit: 'g' },
                    { name: '🍊 Cam', weight: 150, unit: 'g' },
                    { name: '🍐 Lê', weight: 180, unit: 'g' },
                    { name: '🥔 Khoai tây', weight: 300, unit: 'g' },
                    { name: '📚 Sách', weight: 500, unit: 'g' },
                    { name: '🥛 Hộp sữa', weight: 1, unit: 'kg' },
                    { name: '🥥 Dừa', weight: 1.5, unit: 'kg' }
                ]
            };
        } else {
            // Trộn đơn vị, ẩn khối lượng 2 vật
            return {
                num: 7,
                showWeight: true,
                hideWeight: [1, 4],
                itemsPool: [
                    { name: '🍎 Táo', weight: 200, unit: 'g' },
                    { name: '🍊 Cam', weight: 150, unit: 'g' },
                    { name: '🥔 Khoai tây', weight: 0.25, unit: 'kg' },
                    { name: '🥥 Dừa', weight: 1.5, unit: 'kg' },
                    { name: '📦 Thùng', weight: 2, unit: 'kg' },
                    { name: '🍉 Dưa hấu', weight: 3, unit: 'kg' },
                    { name: '🍚 Bao gạo', weight: 5, unit: 'kg' }
                ]
            };
        }
    }

    function generateGame() {
        const config = getLevelConfig(level);
        // Chọn ngẫu nhiên vật phẩm
        currentItems = [...config.itemsPool]
            .sort(() => Math.random() - 0.5)
            .slice(0, config.num);

        // Hiển thị các vật phẩm
        itemsContainer.innerHTML = currentItems.map((item, idx) => {
            let showWeight = config.showWeight && !config.hideWeight.includes(idx);
            return `
            <div class="item draggable cursor-pointer bg-white border-2 border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow mb-2"
                 data-weight="${convertToGrams(item.weight, item.unit)}">
                <div class="text-2xl mb-2">${item.name.split(' ')[0]}</div>
                <div class="text-sm font-bold">${showWeight ? (item.weight + ' ' + item.unit) : '???'}</div>
            </div>
            `;
        }).join('');

        // Xóa các vật phẩm đã xếp
        sortedContainer.innerHTML = '';

        // Khởi tạo click để chuyển vật xuống khu vực xếp hàng
        initClickToAdd();
        // Khởi tạo drag & drop trong khu vực xếp hàng
        initSortable();
        // Ẩn nút tiếp tục nếu có
        const nextBtn = document.getElementById('next-level');
        if (nextBtn) nextBtn.style.display = 'none';
    }

    function initClickToAdd() {
        const draggables = itemsContainer.querySelectorAll('.item');
        draggables.forEach(item => {
            item.onclick = function() {
                // Không cho thêm nếu đã đủ số lượng
                if (sortedContainer.children.length >= currentItems.length) return;
                // Clone node và thêm nút xóa
                const clone = item.cloneNode(true);
                clone.classList.remove('draggable');
                clone.classList.add('sortable-item');
                const removeBtn = document.createElement('button');
                removeBtn.innerHTML = '✖';
                removeBtn.className = 'remove-btn ml-2 text-red-500 text-lg font-bold hover:text-red-700';
                removeBtn.onclick = function(e) {
                    e.stopPropagation();
                    item.style.display = '';
                    clone.remove();
                };
                clone.appendChild(removeBtn);
                sortedContainer.appendChild(clone);
                item.style.display = 'none';
            };
        });
    }

    function initSortable() {
        let dragged = null;
        sortedContainer.addEventListener('dragstart', function(e) {
            if (e.target.classList.contains('sortable-item')) {
                dragged = e.target;
                setTimeout(() => dragged.classList.add('opacity-50'), 0);
            }
        });
        sortedContainer.addEventListener('dragend', function(e) {
            if (dragged) {
                dragged.classList.remove('opacity-50');
                dragged = null;
            }
        });
        sortedContainer.addEventListener('dragover', function(e) {
            e.preventDefault();
            const afterElement = getDragAfterElement(sortedContainer, e.clientY);
            if (afterElement == null) {
                sortedContainer.appendChild(dragged);
            } else {
                sortedContainer.insertBefore(dragged, afterElement);
            }
        });
        // Cho phép các item trong sortedContainer có thể drag
        sortedContainer.addEventListener('mousedown', function(e) {
            const item = e.target.closest('.sortable-item');
            if (item) {
                item.setAttribute('draggable', 'true');
            }
        });
        sortedContainer.addEventListener('mouseup', function(e) {
            const item = e.target.closest('.sortable-item');
            if (item) {
                item.removeAttribute('draggable');
            }
        });
    }

    // Sửa lại getDragAfterElement cho sortedContainer
    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('.sortable-item:not(.opacity-50)')];
        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }

    // Sửa lại checkOrder để lấy đúng data-weight từ sortedContainer
    function checkOrder() {
        const items = [...sortedContainer.querySelectorAll('.sortable-item')];
        if (items.length < currentItems.length) {
            showMessage('Hãy xếp tất cả các vật vào khu vực xếp hàng!', false, '🤔');
            sortedContainer.classList.add('shake');
            setTimeout(() => sortedContainer.classList.remove('shake'), 500);
            return;
        }
        // Lấy thứ tự đúng (theo khối lượng tăng dần)
        const sortedByWeight = [...currentItems]
            .map(item => ({...item, gram: convertToGrams(item.weight, item.unit)}))
            .sort((a, b) => a.gram - b.gram);
        // Lấy thứ tự người chơi kéo vào
        const userOrder = items.map(item => parseInt(item.dataset.weight));
        // Lấy thứ tự đúng
        const correctOrder = sortedByWeight.map(item => item.gram);
        // So sánh từng vị trí
        const isCorrect = userOrder.every((w, i) => w === correctOrder[i]);
        if (isCorrect) {
            showMessage('Đúng rồi! Bạn đã xếp đúng thứ tự! 🎉', true, '🎉');
            items.forEach((item, index) => {
                setTimeout(() => {
                    item.classList.add('border-green-500');
                }, index * 120);
            });
        } else {
            showMessage('Chưa đúng, hãy thử lại! 😅', false, '😅');
            sortedContainer.classList.add('shake');
            setTimeout(() => sortedContainer.classList.remove('shake'), 500);
        }
    }

    function showMessage(text, isCorrect, icon) {
        messageEl.innerHTML = `<span class='icon'>${icon || (isCorrect ? '🎉' : '😅')}</span> <span>${text}</span>`;
        messageEl.className = `show ${isCorrect ? 'correct' : 'incorrect'}`;
        if (isCorrect && level < maxLevel) {
            setTimeout(() => {
                showNextLevelBtn();
            }, 1200);
        }
        setTimeout(() => {
            messageEl.className = '';
        }, 2200);
    }

    function showNextLevelBtn() {
        let btn = document.getElementById('next-level');
        if (!btn) {
            btn = document.createElement('button');
            btn.id = 'next-level';
            btn.className = 'bg-blue-500 text-white px-8 py-3 rounded-lg text-lg font-bold hover:bg-blue-600 mt-6';
            btn.innerText = 'Tiếp tục ▶';
            btn.onclick = function() {
                level++;
                generateGame();
            };
            sortedContainer.parentElement.appendChild(btn);
        }
        btn.style.display = '';
    }

    checkBtn.addEventListener('click', checkOrder);
    newGameBtn.addEventListener('click', generateGame);
    generateGame();
});
</script>
@endsection 