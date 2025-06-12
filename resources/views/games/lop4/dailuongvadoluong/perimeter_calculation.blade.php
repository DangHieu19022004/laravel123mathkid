@extends('layouts.game')

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-blue-600">Tính Chu Vi - Cấp độ {{ $question['level'] }}</h1>
                <p class="text-gray-600 mt-2">Tính chu vi của {{ $question['shape'] }}</p>
            </div>

            <div class="space-y-6">
                <div class="text-center">
                    <div class="inline-block p-6 border-2 border-blue-500 rounded-lg">
                        @switch($question['shape'])
                            @case('hình vuông')
                                <div class="w-32 h-32 border-4 border-blue-500"></div>
                                <p class="mt-4">Cạnh = {{ $question['sides'][0] }} {{ $question['unit'] }}</p>
                                @break

                            @case('hình chữ nhật')
                                <div class="w-40 h-32 border-4 border-blue-500"></div>
                                <p class="mt-4">
                                    Chiều dài = {{ $question['sides'][0] }} {{ $question['unit'] }}<br>
                                    Chiều rộng = {{ $question['sides'][1] }} {{ $question['unit'] }}
                                </p>
                                @break

                            @case('tam giác đều')
                                <div class="relative w-32 h-32">
                                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 border-l-[50px] border-r-[50px] border-b-[87px] border-l-transparent border-r-transparent border-b-blue-500"></div>
                                </div>
                                <p class="mt-4">Cạnh = {{ $question['sides'][0] }} {{ $question['unit'] }}</p>
                                @break

                            @case('hình thang')
                                <div class="relative w-40 h-32">
                                    <div class="absolute inset-0 border-4 border-blue-500 transform skew-x-12"></div>
                                </div>
                                <p class="mt-4">
                                    Đáy trên = {{ $question['sides'][0] }} {{ $question['unit'] }}<br>
                                    Đáy dưới = {{ $question['sides'][1] }} {{ $question['unit'] }}<br>
                                    Cạnh bên = {{ $question['sides'][2] }} {{ $question['unit'] }}<br>
                                    Cạnh bên = {{ $question['sides'][3] }} {{ $question['unit'] }}
                                </p>
                                @break

                            @case('ngũ giác đều')
                                <div class="relative w-32 h-32">
                                    <div class="absolute inset-0 border-4 border-blue-500 transform rotate-18"></div>
                                </div>
                                <p class="mt-4">Cạnh = {{ $question['sides'][0] }} {{ $question['unit'] }}</p>
                                @break
                        @endswitch
                    </div>
                </div>

                <div class="flex flex-col items-center space-y-6">
                    <div class="w-full max-w-md">
                        <div class="flex items-center space-x-4">
                            <input type="number" id="answer" step="1" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Nhập chu vi">
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

function getPerimeterHint(shape) {
    switch(shape) {
        case 'hình vuông':
            return 'Chu vi hình vuông = Cạnh × 4. Hãy thử cộng 4 lần cạnh nhé!';
        case 'hình chữ nhật':
            return 'Chu vi hình chữ nhật = (Dài + Rộng) × 2. Cộng dài và rộng rồi nhân đôi!';
        case 'tam giác đều':
            return 'Chu vi tam giác đều = Cạnh × 3. Đếm 3 cạnh giống nhau!';
        case 'hình thang':
            return 'Chu vi hình thang = Tổng các cạnh. Cộng tất cả các cạnh lại!';
        case 'ngũ giác đều':
            return 'Chu vi ngũ giác đều = Cạnh × 5. 5 cạnh bằng nhau đó!';
        default:
            return 'Chu vi = Tổng độ dài các cạnh!';
    }
}

document.getElementById('check').addEventListener('click', async function() {
    const answer = document.getElementById('answer').value;
    if (!answer) {
        alert('Vui lòng nhập đáp án!');
        return;
    }

    try {
        const response = await fetch('{{ route("games.lop4.dailuongvadoluong.perimeter_calculation.check") }}', {
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
                    <a href="{{ route('games.lop4.dailuongvadoluong.perimeter_calculation') }}" class="inline-block mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Tiếp tục ▶
                    </a>
                `;
            } else {
                resultDiv.innerHTML = `
                    <a href="{{ route('games.lop4.dailuongvadoluong.perimeter_calculation.reset') }}" class="inline-block mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Chơi lại 🔄
                    </a>
                `;
            }
        } else {
            showToast('<span style="font-size:2rem;">🤔</span> <span style="color:#d32f2f;font-weight:600;">Chưa đúng! '+getPerimeterHint(shape)+'</span>', '#fffde7');
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