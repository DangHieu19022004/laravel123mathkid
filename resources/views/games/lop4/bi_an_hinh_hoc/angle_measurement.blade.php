@extends('layouts.game')

@section('game_content')
<div class="container mx-auto px-4 py-8 max-w-lg">
    <div class="mb-4">
        <a href="{{ route('games.lop4.bi_an_hinh_hoc.index') }}" class="inline-block px-4 py-2 bg-purple-100 text-purple-700 rounded-lg shadow hover:bg-purple-200 transition font-semibold"><span class="mr-2">←</span>Quay lại danh sách trò chơi</a>
    </div>
    <div class="text-center mb-6">
        <h1 id="levelTitle" class="text-3xl font-bold text-blue-600">Đo Góc - Cấp độ {{ $question['level'] }}</h1>
        <p id="angleDesc" class="text-gray-600 mt-2">Hãy đo <strong>{{ $question['angle_type'] }}</strong> dưới đây</p>
    </div>

    <div class="flex justify-center mb-6">
        <div id="jxgbox" style="width: 320px; height: 320px; background: #fff;"></div>
    </div>

    <div class="flex items-center justify-center mb-4 space-x-2">
        <input type="number" id="answer" min="0" max="360" class="w-24 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Độ">
        <span class="text-lg font-medium">°</span>
    </div>

    <div class="flex justify-center gap-4 mb-4">
        <button id="check" class="px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">Kiểm tra</button>
        <button id="resetGame" class="px-6 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">Chơi lại</button>
        @if($question['level'] < 5)
            <button id="nextLevel" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition hidden">Cấp độ Tiếp Theo ▶</button>
        @endif
    </div>

    <div id="result" class="text-center text-xl font-semibold min-h-[2rem]"></div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsxgraph/distrib/jsxgraph.css" />
<script src="https://cdn.jsdelivr.net/npm/jsxgraph/distrib/jsxgraphcore.js"></script>
<script>
const getQuestionUrl = "{{ route('games.lop4.bi_an_hinh_hoc.angle_measurement') }}";
const checkAnswerUrl = "{{ route('games.lop4.bi_an_hinh_hoc.angle_measurement.check') }}";

let currentLevel = parseInt(localStorage.getItem('angleMeasurementLevel')||'1');
const maxLevel = 5;

const levelDisplay = document.getElementById('levelDisplay');
const questionBox = document.getElementById('questionBox');
const answerInput = document.getElementById('answer');
const checkBtn = document.getElementById('check');
const resetBtn = document.getElementById('resetGame');
const nextBtn = document.getElementById('nextLevel');
const messageBox = document.getElementById('result');

function saveLevel() {
    localStorage.setItem('angleMeasurementLevel', currentLevel);
}

function resetLevel() {
    localStorage.removeItem('angleMeasurementLevel');
    currentLevel = 1;
    saveLevel();
}

function renderQuestion() {
    fetch(getQuestionUrl + '?js_level=' + currentLevel, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error('Lỗi server');
        return res.json();
    })
    .then(q => {
        if(levelDisplay) levelDisplay.textContent = currentLevel;
        answerInput.value = '';
        messageBox.textContent = '';
        if(nextBtn) nextBtn.classList.add('hidden');

        // Cập nhật tiêu đề và mô tả loại góc
        const levelTitle = document.getElementById('levelTitle');
        if (levelTitle) levelTitle.textContent = `Đo Góc - Cấp độ ${currentLevel}`;
        const angleDesc = document.getElementById('angleDesc');
        if (angleDesc && q.angle_type) angleDesc.innerHTML = `Hãy đo <strong>${q.angle_type}</strong> dưới đây`;

        // Hủy board cũ nếu có
        if (window.board && typeof window.board === 'object') {
            JXG.JSXGraph.freeBoard(window.board);
        }

        // Tạo board mới và gán vào biến global
        window.board = JXG.JSXGraph.initBoard('jxgbox', {
            boundingbox: [-1.2, 1.2, 1.2, -1.2],
            axis: false,
            showNavigation: false
        });

        for (let i = 0; i < 360; i += 30) {
            const rad = i * Math.PI / 180;
            const p1 = [0.92 * Math.cos(rad), 0.92 * Math.sin(rad)];
            const p2 = [Math.cos(rad), Math.sin(rad)];
            board.create('segment', [p1, p2], {
                strokeColor: i % 90 ? '#bbb' : '#1976d2',
                strokeWidth: i % 90 ? 1 : 2,
                fixed: true
            });
            board.create('text', [1.08 * Math.cos(rad), 1.08 * Math.sin(rad), i + '°'], {
                fontSize:13,
                color:'#1976d2',
                anchorX:'middle',
                anchorY:'middle',
                fixed:true
            });
        }

        const O = board.create('point', [0, 0], {fixed:true, size:0});
        const A = board.create('point', [1, 0], {fixed:true, size:0});
        board.create('line', [O, A], {straightFirst:false, straightLast:false, strokeWidth:3, color:'#1976d2'});

        const radB = q.actual_angle * Math.PI / 180;
        const B = board.create('point', [Math.cos(radB), Math.sin(radB)], {fixed:true, size:0});
        board.create('line', [O, B], {straightFirst:false, straightLast:false, strokeWidth:3, color:'#1976d2'});
        board.create('arc', [O, A, B], {strokeColor:'#ff9800', strokeWidth:3});
    })
    .catch((err) => {
        console.error('Fetch error:', err);
        messageBox.textContent = 'Không thể lấy dữ liệu câu hỏi từ server!';
        messageBox.classList.add('text-red-600');
    });
}


document.addEventListener('DOMContentLoaded', () => {
    renderQuestion();

    checkBtn.addEventListener('click', async () => {
    const ans = parseInt(document.getElementById('answer').value);
    if (isNaN(ans)) {
        alert('Vui lòng nhập đáp án!');
        return;
    }
    try {
        const res = await fetch(checkAnswerUrl, {
            method: 'POST',
            headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
            body: JSON.stringify({answer: ans, level: currentLevel})
        });
        const data = await res.json();
        if (data.correct) {
            messageBox.textContent = '🎉 Chính xác!';
            messageBox.classList.remove('text-red-600');
            messageBox.classList.add('text-green-600');
            if (data.next_level && nextBtn) {
                nextBtn.classList.remove('hidden');
            }
        } else {
            messageBox.textContent = '😕 Sai rồi! Đáp án đúng: {{ $question["actual_angle"] }}°';
            messageBox.classList.remove('text-green-600');
            messageBox.classList.add('text-red-600');
        }
    } catch (e) {
        console.error(e);
        alert('Lỗi server, vui lòng thử lại.');
    }
});

if (nextBtn) {
    nextBtn.addEventListener('click', function() {
        if (currentLevel < maxLevel) {
            currentLevel++;
            localStorage.setItem('angleMeasurementLevel', currentLevel);
            renderQuestion();
        }
    });
}


    resetBtn.addEventListener('click', function() {
        if (confirm('Bạn có chắc muốn chơi lại từ đầu?')) {
            resetLevel();
            renderQuestion();
        }
    });

    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            if (currentLevel < totalLevels) {
                localStorage.setItem('angleMeasurementLevel', currentLevel + 1);
                window.location.href = '{{ route("games.lop4.bi_an_hinh_hoc.angle_measurement") }}';
            }
        });
    }
});
</script>
@endsection