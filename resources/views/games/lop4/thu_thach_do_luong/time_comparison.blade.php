@extends('layouts.game')

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-blue-600 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-400 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    So Sánh Thời Gian - Cấp độ {{ $question['level'] }}
                </h1>
                <p class="text-gray-600 mt-2">Kéo thả các khoảng thời gian bên dưới để sắp xếp <span class="font-semibold text-blue-700">từ ngắn đến dài</span>, sau đó nhấn <b>Kiểm tra</b>.</p>
            </div>

            <div class="space-y-6">
                <div id="time-container" class="flex flex-col space-y-4">
                    @foreach($question['times'] as $index => $time)
                        <div class="bg-blue-50 p-4 rounded-lg cursor-move shadow hover:shadow-lg transition-all duration-200 border-2 border-transparent hover:border-blue-400 flex items-center gap-3 drag-item" draggable="true" data-index="{{ $index }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <p class="text-lg text-center flex-1">{{ $time['hours'] }} giờ {{ $time['minutes'] }} phút</p>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-8">
                    <button id="check" class="px-8 py-3 bg-blue-600 text-white rounded-lg text-lg font-semibold shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all duration-200">
                        Kiểm tra
                    </button>
                </div>

                <div id="result" class="hidden text-center p-4 rounded-lg text-lg font-semibold"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const timeContainer = document.getElementById('time-container');
let draggedItem = null;

function addDragEvents() {
    const items = timeContainer.getElementsByClassName('drag-item');
    for (let item of items) {
        item.addEventListener('dragstart', function() {
            draggedItem = item;
            setTimeout(() => item.classList.add('opacity-50', 'ring-4', 'ring-blue-300'), 0);
        });
        item.addEventListener('dragend', function() {
            draggedItem = null;
            item.classList.remove('opacity-50', 'ring-4', 'ring-blue-300');
        });
        item.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('ring-2', 'ring-blue-400');
        });
        item.addEventListener('dragleave', function(e) {
            this.classList.remove('ring-2', 'ring-blue-400');
        });
        item.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('ring-2', 'ring-blue-400');
            if (this !== draggedItem) {
                let allItems = [...timeContainer.getElementsByClassName('drag-item')];
                let draggedIndex = allItems.indexOf(draggedItem);
                let droppedIndex = allItems.indexOf(this);
                if (draggedIndex < droppedIndex) {
                    this.parentNode.insertBefore(draggedItem, this.nextSibling);
                } else {
                    this.parentNode.insertBefore(draggedItem, this);
                }
            }
        });
    }
}
addDragEvents();

// Re-apply drag events if DOM changes (not needed here but for future-proof)
// new MutationObserver(addDragEvents).observe(timeContainer, {childList: true});

document.getElementById('check').addEventListener('click', async function() {
    const answer = [];
    const items = timeContainer.getElementsByClassName('drag-item');
    for (let item of items) {
        answer.push(parseInt(item.dataset.index));
    }
    const resultDiv = document.getElementById('result');
    resultDiv.classList.add('hidden');
    resultDiv.innerHTML = '';
    try {
        const response = await fetch('{{ route("games.lop4.dailuongvadoluong.time_comparison.check") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ answer })
        });
        const text = await response.text();
        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            resultDiv.classList.remove('hidden', 'bg-green-100', 'bg-yellow-100');
            resultDiv.classList.add('bg-red-100');
            resultDiv.innerHTML = `<span class='text-red-700'>Có lỗi dữ liệu từ máy chủ!<br><pre>${text.replace(/</g,'&lt;')}</pre></span>`;
            return;
        }
        resultDiv.classList.remove('hidden', 'bg-green-100', 'bg-red-100', 'bg-yellow-100');
        if (data.error) {
            resultDiv.classList.add('bg-yellow-100');
            resultDiv.innerHTML = `<span class='text-yellow-700'>⚠️ ${data.error}</span>`;
            return;
        }
        if (data.correct) {
            resultDiv.classList.add('bg-green-100');
            if (data.next_level) {
                resultDiv.innerHTML = `
                    <span class='text-3xl'>✅</span><br>
                    <span class='text-green-700'>Chính xác! Thứ tự các khoảng thời gian đã đúng.</span>
                    <a href="{{ route('games.lop4.dailuongvadoluong.time_comparison') }}" class="block mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 mx-auto w-fit">
                        Tiếp tục ▶
                    </a>
                `;
            } else {
                resultDiv.innerHTML = `
                    <span class='text-3xl'>🏆</span><br>
                    <span class='text-green-700'>Chúc mừng! Bạn đã hoàn thành tất cả các cấp độ!</span>
                    <a href="{{ route('games.lop4.dailuongvadoluong.time_comparison.reset') }}" class="block mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 mx-auto w-fit">
                        Chơi lại 🔄
                    </a>
                `;
            }
        } else {
            resultDiv.classList.add('bg-red-100');
            resultDiv.innerHTML = `
                <span class='text-3xl'>❌</span><br>
                <span class='text-red-700'>Sai rồi! Hãy thử sắp xếp lại.</span>
                <button onclick="location.reload()" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 rounded-lg mx-auto w-fit block">
                    Thử lại 🔄
                </button>
            `;
        }
        resultDiv.classList.remove('hidden');
    } catch (error) {
        console.error('Error:', error);
        resultDiv.classList.remove('hidden', 'bg-green-100', 'bg-red-100');
        resultDiv.classList.add('bg-red-100');
        resultDiv.innerHTML = `<span class='text-red-700'>Có lỗi xảy ra. Vui lòng thử lại!</span>`;
    }
});
</script>
@endsection 