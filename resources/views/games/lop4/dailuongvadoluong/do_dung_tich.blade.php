@extends('layouts.game')

@section('title', 'Đo Dung Tích')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600">Đo Dung Tích 🥛</h1>
        <p class="text-lg mt-2">Ước lượng và đo dung tích các vật chứa</p>
    </div>

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-6">
        <!-- Khu vực hiển thị -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Vật chứa -->
            <div class="text-center">
                <div id="container-display" class="text-9xl mb-4">
                    <!-- Emoji của vật chứa sẽ được thêm bằng JavaScript -->
                </div>
                <div id="container-name" class="text-2xl font-bold text-gray-800 mb-2">
                    <!-- Tên vật chứa -->
                </div>
                <div id="container-hint" class="text-gray-600 text-sm">
                    <!-- Gợi ý về dung tích -->
                </div>
            </div>

            <!-- Đo lường -->
            <div class="flex flex-col justify-center">
                <div class="relative w-full h-48 bg-blue-50 rounded-lg overflow-hidden mb-4">
                    <div id="liquid-level" class="absolute bottom-0 left-0 w-full bg-blue-400 transition-all duration-500"
                         style="height: 0%;">
                    </div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span id="volume-display" class="text-4xl font-bold text-blue-800">0ml</span>
                    </div>
                </div>

                <!-- Điều chỉnh dung tích -->
                <div class="flex gap-4 mb-4">
                    <button class="volume-btn bg-blue-100 px-4 py-2 rounded-lg hover:bg-blue-200" data-value="-100">
                        -100ml
                    </button>
                    <button class="volume-btn bg-blue-100 px-4 py-2 rounded-lg hover:bg-blue-200" data-value="-10">
                        -10ml
                    </button>
                    <button class="volume-btn bg-blue-100 px-4 py-2 rounded-lg hover:bg-blue-200" data-value="10">
                        +10ml
                    </button>
                    <button class="volume-btn bg-blue-100 px-4 py-2 rounded-lg hover:bg-blue-200" data-value="100">
                        +100ml
                    </button>
                </div>

                <!-- Đơn vị đo -->
                <select id="unit-select" class="w-full p-2 border rounded-lg mb-4">
                    <option value="ml">Mililít (ml)</option>
                    <option value="l">Lít (l)</option>
                </select>

                <!-- Nút kiểm tra -->
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

        <!-- Bảng quy đổi -->
        <div class="mt-8 p-4 bg-blue-50 rounded-lg">
            <h3 class="font-bold mb-2">Bảng quy đổi dung tích:</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-semibold mb-1">Đơn vị cơ bản:</h4>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        <li>1 lít (l) = 1000 mililít (ml)</li>
                        <li>1 lít = 1 dm³ (decimét khối)</li>
                        <li>1 mililít = 1 cm³ (centimét khối)</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-1">Dung tích tham khảo:</h4>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        <li>Ly nước: 200-250ml</li>
                        <li>Chai nước: 500ml</li>
                        <li>Bình nước: 1-2 lít</li>
                        <li>Xô nước: 10 lít</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Thông báo -->
    <div id="message" class="fixed top-4 right-4 p-4 rounded-lg text-white font-bold hidden"></div>
</div>

<style>
.volume-btn {
    transition: all 0.15s ease;
}
.volume-btn:active {
    transform: scale(0.95);
}
#liquid-level {
    background: linear-gradient(180deg, 
        rgba(96, 165, 250, 0.8) 0%,
        rgba(59, 130, 246, 0.9) 100%
    );
}
</style>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const containerDisplay = document.getElementById('container-display');
    const containerName = document.getElementById('container-name');
    const containerHint = document.getElementById('container-hint');
    const liquidLevel = document.getElementById('liquid-level');
    const volumeDisplay = document.getElementById('volume-display');
    const volumeBtns = document.querySelectorAll('.volume-btn');
    const unitSelect = document.getElementById('unit-select');
    const checkAnswerBtn = document.getElementById('check-answer');
    const nextQuestionBtn = document.getElementById('next-question');
    const messageEl = document.getElementById('message');

    let currentVolume = 0;
    let currentContainer = null;
    const maxVolume = 2000; // 2 lít

    // Danh sách các vật chứa
    const containers = [
        { 
            name: 'Ly nước', 
            volume: 250, 
            range: 50, 
            emoji: '🥛',
            hint: 'Một ly nước uống thông thường'
        },
        { 
            name: 'Chai nước', 
            volume: 500, 
            range: 100, 
            emoji: '🍶',
            hint: 'Chai nước khoáng phổ biến'
        },
        { 
            name: 'Bình nước', 
            volume: 1500, 
            range: 200, 
            emoji: '🫗',
            hint: 'Bình nước lớn để trong tủ lạnh'
        },
        { 
            name: 'Cốc trà', 
            volume: 180, 
            range: 30, 
            emoji: '🍵',
            hint: 'Cốc trà nhỏ dùng trong nhà hàng'
        },
        { 
            name: 'Lon nước', 
            volume: 330, 
            range: 50, 
            emoji: '🥤',
            hint: 'Lon nước ngọt thông thường'
        }
    ];

    // Cập nhật hiển thị
    function updateDisplay() {
        const percent = (currentVolume / maxVolume) * 100;
        liquidLevel.style.height = `${Math.min(100, percent)}%`;
        
        if (unitSelect.value === 'l') {
            volumeDisplay.textContent = (currentVolume / 1000).toFixed(2) + 'l';
        } else {
            volumeDisplay.textContent = currentVolume + 'ml';
        }
    }

    // Thay đổi dung tích
    function changeVolume(amount) {
        currentVolume = Math.max(0, Math.min(maxVolume, currentVolume + amount));
        updateDisplay();
    }

    // Tạo câu hỏi mới
    function generateQuestion() {
        currentContainer = containers[Math.floor(Math.random() * containers.length)];
        containerDisplay.textContent = currentContainer.emoji;
        containerName.textContent = currentContainer.name;
        containerHint.textContent = currentContainer.hint;
        
        currentVolume = 0;
        updateDisplay();
        messageEl.classList.add('hidden');
    }

    // Kiểm tra câu trả lời
    function checkAnswer() {
        const difference = Math.abs(currentVolume - currentContainer.volume);
        const isCorrect = difference <= currentContainer.range;

        if (isCorrect) {
            showMessage('Tuyệt vời! Ước lượng của bạn rất chính xác! 🎉', 'bg-green-500');
        } else {
            const message = currentVolume > currentContainer.volume ? 
                'Dung tích hơi nhiều, thử lại nhé!' : 
                'Dung tích hơi ít, thử lại nhé!';
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
    volumeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            changeVolume(parseInt(btn.dataset.value));
        });
    });

    unitSelect.addEventListener('change', updateDisplay);
    checkAnswerBtn.addEventListener('click', checkAnswer);
    nextQuestionBtn.addEventListener('click', generateQuestion);

    // Khởi tạo game
    generateQuestion();
});
</script>
@endsection 