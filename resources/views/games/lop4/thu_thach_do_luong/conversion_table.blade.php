@extends('layouts.game')

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600">Điền Vào Bảng Quy Đổi 📋</h1>
        <p class="text-lg mt-2">Kéo các số đúng vào từng ô để hoàn thành bảng quy đổi đơn vị đo</p>
        <div class="mt-2 text-base text-gray-700">Cấp độ: <span id="level">1</span> / <span id="max-level">3</span></div>
    </div>
    <div class="flex flex-col items-center">
        <div class="overflow-x-auto w-full max-w-3xl mb-8">
            <table class="min-w-full bg-white rounded-xl shadow-lg" id="conversion-table">
                <!-- Bảng sẽ được render bằng JS -->
            </table>
        </div>
        <div class="flex flex-wrap gap-4 justify-center mb-8" id="draggables">
            <!-- Các số sẽ được render ở đây -->
        </div>
        <div class="flex flex-wrap gap-4 justify-center mb-4">
            <button id="check" class="px-8 py-3 bg-green-500 text-white rounded-lg text-lg font-bold hover:bg-green-600 transition-all">Kiểm tra</button>
            <button id="reset" class="px-8 py-3 bg-yellow-500 text-white rounded-lg text-lg font-bold hover:bg-yellow-600 transition-all">Chơi lại</button>
            <button id="next-level" class="px-8 py-3 bg-blue-500 text-white rounded-lg text-lg font-bold hover:bg-blue-600 transition-all hidden">Cấp độ tiếp theo</button>
        </div>
        <div id="message" class="mt-6 text-xl font-bold hidden"></div>
    </div>
</div>
@endsection

@section('styles')
<style>
.dropzone {
    min-height: 48px;
    min-width: 90px;
    border: 2px dashed #60a5fa;
    border-radius: 10px;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s, border-color 0.2s;
    cursor: pointer;
    font-size: 1.15rem;
    font-weight: 600;
    box-shadow: 0 2px 8px #60a5fa22;
    margin: 0 auto;
}
.dropzone.bg-blue-100 {
    background: #dbeafe;
    border-color: #2563eb;
}
.dropzone.bg-green-100 {
    background: #bbf7d0;
    border-color: #22c55e;
}
.dropzone.bg-red-100 {
    background: #fee2e2;
    border-color: #ef4444;
}
.draggable {
    user-select: none;
    -webkit-user-drag: element;
    z-index: 10;
    background: #bae6fd;
    box-shadow: 0 4px 16px #38bdf822;
    transition: box-shadow 0.2s, transform 0.2s, background 0.2s;
    font-size: 1.2rem;
    font-weight: bold;
    border-radius: 12px;
    padding: 0.8rem 2.2rem;
    cursor: grab;
    outline: none;
}
.draggable:active {
    transform: scale(1.08) rotate(-2deg);
    box-shadow: 0 8px 24px #38bdf822;
    background: #7dd3fc;
}
.draggable:hover {
    background: #38bdf8;
    color: #fff;
}
.dropped {
    pointer-events: auto;
    background: #38bdf8 !important;
    color: #fff !important;
    font-size: 1.2rem;
    border-radius: 10px;
    padding: 0.7rem 2rem;
    box-shadow: 0 2px 8px #38bdf822;
    cursor: grab;
}
#message {
    min-height: 2.5rem;
    transition: all 0.3s;
}
</style>
@endsection

@section('scripts')
<script>
// Các cấp độ bảng quy đổi
const levels = [
    // Level 1: 1 hàng, đơn vị mét
    {
        headers: ['Mét (m)', 'Decimét (dm)', 'Centimét (cm)', 'Milimét (mm)'],
        rows: [
            { m: 1, dm: 10, cm: 100, mm: 1000 }
        ],
        draggables: [10, 100, 1000, 20, 200, 2000]
    },
    // Level 2: 2 hàng, số lớn hơn
    {
        headers: ['Mét (m)', 'Decimét (dm)', 'Centimét (cm)', 'Milimét (mm)'],
        rows: [
            { m: 2.5, dm: 25, cm: 250, mm: 2500 },
            { m: 0.7, dm: 7, cm: 70, mm: 700 }
        ],
        draggables: [25, 250, 2500, 7, 70, 700, 2.5, 0.7, 5, 50, 500, 5000]
    },
    // Level 3: Đơn vị hỗn hợp
    {
        headers: ['Kilomét (km)', 'Mét (m)', 'Centimét (cm)', 'Milimét (mm)'],
        rows: [
            { km: 0.03, m: 30, cm: 3000, mm: 30000 },
            { km: 1.2, m: 1200, cm: 120000, mm: 1200000 }
        ],
        draggables: [0.03, 30, 3000, 30000, 1.2, 1200, 120000, 1200000, 0.3, 3, 300, 300000]
    },
    // Level 4: Đơn vị hỗn hợp, nhiều hàng hơn
    {
        headers: ['Kilomét (km)', 'Mét (m)', 'Decimét (dm)', 'Centimét (cm)', 'Milimét (mm)'],
        rows: [
            { km: 0.05, m: 50, dm: 500, cm: 5000, mm: 50000 },
            { km: 2.3, m: 2300, dm: 23000, cm: 230000, mm: 2300000 },
            { km: 0.8, m: 800, dm: 8000, cm: 80000, mm: 800000 }
        ],
        draggables: [0.05, 50, 500, 5000, 50000, 2.3, 2300, 23000, 230000, 2300000, 0.8, 800, 8000, 80000, 800000]
    },
    // Level 5: Đơn vị hỗn hợp, số thập phân, nhiều hàng
    {
        headers: ['Kilomét (km)', 'Mét (m)', 'Decimét (dm)', 'Centimét (cm)', 'Milimét (mm)'],
        rows: [
            { km: 0.12, m: 120, dm: 1200, cm: 12000, mm: 120000 },
            { km: 1.75, m: 1750, dm: 17500, cm: 175000, mm: 1750000 },
            { km: 0.6, m: 600, dm: 6000, cm: 60000, mm: 600000 },
            { km: 3.5, m: 3500, dm: 35000, cm: 350000, mm: 3500000 }
        ],
        draggables: [0.12, 120, 1200, 12000, 120000, 1.75, 1750, 17500, 175000, 1750000, 0.6, 600, 6000, 60000, 600000, 3.5, 3500, 35000, 350000, 3500000]
    }
];
const LEVEL_KEY = 'conversion_table_level';
let currentLevel = 0;

