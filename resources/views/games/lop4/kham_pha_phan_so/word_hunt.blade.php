@extends('layouts.game')

@section('content')
    <div class="min-h-screen flex flex-col items-center bg-gradient-to-br from-green-200 via-teal-200 to-lime-200 py-8 px-4 font-sans">
        <div class="w-full max-w-5xl bg-white/70 backdrop-blur-sm rounded-3xl shadow-2xl p-4 md:p-8 flex flex-col items-center animate-fade-in">
            <!-- Header -->
            <div class="flex flex-col items-center text-center mb-4">
                <div id="animated-icon" class="w-20 h-20 mb-2 text-green-700 drop-shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
                        <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-green-800 drop-shadow">Săn Phân Số</h1>
                <p class="text-green-600 mt-1 font-semibold">Click để chọn những chiếc lá có phân số đúng</p>
            </div>

            <!-- Progress Bar & Hint -->
            <div class="w-full max-w-2xl px-4 my-4 space-y-4">
                <div class="w-full bg-lime-200/80 rounded-full h-4 border-2 border-lime-400/50 shadow-inner">
                    <div id="progress-bar" class="bg-gradient-to-r from-teal-400 to-green-500 h-full rounded-full transition-all duration-500" style="width: 0%"></div>
                </div>
                <div id="hint-box" class="w-full bg-yellow-100 border-l-4 border-yellow-400 text-yellow-800 p-3 rounded-xl shadow">
                    <strong>Gợi ý:</strong> <span id="hint-text"></span>
                </div>
            </div>

            <!-- Game Scene -->
            <div id="scene" class="w-full min-h-[300px] md:min-h-[350px] bg-cover bg-center rounded-2xl p-4 relative flex flex-wrap justify-center items-center gap-4 border-4 border-green-800/20 shadow-inner">
                <!-- Leaves will be injected by JS -->
            </div>

            <!-- Controls -->
            <div class="flex items-center gap-4 mt-8">
                <button id="check-btn" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-full shadow-lg transition-all duration-200 text-lg disabled:bg-gray-400 disabled:cursor-not-allowed">Kiểm tra</button>
                <button id="replay-btn" class="hidden px-6 py-3 bg-orange-400 hover:bg-orange-500 text-white font-bold rounded-full shadow-lg transition-all duration-200">Chơi lại từ đầu</button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-8px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        @keyframes pulse-icon {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.08);
            }
        }

        #animated-icon {
            animation: pulse-icon 2.5s ease-in-out infinite;
        }

        .leaf-btn {
            transition: all 0.2s ease-in-out;
            filter: drop-shadow(3px 3px 3px rgba(0, 0, 0, 0.2));
            animation: float 6s ease-in-out infinite;
            animation-delay: var(--float-delay, 0s);
        }

        .leaf-btn:hover {
            filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.3));
            transform: scale(1.05) !important; /* Override float animation */
            animation-play-state: paused;
        }

        .leaf-btn.selected svg {
            transform: scale(1.1);
            filter: drop-shadow(0 0 8px rgba(65, 182, 211, 0.8));
        }

        .leaf-btn.selected svg path {
            stroke: #3be48f; /* amber-400 */
            stroke-width: 3px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const questions = @json($questions);
            let currentLevel = 0;

            // DOM Elements
            const progressBar = document.getElementById('progress-bar');
            const hintText = document.getElementById('hint-text');
            const scene = document.getElementById('scene');
            const checkBtn = document.getElementById('check-btn');
            const replayBtn = document.getElementById('replay-btn');

            function createLeaf(option) {
                const leafBtn = document.createElement('button');
                leafBtn.className = 'leaf-btn w-28 h-28 md:w-32 md:h-32 relative animate-pop-in';
                leafBtn.dataset.correct = option.correct;

                const hue = Math.random() * 40 + 15; // Autumn colors: Oranges, yellows, browns
                const leafSVG = `
            <svg viewBox="0 0 64 64" class="w-full h-full transition-all duration-200">
                <path d="M32 0C32 0 64 32 64 64 64 64 32 32 0 32 0 32 32 0 32 0Z" fill="hsl(${hue}, 85%, 65%)" />
            </svg>
        `;
                const fractionText = `
            <div class="absolute -top-6 inset-0 flex items-center justify-center">
                <span class="font-bold text-xl text-black/70">${option.text}</span>
            </div>
        `;
                leafBtn.innerHTML = leafSVG + fractionText;
                return leafBtn;
            }

            function shuffle(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
                return array;
            }

            function showLevel(level) {
                const question = questions[level];

                // Update UI
                progressBar.style.width = `${((level) / questions.length) * 100}%`;
                hintText.innerHTML = question.hint;
                checkBtn.disabled = true;

                // Clear previous level
                scene.innerHTML = '';

                // Create and shuffle leaves
                const leaves = shuffle(question.options.map(opt => createLeaf(opt)));

                leaves.forEach((leaf, i) => {
                    leaf.style.setProperty('--pop-in-delay', `${i * 50}ms`);
                    leaf.style.setProperty('--float-delay', `${Math.random() * 5}s`);
                    scene.appendChild(leaf);
                });

                addClickListeners();
            }

            function updateCheckButtonState() {
                const selectedLeaves = scene.querySelectorAll('.leaf-btn.selected').length;
                checkBtn.disabled = selectedLeaves === 0;
            }

            function addClickListeners() {
                const leaves = scene.querySelectorAll('.leaf-btn');
                leaves.forEach(leaf => {
                    leaf.addEventListener('click', () => {
                        leaf.classList.toggle('selected');
                        updateCheckButtonState();
                    });
                });
            }

            function checkAnswer() {
                const selectedLeaves = scene.querySelectorAll('.leaf-btn.selected');
                const correctLeaves = scene.querySelectorAll('.leaf-btn[data-correct="true"]');

                let allCorrectSelected = true;
                selectedLeaves.forEach(leaf => {
                    if (leaf.dataset.correct !== 'true') {
                        allCorrectSelected = false;
                    }
                });

                const isCorrect = allCorrectSelected && selectedLeaves.length === correctLeaves.length;

                if (isCorrect) {
                    progressBar.style.width = `${((currentLevel + 1) / questions.length) * 100}%`;
                    Swal.fire({
                        icon: 'success',
                        title: 'Chính xác! 🎉',
                        text: 'Bạn đã tìm thấy tất cả các phân số đúng!',
                        timer: 1500,
                        showConfirmButton: false,
                    });

                    setTimeout(() => {
                        if (currentLevel < questions.length - 1) {
                            currentLevel++;
                            showLevel(currentLevel);
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Bạn đã hoàn thành cuộc đi săn! 🏆',
                                text: 'Một thợ săn phân số cừ khôi!',
                                confirmButtonText: 'Tuyệt vời!',
                            });
                            checkBtn.classList.add('hidden');
                            replayBtn.classList.remove('hidden');
                        }
                    }, 1500);

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Chưa đúng rồi... 🤔',
                        html: 'Hãy nhìn kĩ lại xem. Bạn có thể đã chọn thừa hoặc thiếu chiếc lá nào đó!',
                        confirmButtonText: 'Thử lại',
                    });
                }
            }

            checkBtn.addEventListener('click', checkAnswer);
            replayBtn.addEventListener('click', () => {
                currentLevel = 0;
                showLevel(0);
                progressBar.style.width = '0%';
                checkBtn.classList.remove('hidden');
                replayBtn.classList.add('hidden');
            });

            // Add animation styles
            const style = document.createElement('style');
            style.innerHTML = `
        @keyframes pop-in {
            0% { transform: scale(0); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .animate-pop-in {
            animation: pop-in 0.4s cubic-bezier(.68,-0.55,.27,1.55) backwards;
            animation-delay: var(--pop-in-delay, 0ms);
        }
    `;
            document.head.appendChild(style);

            // Initial game start
            showLevel(currentLevel);
        });
    </script>
@endpush
