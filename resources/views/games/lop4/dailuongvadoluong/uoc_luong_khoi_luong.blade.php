@extends('layouts.game')

@section('title', 'Ước Lượng Khối Lượng')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600">Ước Lượng Khối Lượng ⚖️</h1>
        <p class="text-lg mt-2">Ước lượng khối lượng của các vật thể quen thuộc</p>
    </div>

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-6">
        <!-- Hiển thị vật thể -->
        <div class="text-center mb-8">
            <div id="object-display" class="text-9xl mb-4">
                <!-- Emoji của vật thể sẽ được thêm bằng JavaScript -->
            </div>
            <div id="object-name" class="text-2xl font-bold text-gray-800">
                <!-- Tên vật thể sẽ được thêm bằng JavaScript -->
            </div>
        </div>

        <!-- Thanh trượt ước lượng -->
        <div class="mb-8">
            <div class="flex justify-between text-sm text-gray-600 mb-2">
                <span>Nhẹ hơn</span>
                <span>Nặng hơn</span>
            </div>
            <input type="range" id="weight-slider" 
                   class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                   min="0" max="100" step="1">
            <div class="flex justify-between mt-2">
                <span id="min-weight" class="text-sm font-bold">0g</span>
                <span id="current-weight" class="text-sm font-bold">500g</span>
                <span id="max-weight" class="text-sm font-bold">1000g</span>
            </div>
        </div>

        <!-- Nút kiểm tra -->
        <div class="text-center space-y-4">
            <button id="check-answer" 
                    class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                Kiểm tra
            </button>
            <button id="next-question" 
                    class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition-colors">
                Câu hỏi tiếp theo
            </button>
        </div>

        <!-- Thông tin hỗ trợ -->
        <div class="mt-8 p-4 bg-blue-50 rounded-lg">
            <h3 class="font-bold mb-2">Mẹo ước lượng:</h3>
            <ul class="list-disc list-inside text-sm space-y-1">
                <li>1 quả táo trung bình nặng khoảng 150g</li>
                <li>1 quyển vở học sinh nặng khoảng 200g</li>
                <li>1 hộp sữa 200ml nặng khoảng 220g</li>
                <li>1 chai nước 500ml nặng khoảng 520g</li>
            </ul>
        </div>
    </div>

    <!-- Thông báo -->
    <div id="message" class="fixed top-4 right-4 p-4 rounded-lg text-white font-bold hidden"></div>
</div>

<style>
input[type="range"] {
    height: 4px;
    background: linear-gradient(to right, #3B82F6 0%, #3B82F6 50%, #E5E7EB 50%, #E5E7EB 100%);
    outline: none;
    transition: background 450ms ease-in;
    -webkit-appearance: none;
}

input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    background: #3B82F6;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.15s ease-in-out;
}

input[type="range"]::-webkit-slider-thumb:hover {
    transform: scale(1.2);
}

.object-display {
    transition: transform 0.3s ease;
}
</style>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const objectDisplay = document.getElementById('object-display');
    const objectName = document.getElementById('object-name');
    const weightSlider = document.getElementById('weight-slider');
    const currentWeight = document.getElementById('current-weight');
    const minWeight = document.getElementById('min-weight');
    const maxWeight = document.getElementById('max-weight');
    const checkAnswerBtn = document.getElementById('check-answer');
    const nextQuestionBtn = document.getElementById('next-question');
    const messageEl = document.getElementById('message');

    let currentObject = null;

    // Danh sách vật thể và khối lượng
    const objects = [
        { name: 'Quả táo', weight: 150, range: 50, emoji: '🍎', unit: 'g' },
        { name: 'Quyển vở', weight: 200, range: 50, emoji: '📓', unit: 'g' },
        { name: 'Hộp sữa', weight: 220, range: 50, emoji: '🥛', unit: 'g' },
        { name: 'Chai nước', weight: 520, range: 100, emoji: '🍶', unit: 'g' },
        { name: 'Túi gạo', weight: 1, range: 0.2, emoji: '🌾', unit: 'kg' },
        { name: 'Quả dưa hấu', weight: 3, range: 0.5, emoji: '🍉', unit: 'kg' },
        { name: 'Cặp sách', weight: 2.5, range: 0.5, emoji: '🎒', unit: 'kg' },
        { name: 'Quả cam', weight: 180, range: 40, emoji: '🍊', unit: 'g' }
    ];

    // Cập nhật thanh trượt
    function updateSlider(value) {
        const percent = ((value - weightSlider.min) / (weightSlider.max - weightSlider.min)) * 100;
        weightSlider.style.background = `linear-gradient(to right, #3B82F6 0%, #3B82F6 ${percent}%, #E5E7EB ${percent}%, #E5E7EB 100%)`;
        
        // Hiển thị giá trị hiện tại
        const displayValue = currentObject.unit === 'kg' ? 
            (value / 100).toFixed(1) + 'kg' : 
            Math.round(value * 10) + 'g';
        currentWeight.textContent = displayValue;
    }

    // Tạo câu hỏi mới
    function generateQuestion() {
        currentObject = objects[Math.floor(Math.random() * objects.length)];
        objectDisplay.textContent = currentObject.emoji;
        objectName.textContent = currentObject.name;

        // Cập nhật thang đo
        if (currentObject.unit === 'kg') {
            weightSlider.min = 0;
            weightSlider.max = 500; // 5kg
            weightSlider.value = 250;
            minWeight.textContent = '0kg';
            maxWeight.textContent = '5kg';
        } else {
            weightSlider.min = 0;
            weightSlider.max = 100;
            weightSlider.value = 50;
            minWeight.textContent = '0g';
            maxWeight.textContent = '1000g';
        }

        updateSlider(weightSlider.value);
        messageEl.classList.add('hidden');
    }

    // Kiểm tra câu trả lời
    function checkAnswer() {
        const userEstimate = currentObject.unit === 'kg' ? 
            parseFloat(weightSlider.value) / 100 : 
            parseFloat(weightSlider.value) * 10;
        
        const targetWeight = currentObject.weight;
        const allowedRange = currentObject.range;

        const isCorrect = Math.abs(userEstimate - targetWeight) <= allowedRange;

        if (isCorrect) {
            showMessage('Tuyệt vời! Ước lượng của bạn rất chính xác! 🎉', 'bg-green-500');
        } else {
            const message = userEstimate > targetWeight ? 
                'Ước lượng hơi cao, thử lại nhé!' : 
                'Ước lượng hơi thấp, thử lại nhé!';
            showMessage(message, 'bg-red-500');
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
    weightSlider.addEventListener('input', function() {
        updateSlider(this.value);
    });

    checkAnswerBtn.addEventListener('click', checkAnswer);
    nextQuestionBtn.addEventListener('click', generateQuestion);

    // Khởi tạo game
    generateQuestion();
});
</script>
@endsection 