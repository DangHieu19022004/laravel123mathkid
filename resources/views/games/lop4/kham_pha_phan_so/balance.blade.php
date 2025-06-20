@extends('layouts.game')

@section('content')
    <div class="relative min-h-screen flex flex-col items-center overflow-hidden bg-gradient-to-br from-blue-200 via-indigo-100 to-purple-200 animate-bg-move">
        <!-- Decor icons -->
        <div class="absolute top-4 left-8 text-5xl opacity-70 animate-float-x select-none">☁️</div>
        <div class="absolute top-10 right-10 text-4xl opacity-80 animate-float-y select-none">🎈</div>
        <div class="absolute top-1/2 left-10 text-3xl opacity-70 animate-float-y select-none">🦋</div>
        <div class="absolute bottom-20 right-16 text-3xl opacity-70 animate-float-x select-none">🦋</div>
        <div class="relative z-10 w-full max-w-xl bg-white/80 rounded-3xl shadow-2xl p-10 my-8 border-4 border-blue-200 backdrop-blur-md">
            <div class="flex items-center justify-center gap-2 mb-4">
                <span class="text-4xl animate-glow">🎉</span>
                <!-- SVG cân 3D thuần -->
                <span class="inline-block w-12 h-12 animate-glow">
                    <svg viewBox="0 0 64 64" fill="none" class="w-full h-full">
                        <g filter="url(#shadow)">
                            <rect x="28" y="10" width="8" height="36" rx="4" fill="#60a5fa"/>
                            <rect x="12" y="44" width="40" height="6" rx="3" fill="#2563eb"/>
                            <!-- Beam -->
                            <rect x="16" y="24" width="32" height="6" rx="3" fill="url(#beamG)"/>
                            <!-- Left pan -->
                            <ellipse cx="20" cy="38" rx="7" ry="4" fill="#fde68a" stroke="#fbbf24" stroke-width="2"/>
                            <ellipse cx="44" cy="38" rx="7" ry="4" fill="#fbcfe8" stroke="#f472b6" stroke-width="2"/>
                        </g>
                        <defs>
                            <filter id="shadow" x="0" y="0" width="64" height="64" filterUnits="userSpaceOnUse">
                                <feDropShadow dx="0" dy="2" stdDeviation="2" flood-color="#60a5fa"/>
                            </filter>
                            <linearGradient id="beamG" x1="16" y1="24" x2="48" y2="30" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#60a5fa"/>
                                <stop offset="1" stop-color="#818cf8"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </span>
                <span class="text-4xl animate-glow">🎈</span>
            </div>
            <div class="text-3xl font-extrabold text-blue-700 mb-2 text-center drop-shadow-lg animate-glow">Cân Bằng</div>
            <div class="text-base text-gray-600 text-center mb-6">Thử thách cân não với phân số! Đặt các phân số lên cân và tìm ra dấu đúng để duy trì sự cân bằng, chứng tỏ bạn là bậc thầy so sánh phân số.</div>
            <!-- Khung game mới, nền gradient tươi sáng, bóng đổ -->
            <div id="question-area" class="mb-4 text-2xl font-extrabold text-center text-blue-600 drop-shadow-lg"></div>
            <div class="flex flex-col items-center mb-4">
                <svg id="balance-svg" width="180" height="180" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <path fill="#000000" d="M512,292.069h-0.442l-81.151-186.586c9.816,0.74,17.961,1.439,24.078,2.012l2.362-25.581
                            c-27.16-2.514-92.696-7.342-163.61-8.702c-1.774-6.657-5.298-12.639-9.998-17.348c-6.932-6.953-16.621-11.272-27.232-11.272
                            c-10.615,0-20.327,4.319-27.26,11.272c-4.701,4.709-8.224,10.691-9.971,17.348c-70.91,1.36-136.453,6.189-163.633,8.702
                            l2.39,25.597c6.085-0.572,14.254-1.257,24.046-2.004h0.003L0.45,292.069H0c0.06,0.207,0.131,0.398,0.191,0.589l-0.167,0.389
                            l0.334,0.143c12.567,39.836,49.786,68.734,93.782,68.734c43.992,0,81.203-28.89,93.774-68.734l0.335-0.143l-0.164-0.389
                            c0.06-0.192,0.132-0.382,0.188-0.589h-0.442l-81.882-188.28c31.566-2.052,72.396-4.137,114.884-4.948
                            c1.93,4.327,4.622,8.233,7.915,11.518c3.361,3.388,7.37,6.141,11.837,8.097v271.086c-17.393,0-30.943,0-30.943,0
                            s-7.413,46.342-40.794,53.756v24.11h174.308v-24.11c-33.38-7.414-40.798-53.756-40.798-53.756s-13.55,0-30.942,0V118.456h0.004
                            c4.45-1.956,8.46-4.709,11.82-8.097c3.317-3.285,6.014-7.191,7.938-11.518c42.488,0.811,83.31,2.896,114.881,4.948l-81.883,188.28
                            h-0.449c0.06,0.207,0.131,0.398,0.191,0.589l-0.167,0.389l0.334,0.143c12.568,39.836,49.786,68.734,93.782,68.734
                            c43.992,0,81.202-28.89,93.774-68.734l0.334-0.143l-0.163-0.389C511.873,292.467,511.945,292.276,512,292.069z M171.015,292.069
                            H17.253L94.14,115.291L171.015,292.069z M270.525,97.647c-0.334,0.335-0.668,0.644-1.026,0.923
                            c-3.604,3.214-8.28,5.107-13.491,5.107c-5.218,0-9.891-1.893-13.519-5.107c-0.357-0.278-0.691-0.588-1.025-0.923
                            c-3.723-3.722-6.01-8.813-6.01-14.524c0-3.722,0.974-7.191,2.692-10.197c0.927-1.591,2.032-3.039,3.318-4.343
                            c3.75-3.722,8.837-6.006,14.544-6.006c5.704,0,10.79,2.283,14.517,6.006c1.309,1.304,2.414,2.752,3.318,4.343
                            c1.741,3.006,2.72,6.475,2.72,10.197C276.562,88.834,274.276,93.925,270.525,97.647z M340.985,292.069l76.883-176.778
                            l76.88,176.778H340.985z"/>
                    </g>
                </svg>
            </div>
            <div class="mb-4 text-center text-lg text-fuchsia-600 font-semibold">Chọn dấu so sánh thích hợp để cân bằng hai bên!</div>
            <div id="answer-area" class="mb-8 flex justify-center gap-6"></div>
            <div class="flex justify-center gap-6 mt-6">
                <button id="next-btn" class="hidden px-8 py-3 bg-gradient-to-r from-green-400 to-blue-400 text-white rounded-full shadow-lg hover:from-green-500 hover:to-blue-500 text-xl font-bold transition">Câu tiếp</button>
                <button id="reset-btn" class="px-8 py-3 bg-gradient-to-r from-pink-400 to-yellow-300 text-white rounded-full shadow-lg hover:from-pink-500 hover:to-yellow-400 text-xl font-bold transition">Chơi lại</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const questions = @json($questions);
        let current = 1;

        function renderQuestion() {
            const q = questions[current];
            // Update question text
            document.getElementById('question-area').innerHTML = `
        <span class='text-blue-600'>Câu hỏi ${current}:</span><br>
        <span class="text-red-500 font-extrabold">${q.left.numerator}/${q.left.denominator}</span>
        <span class="mx-2 font-extrabold text-purple-500">?</span>
        <span class="text-pink-500 font-extrabold">${q.right.numerator}/${q.right.denominator}</span>
    `;
            document.getElementById('answer-area').innerHTML = `
        <button onclick=\"checkAnswer('<')\" class=\"px-8 py-3 bg-gradient-to-r from-blue-300 to-blue-500 text-white rounded-full shadow-xl hover:from-blue-400 hover:to-blue-600 text-2xl font-bold flex items-center gap-2 transition\">&lt;</button>
        <button onclick=\"checkAnswer('=')\" class=\"px-8 py-3 bg-gradient-to-r from-green-300 to-green-500 text-white rounded-full shadow-xl hover:from-green-400 hover:to-green-600 text-2xl font-bold flex items-center gap-2 transition\">=</button>
        <button onclick=\"checkAnswer('>')\" class=\"px-8 py-3 bg-gradient-to-r from-pink-300 to-pink-500 text-white rounded-full shadow-xl hover:from-pink-400 hover:to-pink-600 text-2xl font-bold flex items-center gap-2 transition\">&gt;</button>
    `;
            document.getElementById('next-btn').classList.add('hidden');
        }

        function checkAnswer(symbol) {
            const q = questions[current];
            // Không còn hiệu ứng nghiêng, chỉ kiểm tra đúng/sai
            if (symbol === q.correct_symbol) {
                Swal.fire({
                    title: 'Chính xác!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1200,
                    didOpen: () => {
                        if (window.confetti) confetti({particleCount: 80, spread: 70, origin: {y: 0.7}});
                    }
                });
                document.getElementById('next-btn').classList.remove('hidden');
            } else {
                shakeSVG();
                Swal.fire({
                    title: 'Sai rồi!',
                    text: 'Thử lại nhé!',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1200
                });
            }
        }

        function shakeSVG() {
            const svg = document.getElementById('balance-svg');
            svg.classList.add('svg-shake');
            setTimeout(() => svg.classList.remove('svg-shake'), 500);
        }

        document.getElementById('next-btn').onclick = function () {
            current++;
            if (questions[current]) {
                renderQuestion();
            } else {
                Swal.fire({
                    title: 'Hoàn thành!',
                    text: 'Bạn đã hoàn thành tất cả câu hỏi!',
                    icon: 'success',
                    showConfirmButton: true
                });
                document.getElementById('next-btn').classList.add('hidden');
            }
        };
        document.getElementById('reset-btn').onclick = function () {
            current = 1;
            renderQuestion();
        };

        // Animation CSS
        const style = document.createElement('style');
        style.innerHTML = `
@keyframes float-x { 0%,100% { transform: translateX(0); } 50% { transform: translateX(18px); } }
.animate-float-x { animation: float-x 6s ease-in-out infinite; }
@keyframes float-y { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-18px); } }
.animate-float-y { animation: float-y 7s ease-in-out infinite; }
@keyframes fade-in { from { opacity: 0; transform: translateY(40px);} to { opacity: 1; transform: none;} }
.animate-fade-in { animation: fade-in 0.7s cubic-bezier(.68,-0.55,.27,1.55); }
@keyframes glow { 0%,100% { filter: drop-shadow(0 0 0px #60a5fa); } 50% { filter: drop-shadow(0 0 16px #60a5fa); } }
.animate-glow { animation: glow 2.5s ease-in-out infinite; }
.svg-shake { animation: svg-shake 0.5s; }
@keyframes svg-shake { 0% { transform: translateX(0); } 20% { transform: translateX(-8px); } 40% { transform: translateX(8px); } 60% { transform: translateX(-8px); } 80% { transform: translateX(8px); } 100% { transform: translateX(0); } }
`;
        document.head.appendChild(style);

        renderQuestion();
    </script>
@endpush
