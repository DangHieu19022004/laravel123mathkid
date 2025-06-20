@extends('layouts.game')

@section('content')
    <div class="min-h-screen flex flex-col items-center bg-gradient-to-br from-purple-400 via-cyan-200 to-sky-100 py-8">
        <div class="w-full max-w-xl bg-white/60 backdrop-blur-md rounded-3xl shadow-2xl p-2 sm:p-6 flex flex-col items-center border border-white/40">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-purple-700 mb-2 flex items-center gap-2 drop-shadow-lg">
                <span>Dãy Số Quy Luật</span> <span class="text-xl sm:text-2xl md:text-3xl">✨</span>
            </h1>
            <div class="w-full mb-4">
                <div class="bg-cyan-50 border-l-4 border-cyan-400 rounded-xl p-4 flex flex-col gap-2 shadow-sm">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-2xl">📖</span>
                        <span class="font-bold text-cyan-700 text-lg">Hướng dẫn chơi:</span>
                    </div>
                    <ul class="list-disc pl-6 text-cyan-800 text-sm">
                        <li>Quan sát dãy phân số đã cho và tìm quy luật thay đổi.</li>
                        <li>Điền tử số và mẫu số của phân số tiếp theo vào ô trống.</li>
                        <li>Nhấn <span class='inline-block px-2 py-1 bg-cyan-200 rounded text-cyan-900 font-semibold'>Kiểm tra</span> để xác nhận đáp án.</li>
                        <li>Nếu đúng, bạn sẽ được chuyển sang cấp độ tiếp theo.</li>
                        <li>Nếu sai, hãy thử lại cho đến khi đúng!</li>
                    </ul>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-between w-full mb-4 sm:mb-6 gap-2 sm:gap-6">
                <span class="inline-flex items-center px-3 sm:px-4 py-2 rounded-full bg-gradient-to-r from-fuchsia-400 via-cyan-400 to-sky-400 text-white font-bold text-base sm:text-lg shadow">
                    <span class="mr-2">Cấp độ</span>
                    <span id="level" class="text-xl sm:text-2xl font-extrabold drop-shadow">1</span>
                    <span class="mx-1 text-base sm:text-lg font-bold">/5</span>
                    <span class="ml-1">🪐</span>
                </span>
                <div class="relative w-full my-2 sm:w-64 h-5 sm:h-5 bg-white/40 rounded-full overflow-hidden shadow">
                    <div id="progress-bar" class="absolute left-0 top-0 h-5 sm:h-5 bg-gradient-to-r from-fuchsia-400 via-cyan-400 to-sky-400 rounded-full animate-progress-stripes transition-all duration-700" style="width: 0%"></div>
                    <div class="absolute inset-0 flex items-center justify-center text-xs font-bold text-gray-500">Tiến trình</div>
                </div>
            </div>
            <p class="text-gray-700 mb-2 text-center">Hãy điền phân số tiếp theo vào dãy cho đúng quy luật!</p>
            <div id="pattern-sequence" class="flex flex-wrap gap-3 sm:gap-6 mb-6 sm:mb-8 justify-center items-center w-full"></div>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-6 w-full justify-center mb-4">
                <button id="check-answer" class="w-full sm:w-auto px-6 sm:px-8 py-3 rounded-full bg-gradient-to-r from-cyan-400 via-fuchsia-400 to-sky-400 text-white font-extrabold shadow-xl text-base sm:text-lg flex items-center justify-center gap-2 transition-all duration-200 hover:scale-110 focus:ring-4 focus:ring-cyan-200 active:scale-95 floating-glow">
                    <span>🔍</span> <span>Kiểm tra</span>
                </button>
                <button id="next-level" class="w-full sm:w-auto px-6 sm:px-8 py-3 rounded-full bg-gradient-to-r from-violet-400 via-sky-300 to-cyan-400 text-white font-extrabold shadow-xl text-base sm:text-lg flex items-center justify-center gap-2 transition-all duration-200 hover:scale-110 focus:ring-4 focus:ring-violet-200 active:scale-95 hidden floating-glow">
                    <span>⏭️</span> <span>Tiếp theo</span>
                </button>
                <button id="resetBtn" class="w-full sm:w-auto px-6 sm:px-8 py-3 rounded-full bg-gradient-to-r from-sky-200 via-fuchsia-200 to-cyan-200 text-cyan-700 font-extrabold shadow-xl text-base sm:text-lg flex items-center justify-center gap-2 transition-all duration-200 hover:scale-110 focus:ring-4 focus:ring-sky-100 active:scale-95 floating-glow">
                    <span>🔁</span> <span>Chơi lại</span>
                </button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @keyframes progress-stripes {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: 40px 0;
            }
        }

        .animate-progress-stripes {
            background-image: repeating-linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0 10px, transparent 10px 20px);
            background-size: 40px 40px;
            animation: progress-stripes 1s linear infinite;
        }

        @keyframes bounce-slow {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-8px);
            }
        }

        .animate-bounce-slow {
            animation: bounce-slow 1.2s infinite;
        }

        @keyframes shake {
            10%, 90% {
                transform: translateX(-2px);
            }
            20%, 80% {
                transform: translateX(4px);
            }
            30%, 50%, 70% {
                transform: translateX(-8px);
            }
            40%, 60% {
                transform: translateX(8px);
            }
        }

        .shake {
            animation: shake 0.5s;
        }

        .floating-glow {
            box-shadow: 0 4px 24px 0 rgba(137, 207, 240, 0.25), 0 1.5px 8px 0 rgba(236, 72, 153, 0.12);
            filter: drop-shadow(0 0 8px #a5f3fc88);
        }

        .neumorph {
            background: linear-gradient(145deg, #f3f4f6 60%, #e0e7ef 100%);
            box-shadow: 6px 6px 16px #cbd5e1, -6px -6px 16px #fff;
        }
    </style>
@endpush

@push('scripts')
    <script src="/js/sweetalert2.min.js"></script>
    <script>
        const QUESTIONS = @json($questions);
        let level = 1;

        function renderPattern() {
            const q = QUESTIONS[level - 1] || QUESTIONS[0];
            document.getElementById('level').textContent = level;
            document.getElementById('progress-bar').style.width = ((level - 1) * 100 / 4) + '%';
            const seqDiv = document.getElementById('pattern-sequence');
            seqDiv.innerHTML = '';
            q.sequence.forEach(frac => {
                const el = document.createElement('div');
                el.className = 'neumorph px-2 sm:px-4 py-3 sm:py-5 text-lg sm:text-2xl font-bold text-purple-700 shadow-lg flex flex-col items-center floating-glow transition-all duration-300 min-w-[60px] sm:min-w-[90px]';
                el.innerHTML = `<span>${frac.numerator}</span><span class='text-base font-normal'>—</span><span>${frac.denominator}</span>`;
                seqDiv.appendChild(el);
            });
            // Input cho đáp án
            const inputDiv = document.createElement('div');
            inputDiv.className = 'flex flex-col items-center gap-1 neumorph px-4 sm:px-7 py-3 sm:py-5 shadow-lg floating-glow min-w-[60px] sm:min-w-[90px]';
            inputDiv.innerHTML = `
        <input id="ans-num" type="number" class="w-36 sm:w-24 px-2 py-1 border-2 border-cyan-300 focus:ring-2 focus:ring-fuchsia-400 font-bold text-center mb-1 bg-white/80" placeholder="Tử số">
        <span class='text-base font-normal'>—</span>
        <input id="ans-den" type="number" class="w-36 sm:w-24 px-2 py-1 border-2 border-cyan-300 focus:ring-2 focus:ring-fuchsia-400 font-bold text-center bg-white/80" placeholder="Mẫu số">
    `;
            seqDiv.appendChild(inputDiv);
            document.getElementById('next-level').classList.add('hidden');
            document.getElementById('check-answer').classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            renderPattern();
            document.getElementById('check-answer').onclick = function () {
                const q = QUESTIONS[level - 1] || QUESTIONS[0];
                const num = parseInt(document.getElementById('ans-num').value);
                const den = parseInt(document.getElementById('ans-den').value);
                if (num === q.answer.numerator && den === q.answer.denominator) {
                    document.getElementById('pattern-sequence').classList.add('animate-bounce-slow');
                    Swal.fire({
                        icon: 'success',
                        title: 'Chính xác!',
                        text: 'Bạn đã điền đúng phân số tiếp theo!',
                        background: '#f0fff4',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        document.getElementById('pattern-sequence').classList.remove('animate-bounce-slow');
                        if (level < 5) {
                            document.getElementById('check-answer').classList.add('hidden');
                            document.getElementById('next-level').classList.remove('hidden');
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Chúc mừng!',
                                text: 'Bạn đã hoàn thành tất cả các cấp độ!',
                                confirmButtonText: 'Chơi lại',
                                background: '#f0f9ff',
                            }).then(() => {
                                level = 1;
                                renderPattern();
                            });
                        }
                    });
                } else {
                    document.getElementById('pattern-sequence').classList.add('shake');
                    Swal.fire({
                        icon: 'error',
                        title: 'Chưa đúng!',
                        text: 'Hãy thử lại nhé!',
                        background: '#fffbea',
                    });
                    setTimeout(() => document.getElementById('pattern-sequence').classList.remove('shake'), 600);
                }
            };
            document.getElementById('next-level').onclick = function () {
                level++;
                renderPattern();
            };
            document.getElementById('resetBtn').onclick = function () {
                level = 1;
                renderPattern();
            };
        });
    </script>
@endpush
