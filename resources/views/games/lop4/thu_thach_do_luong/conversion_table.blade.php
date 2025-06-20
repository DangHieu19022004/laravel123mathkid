@extends('layouts.game')

@section('content')
    <div class="conversion-table-bg flex flex-col items-center min-h-screen py-8">
        <div class="w-full max-w-2xl bg-white rounded-3xl shadow-2xl p-8 flex flex-col items-center">
            <h2 class="mb-4 text-3xl font-extrabold text-blue-600 tracking-tight text-center flex items-center gap-2" style="font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;">
                <span>Bảng Quy Đổi Đơn Vị</span>
                <span class="text-4xl">📋</span>
            </h2>
            <div class="level-label mb-2" id="level-label"></div>
            <div class="level-bar mb-6">
                <div class="level-bar-inner" id="level-bar-inner"></div>
            </div>
            <div class="mb-4 text-center text-lg text-gray-700">Kéo các số đúng vào từng ô để hoàn thành bảng quy đổi</div>
            <div class="overflow-x-auto w-full mb-8">
                <table class="min-w-full bg-blue-50 rounded-xl shadow-lg" id="conversion-table"></table>
            </div>
            <div class="flex flex-wrap gap-4 justify-center mb-8 w-full" id="draggables"></div>
            <div class="flex flex-wrap gap-4 justify-center mb-4 w-full">
                <button id="check" class="px-8 py-3 bg-green-500 text-white rounded-xl text-lg font-bold hover:bg-green-600 transition-all">Kiểm tra</button>
                <button id="reset" class="px-8 py-3 bg-yellow-500 text-white rounded-xl text-lg font-bold hover:bg-yellow-600 transition-all">Chơi lại</button>
                <button id="next-level" class="px-8 py-3 bg-blue-500 text-white rounded-xl text-lg font-bold hover:bg-blue-600 transition-all hidden">Cấp độ tiếp theo</button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        body {
            background: linear-gradient(135deg, #e3f2fd 0%, #fceabb 100%);
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
        }

        .conversion-table-bg {
            background: linear-gradient(135deg, #e3f2fd 0%, #fceabb 100%);
        }

        .level-bar {
            width: 100%;
            background: #e3f2fd;
            border-radius: 1.2rem;
            height: 18px;
            box-shadow: 0 2px 8px 0 rgba(33, 150, 243, 0.08);
            overflow: hidden;
        }

        .level-bar-inner {
            height: 100%;
            background: linear-gradient(90deg, #42a5f5 0%, #29b6f6 100%);
            border-radius: 1.2rem;
            transition: width 0.5s cubic-bezier(.4, 2, .6, 1);
        }

        .level-label {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1976d2;
            letter-spacing: 1px;
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
        }

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

        .swal2-popup.swal2-rounded {
            border-radius: 1.5rem !important;
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
            font-size: 1.1rem;
            box-shadow: 0 8px 32px 0 rgba(33, 150, 243, 0.10);
        }

        .swal2-title {
            color: #1976d2 !important;
            font-weight: 700;
            font-size: 1.5rem !important;
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
        }

        .swal2-icon-success {
            color: #43e97b !important;
            border-color: #43e97b !important;
        }

        .swal2-icon-error {
            color: #ff5858 !important;
            border-color: #ff5858 !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const questions = @json($questions);
        let level = 1;
        let maxLevel = questions.length;

        window.onload = function () {
            Swal.fire({
                title: 'Hướng dẫn',
                html: `<div style='font-size:1.15rem;line-height:1.6'><b>Kéo các số đúng vào từng ô</b> để hoàn thành bảng quy đổi.<br>Hoàn thành tất cả level để trở thành "bậc thầy quy đổi"!<br><br><span style='font-size:2rem;'>📋🔁</span></div>`,
                icon: 'info',
                confirmButtonText: 'Bắt đầu chơi',
                customClass: {popup: 'swal2-popup swal2-rounded'}
            });
            renderLevel();
        };

        function renderLevel() {
            document.getElementById('level-label').innerHTML = `Level <span style='color:#1565c0'>${level}</span> / ${maxLevel}`;
            document.getElementById('level-bar-inner').style.width = ((level - 1) / maxLevel * 100) + '%';
            const q = questions[level - 1];
            // Tạo headers và rows cho bảng
            let headers = [q.type === 'mixed' ? 'Giá trị' : q.type.charAt(0).toUpperCase() + q.type.slice(1)];
            let rows = [];
            let draggables = [];
            if (q.type === 'mixed') {
                q.values.forEach((v, i) => {
                    let toUnit = (q.conversions && q.conversions[v.unit]) ? q.conversions[v.unit].to : '';
                    let answer = (q.conversions && q.conversions[v.unit]) ? v.value * q.conversions[v.unit].multiplier : v.value;
                    headers.push(`${v.unit} → ${toUnit}`);
                    let row = {};
                    row[v.unit] = `${v.value} ${v.unit}`;
                    row[toUnit] = null;
                    rows.push(row);
                    draggables.push(answer);
                });
            } else {
                headers.push(q.target_unit);
                q.values.forEach((v, i) => {
                    let answer = convertMeasurement(v.value, v.unit, q.target_unit);
                    let row = {};
                    row[v.unit] = `${v.value} ${v.unit}`;
                    row[q.target_unit] = null;
                    rows.push(row);
                    draggables.push(answer);
                });
            }
            // Shuffle draggables
            draggables = shuffle(draggables);
            // Render table
            let html = '<thead><tr>';
            headers.forEach(h => html += `<th class='py-3 px-4 text-lg bg-blue-100'>${h}</th>`);
            html += '</tr></thead><tbody>';
            rows.forEach((row, rowIdx) => {
                html += '<tr>';
                Object.keys(row).forEach((unit, colIdx) => {
                    if (row[unit] !== null) {
                        html += `<td class='py-3 px-4 text-center font-bold'>${row[unit]}</td>`;
                    } else {
                        html += `<td class='py-3 px-4 text-center'><div class='dropzone' data-unit='${unit}' data-row='${rowIdx}'></div></td>`;
                    }
                });
                html += '</tr>';
            });
            html += '</tbody>';
            document.getElementById('conversion-table').innerHTML = html;
            // Render draggables
            const draggablesContainer = document.getElementById('draggables');
            draggablesContainer.innerHTML = '';
            draggables.forEach(val => {
                const el = document.createElement('div');
                el.className = 'draggable';
                el.textContent = val;
                el.setAttribute('draggable', 'true');
                el.dataset.value = val;
                draggablesContainer.appendChild(el);
            });
            resetDropzones();
            document.getElementById('next-level').classList.add('hidden');
        }

        function shuffle(arr) {
            for (let i = arr.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [arr[i], arr[j]] = [arr[j], arr[i]];
            }
            return arr;
        }

        function convertMeasurement(value, fromUnit, toUnit) {
            const conversions = {
                'km_m': 1000,
                'm_km': 0.001,
                'kg_g': 1000,
                'g_kg': 0.001,
                'l_ml': 1000,
                'ml_l': 0.001
            };
            const key = `${fromUnit}_${toUnit}`;
            return Math.round((value * (conversions[key] ?? 1)) * 1000) / 1000;
        }

        function resetDropzones() {
            document.querySelectorAll('.dropzone').forEach(zone => {
                zone.innerHTML = '';
                zone.classList.remove('bg-green-100', 'bg-red-100', 'bg-blue-100');
                delete zone.dataset.value;
            });
        }

        // Drag & Drop logic
        let draggedEl = null;
        let draggedValue = null;
        let draggedFrom = null;

        document.addEventListener('dragstart', function (e) {
            if (e.target.classList.contains('draggable') || e.target.classList.contains('dropped')) {
                draggedEl = e.target;
                draggedValue = e.target.dataset.value;
                draggedFrom = e.target.parentElement.classList.contains('dropzone') ? 'dropzone' : 'draggables';
                setTimeout(() => draggedEl.classList.add('opacity-50'), 0);
            }
        });
        document.addEventListener('dragend', function (e) {
            if (draggedEl) draggedEl.classList.remove('opacity-50');
            draggedEl = null;
            draggedValue = null;
            draggedFrom = null;
        });
        document.addEventListener('dragover', function (e) {
            if (e.target.classList.contains('dropzone') || e.target.id === 'draggables') {
                e.preventDefault();
                if (e.target.classList.contains('dropzone')) e.target.classList.add('bg-blue-100');
            }
        });
        document.addEventListener('dragleave', function (e) {
            if (e.target.classList.contains('dropzone')) {
                e.target.classList.remove('bg-blue-100');
            }
        });
        document.addEventListener('drop', function (e) {
            if (e.target.classList.contains('dropzone')) {
                e.preventDefault();
                e.target.classList.remove('bg-blue-100');
                if (!draggedEl) return;
                if (e.target.dataset.value) {
                    const oldValue = e.target.dataset.value;
                    const oldEl = document.createElement('div');
                    oldEl.className = 'draggable';
                    oldEl.textContent = oldValue;
                    oldEl.setAttribute('draggable', 'true');
                    oldEl.dataset.value = oldValue;
                    document.getElementById('draggables').appendChild(oldEl);
                }
                if (draggedFrom === 'dropzone') {
                    draggedEl.parentElement.innerHTML = '';
                    delete draggedEl.parentElement.dataset.value;
                }
                e.target.innerHTML = `<div class='dropped' draggable='true' data-value='${draggedValue}'>${draggedValue}</div>`;
                e.target.dataset.value = draggedValue;
                if (draggedFrom === 'draggables') {
                    draggedEl.remove();
                }
                draggedEl = null;
                draggedValue = null;
                draggedFrom = null;
            }
            if (e.target.id === 'draggables') {
                e.preventDefault();
                if (!draggedEl) return;
                if (draggedFrom === 'dropzone') {
                    draggedEl.parentElement.innerHTML = '';
                    delete draggedEl.parentElement.dataset.value;
                }
                const el = document.createElement('div');
                el.className = 'draggable';
                el.textContent = draggedValue;
                el.setAttribute('draggable', 'true');
                el.dataset.value = draggedValue;
                document.getElementById('draggables').appendChild(el);
                draggedEl = null;
                draggedValue = null;
                draggedFrom = null;
            }
        });
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('dropped')) {
                const zone = e.target.parentElement;
                const val = zone.dataset.value;
                const el = document.createElement('div');
                el.className = 'draggable';
                el.textContent = val;
                el.setAttribute('draggable', 'true');
                el.dataset.value = val;
                document.getElementById('draggables').appendChild(el);
                zone.innerHTML = '';
                delete zone.dataset.value;
            }
        });
        document.getElementById('check').addEventListener('click', function () {
            let correct = true;
            const q = questions[level - 1];
            document.querySelectorAll('.dropzone').forEach((zone, idx) => {
                const unit = zone.dataset.unit;
                const rowIdx = zone.dataset.row;
                const value = zone.dataset.value;
                let answer = null;
                if (q.type === 'mixed') {
                    const v = q.values[rowIdx];
                    answer = (q.conversions && q.conversions[v.unit]) ? v.value * q.conversions[v.unit].multiplier : v.value;
                } else {
                    const v = q.values[rowIdx];
                    answer = convertMeasurement(v.value, v.unit, q.target_unit);
                }
                if (parseFloat(value) === answer) {
                    zone.classList.add('bg-green-100');
                    zone.classList.remove('bg-red-100');
                } else {
                    zone.classList.add('bg-red-100');
                    zone.classList.remove('bg-green-100');
                    correct = false;
                }
            });
            if (correct) {
                Swal.fire({
                    icon: 'success',
                    title: `Level ${level} hoàn thành!`,
                    html: '<span style="font-size:1.2rem">Bạn đã hoàn thành bảng quy đổi!<br>Tiếp tục level tiếp theo nhé!</span>',
                    showConfirmButton: false,
                    timer: 1200,
                    timerProgressBar: true,
                    customClass: {popup: 'swal2-popup swal2-rounded'}
                }).then(() => {
                    if (level < maxLevel) {
                        level++;
                        renderLevel();
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: '🎉 Hoàn thành tất cả level! 🎉',
                            html: '<span style="font-size:1.2rem">Bạn đã trở thành bậc thầy quy đổi!<br>👏👏👏</span>',
                            confirmButtonText: 'Chơi lại',
                            customClass: {popup: 'swal2-popup swal2-rounded'},
                            didOpen: () => {
                                confetti();
                            }
                        }).then(() => {
                            level = 1;
                            renderLevel();
                        });
                    }
                });
                document.getElementById('next-level').classList.remove('hidden');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Chưa đúng!',
                    html: `<span style='font-size:1.1rem'>Có ô chưa đúng, hãy kiểm tra lại!</span>`,
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    customClass: {popup: 'swal2-popup swal2-rounded'}
                });
            }
        });
        document.getElementById('reset').addEventListener('click', function () {
            level = 1;
            renderLevel();
        });
        document.getElementById('next-level').addEventListener('click', function () {
            if (level < maxLevel) {
                level++;
                renderLevel();
            }
        });

        function confetti() {
            if (document.getElementById('confetti-canvas')) return;
            const canvas = document.createElement('canvas');
            canvas.id = 'confetti-canvas';
            canvas.style.position = 'fixed';
            canvas.style.left = 0;
            canvas.style.top = 0;
            canvas.style.width = '100vw';
            canvas.style.height = '100vh';
            canvas.style.pointerEvents = 'none';
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            document.body.appendChild(canvas);
            const ctx = canvas.getContext('2d');
            const pieces = [];
            for (let i = 0; i < 120; i++) {
                pieces.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * -canvas.height,
                    r: 6 + Math.random() * 8,
                    d: 2 + Math.random() * 2,
                    color: `hsl(${Math.random() * 360},90%,60%)`,
                    tilt: Math.random() * 10,
                    tiltAngle: 0
                });
            }
            let frame = 0;

            function draw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                for (let p of pieces) {
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.r, 0, 2 * Math.PI);
                    ctx.fillStyle = p.color;
                    ctx.fill();
                }
                update();
                frame++;
                if (frame < 120) {
                    requestAnimationFrame(draw);
                } else {
                    document.body.removeChild(canvas);
                }
            }

            function update() {
                for (let p of pieces) {
                    p.y += p.d + Math.random() * 2;
                    p.x += Math.sin(frame / 10 + p.tilt) * 2;
                }
            }

            draw();
        }
    </script>
@endpush
