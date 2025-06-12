@extends('layouts.game')

@section('title', 'Thời Gian Phiêu Lưu')

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600">Thời Gian Phiêu Lưu ⏱️</h1>
        <p class="text-lg mt-2">Chọn khoảng thời gian đúng giữa hai mốc thời gian</p>
    </div>

    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-6">
        <!-- Hiển thị thời gian -->
        <div class="flex justify-center items-center gap-8 mb-8">
            <div class="text-center">
                <div class="text-xl font-bold" id="start-time"></div>
                <div class="text-sm text-gray-600">Bắt đầu</div>
            </div>
            
            <div class="text-4xl">➡️</div>
            
            <div class="text-center">
                <div class="text-xl font-bold" id="end-time"></div>
                <div class="text-sm text-gray-600">Kết thúc</div>
            </div>
        </div>

        <!-- Đồng hồ animation -->
        <div class="flex justify-center mb-8">
            <div class="clock w-40 h-40 rounded-full border-4 border-gray-800 relative">
                <div class="hour-hand absolute w-1 h-16 bg-black top-[20%] left-1/2 -translate-x-1/2 origin-bottom"></div>
                <div class="minute-hand absolute w-1 h-20 bg-black top-[12%] left-1/2 -translate-x-1/2 origin-bottom"></div>
                <div class="center-dot absolute w-3 h-3 bg-black rounded-full top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>
                <!-- Số trên đồng hồ -->
                <div class="numbers absolute inset-0">
                    <div class="number absolute w-full h-full text-center" style="transform: rotate(30deg)">
                        <span class="inline-block" style="transform: rotate(-30deg)">1</span>
                    </div>
                    <div class="number absolute w-full h-full text-center" style="transform: rotate(60deg)">
                        <span class="inline-block" style="transform: rotate(-60deg)">2</span>
                    </div>
                    <div class="number absolute w-full h-full text-center" style="transform: rotate(90deg)">
                        <span class="inline-block" style="transform: rotate(-90deg)">3</span>
                    </div>
                    <div class="number absolute w-full h-full text-center" style="transform: rotate(120deg)">
                        <span class="inline-block" style="transform: rotate(-120deg)">4</span>
                    </div>
                    <div class="number absolute w-full h-full text-center" style="transform: rotate(150deg)">
                        <span class="inline-block" style="transform: rotate(-150deg)">5</span>
                    </div>
                    <div class="number absolute w-full h-full text-center" style="transform: rotate(180deg)">
                        <span class="inline-block" style="transform: rotate(-180deg)">6</span>
                    </div>
                    <div class="number absolute w-full h-full text-center" style="transform: rotate(210deg)">
                        <span class="inline-block" style="transform: rotate(-210deg)">7</span>
                    </div>
                    <div class="number absolute w-full h-full text-center" style="transform: rotate(240deg)">
                        <span class="inline-block" style="transform: rotate(-240deg)">8</span>
                    </div>
                    <div class="number absolute w-full h-full text-center" style="transform: rotate(270deg)">
                        <span class="inline-block" style="transform: rotate(-270deg)">9</span>
                    </div>
                    <div class="number absolute w-full h-full text-center" style="transform: rotate(300deg)">
                        <span class="inline-block" style="transform: rotate(-300deg)">10</span>
                    </div>
                    <div class="number absolute w-full h-full text-center" style="transform: rotate(330deg)">
                        <span class="inline-block" style="transform: rotate(-330deg)">11</span>
                    </div>
                    <div class="number absolute w-full h-full text-center" style="transform: rotate(0deg)">
                        <span class="inline-block" style="transform: rotate(0deg)">12</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Các lựa chọn -->
        <div class="grid grid-cols-2 gap-4" id="options">
            <!-- Options will be inserted here -->
        </div>

        <!-- Nút làm mới -->
        <div class="text-center mt-8">
            <button id="new-question" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                Câu hỏi mới
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
    const startTimeEl = document.getElementById('start-time');
    const endTimeEl = document.getElementById('end-time');
    const optionsContainer = document.getElementById('options');
    const messageEl = document.getElementById('message');
    const newQuestionBtn = document.getElementById('new-question');
    const hourHand = document.querySelector('.hour-hand');
    const minuteHand = document.querySelector('.minute-hand');

    let correctAnswer = 0;

    function generateQuestion() {
        // Tạo thời gian ngẫu nhiên
        const hour = Math.floor(Math.random() * 12) + 1;
        const minute = Math.floor(Math.random() * 12) * 5; // Chia 5 phút để dễ tính
        
        // Tạo khoảng thời gian ngẫu nhiên (15-120 phút)
        const duration = (Math.floor(Math.random() * 22) + 3) * 5;
        
        // Tính thời gian kết thúc
        let endHour = hour;
        let endMinute = minute + duration;
        
        if (endMinute >= 60) {
            endHour += Math.floor(endMinute / 60);
            endMinute = endMinute % 60;
            if (endHour > 12) {
                endHour -= 12;
            }
        }

        // Hiển thị thời gian
        startTimeEl.textContent = `${hour}:${minute.toString().padStart(2, '0')}`;
        endTimeEl.textContent = `${endHour}:${endMinute.toString().padStart(2, '0')}`;

        // Animation đồng hồ
        const startAngle = (hour % 12) * 30 + minute * 0.5;
        hourHand.style.transform = `rotate(${startAngle}deg)`;
        minuteHand.style.transform = `rotate(${minute * 6}deg)`;

        // Tạo các lựa chọn
        correctAnswer = duration;
        const options = [
            duration,
            duration + 5,
            duration - 5,
            duration + 10
        ].sort(() => Math.random() - 0.5);

        optionsContainer.innerHTML = options.map(opt => `
            <button class="option bg-gray-100 p-4 rounded-lg text-lg font-bold hover:bg-gray-200 transition-colors"
                    data-value="${opt}">
                ${opt} phút
            </button>
        `).join('');

        // Thêm sự kiện click cho các lựa chọn
        document.querySelectorAll('.option').forEach(btn => {
            btn.addEventListener('click', handleAnswer);
        });
    }

    function handleAnswer(e) {
        const selectedValue = parseInt(e.target.dataset.value);
        const isCorrect = selectedValue === correctAnswer;

        // Hiển thị thông báo
        if (isCorrect) {
            showMessage('Đúng rồi! 🎉', 'bg-green-500');
        } else {
            showMessage('Chưa đúng, thử lại!', 'bg-red-500');
        }

        // Highlight đáp án đã chọn
        document.querySelectorAll('.option').forEach(btn => {
            btn.classList.remove('bg-green-200', 'bg-red-200');
        });
        e.target.classList.add(isCorrect ? 'bg-green-200' : 'bg-red-200');
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

    // Khởi tạo câu hỏi đầu tiên
    generateQuestion();

    // Sự kiện nút làm mới
    newQuestionBtn.addEventListener('click', generateQuestion);
});
</script>

<style>
.clock .numbers .number {
    transform-origin: center;
}
.clock .numbers .number span {
    position: absolute;
    left: 50%;
    transform-origin: center;
    top: 10px;
}
.hour-hand, .minute-hand {
    transition: transform 0.5s ease-in-out;
}
</style>
@endsection 