@extends('layouts.game')

@section('content')
    <div class="min-h-screen flex flex-col items-center bg-gradient-to-br from-blue-200 via-indigo-200 to-purple-200 py-4 md:py-8">
        <div class="w-full max-w-lg bg-white/90 rounded-3xl shadow-2xl p-0 md:p-0 flex flex-col items-center animate-fade-in mx-2 md:mx-0 relative overflow-hidden">
            <!-- Top Illustration -->
            <div class="w-full flex flex-col items-center pt-8 pb-2 bg-gradient-to-r from-blue-400 to-purple-400 rounded-t-3xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mb-2 animate-bounce-slow" viewBox="0 0 36 36">
                    <path fill="#CCD6DD" d="M31 2H5C3.343 2 2 3.343 2 5v26c0 1.657 1.343 3 3 3h26c1.657 0 3-1.343 3-3V5c0-1.657-1.343-3-3-3z"/>
                    <path fill="#E1E8ED" d="M31 1H5C2.791 1 1 2.791 1 5v26c0 2.209 1.791 4 4 4h26c2.209 0 4-1.791 4-4V5c0-2.209-1.791-4-4-4zm0 2c1.103 0 2 .897 2 2v4h-6V3h4zm-4 16h6v6h-6v-6zm0-2v-6h6v6h-6zM25 3v6h-6V3h6zm-6 8h6v6h-6v-6zm0 8h6v6h-6v-6zM17 3v6h-6V3h6zm-6 8h6v6h-6v-6zm0 8h6v6h-6v-6zM3 5c0-1.103.897-2 2-2h4v6H3V5zm0 6h6v6H3v-6zm0 8h6v6H3v-6zm2 14c-1.103 0-2-.897-2-2v-4h6v6H5zm6 0v-6h6v6h-6zm8 0v-6h6v6h-6zm12 0h-4v-6h6v4c0 1.103-.897 2-2 2z"/>
                    <path fill="#DD2E44" d="M4.998 33c-.32 0-.645-.076-.946-.239-.973-.523-1.336-1.736-.813-2.709l7-13c.299-.557.845-.939 1.47-1.031.626-.092 1.258.118 1.705.565l6.076 6.076 9.738-18.59c.512-.978 1.721-1.357 2.699-.843.979.512 1.356 1.721.844 2.7l-11 21c-.295.564-.841.953-1.47 1.05-.627.091-1.266-.113-1.716-.563l-6.1-6.099-5.724 10.631C6.4 32.619 5.71 33 4.998 33z"/>
                </svg>
                <h1 class="text-2xl md:text-4xl font-extrabold text-white mb-1 drop-shadow text-center">Câu Đố Phân Số</h1>
            </div>
            <!-- Progress Bar -->
            <div class="w-full px-8 mt-2 mb-4">
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div id="progress-bar" class="bg-gradient-to-r from-blue-500 to-purple-500 h-3 rounded-full transition-all duration-500" style="width: 20%"></div>
                </div>
                <div id="level-indicator" class="text-sm text-gray-600 mt-1 text-right font-semibold">Cấp độ 1/5</div>
            </div>
            <!-- Card -->
            <div class="w-full flex flex-col items-center px-6 pb-8">
                <!-- Instructions -->
                <div class="w-full bg-blue-50 border-l-4 border-blue-400 p-3 rounded-xl mb-4 animate-fade-in">
                    <h3 class="font-semibold text-blue-700 mb-1 text-sm">🎯 Hướng dẫn:</h3>
                    <ul class="list-disc list-inside text-gray-700 text-xs md:text-base">
                        <li>Đọc câu đố cẩn thận</li>
                        <li>Điền phân số thích hợp vào chỗ trống</li>
                        <li>Rút gọn phân số nếu có thể</li>
                    </ul>
                </div>
                <!-- Sentence Problem -->
                <div class="w-full flex flex-col items-center mb-4">
                    <div class="bg-gradient-to-br from-blue-100 to-purple-100 rounded-2xl p-4 shadow-lg mb-2 animate-pop-in w-full">
                        <p id="sentence-question" class="text-base md:text-xl font-semibold text-gray-700 text-center transition-all duration-300">
                            <!-- JS will fill this -->
                        </p>
                    </div>
                </div>
                <!-- Answer Input Card -->
                <form id="answer-form" class="flex flex-col items-center gap-2 mb-3 animate-fade-in w-full max-w-xs md:max-w-md mx-auto">
                    <div class="bg-white rounded-2xl shadow-lg border border-blue-200 px-4 py-3 w-full flex flex-row items-center gap-3 justify-center">
                        <div class="flex flex-col items-center">
                            <label for="numerator" class="text-xs text-gray-500 font-semibold mb-1">Tử số</label>
                            <input type="number" id="numerator" class="w-16 md:w-20 px-2 py-2 rounded-lg border-2 border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-center font-bold text-lg bg-blue-50 shadow-sm transition-all duration-200 outline-none" placeholder="0" min="0" required autocomplete="off">
                        </div>
                        <span class="text-2xl font-bold text-blue-400 mx-1 select-none">/</span>
                        <div class="flex flex-col items-center">
                            <label for="denominator" class="text-xs text-gray-500 font-semibold mb-1">Mẫu số</label>
                            <input type="number" id="denominator" class="w-16 md:w-20 px-2 py-2 rounded-lg border-2 border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-center font-bold text-lg bg-blue-50 shadow-sm transition-all duration-200 outline-none" placeholder="1" min="1" required autocomplete="off">
                        </div>
                    </div>
                    <button type="submit" class="w-full md:w-1/2 mt-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white font-bold rounded-full shadow transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400 flex items-center justify-center gap-2 text-base">
                        Kiểm tra
                    </button>
                </form>
                <div id="hint" class="w-full max-w-md bg-purple-100 border-l-4 border-purple-400 text-purple-800 font-semibold rounded-xl px-4 py-3 mt-2 mb-2 hidden animate-fade-in">
                    <i class="fas fa-lightbulb"></i> <span id="hint-text"></span>
                </div>
                <button id="replay-btn" class="hidden mt-2 px-4 py-2 bg-gradient-to-r from-blue-300 to-purple-300 hover:from-blue-400 hover:to-purple-400 text-blue-900 font-bold rounded-full shadow transition-all duration-200 animate-bounce-in text-sm md:text-base">Chơi lại từ đầu</button>
            </div>
            <!-- Toast Notification -->
            <div id="toast" class="fixed bottom-6 right-6 z-50 hidden min-w-[180px] max-w-xs bg-white border-l-4 border-blue-500 shadow-lg rounded-xl px-4 py-3 flex items-center gap-2 animate-fade-in">
                <span id="toast-icon"></span>
                <span id="toast-message" class="font-semibold"></span>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Google Fonts -->
    <script>
        // Game data (5 levels)
        const questions = @json($questions);

        let currentLevel = 0;
        let wrongAttempts = 0;

        const sentenceQuestion = document.getElementById('sentence-question');
        const levelIndicator = document.getElementById('level-indicator');
        const numeratorInput = document.getElementById('numerator');
        const denominatorInput = document.getElementById('denominator');
        const answerForm = document.getElementById('answer-form');
        const hintDiv = document.getElementById('hint');
        const hintText = document.getElementById('hint-text');
        const replayBtn = document.getElementById('replay-btn');
        const progressBar = document.getElementById('progress-bar');
        const toast = document.getElementById('toast');
        const toastIcon = document.getElementById('toast-icon');
        const toastMessage = document.getElementById('toast-message');

        function showLevel(level) {
            const q = questions[level];
            sentenceQuestion.textContent = q.text;
            levelIndicator.textContent = `Cấp độ ${level + 1}/${questions.length}`;
            progressBar.style.width = `${((level + 1) / questions.length) * 100}%`;
            numeratorInput.value = '';
            denominatorInput.value = '';
            numeratorInput.disabled = false;
            denominatorInput.disabled = false;
            answerForm.querySelector('button').disabled = false;
            hintDiv.classList.add('hidden');
            wrongAttempts = 0;
            numeratorInput.focus();
        }

        function checkAnswer(level, num, den) {
            const correct = questions[level].answer;
            // Compare fractions: a/b == c/d <=> a*d == b*c
            return (num * correct.denominator) === (den * correct.numerator);
        }

        function showToast(type, message) {
            toast.classList.remove('hidden');
            toast.classList.add('flex');
            toast.classList.remove('animate-fade-out');
            if (type === 'success') {
                toastIcon.innerHTML = '✅';
                toast.classList.remove('border-red-500');
                toast.classList.add('border-blue-500');
            } else {
                toastIcon.innerHTML = '❌';
                toast.classList.remove('border-blue-500');
                toast.classList.add('border-red-500');
            }
            toastMessage.textContent = message;
            setTimeout(() => {
                toast.classList.add('animate-fade-out');
                setTimeout(() => {
                    toast.classList.add('hidden');
                    toast.classList.remove('flex');
                    toast.classList.remove('animate-fade-out');
                }, 600);
            }, 1200);
        }

        answerForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const num = parseInt(numeratorInput.value);
            const den = parseInt(denominatorInput.value);
            if (isNaN(num) || isNaN(den) || den <= 0) {
                showToast('error', 'Vui lòng nhập số hợp lệ!');
                return;
            }
            answerForm.querySelector('button').disabled = true;
            numeratorInput.disabled = true;
            denominatorInput.disabled = true;
            if (checkAnswer(currentLevel, num, den)) {
                showToast('success', 'Đúng rồi! 🎉');
                setTimeout(() => {
                    if (currentLevel < questions.length - 1) {
                        currentLevel++;
                        showLevel(currentLevel);
                    } else {
                        showToast('success', 'Hoàn thành tất cả cấp độ! 🏆');
                        setTimeout(() => {
                            currentLevel = 0;
                            showLevel(currentLevel);
                        }, 1200);
                        replayBtn.classList.remove('hidden');
                    }
                }, 1200);
            } else {
                wrongAttempts++;
                showToast('error', 'Chưa đúng, hãy thử lại!');
                if (wrongAttempts >= 2) {
                    hintText.textContent = questions[currentLevel].hint;
                    hintDiv.classList.remove('hidden');
                }
                setTimeout(() => {
                    numeratorInput.value = '';
                    denominatorInput.value = '';
                    numeratorInput.disabled = false;
                    denominatorInput.disabled = false;
                    answerForm.querySelector('button').disabled = false;
                    numeratorInput.focus();
                }, 1200);
            }
        });

        replayBtn.addEventListener('click', function () {
            currentLevel = 0;
            showLevel(currentLevel);
            replayBtn.classList.add('hidden');
        });

        // Animations & Custom Font
        const style = document.createElement('style');
        style.innerHTML = `
@keyframes pop-in { 0% { transform: scale(0.7); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
@keyframes fade-in { 0% { opacity: 0; } 100% { opacity: 1; } }
@keyframes fade-out { 0% { opacity: 1; } 100% { opacity: 0; } }
@keyframes bounce-in { 0% { transform: translateY(40px); opacity: 0; } 60% { transform: translateY(-10px); opacity: 1; } 100% { transform: translateY(0); } }
@keyframes bounce-slow { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
.animate-pop-in { animation: pop-in 0.4s cubic-bezier(.68,-0.55,.27,1.55); }
.animate-fade-in { animation: fade-in 0.7s; }
.animate-fade-out { animation: fade-out 0.6s; }
.animate-bounce-in { animation: bounce-in 0.7s; }
.animate-bounce-slow { animation: bounce-slow 2s infinite; }
`;
        document.head.appendChild(style);

        // Start game
        showLevel(currentLevel);
    </script>
@endpush
