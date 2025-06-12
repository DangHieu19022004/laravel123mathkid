@extends('layouts.game')

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-blue-600">Đo Góc - Cấp độ {{ $question['level'] }}</h1>
                <p class="text-gray-600 mt-2">Hãy đo {{ $question['angle_type'] }} dưới đây</p>
            </div>

            <div class="space-y-6">
                <div class="text-center">
                    <div class="inline-block p-6 border-2 border-blue-500 rounded-lg">
                        <div id="jxgbox" class="mx-auto" style="width: 320px; height: 320px; background: #fff;"></div>
                    </div>
                </div>

                <div class="flex flex-col items-center space-y-6">
                    <div class="w-full max-w-md">
                        <div class="flex items-center space-x-4">
                            <input type="number" id="answer" min="0" max="360" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Nhập số độ">
                            <span class="text-lg font-medium">độ</span>
                        </div>
                    </div>

                    <button id="check" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        Kiểm tra
                    </button>

                    <div id="result" class="hidden text-center p-4 rounded-lg w-full"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="toast" style="position: fixed; top: 32px; right: 32px; z-index: 9999; min-width: 220px; display: none;"></div>

<script>
function showToast(html, bg) {
    const toast = document.getElementById('toast');
    toast.innerHTML = html;
    toast.style.background = bg;
    toast.style.display = 'block';
    toast.style.color = '#222';
    toast.style.borderRadius = '12px';
    toast.style.padding = '18px 28px';
    toast.style.boxShadow = '0 4px 16px rgba(0,0,0,0.10)';
    setTimeout(() => { toast.style.display = 'none'; }, 2500);
}

function getAngleHint(type) {
    switch(type) {
        case 'góc vuông':
            return 'Góc vuông = 90°. Hãy nhớ góc vuông như góc của quyển vở!';
        case 'góc nhọn':
            return 'Góc nhọn < 90°. Hãy so với góc vuông để ước lượng!';
        case 'góc tù':
            return 'Góc tù > 90° và < 180°. Lớn hơn góc vuông nhưng chưa tới nửa vòng tròn!';
        case 'góc bẹt':
            return 'Góc bẹt = 180°. Một đường thẳng luôn!';
        default:
            return 'Hãy dùng thước đo góc hoặc ước lượng bằng mắt nhé!';
    }
}

document.getElementById('check').addEventListener('click', async function() {
    const answer = document.getElementById('answer').value;
    if (!answer) {
        alert('Vui lòng nhập đáp án!');
        return;
    }

    try {
        const response = await fetch('{{ route("games.lop4.dailuongvadoluong.angle_measurement.check") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ answer: parseInt(answer) })
        });

        const data = await response.json();
        const resultDiv = document.getElementById('result');
        resultDiv.classList.remove('hidden', 'bg-green-100', 'bg-red-100');
        const angleType = @json($question['angle_type']);
        if (data.correct) {
            showToast('<span style="font-size:2rem;">🎉</span> <span style="color:#009688;font-weight:600;">Chính xác! Bạn thật giỏi!</span>', '#e0f7fa');
            resultDiv.classList.add('bg-green-100');
            if (data.next_level) {
                resultDiv.innerHTML = `
                    <a href="{{ route('games.lop4.dailuongvadoluong.angle_measurement') }}" class="inline-block mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Tiếp tục ▶
                    </a>
                `;
            } else {
                resultDiv.innerHTML = `
                    <a href="{{ route('games.lop4.dailuongvadoluong.angle_measurement.reset') }}" class="inline-block mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Chơi lại 🔄
                    </a>
                `;
            }
        } else {
            showToast('<span style="font-size:2rem;">🧐</span> <span style="color:#d32f2f;font-weight:600;">Chưa đúng! '+getAngleHint(angleType)+'</span>', '#fffde7');
            resultDiv.classList.add('bg-red-100');
            resultDiv.innerHTML = `
                <button onclick="location.reload()" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Thử lại 🔄
                </button>
            `;
        }
        resultDiv.classList.remove('hidden');
    } catch (error) {
        console.error('Error:', error);
        alert('Có lỗi xảy ra. Vui lòng thử lại!');
    }
});
</script>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsxgraph/distrib/jsxgraph.css" />
<script src="https://cdn.jsdelivr.net/npm/jsxgraph/distrib/jsxgraphcore.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var board = JXG.JSXGraph.initBoard('jxgbox', {
        boundingbox: [-1.2, 1.2, 1.2, -1.2],
        axis: false,
        showCopyright: false,
        showNavigation: false
    });
    // Vẽ vạch chia và số quanh hình tròn
    for (let i = 0; i < 360; i += 10) {
        let rad = i * Math.PI / 180;
        let x1 = 0.92 * Math.cos(rad);
        let y1 = 0.92 * Math.sin(rad);
        let x2 = Math.cos(rad);
        let y2 = Math.sin(rad);
        board.create('segment', [[x1, y1], [x2, y2]], {
            strokeColor: (i % 90 === 0) ? '#1976d2' : '#bbb',
            strokeWidth: (i % 90 === 0) ? 2 : 1,
            fixed: true
        });
        // Số đo
        if (i % 30 === 0) {
            let xt = 1.08 * Math.cos(rad);
            let yt = 1.08 * Math.sin(rad);
            board.create('text', [xt, yt, i + '°'], {
                fontSize: 13,
                color: '#1976d2',
                anchorX: 'middle',
                anchorY: 'middle',
                fixed: true
            });
        }
    }
    // Tâm O
    var O = board.create('point', [0, 0], {name: 'O', fixed: true, size: 3, color: '#1976d2', withLabel: false});
    // Cánh tay cố định (trục Ox)
    var A = board.create('point', [1, 0], {fixed: true, size: 2, color: '#1976d2', withLabel: false});
    var OA = board.create('line', [O, A], {straightFirst: false, straightLast: false, strokeWidth: 3, color: '#1976d2'});
    // Cánh tay di chuyển (góc thực tế)
    var angleDeg = {{ $question['actual_angle'] }};
    var rad = angleDeg * Math.PI / 180;
    var B = board.create('point', [Math.cos(rad), Math.sin(rad)], {fixed: true, size: 2, color: '#1976d2', withLabel: false});
    var OB = board.create('line', [O, B], {straightFirst: false, straightLast: false, strokeWidth: 3, color: '#1976d2'});
    // Vẽ cung góc nổi bật
    var arc = board.create('arc', [O, A, B], {strokeColor: '#ff9800', strokeWidth: 3});
});
</script>
@endsection 