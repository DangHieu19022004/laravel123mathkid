@extends('layouts.game')

@section('title', 'Tính Diện Tích')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600">Tính Diện Tích 🟥</h1>
        <p class="text-lg mt-2">Tính diện tích các hình học</p>
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
                        Diện tích của hình là:
                    </label>
                    <div class="flex gap-2">
                        <input type="number" id="answer-input" 
                               class="w-full px-3 py-2 border rounded-lg text-center text-xl"
                               step="0.1">
                        <select id="unit-select" class="px-3 py-2 border rounded-lg">
                            <option value="cm2">cm²</option>
                            <option value="m2">m²</option>
                            <option value="mm2">mm²</option>
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
            <h3 class="font-bold mb-2">Công thức tính diện tích:</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-semibold mb-1">Hình vuông:</h4>
                    <p class="text-sm">Diện tích = cạnh × cạnh</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-1">Hình chữ nhật:</h4>
                    <p class="text-sm">Diện tích = chiều dài × chiều rộng</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-1">Hình tam giác:</h4>
                    <p class="text-sm">Diện tích = (đáy × chiều cao) ÷ 2</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-1">Hình tròn:</h4>
                    <p class="text-sm">Diện tích ≈ 3.14 × bán kính × bán kính</p>
                </div>
            </div>
        </div>

        <!-- Bảng quy đổi -->
        <div class="mt-4 p-4 bg-blue-50 rounded-lg">
            <h3 class="font-bold mb-2">Bảng quy đổi đơn vị diện tích:</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                <div>1 m² = 10000 cm²</div>
                <div>1 cm² = 100 mm²</div>
                <div>1 m² = 1000000 mm²</div>
                <div>1 dm² = 100 cm²</div>
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
            area: 25,
            unit: 'cm2'
        },
        {
            name: 'Hình chữ nhật',
            type: 'rectangle',
            dimensions: { width: 4, height: 6 },
            area: 24,
            unit: 'cm2'
        },
        {
            name: 'Hình tam giác',
            type: 'triangle',
            dimensions: { base: 6, height: 4 },
            area: 12,
            unit: 'cm2'
        },
        {
            name: 'Hình tròn',
            type: 'circle',
            dimensions: { radius: 3 },
            area: 28.26,
            unit: 'cm2'
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
                ctx.fillText(`${shape.dimensions.side} cm`, centerX, centerY + side/2 + 20);
                break;

            case 'rectangle':
                const width = shape.dimensions.width * scale;
                const height = shape.dimensions.height * scale;
                ctx.beginPath();
                ctx.rect(centerX - width/2, centerY - height/2, width, height);
                ctx.stroke();
                ctx.fillText(`${shape.dimensions.width} cm`, centerX, centerY + height/2 + 20);
                ctx.fillText(`${shape.dimensions.height} cm`, centerX + width/2 + 20, centerY);
                break;

            case 'triangle':
                const base = shape.dimensions.base * scale;
                const height = shape.dimensions.height * scale;
                ctx.beginPath();
                ctx.moveTo(centerX - base/2, centerY + height/2);
                ctx.lineTo(centerX + base/2, centerY + height/2);
                ctx.lineTo(centerX, centerY - height/2);
                ctx.closePath();
                ctx.stroke();
                // Vẽ đường cao
                ctx.setLineDash([5, 5]);
                ctx.beginPath();
                ctx.moveTo(centerX, centerY + height/2);
                ctx.lineTo(centerX, centerY - height/2);
                ctx.stroke();
                ctx.setLineDash([]);
                ctx.fillText(`${shape.dimensions.base} cm`, centerX, centerY + height/2 + 20);
                ctx.fillText(`h = ${shape.dimensions.height} cm`, centerX + base/2 + 30, centerY);
                break;

            case 'circle':
                const radius = shape.dimensions.radius * scale;
                ctx.beginPath();
                ctx.arc(centerX, centerY, radius, 0, Math.PI * 2);
                ctx.stroke();
                // Vẽ bán kính
                ctx.beginPath();
                ctx.moveTo(centerX, centerY);
                ctx.lineTo(centerX + radius, centerY);
                ctx.stroke();
                ctx.fillText(`r = ${shape.dimensions.radius} cm`, centerX + radius/2, centerY - 10);
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
        let correctAnswer = currentShape.area;

        // Chuyển đổi đơn vị nếu cần
        if (userUnit !== currentShape.unit) {
            if (userUnit === 'mm2' && currentShape.unit === 'cm2') {
                correctAnswer *= 100;
            } else if (userUnit === 'cm2' && currentShape.unit === 'mm2') {
                correctAnswer /= 100;
            } else if (userUnit === 'm2' && currentShape.unit === 'cm2') {
                correctAnswer /= 10000;
            } else if (userUnit === 'cm2' && currentShape.unit === 'm2') {
                correctAnswer *= 10000;
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