@extends('layouts.game')

@section('title', 'Đo Độ Dài')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600">Đo Độ Dài 📏</h1>
        <p class="text-lg mt-2">Sử dụng thước để đo độ dài các vật</p>
    </div>

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-6">
        <!-- Khu vực đo -->
        <div class="relative mb-8" id="measurement-area">
            <!-- Thước đo -->
            <div class="ruler w-full h-16 bg-gray-100 relative overflow-hidden">
                <div class="ruler-marks absolute top-0 left-0 w-full h-full">
                    <!-- Vạch đo sẽ được tạo bằng JavaScript -->
                </div>
                <div id="ruler-pointer" class="absolute top-0 w-0.5 h-full bg-red-500 cursor-move hidden"></div>
            </div>

            <!-- Vật cần đo -->
            <div id="object-to-measure" class="mt-4 flex justify-center items-center">
                <!-- Vật thể sẽ được thêm bằng JavaScript -->
            </div>
        </div>

        <!-- Nhập kết quả -->
        <div class="text-center space-y-4">
            <div class="text-xl font-bold mb-2">Độ dài của vật là bao nhiêu?</div>
            <div class="flex justify-center items-center gap-2">
                <input type="number" id="answer-input" 
                       class="w-24 px-3 py-2 border rounded-lg text-center text-xl"
                       step="0.1">
                <select id="unit-select" class="px-3 py-2 border rounded-lg text-xl">
                    <option value="cm">cm</option>
                    <option value="mm">mm</option>
                    <option value="m">m</option>
                </select>
            </div>
            <button id="check-answer" 
                    class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                Kiểm tra
            </button>
        </div>

        <!-- Nút chuyển câu hỏi -->
        <div class="text-center mt-8">
            <button id="next-question" 
                    class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition-colors">
                Câu hỏi tiếp theo
            </button>
        </div>
    </div>

    <!-- Thông báo -->
    <div id="message" class="fixed top-4 right-4 p-4 rounded-lg text-white font-bold hidden"></div>
</div>

<style>
.ruler {
    background-image: linear-gradient(90deg, 
        rgba(0,0,0,0.5) 1px, 
        rgba(0,0,0,0) 1px
    );
    background-size: 10px 100%;
}

.ruler::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: linear-gradient(90deg, 
        rgba(0,0,0,0.8) 2px, 
        rgba(0,0,0,0) 2px
    );
    background-size: 50px 100%;
}

.object-item {
    transition: all 0.3s ease;
}
</style>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const measurementArea = document.getElementById('measurement-area');
    const objectToMeasure = document.getElementById('object-to-measure');
    const rulerPointer = document.getElementById('ruler-pointer');
    const answerInput = document.getElementById('answer-input');
    const unitSelect = document.getElementById('unit-select');
    const checkAnswerBtn = document.getElementById('check-answer');
    const nextQuestionBtn = document.getElementById('next-question');
    const messageEl = document.getElementById('message');

    let currentObject = null;
    let isDragging = false;
    let startX = 0;
    let scrollLeft = 0;

    // Danh sách các vật thể để đo
    const objects = [
        { name: 'Cây bút chì', length: 15, unit: 'cm', image: '✏️', scale: 2 },
        { name: 'Chiếc kẹp giấy', length: 35, unit: 'mm', image: '📎', scale: 1 },
        { name: 'Quyển vở', length: 25, unit: 'cm', image: '📓', scale: 2.5 },
        { name: 'Cây thước', length: 30, unit: 'cm', image: '📏', scale: 3 },
        { name: 'Tờ giấy A4', length: 297, unit: 'mm', image: '📄', scale: 3 },
        { name: 'Cục tẩy', length: 4, unit: 'cm', image: '🧊', scale: 0.8 }
    ];

    // Tạo vạch đo trên thước
    function createRulerMarks() {
        const ruler = document.querySelector('.ruler-marks');
        for (let i = 0; i <= 50; i++) {
            const mark = document.createElement('div');
            mark.className = 'absolute top-0 h-full text-xs text-gray-600';
            mark.style.left = `${i * 50}px`;
            if (i % 5 === 0) {
                mark.innerHTML = `<span class="absolute -bottom-6">${i}</span>`;
            }
            ruler.appendChild(mark);
        }
    }

    // Tạo câu hỏi mới
    function generateQuestion() {
        currentObject = objects[Math.floor(Math.random() * objects.length)];
        objectToMeasure.innerHTML = `
            <div class="object-item text-6xl" style="transform: scale(${currentObject.scale})">
                ${currentObject.image}
            </div>
        `;
        answerInput.value = '';
        messageEl.classList.add('hidden');
    }

    // Kiểm tra câu trả lời
    function checkAnswer() {
        const userAnswer = parseFloat(answerInput.value);
        const userUnit = unitSelect.value;
        let correctAnswer = currentObject.length;
        
        // Chuyển đổi đơn vị nếu cần
        if (userUnit !== currentObject.unit) {
            if (userUnit === 'mm' && currentObject.unit === 'cm') {
                correctAnswer *= 10;
            } else if (userUnit === 'cm' && currentObject.unit === 'mm') {
                correctAnswer /= 10;
            }
        }

        const isCorrect = Math.abs(userAnswer - correctAnswer) < 0.1;
        
        if (isCorrect) {
            showMessage('Đúng rồi! 🎉', 'bg-green-500');
        } else {
            showMessage('Chưa đúng, thử lại!', 'bg-red-500');
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

    // Xử lý kéo thước
    measurementArea.addEventListener('mousedown', (e) => {
        isDragging = true;
        startX = e.pageX - measurementArea.offsetLeft;
        scrollLeft = measurementArea.scrollLeft;
        rulerPointer.classList.remove('hidden');
        rulerPointer.style.left = `${e.pageX - measurementArea.getBoundingClientRect().left}px`;
    });

    measurementArea.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        e.preventDefault();
        const x = e.pageX - measurementArea.offsetLeft;
        const walk = (x - startX) * 2;
        measurementArea.scrollLeft = scrollLeft - walk;
        rulerPointer.style.left = `${e.pageX - measurementArea.getBoundingClientRect().left}px`;
    });

    measurementArea.addEventListener('mouseup', () => {
        isDragging = false;
    });

    measurementArea.addEventListener('mouseleave', () => {
        isDragging = false;
        rulerPointer.classList.add('hidden');
    });

    // Khởi tạo game
    createRulerMarks();
    generateQuestion();

    // Event listeners
    checkAnswerBtn.addEventListener('click', checkAnswer);
    nextQuestionBtn.addEventListener('click', generateQuestion);
});
</script>
@endsection 