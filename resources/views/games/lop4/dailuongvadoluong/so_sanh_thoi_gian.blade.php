@extends('layouts.game')

@section('title', 'So Sánh Thời Gian')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600">So Sánh Thời Gian 🕒</h1>
        <p class="text-lg mt-2">So sánh các khoảng thời gian khác nhau</p>
    </div>

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-6">
        <!-- Khu vực hiển thị thời gian -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Thời gian 1 -->
            <div class="text-center p-6 bg-blue-50 rounded-xl">
                <div id="time1-display" class="text-4xl font-bold mb-4">
                    <!-- Thời gian 1 sẽ được thêm bằng JavaScript -->
                </div>
                <div id="time1-description" class="text-gray-600">
                    <!-- Mô tả thời gian 1 -->
                </div>
            </div>

            <!-- Thời gian 2 -->
            <div class="text-center p-6 bg-blue-50 rounded-xl">
                <div id="time2-display" class="text-4xl font-bold mb-4">
                    <!-- Thời gian 2 sẽ được thêm bằng JavaScript -->
                </div>
                <div id="time2-description" class="text-gray-600">
                    <!-- Mô tả thời gian 2 -->
                </div>
            </div>
        </div>

        <!-- Câu hỏi -->
        <div class="text-center mb-8">
            <p class="text-xl font-bold">Khoảng thời gian nào dài hơn?</p>
        </div>

        <!-- Nút lựa chọn -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <button id="choice1" class="p-4 bg-white border-2 border-blue-500 rounded-lg hover:bg-blue-50 transition-colors">
                Khoảng thời gian 1
            </button>
            <button id="choice2" class="p-4 bg-white border-2 border-blue-500 rounded-lg hover:bg-blue-50 transition-colors">
                Khoảng thời gian 2
            </button>
        </div>

        <!-- Nút câu hỏi mới -->
        <div class="text-center">
            <button id="next-question" 
                    class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition-colors">
                Câu hỏi tiếp theo
            </button>
        </div>

        <!-- Bảng quy đổi -->
        <div class="mt-8 p-4 bg-blue-50 rounded-lg">
            <h3 class="font-bold mb-2">Bảng quy đổi thời gian:</h3>
            <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                <li>1 giờ = 60 phút</li>
                <li>1 phút = 60 giây</li>
                <li>1 giờ = 3600 giây</li>
                <li>1 ngày = 24 giờ</li>
                <li>1 tuần = 7 ngày</li>
                <li>1 tháng = 30 ngày</li>
            </ul>
        </div>
    </div>

    <!-- Thông báo -->
    <div id="message" class="fixed top-4 right-4 p-4 rounded-lg text-white font-bold hidden"></div>
</div>

<style>
button.selected {
    background-color: #93C5FD;
    border-color: #2563EB;
}
button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}
</style>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const time1Display = document.getElementById('time1-display');
    const time2Display = document.getElementById('time2-display');
    const time1Description = document.getElementById('time1-description');
    const time2Description = document.getElementById('time2-description');
    const choice1Btn = document.getElementById('choice1');
    const choice2Btn = document.getElementById('choice2');
    const nextQuestionBtn = document.getElementById('next-question');
    const messageEl = document.getElementById('message');

    let currentQuestion = null;

    // Danh sách các khoảng thời gian để so sánh
    const timeComparisons = [
        {
            time1: { value: 2, unit: 'giờ', description: '2 giờ' },
            time2: { value: 90, unit: 'phút', description: '90 phút' }
        },
        {
            time1: { value: 1, unit: 'ngày', description: '1 ngày' },
            time2: { value: 20, unit: 'giờ', description: '20 giờ' }
        },
        {
            time1: { value: 120, unit: 'phút', description: '120 phút' },
            time2: { value: 1.5, unit: 'giờ', description: '1 giờ 30 phút' }
        },
        {
            time1: { value: 7, unit: 'ngày', description: '7 ngày' },
            time2: { value: 1, unit: 'tuần', description: '1 tuần' }
        },
        {
            time1: { value: 180, unit: 'giây', description: '180 giây' },
            time2: { value: 2, unit: 'phút', description: '2 phút' }
        },
        {
            time1: { value: 0.5, unit: 'giờ', description: '30 phút' },
            time2: { value: 45, unit: 'phút', description: '45 phút' }
        }
    ];

    // Chuyển đổi thời gian về đơn vị giây
    function convertToSeconds(time) {
        switch(time.unit) {
            case 'giây':
                return time.value;
            case 'phút':
                return time.value * 60;
            case 'giờ':
                return time.value * 3600;
            case 'ngày':
                return time.value * 86400;
            case 'tuần':
                return time.value * 604800;
            default:
                return 0;
        }
    }

    // Tạo câu hỏi mới
    function generateQuestion() {
        currentQuestion = timeComparisons[Math.floor(Math.random() * timeComparisons.length)];
        
        time1Display.textContent = currentQuestion.time1.description;
        time2Display.textContent = currentQuestion.time2.description;
        time1Description.textContent = `Thời gian thứ nhất`;
        time2Description.textContent = `Thời gian thứ hai`;

        // Reset trạng thái nút
        choice1Btn.classList.remove('selected');
        choice2Btn.classList.remove('selected');
        choice1Btn.disabled = false;
        choice2Btn.disabled = false;

        messageEl.classList.add('hidden');
    }

    // Kiểm tra câu trả lời
    function checkAnswer(selectedTime, otherTime) {
        const selectedSeconds = convertToSeconds(selectedTime);
        const otherSeconds = convertToSeconds(otherTime);

        const isCorrect = selectedSeconds > otherSeconds;

        if (isCorrect) {
            showMessage('Đúng rồi! 🎉', 'bg-green-500');
        } else {
            showMessage('Chưa đúng, thử lại nhé!', 'bg-red-500');
        }

        return isCorrect;
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

    // Xử lý sự kiện click
    choice1Btn.addEventListener('click', function() {
        this.classList.add('selected');
        choice2Btn.classList.remove('selected');
        
        const isCorrect = checkAnswer(currentQuestion.time1, currentQuestion.time2);
        if (isCorrect) {
            choice1Btn.disabled = true;
            choice2Btn.disabled = true;
        }
    });

    choice2Btn.addEventListener('click', function() {
        this.classList.add('selected');
        choice1Btn.classList.remove('selected');
        
        const isCorrect = checkAnswer(currentQuestion.time2, currentQuestion.time1);
        if (isCorrect) {
            choice1Btn.disabled = true;
            choice2Btn.disabled = true;
        }
    });

    nextQuestionBtn.addEventListener('click', generateQuestion);

    // Khởi tạo game
    generateQuestion();
});
</script>
@endsection 