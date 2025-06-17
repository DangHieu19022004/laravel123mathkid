@extends('layouts.app')

@section('content')
<div class="game-container">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 mb-4">Chia Táo 🍎</h1>
        <div class="card d-inline-block mb-4">
            <div class="card-body">
                <h2 class="h4 mb-3">Cấp độ <span id="current-level"></span>/5</h2>
                <p class="h5 text-muted" id="instruction-text">
                    <!-- Instruction will be set by JS -->
                </p>
            </div>
        </div>
    </div>

    <!-- Game Area -->
    <div class="row justify-content-center mb-5">
        <!-- Instructions -->
        <div class="col-12 mb-4">
            <div class="alert alert-info">
                <h3 class="h5 mb-3">🎯 Hướng dẫn chơi:</h3>
                <ul class="text-start mb-0">
                    <li>Có tổng cộng <span id="total-apples"></span> quả táo</li>
                    <li>Bạn cần chia đều vào <span id="total-groups"></span> nhóm</li>
                    <li>Kéo và thả táo vào từng nhóm</li>
                    <li>Mỗi nhóm phải có số táo bằng nhau</li>
                </ul>
            </div>
        </div>

        <!-- Apple Source -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body text-center" id="apple-source"></div>
            </div>
        </div>

        <!-- Apple Groups -->
        <div class="col-12">
            <div class="row g-4 justify-content-center" id="apple-groups"></div>
        </div>
    </div>

    <!-- Controls -->
    <div class="text-center">
        <button id="check-btn" class="btn btn-game mb-3">Kiểm tra</button>
        <div id="message" class="alert d-none my-3"></div>
        <button id="reset-btn" class="btn btn-link text-decoration-none">Chơi lại từ đầu</button>
        <a href="{{ url('/games/lop4/kham-pha-phan-so') }}" class="btn btn-link text-decoration-none">← Quay lại danh sách</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Các câu hỏi được định nghĩa sẵn tại client
const questions = {
    1: { apples: 4, students: 2 },
    2: { apples: 6, students: 3 },
    3: { apples: 8, students: 4 },
    4: { apples: 10, students: 5 },
    5: { apples: 12, students: 6 }
};
const maxLevel = 5;

document.addEventListener('DOMContentLoaded', () => {
    // Lấy level từ localStorage, mặc định 1
    let level = parseInt(localStorage.getItem('appleLevel'), 10);
    if (isNaN(level) || !questions[level]) level = 1;
    localStorage.setItem('appleLevel', level);

    const { apples, students } = questions[level];

    // Hiển thị level, apples và groups
    document.getElementById('current-level').textContent = level;
    document.getElementById('total-apples').textContent = apples;
    document.getElementById('total-groups').textContent = students;

    // Tạo các quả táo
    const source = document.getElementById('apple-source');
    source.innerHTML = '';
    for (let i = 0; i < apples; i++) {
        const apple = document.createElement('div');
        apple.className = 'apple draggable';
        apple.draggable = true;
        apple.textContent = '🍎';
        source.appendChild(apple);
    }

    // Tạo các nhóm
    const container = document.getElementById('apple-groups');
    container.innerHTML = '';
    for (let i = 1; i <= students; i++) {
        const col = document.createElement('div');
        col.className = 'col-md-4';
        col.innerHTML = `
            <div class="card h-100 apple-group">
                <div class="card-header text-center">Nhóm ${i}</div>
                <div class="card-body droppable" data-group="${i}"></div>
            </div>
        `;
        container.appendChild(col);
    }

    // Khởi tạo drag & drop
    initDragAndDrop();

    // Xử lý kiểm tra
    document.getElementById('check-btn').addEventListener('click', () => {
        const droppables = document.querySelectorAll('.droppable');
        const counts = Array.from(droppables).map(d => d.children.length);
        const expected = apples / students;
        const allEqual = counts.every(c => c === expected);
        const message = document.getElementById('message');
        message.classList.remove('d-none');

        if (allEqual) {
            message.className = 'alert alert-success';
            message.textContent = '🎉 Đúng rồi!';
            // Lên level tiếp theo nếu chưa max
            if (level < maxLevel) {
                localStorage.setItem('appleLevel', level + 1);
                setTimeout(() => location.reload(), 1500);
            } else {
                message.textContent += ' Bạn đã hoàn thành tất cả cấp độ!';
            }
        } else {
            message.className = 'alert alert-warning';
            message.innerHTML = `⚠️ Chưa đúng! Mỗi nhóm cần có ${expected} táo.`;
        }
    });

    // Xử lý reset
    document.getElementById('reset-btn').addEventListener('click', () => {
        if (confirm('Chơi lại từ đầu?')) {
            localStorage.removeItem('appleLevel');
            setTimeout(() => location.reload(), 200);
        }
    });
});

function initDragAndDrop() {
    document.querySelectorAll('.draggable').forEach(el => {
        el.addEventListener('dragstart', () => el.classList.add('dragging'));
        el.addEventListener('dragend', () => el.classList.remove('dragging'));
    });
    document.querySelectorAll('.droppable').forEach(drop => {
        drop.addEventListener('dragover', e => { e.preventDefault(); drop.classList.add('drag-over'); });
        drop.addEventListener('dragleave', () => drop.classList.remove('drag-over'));
        drop.addEventListener('drop', e => {
            e.preventDefault();
            drop.classList.remove('drag-over');
            const apple = document.querySelector('.dragging');
            if (apple) drop.appendChild(apple);
        });
    });
}
</script>
@endpush

@push('styles')
<style>
.btn-game { background: linear-gradient(45deg,#ff69b4,#ff1493); color:#fff; padding:10px 30px; border:none; border-radius:25px; }
.apple { font-size:2rem; margin:5px; cursor:grab; }
.apple.dragging { opacity:0.5; cursor:grabbing; }
.apple-group { border:2px dashed #ddd; min-height:150px; padding:1rem; }
.droppable.drag-over { background:#f8f9fa; border-color:#ff1493; }
</style>
@endpush
