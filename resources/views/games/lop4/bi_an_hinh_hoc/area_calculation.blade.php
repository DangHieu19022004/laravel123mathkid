@extends('layouts.game')

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-blue-600">Tính Diện Tích - Cấp độ {{ $question['level'] }}</h1>
                <p class="text-gray-600 mt-2">Tính diện tích của {{ $question['shape'] }}</p>
            </div>

            <div class="space-y-6">
                <div class="text-center">
                    <div class="inline-block p-6 border-2 border-blue-500 rounded-lg">
                        @switch($question['shape'])
                            @case('hình vuông')
                                <div class="w-32 h-32 border-4 border-blue-500 bg-blue-50"></div>
                                <p class="mt-4">Cạnh = {{ $question['dimensions']['cạnh'] }} {{ explode('²', $question['unit'])[0] }}</p>
                                @break

                            @case('hình chữ nhật')
                                <div class="w-40 h-32 border-4 border-blue-500 bg-blue-50"></div>
                                <p class="mt-4">
                                    Chiều dài = {{ $question['dimensions']['chiều dài'] }} {{ explode('²', $question['unit'])[0] }}<br>
                                    Chiều rộng = {{ $question['dimensions']['chiều rộng'] }} {{ explode('²', $question['unit'])[0] }}
                                </p>
                                @break

                            @case('tam giác')
                                <div class="relative w-32 h-32">
                                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 border-l-[50px] border-r-[50px] border-b 
                                    [87px] border-l-transparent border-r-transparent border-b-blue-500 bg-blue-50"></div>
                                </div>
                                <p class="mt-4">
                                    Đáy = {{ $question['dimensions']['đáy'] }} {{ explode('²', $question['unit'])[0] }}<br>
                                    Chiều cao = {{ $question['dimensions']['chiều cao'] }} {{ explode('²', $question['unit'])[0] }}
                                </p>
                                @break

                            @case('hình thang')
                                <div class="relative w-40 h-32">
                                    <div class="absolute inset-0 border-4 border-blue-500 transform skew-x-12 bg-blue-50"></div>
                                </div>
                                <p class="mt-4">
                                    Đáy lớn = {{ $question['dimensions']['đáy lớn'] }} {{ explode('²', $question['unit'])[0] }}<br>
                                    Đáy nhỏ = {{ $question['dimensions']['đáy nhỏ'] }} {{ explode('²', $question['unit'])[0] }}<br>
                                    Chiều cao = {{ $question['dimensions']['chiều cao'] }} {{ explode('²', $question['unit'])[0] }}
                                </p>
                                @break

                            @case('hình bình hành')
                                <div class="relative w-40 h-32">
                                    <div class="absolute inset-0 border-4 border-blue-500 transform skew-x-12 bg-blue-50"></div>
                                </div>
                                <p class="mt-4">
                                    Đáy = {{ $question['dimensions']['đáy'] }} {{ explode('²', $question['unit'])[0] }}<br>
                                    Chiều cao = {{ $question['dimensions']['chiều cao'] }} {{ explode('²', $question['unit'])[0] }}
                                </p>
                                @break
                        @endswitch
                    </div>
                </div>

                <div class="flex flex-col items-center space-y-6">
                    <div class="w-full max-w-md">
                        <div class="flex items-center space-x-4">
                            <input type="number" id="answer" step="1" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Nhập diện tích">
                            <span class="text-lg font-medium">{{ $question['unit'] }}</span>
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

function getAreaHint(shape) {
    switch(shape) {
        case 'hình vuông':
            return 'Diện tích hình vuông = Cạnh × Cạnh. Nhớ nhân hai lần cạnh nhé!';
        case 'hình chữ nhật':
            return 'Diện tích hình chữ nhật = Dài × Rộng. Dài nhân rộng là ra!';
        case 'tam giác':
            return 'Diện tích tam giác = (Đáy × Chiều cao) : 2. Đáy nhân cao rồi chia đôi!';
        case 'hình thang':
            return 'Diện tích hình thang = (Đáy lớn + Đáy nhỏ) × Chiều cao : 2. Cộng hai đáy, nhân cao, chia đôi!';
        case 'hình bình hành':
            return 'Diện tích hình bình hành = Đáy × Chiều cao. Đáy nhân cao là ra!';
        default:
            return 'Diện tích = Công thức riêng cho từng hình!';
    }
}

document.getElementById('check').addEventListener('click', async function() {
    const answer = document.getElementById('answer').value;
    if (!answer) {
        alert('Vui lòng nhập đáp án!');
        return;
    }

    try {
        const response = await fetch('{{ route("games.lop4.dailuongvadoluong.area_calculation.check") }}', {
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
        const shape = @json($question['shape']);
        if (data.correct) {
            showToast('<span style="font-size:2rem;">🎉</span> <span style="color:#009688;font-weight:600;">Chính xác! Bạn thật giỏi!</span>', '#e0f7fa');
            resultDiv.classList.add('bg-green-100');
            if (data.next_level) {
                resultDiv.innerHTML = `
                    <a href="{{ route('games.lop4.dailuongvadoluong.area_calculation') }}" class="inline-block mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Tiếp tục ▶
                    </a>
                `;
            } else {
                resultDiv.innerHTML = `
                    <a href="{{ route('games.lop4.dailuongvadoluong.area_calculation.reset') }}" class="inline-block mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Chơi lại 🔄
                    </a>
                `;
            }
        } else {
            showToast('<span style="font-size:2rem;">🤔</span> <span style="color:#d32f2f;font-weight:600;">Chưa đúng! '+getAreaHint(shape)+'</span>', '#fffde7');
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