@extends('layouts.game')

@section('title', 'Đo Góc')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600">Đo Góc 📐</h1>
        <p class="text-lg mt-2">Đo và ước lượng các góc</p>
    </div>

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-6">
        <!-- Khu vực hiển thị góc -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Góc -->
            <div class="relative">
                <div id="angle-container" class="w-full h-64 bg-blue-50 rounded-lg flex items-center justify-center">
                    <canvas id="angleCanvas" width="300" height="300"></canvas>
                </div>
                <div id="angle-name" class="text-center mt-4 text-xl font-bold">
                    <!-- Tên góc sẽ được thêm bằng JavaScript -->
                </div>
            </div>

            <!-- Điều khiển -->
            <div class="flex flex-col justify-center">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Số đo của góc là:
                    </label>
                    <div class="flex gap-2">
                        <input type="number" id="answer-input" 
                               class="w-full px-3 py-2 border rounded-lg text-center text-xl"
                               min="0" max="360" step="1">
                        <span class="px-3 py-2 bg-gray-100 rounded-lg">độ</span>
                    </div>
                </div>

                <!-- Nút điều chỉnh -->
                <div class="grid grid-cols-2 gap-2 mb-4">
                    <button class="angle-btn bg-blue-100 px-4 py-2 rounded-lg hover:bg-blue-200" data-value="-10">
                        -10°
                    </button>
                    <button class="angle-btn bg-blue-100 px-4 py-2 rounded-lg hover:bg-blue-200" data-value="10">
                        +10°
                    </button>
                    <button class="angle-btn bg-blue-100 px-4 py-2 rounded-lg hover:bg-blue-200" data-value="-1">
                        -1°
                    </button>
                    <button class="angle-btn bg-blue-100 px-4 py-2 rounded-lg hover:bg-blue-200" data-value="1">
                        +1°
                    </button>
                </div>

                <button id="check-answer" 
                        class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors mb-2">
                    Kiểm tra
                </button>
                <button id="next-question" 
                        class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition-colors">
                    Câu hỏi tiếp theo
                </button>
            </div>
        </div>

        <!-- Thông tin hỗ trợ -->
        <div class="mt-8 p-4 bg-blue-50 rounded-lg">
            <h3 class="font-bold mb-2">Các góc đặc biệt:</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-semibold mb-1">Góc vuông:</h4>
                    <p class="text-sm">90 độ</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-1">Góc bẹt:</h4>
                    <p class="text-sm">180 độ</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-1">Góc nhọn:</h4>
                    <p class="text-sm">Nhỏ hơn 90 độ</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-1">Góc tù:</h4>
                    <p class="text-sm">Lớn hơn 90 độ và nhỏ hơn 180 độ</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Thông báo -->
    <div id="message" class="fixed top-4 right-4 p-4 rounded-lg text-white font-bold hidden"></div>
</div>

<style>
.angle-btn {
    transition: all 0.15s ease;
}
.angle-btn:active {
    transform: scale(0.95);
}
</style>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('angleCanvas');
    const ctx = canvas.getContext('2d');
    const angleName = document.getElementById('angle-name');
    const answerInput = document.getElementById('answer-input');
    const angleBtns = document.querySelectorAll('.angle-btn');
    const checkAnswerBtn = document.getElementById('check-answer');
    const nextQuestionBtn = document.getElementById('next-question');
    const messageEl = document.getElementById('message');

    let currentAngle = null;
    let userAngle = 0;

    // Danh sách các góc
    const angles = [
        { name: 'Góc vuông', angle: 90, range: 2 },
        { name: 'Góc nhọn', angle: 45, range: 2 },
        { name: 'Góc tù', angle: 135, range: 2 },
        { name: 'Góc bẹt', angle: 180, range: 2 },
        { name: 'Góc nhọn nhỏ', angle: 30, range: 2 },
        { name: 'Góc tù lớn', angle: 150, range: 2 }
    ];

    // Vẽ góc
    function drawAngle(angle) {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;
        const radius = 100;

        // Vẽ cung tròn
        ctx.beginPath();
        ctx.arc(centerX, centerY, 20, 0, (angle * Math.PI) / 180, false);
        ctx.strokeStyle = '#93C5FD';
        ctx.lineWidth = 2;
        ctx.stroke();

        // Vẽ cạnh thứ nhất
        ctx.beginPath();
        ctx.moveTo(centerX, centerY);
        ctx.lineTo(centerX + radius, centerY);
        ctx.strokeStyle = '#2563EB';
        ctx.lineWidth = 2;
        ctx.stroke();

        // Vẽ cạnh thứ hai
        ctx.beginPath();
        ctx.moveTo(centerX, centerY);
        const endX = centerX + radius * Math.cos((angle * Math.PI) / 180);
        const endY = centerY - radius * Math.sin((angle * Math.PI) / 180);
        ctx.lineTo(endX, endY);
        ctx.stroke();
    }

    // Cập nhật góc
    function updateAngle(value) {
        userAngle = Math.max(0, Math.min(360, userAngle + value));
        answerInput.value = userAngle;
        drawAngle(userAngle);
    }

    // Tạo câu hỏi mới
    function generateQuestion() {
        currentAngle = angles[Math.floor(Math.random() * angles.length)];
        angleName.textContent = currentAngle.name;
        userAngle = 0;
        answerInput.value = '';
        drawAngle(0);
        messageEl.classList.add('hidden');
    }

    // Kiểm tra câu trả lời
    function checkAnswer() {
        const userAnswer = parseInt(answerInput.value);
        const isCorrect = Math.abs(userAnswer - currentAngle.angle) <= currentAngle.range;

        if (isCorrect) {
            showMessage('Đúng rồi! 🎉', 'bg-green-500');
        } else {
            showMessage('Chưa đúng, thử lại nhé!', 'bg-red-500');
        }
    }

    // Hiển thị thông báo
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

    // Event listeners
    angleBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            updateAngle(parseInt(btn.dataset.value));
        });
    });

    answerInput.addEventListener('input', function() {
        userAngle = parseInt(this.value) || 0;
        drawAngle(userAngle);
    });

    checkAnswerBtn.addEventListener('click', checkAnswer);
    nextQuestionBtn.addEventListener('click', generateQuestion);

    // Khởi tạo game
    generateQuestion();
});
</script>
@endsection 