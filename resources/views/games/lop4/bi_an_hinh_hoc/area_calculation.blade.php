@extends('layouts.game')

@section('game_content')
<div class="container mx-auto px-4 py-8 max-w-md">
    <div class="mb-4">
        <a href="{{ route('games.lop4.bi_an_hinh_hoc.index') }}" class="inline-block px-4 py-2 bg-purple-100 text-purple-700 rounded-lg shadow hover:bg-purple-200 transition font-semibold"><span class="mr-2">←</span>Quay lại danh sách trò chơi</a>
    </div>
    <div class="bg-white rounded-xl shadow p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-blue-600">Tính Diện Tích 📐</h1>
            <p class="text-gray-600 mt-2">Cấp độ <span id="levelDisplay">1</span> / <span id="maxLevelDisplay">5</span></p>
        </div>

        <div id="questionBox" class="text-center mb-6">
            <!-- Hình + thông tin được render JS -->
        </div>

        <div class="mb-4 flex items-center justify-center gap-2">
            <input id="answerInput" type="number" step="any" class="w-48 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-center" placeholder="Nhập">
            <span id="unitDisplay" class="font-medium">cm²</span>
        </div>

        <div class="flex justify-center gap-4 mb-4">
            <button id="checkBtn" class="w-32 h-16 bg-green-500 text-white rounded-lg hover:bg-green-600 transition flex items-center justify-center">Kiểm tra</button>
            <button id="resetBtn" class="w-32 h-16 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition flex items-center justify-center">Chơi lại</button>
            <button id="nextBtn" class="w-32 h-16 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition flex items-center justify-center hidden">Tiếp theo</button>
        </div>

        <div id="messageBox" class="text-center text-lg font-semibold min-h-[2rem]"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const getQuestionUrl = "{{ route('games.lop4.bi_an_hinh_hoc.area_calculation') }}";
const checkAnswerUrl = "{{ route('games.lop4.bi_an_hinh_hoc.area_calculation.check') }}";

let currentLevel = parseInt(localStorage.getItem('areaGameLevel')||'1');
const maxLevel = 5;

// DOM
const levelDisplay = document.getElementById('levelDisplay');
const maxLevelDisplay = document.getElementById('maxLevelDisplay');
const questionBox   = document.getElementById('questionBox');
const answerInput   = document.getElementById('answerInput');
const unitDisplayEl = document.getElementById('unitDisplay');
const checkBtn      = document.getElementById('checkBtn');
const resetBtn      = document.getElementById('resetBtn');
const nextBtn       = document.getElementById('nextBtn');
const messageBox    = document.getElementById('messageBox');

maxLevelDisplay.textContent = maxLevel;

function saveLevel() {
    localStorage.setItem('areaGameLevel', currentLevel);
}

function resetLevel() {
    localStorage.removeItem('areaGameLevel');
    currentLevel = 1;
    saveLevel();
}

function renderQuestion() {
    fetch(getQuestionUrl + '?level=' + currentLevel, {
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    })
    .then(res => res.json())
    .then(q => {
        levelDisplay.textContent = currentLevel;
        unitDisplayEl.textContent = q.unit || 'cm²';
        answerInput.value = '';
        messageBox.textContent = '';
        nextBtn.classList.add('hidden');

        let html = '<div class="inline-block p-4 border-2 border-blue-500 rounded-lg">';
        if (!q || !q.shape) {
            html += '<div class="text-red-600">Không có dữ liệu câu hỏi!</div>';
        } else {
            switch(q.shape){
                case 'hình vuông':
                    html += `<div style="width:128px;height:128px;background:#bfdbfe;border:4px solid #3b82f6;margin:auto;"></div>
                    <p class="mt-2">Cạnh = ${q.dimensions.cạnh} cm</p>`;
                    break;
                case 'hình chữ nhật':
                    html += `<div style="width:160px;height:96px;background:#bfdbfe;border:4px solid #3b82f6;margin:auto;"></div>
                    <p class="mt-2">Dài = ${q.dimensions['chiều dài']} cm, Rộng = ${q.dimensions['chiều rộng']} cm</p>`;
                    break;
                case 'tam giác':
                    html += `<div style="width:0;height:0;border-left:64px solid transparent;border-right:64px solid transparent;border-bottom:112px solid #3b82f6;margin:auto;"></div>
                    <p class="mt-2">Đáy = ${q.dimensions.đáy} cm, Cao = ${q.dimensions['chiều cao']} cm</p>`;
                    break;
                case 'hình thang':
                    html += `<div style="width:0;height:0;border-bottom:96px solid #3b82f6;border-left:40px solid transparent;border-right:40px solid transparent;margin:auto;"></div>
                    <p class="mt-2">Đáy lớn = ${q.dimensions['đáy lớn']} cm, Đáy nhỏ = ${q.dimensions['đáy nhỏ']} cm, Cao = ${q.dimensions['chiều cao']} cm</p>`;
                    break;
                case 'hình bình hành':
                    html += `<div style="width:120px;height:80px;background:#bfdbfe;border:4px solid #3b82f6;transform:skew(-20deg);margin:auto;"></div>
                    <p class="mt-2">Đáy = ${q.dimensions.đáy} cm, Cao = ${q.dimensions['chiều cao']} cm</p>`;
                    break;
                default:
                    html += '<div>Không hỗ trợ hình này.</div>';
            }
        }
        html += '</div>';
        questionBox.innerHTML = html;
    })
    .catch(() => {
        questionBox.innerHTML = '<div class="text-red-600">Không thể lấy dữ liệu câu hỏi từ server!</div>';
    });
}

checkBtn.addEventListener('click', () => {
    const ans = parseFloat(answerInput.value);
    if(isNaN(ans)){
        alert('Nhập đáp án!');
        return;
    }
    fetch(checkAnswerUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            answer: ans,
            level: currentLevel
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.correct){
            messageBox.textContent = '🎉 Chính xác!';
            messageBox.classList.remove('text-red-600');
            messageBox.classList.add('text-green-600');
            if(currentLevel < maxLevel){
                nextBtn.classList.remove('hidden');
            }
        } else {
            messageBox.textContent = data.message || '❌ Sai! Hãy thử lại.';
            messageBox.classList.remove('text-green-600');
            messageBox.classList.add('text-red-600');
        }
    });
});

nextBtn.addEventListener('click', () => {
    if(currentLevel < maxLevel){
        currentLevel++;
        saveLevel();
        renderQuestion();
    }
    nextBtn.classList.add('hidden');
});

resetBtn.addEventListener('click', () => {
    resetLevel();
    renderQuestion();
});

document.addEventListener('DOMContentLoaded', () => {
    renderQuestion();
});
</script>
@endsection
