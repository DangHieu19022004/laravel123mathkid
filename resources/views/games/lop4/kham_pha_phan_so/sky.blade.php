@extends('layouts.game')

@section('content')
    <div class="min-h-screen flex flex-col items-center bg-gradient-to-b from-cyan-200 to-blue-400 py-8">
        <div class="w-full max-w-3xl bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl p-4 md:p-8 flex flex-col items-center animate-fade-in mx-2 md:mx-0">
            <!-- Header -->
            <div class="flex flex-col items-center text-center mb-2">
                <div class="w-20 h-20 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-full h-full text-blue-500 animate-bounce-slow">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                    </svg>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-blue-600 drop-shadow">Bầu Trời Phân Số</h1>
                <p class="text-gray-500 mt-1">Chọn phân số có giá trị lớn nhất</p>
            </div>

            <!-- Progress Bar & Level Indicator -->
            <div class="w-full px-4 md:px-8 my-4">
                <div class="flex justify-between items-center mb-1 text-gray-600 font-semibold">
                    <span id="level-indicator">Cấp độ 1/5</span>
                    <span>Tiến trình</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4 border border-gray-300">
                    <div id="progress-bar" class="bg-gradient-to-r from-cyan-400 to-blue-500 h-full rounded-full transition-all duration-500" style="width: 20%"></div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="w-full bg-blue-50 border border-l-4 border-blue-400 p-3 rounded-xl mb-4 animate-fade-in max-w-2xl mx-auto">
                <h3 class="font-semibold text-blue-800 mb-1 text-sm">🎯 Hướng dẫn chơi:</h3>
                <ul class="list-disc list-inside text-gray-700 text-sm">
                    <li>Quan sát các phân số trên những đám mây.</li>
                    <li>Click vào đám mây chứa phân số có giá trị "Lớn nhất".</li>
                    <li>Gợi ý: Hãy quy đồng mẫu số để so sánh nếu bạn không chắc chắn!</li>
                </ul>
            </div>

            <!-- Game Area (Sky) -->
            <div id="sky-area" class="w-full min-h-[250px] md:min-h-[300px] bg-gradient-to-b from-sky-300 to-sky-500 rounded-2xl p-4 relative overflow-hidden">
                <!-- Clouds will be injected by JS -->
            </div>

            <!-- Controls -->
            <div class="flex flex-col items-center mt-6">
                <button id="replay-btn" class="hidden mt-2 px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold rounded-full shadow-lg transition-all duration-200 animate-bounce-in text-base">
                    Chơi lại từ đầu
                </button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @keyframes pop-in { 0% { transform: scale(0.7); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
        @keyframes fade-in { 0% { opacity: 0; } 100% { opacity: 1; } }
        @keyframes bounce-in { 0% { transform: scale(0.5); opacity: 0; } 60% { transform: scale(1.1); opacity: 1; } 100% { transform: scale(1); } }
        @keyframes bounce-slow { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        @keyframes shake { 0%, 100% { transform: translateX(0); } 10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); } 20%, 40%, 60%, 80% { transform: translateX(5px); } }

        @keyframes float-in {
            0% { transform: translateY(60px) scale(0.7); opacity: 0; }
            100% { transform: translateY(0) scale(1); opacity: 1; }
        }

        @keyframes float-and-sway {
            0% { transform: translateY(0px) rotate(-1.5deg); }
            50% { transform: translateY(-12px) rotate(1.5deg); }
            100% { transform: translateY(0px) rotate(-1.5deg); }
        }

        @keyframes breathe {
            0% { transform: scale(1); }
            50% { transform: scale(1.03); }
            100% { transform: scale(1); }
        }

        .fraction-cloud-button {
            /* Combine multiple animations */
            animation:
                float-and-sway var(--float-duration, 10s) ease-in-out var(--float-delay, 0s) infinite,
                breathe var(--breathe-duration, 7s) ease-in-out var(--float-delay, 0s) infinite;
        }

        .animate-float-in {
            animation: float-in 0.7s cubic-bezier(.68,-0.55,.27,1.55) backwards;
            animation-delay: calc(var(--float-delay) * 0.1s); /* Stagger entry */
        }

        .fraction-cloud-button svg > path {
            fill: white;
            transition: fill 0.3s ease;
        }
        .fraction-cloud-button:hover svg > path {
            fill: #f0f9ff; /* sky-50, a very light blue */
        }
        .fraction-cloud-button.is-correct svg > path {
            fill: #a7f3d0; /* emerald-200 */
        }
        .fraction-cloud-button.is-incorrect svg > path {
            fill: #fecaca; /* red-200 */
        }
        .fraction-cloud-button:focus-visible {
            outline: none;
        }
        .fraction-cloud-button:focus-visible svg {
            filter: drop-shadow(0 0 6px #60a5fa); /* blue-400 */
        }

        .animate-fade-in { animation: fade-in 0.7s ease-out; }
        .animate-bounce-in { animation: bounce-in 0.6s; }
        .animate-bounce-slow { animation: bounce-slow 2.5s infinite ease-in-out; }
        .animate-shake { animation: shake 0.5s; }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const questions = @json($questions);
            let currentLevel = 0;
            let isAnswered = false;

            const skyArea = document.getElementById('sky-area');
            const levelIndicator = document.getElementById('level-indicator');
            const progressBar = document.getElementById('progress-bar');
            const replayBtn = document.getElementById('replay-btn');

            function createCloud(fraction, index) {
                const cloudButton = document.createElement('button');
                cloudButton.className = 'fraction-cloud-button absolute w-28 h-20 md:w-36 md:h-24 transition-transform duration-300 hover:scale-110 focus:outline-none';
                cloudButton.dataset.index = index;

                const cloudSVG = `
                    <svg viewBox="0 0 263.3 170.3" class="w-full h-full drop-shadow-md transition-all duration-300">
                        <path d="M211.9,170.3H51.4C23,170.3,0,147.2,0,118.9c0-23.9,15.8-44.2,37.8-50.2c-1-3.6-1.5-7.3-1.5-11.2C36.3,25.9,59.3,3,87.7,3c19.7,0,36.9,11,45.4,27.3c6.4-3.4,13.6-5.3,21.2-5.3c27,0,48.9,21.9,48.9,48.9c0,2.1-0.1,4.2-0.4,6.2C241,83.3,263.3,103.8,263.3,129C263.3,152,240.2,170.3,211.9,170.3z"/>
                    </svg>
                `;

                const fractionText = `
                    <div class="absolute -left-4 inset-0 flex items-center justify-center">
                        <span class="text-lg md:text-2xl font-bold text-gray-700 drop-shadow-sm">${fraction.numerator}</span>
                        <span class="text-base md:text-xl font-bold text-gray-600/90 drop-shadow-sm mx-1">/</span>
                        <span class="text-lg md:text-2xl font-bold text-gray-700 drop-shadow-sm">${fraction.denominator}</span>
                    </div>
                `;

                cloudButton.innerHTML = cloudSVG + fractionText;

                // Set random duration and delay for the float animation
                const floatDuration = Math.random() * 6 + 8; // 8s to 14s
                const floatDelay = Math.random() * 8;      // 0-8s delay
                cloudButton.style.setProperty('--float-duration', `${floatDuration}s`);
                cloudButton.style.setProperty('--float-delay', `${floatDelay}s`);

                // Set random duration for the breathing animation
                const breatheDuration = Math.random() * 5 + 4; // 4s to 9s
                cloudButton.style.setProperty('--breathe-duration', `${breatheDuration}s`);

                cloudButton.classList.add('animate-float-in');

                // --- Random positioning logic ---
                const numFractions = questions[currentLevel].fractions.length;
                // Divide sky into vertical slots to prevent major horizontal overlap
                const slotWidth = 100 / numFractions;
                // Random left position within the slot (cloud is ~20% wide of the container)
                const left = (index * slotWidth) + (Math.random() * (slotWidth - 20));
                // Random top position
                const top = Math.random() * 45 + 5; // From 5% to 50% from top

                cloudButton.style.top = `${top}%`;
                cloudButton.style.left = `${left}%`;
                // --- End of positioning logic ---

                cloudButton.style.animationDelay = `${index * 100}ms`;
                cloudButton.addEventListener('click', () => handleAnswer(index, cloudButton));
                return cloudButton;
            }

            function showLevel(level) {
                isAnswered = false;
                const question = questions[level];

                // Update UI
                levelIndicator.textContent = `Cấp độ ${level + 1}/${questions.length}`;
                progressBar.style.width = `${((level + 1) / questions.length) * 100}%`;
                replayBtn.classList.add('hidden');
                skyArea.innerHTML = '';

                // Create new clouds
                question.fractions.forEach((fraction, index) => {
                    const cloud = createCloud(fraction, index);
                    skyArea.appendChild(cloud);
                });
            }

            function handleAnswer(selectedIndex, selectedCloud) {
                if (isAnswered) return;
                isAnswered = true;

                const question = questions[currentLevel];
                const correct = selectedIndex === question.correct_index;

                // Disable all clouds
                document.querySelectorAll('.fraction-cloud-button').forEach(c => c.disabled = true);

                if (correct) {
                    selectedCloud.classList.add('is-correct', 'animate-pulse');
                    Swal.fire({
                        icon: 'success',
                        title: 'Đúng rồi! 🎉',
                        text: 'Bạn thật giỏi!',
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: {popup: 'animate-pop-in'}
                    });

                    setTimeout(() => {
                        if (currentLevel < questions.length - 1) {
                            currentLevel++;
                            showLevel(currentLevel);
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Hoàn thành xuất sắc! 🏆',
                                text: 'Bạn đã chinh phục bầu trời phân số!',
                                confirmButtonText: 'Tuyệt vời!',
                                confirmButtonColor: '#3B82F6',
                                customClass: {popup: 'animate-pop-in'}
                            });
                            replayBtn.classList.remove('hidden');
                        }
                    }, 1500);
                } else {
                    selectedCloud.classList.add('is-incorrect', 'animate-shake');
                    Swal.fire({
                        icon: 'error',
                        title: 'Chưa đúng 🤔',
                        text: 'Hãy thử lại nhé!',
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: {popup: 'animate-pop-in'}
                    });

                    // Highlight correct answer
                    const correctCloud = skyArea.querySelector(`[data-index="${question.correct_index}"]`);
                    if (correctCloud) {
                        correctCloud.classList.add('is-correct');
                    }

                    // Reset for another try after a delay
                    setTimeout(() => {
                        isAnswered = false;
                        document.querySelectorAll('.fraction-cloud-button').forEach(c => {
                            c.disabled = false;
                            c.classList.remove('is-correct', 'is-incorrect', 'animate-shake', 'animate-pulse');
                        });
                    }, 2000);
                }
            }

            replayBtn.addEventListener('click', function () {
                currentLevel = 0;
                showLevel(currentLevel);
                replayBtn.classList.add('hidden');
            });

            showLevel(currentLevel);
        });
    </script>
@endpush
