@extends('layouts.game')

@section('content')
    <div class="flex justify-center items-center min-h-screen bg-gradient-to-br from-blue-200 via-blue-100 to-pink-100">
        <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-lg border-2 border-blue-400 animate-fade-in">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-extrabold text-blue-700 drop-shadow mb-2 flex items-center justify-center gap-2">
                    <span class="animate-bounce">🥛</span> So Sánh Dung Tích <span class="animate-bounce">🛢️</span>
                </h1>
                <p class="text-gray-600 text-lg">Câu hỏi <span id="levelDisplay">1</span> /
                    <span id="maxLevelDisplay">5</span></p>
            </div>
            <div id="questionBox" class="text-center mb-8"></div>
            <div class="flex items-center justify-center gap-2 mb-6">
                <span class="font-bold text-blue-700 text-xl">Chọn đáp án đúng:</span>
            </div>
            <div class="flex justify-center gap-4 mb-2">
                <button id="resetBtn" class="w-40 h-14 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white rounded-xl hover:scale-105 active:scale-95 transition text-lg font-bold flex items-center justify-center gap-2 shadow-lg focus:outline-none focus:ring-2 focus:ring-yellow-300">
                    <span>🔄</span>Chơi lại
                </button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @keyframes shape-correct {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 #22c55e44;
            }
            50% {
                transform: scale(1.12);
                box-shadow: 0 0 30px 10px #22c55e44;
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 #22c55e44;
            }
        }

        @keyframes shape-wrong {
            0% {
                transform: translateX(0);
            }
            20% {
                transform: translateX(-10px);
            }
            40% {
                transform: translateX(10px);
            }
            60% {
                transform: translateX(-8px);
            }
            80% {
                transform: translateX(8px);
            }
            100% {
                transform: translateX(0);
            }
        }

        .animate-shape-correct {
            animation: shape-correct 0.7s;
        }

        .animate-shape-wrong {
            animation: shape-wrong 0.5s;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.7s;
        }
    </style>
@endpush

@push('scripts')
    <script src="/js/sweetalert2.min.js"></script>
    <script>
        const questions = @json($questions);
        let currentIdx = 0;
        let answered = false;

        const levelDisplay = document.getElementById('levelDisplay');
        const maxLevelDisplay = document.getElementById('maxLevelDisplay');
        const questionBox = document.getElementById('questionBox');
        const resetBtn = document.getElementById('resetBtn');

        maxLevelDisplay.textContent = questions.length;

        function renderQuestion(idx) {
            answered = false;
            const q = questions[idx];
            levelDisplay.textContent = idx + 1;
            // Render các object để chọn
            let html = '<div class="flex flex-wrap justify-center gap-6">';
            q.objects.forEach((o, i) => {
                html += `<button class='object-card group relative flex flex-col items-center justify-center w-32 h-40 bg-gradient-to-br from-blue-100 to-blue-200 border-4 border-blue-300 rounded-2xl shadow-lg hover:scale-105 transition cursor-pointer' data-idx='${i}'>
            <span class='text-5xl mb-2'>${o.emoji}</span>
            <span class='font-bold text-lg text-blue-700 mb-1'>${o.object}</span>
            <span class='text-gray-600'>${o.volume} ${o.unit}</span>
        </button>`;
            });
            html += '</div>';
            html += `<div class='mt-6 text-lg font-semibold text-blue-700'>${q.type === 'max' ? 'Chọn vật có dung tích lớn nhất' : 'Chọn vật có dung tích nhỏ nhất'}</div>`;
            questionBox.innerHTML = html;
            // Gắn sự kiện chọn đáp án
            document.querySelectorAll('.object-card').forEach(btn => {
                btn.onclick = function () {
                    if (answered) return;
                    const idxBtn = parseInt(this.getAttribute('data-idx'));
                    if (idxBtn === q.answer_index) {
                        this.classList.add('border-green-400', 'animate-shape-correct');
                        setTimeout(() => this.classList.remove('animate-shape-correct'), 800);
                        answered = true;
                        if (currentIdx < questions.length - 1) {
                            Swal.fire({icon: 'success', title: '🎉 Chính xác!', showConfirmButton: false, timer: 1200});
                            setTimeout(() => {
                                currentIdx++;
                                renderQuestion(currentIdx);
                            }, 1200);
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: '🎉 Hoàn thành!',
                                text: 'Bạn đã hoàn thành tất cả câu hỏi!',
                                confirmButtonText: 'Chơi lại'
                            }).then(() => {
                                currentIdx = 0;
                                renderQuestion(currentIdx);
                            });
                        }
                    } else {
                        this.classList.add('border-red-400', 'animate-shape-wrong');
                        setTimeout(() => this.classList.remove('animate-shape-wrong', 'border-red-400'), 600);
                        Swal.fire({
                            icon: 'error',
                            title: '❌ Sai!',
                            text: 'Hãy thử lại!',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        }

        resetBtn.addEventListener('click', function () {
            currentIdx = 0;
            renderQuestion(currentIdx);
        });

        document.addEventListener('DOMContentLoaded', function () {
            renderQuestion(currentIdx);
        });
    </script>
@endpush
