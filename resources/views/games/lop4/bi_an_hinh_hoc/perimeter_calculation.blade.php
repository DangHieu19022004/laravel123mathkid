@extends('layouts.game')

@section('game_content')
<div class="container mx-auto px-4 py-8 max-w-md">
    <div class="bg-white rounded-xl shadow p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-blue-600">Tính Chu Vi 📏</h1>
            <p class="text-gray-600 mt-2">Cấp độ <span id="levelDisplay">1</span> / <span id="maxLevelDisplay">5</span></p>
        </div>

        <div id="questionBox" class="text-center mb-6"></div>

        <div class="mb-4 flex items-center justify-center gap-2">
            <input id="answerInput" type="number" step="any" class="w-48 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-center" placeholder="Nhập chu vi">
            <span id="unitDisplay" class="font-medium"></span>
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
// Định nghĩa các cấp độ với shape, sides và hàm tính chu vi
const levels = [
    { shape: 'hình vuông', sides: [5], unit: 'cm', compute: s => s[0] * 4 },
    { shape: 'hình chữ nhật', sides: [6, 4], unit: 'cm', compute: s => (s[0] + s[1]) * 2 },
    { shape: 'tam giác đều', sides: [8], unit: 'cm', compute: s => s[0] * 3 },
    { shape: 'hình thang', sides: [6, 4, 5, 5], unit: 'cm', compute: s => s.reduce((a, b) => a + b, 0) },
    { shape: 'ngũ giác đều', sides: [6], unit: 'cm', compute: s => s[0] * 5 }
];
let currentLevel = parseInt(localStorage.getItem('perimeterLevel') || '0');
const maxLevel = levels.length;

// DOM elements
const levelDisplay    = document.getElementById('levelDisplay');
const maxLevelDisplay = document.getElementById('maxLevelDisplay');
const questionBox     = document.getElementById('questionBox');
const answerInput     = document.getElementById('answerInput');
const unitDisplayEl   = document.getElementById('unitDisplay');
const checkBtn        = document.getElementById('checkBtn');
const resetBtn        = document.getElementById('resetBtn');
const nextBtn         = document.getElementById('nextBtn');
const messageBox      = document.getElementById('messageBox');

maxLevelDisplay.textContent = maxLevel;

function saveLevel() {
    localStorage.setItem('perimeterLevel', currentLevel);
}

function renderQuestion() {
    const q = levels[currentLevel];
    levelDisplay.textContent = currentLevel + 1;
    unitDisplayEl.textContent = q.unit;
    answerInput.value = '';
    messageBox.textContent = '';
    nextBtn.classList.add('hidden');

    // Render hình và thông số
    let html = '<div class="inline-block p-4 border-2 border-blue-500 rounded-lg">';
    switch(q.shape) {
        case 'hình vuông':
            html += `<div class="w-32 h-32 border-4 border-blue-500 bg-blue-50 mx-auto"></div>`;
            html += `<p class="mt-2">Cạnh = ${q.sides[0]} ${q.unit}</p>`;
            break;
        case 'hình chữ nhật':
            html += `<div class="w-40 h-32 border-4 border-blue-500 bg-blue-50 mx-auto"></div>`;
            html += `<p class="mt-2">Dài = ${q.sides[0]} ${q.unit}, Rộng = ${q.sides[1]} ${q.unit}</p>`;
            break;
        case 'tam giác đều':
            html += `<div class="relative w-32 h-32 mx-auto"><div class="absolute top-0 left-1/2 transform -translate-x-1/2 border-l-[50px] border-r-[50px] border-b-[87px] border-l-transparent border-r-transparent border-b-blue-500"></div></div>`;
            html += `<p class="mt-2">Cạnh = ${q.sides[0]} ${q.unit}</p>`;
            break;
        case 'hình thang':
            html += `<div class="relative w-40 h-32 mx-auto"><div class="absolute inset-0 border-4 border-blue-500 transform skew-x-12 bg-blue-50"></div></div>`;
            html += `<p class="mt-2">Đáy trên = ${q.sides[0]} ${q.unit}, Đáy dưới = ${q.sides[1]} ${q.unit}<br>Cạnh bên = ${q.sides[2]} ${q.unit}, ${q.sides[3]} ${q.unit}</p>`;
            break;
        case 'ngũ giác đều':
            html += `<div class="relative w-32 h-32 mx-auto"><div class="absolute inset-0 border-4 border-blue-500 transform rotate-18 bg-blue-50"></div></div>`;
            html += `<p class="mt-2">Cạnh = ${q.sides[0]} ${q.unit}</p>`;
            break;
    }
    html += '</div>';
    questionBox.innerHTML = html;
}

checkBtn.addEventListener('click', () => {
    const q = levels[currentLevel];
    const ans = parseFloat(answerInput.value);
    if (isNaN(ans)) {
        alert('Vui lòng nhập đáp án!');
        return;
    }
    const correctAns = q.compute(q.sides);
    messageBox.classList.remove('text-green-600', 'text-red-600');
    if (Math.abs(ans - correctAns) < 1e-6) {
        messageBox.textContent = '🎉 Chính xác!';
        messageBox.classList.add('text-green-600');
        if (currentLevel < maxLevel - 1) {
            nextBtn.classList.remove('hidden');
        }
    } else {
        messageBox.textContent = `❌ Sai! Đúng = ${correctAns}`;
        messageBox.classList.add('text-red-600');
    }
});

nextBtn.addEventListener('click', () => {
    currentLevel++;
    saveLevel();
    renderQuestion();
});

resetBtn.addEventListener('click', () => {
    currentLevel = 0;
    saveLevel();
    renderQuestion();
});

document.addEventListener('DOMContentLoaded', renderQuestion);
</script>
@endsection