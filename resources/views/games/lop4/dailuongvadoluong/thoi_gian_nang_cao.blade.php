@extends('layouts.game')

@section('title', 'Thời Gian Nâng Cao')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600">Thời Gian Nâng Cao ⏰</h1>
        <p class="text-lg mt-2">Giải các bài toán thời gian phức tạp</p>
    </div>

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-6">
        <!-- Khu vực hiển thị bài toán -->
        <div class="mb-8">
            <div class="bg-blue-50 p-6 rounded-lg">
                <h3 class="text-xl font-bold mb-4">Bài toán:</h3>
                <p id="problem-text" class="text-lg mb-4">
                    <!-- Nội dung bài toán sẽ được thêm bằng JavaScript -->
                </p>
                <div id="problem-hint" class="text-sm text-gray-600 italic hidden">
                    <!-- Gợi ý sẽ được thêm bằng JavaScript -->
                </div>
            </div>
        </div>

        <!-- Khu vực nhập đáp án -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Nhập thời gian -->
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Đáp án của bạn:
                    </label>
                    <div class="flex gap-2">
                        <input type="number" id="hours-input" 
                               class="w-20 px-3 py-2 border rounded-lg text-center"
                               min="0" max="23" placeholder="Giờ">
                        <span class="py-2">:</span>
                        <input type="number" id="minutes-input" 
                               class="w-20 px-3 py-2 border rounded-lg text-center"
                               min="0" max="59" placeholder="Phút">
                    </div>
                </div>

                <!-- Nút điều khiển -->
                <div class="space-y-2">
                    <button id="check-answer" 
                            class="w-full bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        Kiểm tra
                    </button>
                    <button id="show-hint" 
                            class="w-full bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600 transition-colors">
                        Xem gợi ý
                    </button>
                    <button id="next-question" 
                            class="w-full bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition-colors">
                        Câu hỏi tiếp theo
                    </button>
                </div>
            </div>

            <!-- Bảng giúp đỡ -->
            <div class="bg-blue-50 p-4 rounded-lg">
                <h4 class="font-bold mb-2">Lưu ý khi giải toán thời gian:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li>1 giờ = 60 phút</li>
                    <li>1 ngày = 24 giờ</li>
                    <li>Khi cộng/trừ thời gian, chú ý đến việc nhớ/mượn</li>
                    <li>Với thời gian trong ngày, giờ không vượt quá 23</li>
                    <li>Với phút, không vượt quá 59</li>
                </ul>
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
    const problemText = document.getElementById('problem-text');
    const problemHint = document.getElementById('problem-hint');
    const hoursInput = document.getElementById('hours-input');
    const minutesInput = document.getElementById('minutes-input');
    const checkAnswerBtn = document.getElementById('check-answer');
    const showHintBtn = document.getElementById('show-hint');
    const nextQuestionBtn = document.getElementById('next-question');
    const messageEl = document.getElementById('message');

    let currentProblem = null;

    // Danh sách các bài toán
    const problems = [
        {
            text: 'Một chuyến xe khởi hành lúc 7 giờ 45 phút. Xe chạy trong 2 giờ 30 phút thì đến nơi. Hỏi xe đến nơi lúc mấy giờ?',
            answer: { hours: 10, minutes: 15 },
            hint: 'Cộng thời gian: 7:45 + 2:30'
        },
        {
            text: 'Một buổi học bắt đầu từ 13 giờ 20 phút và kết thúc lúc 16 giờ 45 phút. Hỏi buổi học kéo dài bao lâu?',
            answer: { hours: 3, minutes: 25 },
            hint: 'Tính hiệu thời gian: 16:45 - 13:20'
        },
        {
            text: 'Bây giờ là 9 giờ 45 phút. Hỏi 2 giờ 30 phút trước là mấy giờ?',
            answer: { hours: 7, minutes: 15 },
            hint: 'Trừ thời gian: 9:45 - 2:30'
        },
        {
            text: 'Một bộ phim bắt đầu lúc 19 giờ 30 phút và kéo dài 1 giờ 45 phút. Hỏi phim kết thúc lúc mấy giờ?',
            answer: { hours: 21, minutes: 15 },
            hint: 'Cộng thời gian: 19:30 + 1:45'
        },
        {
            text: 'Hiện tại là 15 giờ 20 phút. Hỏi sau 3 giờ 45 phút nữa là mấy giờ?',
            answer: { hours: 19, minutes: 5 },
            hint: 'Cộng thời gian: 15:20 + 3:45'
        }
    ];

    // Tạo câu hỏi mới
    function generateQuestion() {
        currentProblem = problems[Math.floor(Math.random() * problems.length)];
        problemText.textContent = currentProblem.text;
        problemHint.textContent = currentProblem.hint;
        problemHint.classList.add('hidden');
        hoursInput.value = '';
        minutesInput.value = '';
        messageEl.classList.add('hidden');
    }

    // Kiểm tra câu trả lời
    function checkAnswer() {
        const userHours = parseInt(hoursInput.value) || 0;
        const userMinutes = parseInt(minutesInput.value) || 0;
        
        const isCorrect = userHours === currentProblem.answer.hours && 
                         userMinutes === currentProblem.answer.minutes;

        if (isCorrect) {
            showMessage('Đúng rồi! 🎉', 'bg-green-500');
        } else {
            showMessage('Chưa đúng, thử lại nhé!', 'bg-red-500');
        }
    }

    // Hiển thị gợi ý
    function showHint() {
        problemHint.classList.remove('hidden');
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

    // Xử lý nhập liệu
    function handleInput(input, max) {
        let value = parseInt(input.value) || 0;
        if (value < 0) value = 0;
        if (value > max) value = max;
        input.value = value;
    }

    // Event listeners
    hoursInput.addEventListener('input', function() {
        handleInput(this, 23);
    });

    minutesInput.addEventListener('input', function() {
        handleInput(this, 59);
    });

    checkAnswerBtn.addEventListener('click', checkAnswer);
    showHintBtn.addEventListener('click', showHint);
    nextQuestionBtn.addEventListener('click', generateQuestion);

    // Khởi tạo game
    generateQuestion();
});
</script>
@endsection 