function getCurrentLevel() {
    const stored = localStorage.getItem(LEVEL_KEY);
    return stored !== null ? parseInt(stored) : 0;
}

function shuffle(arr) {
    for (let i = arr.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [arr[i], arr[j]] = [arr[j], arr[i]];
    }
    return arr;
}

document.addEventListener('DOMContentLoaded', function() {
    const draggablesContainer = document.getElementById('draggables');
    const table = document.getElementById('conversion-table');
    const checkBtn = document.getElementById('check');
    const resetBtn = document.getElementById('reset');
    const nextLevelBtn = document.getElementById('next-level');
    const messageEl = document.getElementById('message');
    const levelSpan = document.getElementById('level');
    const maxLevelSpan = document.getElementById('max-level');
    maxLevelSpan.textContent = levels.length;

    currentLevel = getCurrentLevel();

    function renderTable(levelIdx) {
        const level = levels[levelIdx];
        let html = '<thead><tr>';
        level.headers.forEach(h => {
            html += `<th class='py-3 px-4 text-lg bg-blue-100'>${h}</th>`;
        });
        html += '</tr></thead><tbody>';
        level.rows.forEach((row, rowIdx) => {
            html += '<tr>';
            Object.keys(row).forEach((unit, colIdx) => {
                if (colIdx === 0) {
                    html += `<td class='py-3 px-4 text-center font-bold'>${row[unit]}</td>`;
                } else {
                    html += `<td class='py-3 px-4 text-center'><div class='dropzone' data-unit='${unit}' data-row='${rowIdx}'></div></td>`;
                }
            });
            html += '</tr>';
        });
        html += '</tbody>';
        table.innerHTML = html;
    }

    function renderDraggables(levelIdx) {
        draggablesContainer.innerHTML = '';
        shuffle([...levels[levelIdx].draggables]).forEach(val => {
            const el = document.createElement('div');
            el.className = 'draggable';
            el.textContent = val;
            el.setAttribute('draggable', 'true');
            el.dataset.value = val;
            draggablesContainer.appendChild(el);
        });
    }

    function resetDropzones() {
        document.querySelectorAll('.dropzone').forEach(zone => {
            zone.innerHTML = '';
            zone.classList.remove('bg-green-100', 'bg-red-100', 'bg-blue-100');
            delete zone.dataset.value;
        });
    }

    // Drag & Drop logic linh hoạt
    let draggedEl = null;
    let draggedValue = null;
    let draggedFrom = null; // 'draggables' hoặc dropzone

    // Bắt đầu kéo từ danh sách hoặc từ dropzone
    document.addEventListener('dragstart', function(e) {
        if (e.target.classList.contains('draggable') || e.target.classList.contains('dropped')) {
            draggedEl = e.target;
            draggedValue = e.target.dataset.value;
            draggedFrom = e.target.parentElement.classList.contains('dropzone') ? 'dropzone' : 'draggables';
            setTimeout(() => draggedEl.classList.add('opacity-50'), 0);
        }
    });
    document.addEventListener('dragend', function(e) {
        if (draggedEl) draggedEl.classList.remove('opacity-50');
        draggedEl = null;
        draggedValue = null;
        draggedFrom = null;
    });

    document.addEventListener('dragover', function(e) {
        if (e.target.classList.contains('dropzone') || e.target.id === 'draggables') {
            e.preventDefault();
            if (e.target.classList.contains('dropzone')) e.target.classList.add('bg-blue-100');
        }
    });
    document.addEventListener('dragleave', function(e) {
        if (e.target.classList.contains('dropzone')) {
            e.target.classList.remove('bg-blue-100');
        }
    });
    document.addEventListener('drop', function(e) {
        // Kéo vào dropzone
        if (e.target.classList.contains('dropzone')) {
            e.preventDefault();
            e.target.classList.remove('bg-blue-100');
            if (!draggedEl) return;
            // Nếu dropzone đã có số, trả số cũ về danh sách
            if (e.target.dataset.value) {
                const oldValue = e.target.dataset.value;
                const oldEl = document.createElement('div');
                oldEl.className = 'draggable';
                oldEl.textContent = oldValue;
                oldEl.setAttribute('draggable', 'true');
                oldEl.dataset.value = oldValue;
                draggablesContainer.appendChild(oldEl);
            }
            // Nếu kéo từ dropzone khác, làm trống dropzone cũ
            if (draggedFrom === 'dropzone') {
                draggedEl.parentElement.innerHTML = '';
                delete draggedEl.parentElement.dataset.value;
            }
            // Đặt số mới vào dropzone
            e.target.innerHTML = `<div class='dropped' draggable='true' data-value='${draggedValue}'>${draggedValue}</div>`;
            e.target.dataset.value = draggedValue;
            // Nếu kéo từ danh sách, xóa số khỏi danh sách
            if (draggedFrom === 'draggables') {
                draggedEl.remove();
            }
            draggedEl = null;
            draggedValue = null;
            draggedFrom = null;
        }
        // Kéo về lại danh sách
        if (e.target.id === 'draggables') {
            e.preventDefault();
            if (!draggedEl) return;
            // Nếu kéo từ dropzone, làm trống dropzone cũ
            if (draggedFrom === 'dropzone') {
                draggedEl.parentElement.innerHTML = '';
                delete draggedEl.parentElement.dataset.value;
            }
            // Thêm lại số vào danh sách
            const el = document.createElement('div');
            el.className = 'draggable';
            el.textContent = draggedValue;
            el.setAttribute('draggable', 'true');
            el.dataset.value = draggedValue;
            draggablesContainer.appendChild(el);
            draggedEl = null;
            draggedValue = null;
            draggedFrom = null;
        }
    });

    // Click vào số trong dropzone để trả lại danh sách
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('dropped')) {
            const zone = e.target.parentElement;
            const val = zone.dataset.value;
            const el = document.createElement('div');
            el.className = 'draggable';
            el.textContent = val;
            el.setAttribute('draggable', 'true');
            el.dataset.value = val;
            draggablesContainer.appendChild(el);
            zone.innerHTML = '';
            delete zone.dataset.value;
        }
    });

    checkBtn.addEventListener('click', function() {
        let correct = true;
        document.querySelectorAll('.dropzone').forEach(zone => {
            const unit = zone.dataset.unit;
            const rowIdx = zone.dataset.row;
            const value = zone.dataset.value;
            const answer = levels[currentLevel].rows[rowIdx][unit];
            if (parseFloat(value) === answer) {
                zone.classList.add('bg-green-100');
                zone.classList.remove('bg-red-100');
            } else {
                zone.classList.add('bg-red-100');
                zone.classList.remove('bg-green-100');
                correct = false;
            }
        });
        messageEl.classList.remove('hidden');
        if (correct) {
            messageEl.textContent = '🎉 Xuất sắc! Bạn đã hoàn thành cấp độ này!';
            messageEl.className = 'mt-6 text-xl font-bold text-green-600';
            if (currentLevel < levels.length - 1) {
                nextLevelBtn.classList.remove('hidden');
            }
        } else {
            messageEl.textContent = 'Có ô chưa đúng, hãy kiểm tra lại!';
            messageEl.className = 'mt-6 text-xl font-bold text-red-600';
        }
    });

    // Đảm bảo gắn sự kiện đúng và reload mạnh
    if (resetBtn) {
        console.log('Đã tìm thấy nút reset');
        resetBtn.addEventListener('click', function() {
            console.log('Đã bấm nút chơi lại');
            currentLevel = 0;
            renderTable(currentLevel);
            renderDraggables(currentLevel);
            resetDropzones();
            messageEl.classList.add('hidden');
            nextLevelBtn.classList.add('hidden');
        });
    } else {
        console.log('Không tìm thấy nút reset!');
    }

    nextLevelBtn.addEventListener('click', function() {
        if (currentLevel < levels.length - 1) {
            currentLevel++;
            localStorage.setItem(LEVEL_KEY, currentLevel);
            levelSpan.textContent = currentLevel + 1;
            renderTable(currentLevel);
            renderDraggables(currentLevel);
            resetDropzones();
            messageEl.classList.add('hidden');
            nextLevelBtn.classList.add('hidden');
        }
    });

    // Khởi tạo game
    levelSpan.textContent = currentLevel + 1;
    renderTable(currentLevel);
    renderDraggables(currentLevel);
    resetDropzones();
});
</script>
@endsection 