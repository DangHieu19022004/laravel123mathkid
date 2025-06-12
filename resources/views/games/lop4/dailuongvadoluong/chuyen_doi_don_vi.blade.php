@extends('layouts.game')

@section('title', 'Chuyển Đổi Đơn Vị Thần Tốc')

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600">Chuyển Đổi Đơn Vị Thần Tốc 🔁</h1>
        <p class="text-lg mt-2">Điền vào chỗ trống để chuyển đổi đơn vị đo lường</p>
    </div>

    <div class="max-w-2xl mx-auto">
        <!-- Bảng điểm -->
        <div class="text-center mb-8">
            <div class="text-2xl font-bold">Điểm: <span id="score">0</span></div>
            <div class="text-sm text-gray-600">Trả lời đúng: +10 điểm | Trả lời sai: -5 điểm</div>
        </div>

        <!-- Câu hỏi -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-center text-2xl font-bold gap-4">
                <span id="value1">1500</span>
                <span id="unit1">g</span>
                <span>=</span>
                <div class="relative">
                    <input type="number" id="answer" 
                           class="w-32 text-center border-b-2 border-blue-500 focus:outline-none focus:border-blue-700 bg-transparent"
                           placeholder="?">
                </div>
                <span id="unit2">kg</span>
            </div>
        </div>

        <!-- Bàn phím ảo -->
        <div class="grid grid-cols-3 gap-4 mb-8">
            <button class="num-btn bg-gray-100 p-4 rounded-lg text-xl font-bold hover:bg-gray-200">7</button>
            <button class="num-btn bg-gray-100 p-4 rounded-lg text-xl font-bold hover:bg-gray-200">8</button>
            <button class="num-btn bg-gray-100 p-4 rounded-lg text-xl font-bold hover:bg-gray-200">9</button>
            <button class="num-btn bg-gray-100 p-4 rounded-lg text-xl font-bold hover:bg-gray-200">4</button>
            <button class="num-btn bg-gray-100 p-4 rounded-lg text-xl font-bold hover:bg-gray-200">5</button>
            <button class="num-btn bg-gray-100 p-4 rounded-lg text-xl font-bold hover:bg-gray-200">6</button>
            <button class="num-btn bg-gray-100 p-4 rounded-lg text-xl font-bold hover:bg-gray-200">1</button>
            <button class="num-btn bg-gray-100 p-4 rounded-lg text-xl font-bold hover:bg-gray-200">2</button>
            <button class="num-btn bg-gray-100 p-4 rounded-lg text-xl font-bold hover:bg-gray-200">3</button>
            <button class="num-btn bg-gray-100 p-4 rounded-lg text-xl font-bold hover:bg-gray-200">0</button>
            <button class="num-btn bg-gray-100 p-4 rounded-lg text-xl font-bold hover:bg-gray-200">.</button>
            <button id="backspace" class="bg-red-100 p-4 rounded-lg text-xl font-bold hover:bg-red-200">⌫</button>
        </div>

        <!-- Nút kiểm tra và làm mới -->
        <div class="flex justify-center gap-4">
            <button id="check" class="bg-green-500 text-white px-8 py-3 rounded-lg text-lg font-bold hover:bg-green-600">
                Kiểm tra
            </button>
            <button id="new-question" class="bg-blue-500 text-white px-8 py-3 rounded-lg text-lg font-bold hover:bg-blue-600">
                Câu mới
            </button>
        </div>
    </div>

    <!-- Thông báo -->
    <div id="message" class="fixed top-4 right-4 p-4 rounded-lg text-white font-bold hidden"></div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const value1El = document.getElementById('value1');
    const unit1El = document.getElementById('unit1');
    const unit2El = document.getElementById('unit2');
    const answerInput = document.getElementById('answer');
    const checkBtn = document.getElementById('check');
    const newQuestionBtn = document.getElementById('new-question');
    const messageEl = document.getElementById('message');
    const scoreEl = document.getElementById('score');
    const backspaceBtn = document.getElementById('backspace');

    let score = 0;
    let correctAnswer = 0;

    // Định nghĩa các bộ chuyển đổi đơn vị
    const conversions = [
        { from: 'g', to: 'kg', factor: 0.001 },
        { from: 'kg', to: 'g', factor: 1000 },
        { from: 'm', to: 'km', factor: 0.001 },
        { from: 'km', to: 'm', factor: 1000 },
        { from: 'cm', to: 'm', factor: 0.01 },
        { from: 'm', to: 'cm', factor: 100 },
        { from: 'mm', to: 'cm', factor: 0.1 },
        { from: 'cm', to: 'mm', factor: 10 }
    ];

    function generateQuestion() {
        // Chọn ngẫu nhiên một bộ chuyển đổi
        const conversion = conversions[Math.floor(Math.random() * conversions.length)];
        
        // Tạo số ngẫu nhiên phù hợp với đơn vị
        let value;
        if (conversion.factor < 1) {
            value = Math.floor(Math.random() * 9000) + 1000; // 1000-9999
        } else {
            value = Math.floor(Math.random() * 90) + 10; // 10-99
        }

        value1El.textContent = value;
        unit1El.textContent = conversion.from;
        unit2El.textContent = conversion.to;
        answerInput.value = '';
        
        correctAnswer = value * conversion.factor;
    }

    function checkAnswer() {
        const userAnswer = parseFloat(answerInput.value);
        const isCorrect = Math.abs(userAnswer - correctAnswer) < 0.001;

        if (isCorrect) {
            showMessage('Đúng rồi! 🎉', 'bg-green-500');
            score += 10;
        } else {
            showMessage(`Chưa đúng! Đáp án là ${correctAnswer}`, 'bg-red-500');
            score = Math.max(0, score - 5);
        }

        scoreEl.textContent = score;
        
        // Tự động tạo câu hỏi mới sau 2 giây nếu đúng
        if (isCorrect) {
            setTimeout(generateQuestion, 2000);
        }
    }

    function showMessage(text, className) {
        messageEl.textContent = text;
        messageEl.className = `fixed top-4 right-4 p-4 rounded-lg text-white font-bold ${className}`;
        messageEl.classList.remove('hidden');
        
        setTimeout(() => {
            if (!messageEl.classList.contains('hidden')) {
                messageEl.classList.add('hidden');
            }
        }, 3000);
    }

    // Xử lý bàn phím ảo
    document.querySelectorAll('.num-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (btn.textContent === '.' && answerInput.value.includes('.')) return;
            answerInput.value += btn.textContent;
        });
    });

    backspaceBtn.addEventListener('click', () => {
        answerInput.value = answerInput.value.slice(0, -1);
    });

    // Xử lý phím Enter để kiểm tra
    answerInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            checkAnswer();
        }
    });

    // Các sự kiện nút
    checkBtn.addEventListener('click', checkAnswer);
    newQuestionBtn.addEventListener('click', generateQuestion);

    // Khởi tạo câu hỏi đầu tiên
    generateQuestion();
});
</script>
@endsection 