@extends('layouts.game')

@section('title', 'Tính Chu Vi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600">Tính Chu Vi 📐</h1>
        <p class="text-lg mt-2">Tính chu vi các hình học</p>
    </div>

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-6">
        <!-- Khu vực hiển thị hình -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Hình vẽ -->
            <div class="relative">
                <div id="shape-container" class="w-full h-64 bg-blue-50 rounded-lg flex items-center justify-center">
                    <canvas id="shapeCanvas" width="300" height="300"></canvas>
                </div>
                <div id="shape-name" class="text-center mt-4 text-xl font-bold">
                    <!-- Tên hình sẽ được thêm bằng JavaScript -->
                </div>
            </div>

            <!-- Nhập kết quả -->
            <div class="flex flex-col justify-center">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Chu vi của hình là:
                    </label>
                    <div class="flex gap-2">
                        <input type="number" id="answer-input" 
                               class="w-full px-3 py-2 border rounded-lg text-center text-xl"
                               step="0.1">
                        <select id="unit-select" class="px-3 py-2 border rounded-lg">
                            <option value="cm">cm</option>
                            <option value="m">m</option>
                            <option value="mm">mm</option>
                        </select>
                    </div>
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

        <!-- Công thức -->
        <div class="mt-8 p-4 bg-blue-50 rounded-lg">
            <h3 class="font-bold mb-2">Công thức tính chu vi:</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-semibold mb-1">Hình vuông:</h4>
                    <p class="text-sm">Chu vi = 4 × cạnh</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-1">Hình chữ nhật:</h4>
                    <p class="text-sm">Chu vi = 2 × (chiều dài + chiều rộng)</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-1">Hình tam giác:</h4>
                    <p class="text-sm">Chu vi = cạnh 1 + cạnh 2 + cạnh 3</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-1">Hình tròn:</h4>
                    <p class="text-sm">Chu vi ≈ 3.14 × đường kính</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Thông báo -->
    <div id="message" class="fixed top-4 right-4 p-4 rounded-lg text-white font-bold hidden"></div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('shapeCanvas');
    const ctx = canvas.getContext('2d');
    const shapeName = document.getElementById('shape-name');
    const answerInput = document.getElementById('answer-input');
    const unitSelect = document.getElementById('unit-select');
    const checkAnswerBtn = document.getElementById('check-answer');
    const nextQuestionBtn = document.getElementById('next-question');
    const messageEl = document.getElementById('message');

    let currentShape = null;

    // Danh sách các hình và kích thước
    const shapes = [
        {
            name: 'Hình vuông',
            type: 'square',
            dimensions: { side: 5 },
            perimeter: 20,
            unit: 'cm'
        },
        {
            name: 'Hình chữ nhật',
            type: 'rectangle',
            dimensions: { width: 4, height: 6 },
            perimeter: 20,
            unit: 'cm'
        },
        {
            name: 'Hình tam giác',
            type: 'triangle',
            dimensions: { side1: 5, side2: 5, side3: 5 },
            perimeter: 15,
            unit: 'cm'
        },
        {
            name: 'Hình tròn',
            type: 'circle',
            dimensions: { radius: 3 },
            perimeter: 18.84,
            unit: 'cm'
        }
    ];

    // Vẽ hình
    function drawShape(shape) {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.strokeStyle = '#2563EB';
        ctx.lineWidth = 2;
        ctx.font = '16px Arial';
        ctx.fillStyle = '#2563EB';
        ctx.textAlign = 'center';

        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;
        const scale = 30; // Tỉ lệ pixel/đơn vị

        switch(shape.type) {
            case 'square':
                const side = shape.dimensions.side * scale;
                ctx.beginPath();
                ctx.rect(centerX - side/2, centerY - side/2, side, side);
                ctx.stroke();
                ctx.fillText(`${shape.dimensions.side}${shape.unit}`, centerX, centerY + side/2 + 20);
                break;

            case 'rectangle':
                const width = shape.dimensions.width * scale;
                const height = shape.dimensions.height * scale;
                ctx.beginPath();
                ctx.rect(centerX - width/2, centerY - height/2, width, height);
                ctx.stroke();
                ctx.fillText(`${shape.dimensions.width}${shape.unit}`, centerX, centerY + height/2 + 20);
                ctx.fillText(`${shape.dimensions.height}${shape.unit}`, centerX + width/2 + 20, centerY);
                break;

            case 'triangle':
                const sideLength = shape.dimensions.side1 * scale;
                ctx.beginPath();
                ctx.moveTo(centerX, centerY - sideLength/2);
                ctx.lineTo(centerX - sideLength/2, centerY + sideLength/2);
                ctx.lineTo(centerX + sideLength/2, centerY + sideLength/2);
                ctx.closePath();
                ctx.stroke();
                ctx.fillText(`${shape.dimensions.side1}${shape.unit}`, centerX, centerY + sideLength/2 + 20);
                break;

            case 'circle':
                const radius = shape.dimensions.radius * scale;
                ctx.beginPath();
                ctx.arc(centerX, centerY, radius, 0, Math.PI * 2);
                ctx.stroke();
                ctx.fillText(`r = ${shape.dimensions.radius}${shape.unit}`, centerX, centerY + radius + 20);
                break;
        }
    }

    // Tạo câu hỏi mới
    function generateQuestion() {
        currentShape = shapes[Math.floor(Math.random() * shapes.length)];
        shapeName.textContent = currentShape.name;
        drawShape(currentShape);
        answerInput.value = '';
        messageEl.classList.add('hidden');
    }

    // Kiểm tra câu trả lời
    function checkAnswer() {
        const userAnswer = parseFloat(answerInput.value);
        const userUnit = unitSelect.value;
        let correctAnswer = currentShape.perimeter;

        // Chuyển đổi đơn vị nếu cần
        if (userUnit !== currentShape.unit) {
            if (userUnit === 'mm' && currentShape.unit === 'cm') {
                correctAnswer *= 10;
            } else if (userUnit === 'cm' && currentShape.unit === 'mm') {
                correctAnswer /= 10;
            } else if (userUnit === 'm' && currentShape.unit === 'cm') {
                correctAnswer /= 100;
            } else if (userUnit === 'cm' && currentShape.unit === 'm') {
                correctAnswer *= 100;
            }
        }

        const isCorrect = Math.abs(userAnswer - correctAnswer) < 0.1;

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
    checkAnswerBtn.addEventListener('click', checkAnswer);
    nextQuestionBtn.addEventListener('click', generateQuestion);

    // Khởi tạo game
    generateQuestion();
});
</script>
@endsection 