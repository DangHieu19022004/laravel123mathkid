@extends('layouts.game')

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-blue-600">Thời Gian Nâng Cao - Cấp độ {{ $question['level'] }}</h1>
                <p class="text-gray-600 mt-2">{{ $question['scenario'] }}</p>
            </div>

            <div class="space-y-6">
                <div class="text-center">
                    <div class="inline-block p-6 border-2 border-blue-500 rounded-lg">
                        <div class="grid grid-cols-2 gap-4">
                            @if(isset($question['start_time']))
                                <div>
                                    <p class="text-sm text-gray-600">Thời gian bắt đầu:</p>
                                    <p class="text-xl font-bold">{{ $question['start_time'] }}</p>
                                </div>
                            @endif

                            @if(isset($question['end_time']))
                                <div>
                                    <p class="text-sm text-gray-600">Thời gian kết thúc:</p>
                                    <p class="text-xl font-bold">{{ $question['end_time'] }}</p>
                                </div>
                            @endif

                            @if(isset($question['duration']))
                                <div>
                                    <p class="text-sm text-gray-600">Thời gian:</p>
                                    <p class="text-xl font-bold">{{ floor($question['duration'] / 60) }} giờ {{ $question['duration'] % 60 }} phút</p>
                                </div>
                            @endif

                            @if(isset($question['next_day']) && $question['next_day'])
                                <div class="col-span-2">
                                    <p class="text-sm text-red-600">* Kết thúc vào ngày hôm sau</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-center space-y-6">
                    <div class="w-full max-w-md">
                        @if($question['answer_unit'] === 'time')
                            <div class="flex items-center space-x-4">
                                <input type="time" id="answer" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="00:00">
                            </div>
                        @else
                            <div class="flex items-center space-x-4">
                                <input type="number" id="answer" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Nhập số phút">
                                <span class="text-lg font-medium">phút</span>
                            </div>
                        @endif
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

<script>
document.getElementById('check').addEventListener('click', async function() {
    const answer = document.getElementById('answer').value;
    if (!answer) {
        alert('Vui lòng nhập đáp án!');
        return;
    }

    try {
        const response = await fetch('{{ route("games.lop4.dailuongvadoluong.advanced_time.check") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ answer })
        });

        const data = await response.json();
        const resultDiv = document.getElementById('result');
        resultDiv.classList.remove('hidden', 'bg-green-100', 'bg-red-100');

        if (data.correct) {
            resultDiv.classList.add('bg-green-100');
            if (data.next_level) {
                resultDiv.innerHTML = `
                    <p class="text-green-600">Chính xác!</p>
                    <a href="{{ route('games.lop4.dailuongvadoluong.advanced_time') }}" class="inline-block mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Tiếp tục ▶
                    </a>
                `;
            } else {
                resultDiv.innerHTML = `
                    <p class="text-green-600">Chúc mừng! Bạn đã hoàn thành tất cả các cấp độ!</p>
                    <a href="{{ route('games.lop4.dailuongvadoluong.advanced_time.reset') }}" class="inline-block mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Chơi lại 🔄
                    </a>
                `;
            }
        } else {
            resultDiv.classList.add('bg-red-100');
            resultDiv.innerHTML = `
                <p class="text-red-600">Sai rồi! Hãy thử lại.</p>
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