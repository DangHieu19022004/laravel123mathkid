@extends('layouts.game')

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-blue-600">So Sánh Độ Dài</h1>
                <p class="text-gray-600 mt-2 text-lg">
                    @if($question['type'] === 'max')
                        Vật nào <span class="font-bold text-blue-700">dài nhất</span>?
                    @else
                        Vật nào <span class="font-bold text-blue-700">ngắn nhất</span>?
                    @endif
                </p>
            </div>
            <div class="flex flex-col items-center space-y-8">
                <div class="w-full flex flex-col gap-6">
                    @foreach($question['objects'] as $i => $obj)
                        <div class="flex flex-col items-center">
                            <button class="object-btn group w-full flex flex-col items-center justify-center py-6 px-2 rounded-xl shadow-sm bg-blue-50 hover:bg-blue-100 transition-all" data-index="{{ $i }}">
                                <span class="text-5xl mb-2">{{ $obj['emoji'] }}</span>
                                <span class="text-lg font-semibold mb-1">{{ $obj['object'] }}</span>
                                <span class="text-base text-gray-500">{{ $obj['length'] }} {{ $obj['unit'] }}</span>
                            </button>
                        </div>
                    @endforeach
                </div>
                <div id="result" class="hidden text-center p-4 rounded-lg w-full"></div>
                <button id="next-question" class="hidden mt-4 px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Câu hỏi tiếp theo ▶</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const answerIndex = {{ $question['answer_index'] }};
    const resultDiv = document.getElementById('result');
    const nextBtn = document.getElementById('next-question');
    const btns = document.querySelectorAll('.object-btn');
    let answered = false;
    btns.forEach((btn, idx) => {
        btn.addEventListener('click', function() {
            if (answered) return;
            answered = true;
            if (idx === answerIndex) {
                resultDiv.className = 'text-center p-4 rounded-lg w-full bg-green-100';
                resultDiv.innerHTML = '<p class="text-green-600 font-bold">Chính xác! 🎉</p>';
                nextBtn.classList.remove('hidden');
            } else {
                resultDiv.className = 'text-center p-4 rounded-lg w-full bg-red-100';
                resultDiv.innerHTML = '<p class="text-red-600 font-bold">Chưa đúng, hãy thử lại!</p>';
                nextBtn.classList.add('hidden');
                answered = false;
            }
            resultDiv.classList.remove('hidden');
        });
    });
    nextBtn.addEventListener('click', function() {
        window.location.reload();
    });
});
</script>
@endsection 