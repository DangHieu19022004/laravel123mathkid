@extends('layouts.game')

@section('content')
    <div class="min-h-screen flex flex-col items-center bg-gradient-to-br from-blue-100 to-yellow-100 py-8">
        <div class="w-full max-w-xl bg-white rounded-3xl shadow-2xl p-8 flex flex-col items-center">
            <h2 class="mb-2 text-3xl font-extrabold text-blue-600 tracking-tight text-center flex items-center gap-2">
                <span>Thời Gian Phiêu Lưu</span>
                <span class="text-4xl">⏱️</span>
            </h2>
            <div class="text-lg text-gray-700 mb-2">Chọn mốc thời gian kết thúc đúng sau khoảng thời gian cho trước</div>
            <div class="mb-2 text-base font-semibold text-blue-700" id="level-label"></div>
            <div class="w-full bg-blue-100 rounded-xl h-4 mb-6 overflow-hidden">
                <div class="h-full bg-gradient-to-r from-blue-400 to-green-400 rounded-xl transition-all duration-500" id="progress-bar-inner"></div>
            </div>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-8 mb-6 w-full">
                <div class="flex flex-col items-center">
                    <div class="text-xl font-bold text-blue-700" id="start-time"></div>
                    <div class="text-sm text-gray-600">Bắt đầu</div>
                </div>
                <div class="text-3xl">➡️</div>
                <div class="flex flex-col items-center">
                    <div class="text-xl font-bold text-blue-700" id="duration-label"></div>
                    <div class="text-sm text-gray-600">Thời lượng</div>
                </div>
            </div>
            <div class="flex justify-center mb-8 w-full">
                <svg id="clock-svg" width="200" height="200" viewBox="0 0 200 200">
                    <!-- Nền gradient -->
                    <defs>
                        <radialGradient id="clock-bg" cx="50%" cy="50%" r="50%">
                            <stop offset="0%" stop-color="#e0f2fe"/>
                            <stop offset="100%" stop-color="#fceabb"/>
                        </radialGradient>
                        <filter id="shadow" x="-20%" y="-20%" width="140%" height="140%">
                            <feDropShadow dx="0" dy="4" stdDeviation="4" flood-color="#60a5fa" flood-opacity="0.18"/>
                        </filter>
                    </defs>
                    <!-- Viền và nền -->
                    <circle cx="100" cy="100" r="90" fill="url(#clock-bg)" stroke="#2563eb" stroke-width="7" filter="url(#shadow)"/>
                    <!-- Vạch chia nhỏ -->
                    <g id="tick-marks">
                        @for ($i = 0; $i < 60; $i++)
                            <rect x="98.5" y="18" width="3" height="@if($i%5==0) 14 @else 7 @endif" fill="@if($i%5==0) #2563eb @else #a5b4fc @endif" transform="rotate({{ $i * 6 }} 100 100)" rx="1.5"/>
                        @endfor
                    </g>
                    <!-- Số -->
                    <g id="clock-numbers">
                        @for ($i = 1; $i <= 12; $i++)
                            <text x="100" y="38" text-anchor="middle" font-size="1.6rem" font-family="'Segoe UI Rounded', Arial, sans-serif" fill="#2563eb" stroke="#fff" stroke-width="2" paint-order="stroke" filter="url(#shadow)" transform="rotate({{ $i * 30 }} 100 100) translate(0, -70)">{{ $i }}</text>
                        @endfor
                    </g>
                    <!-- Kim giờ -->
                    <line id="hour-hand" x1="100" y1="100" x2="100" y2="55" stroke="#2563eb" stroke-width="7" stroke-linecap="round" style="transition: transform 0.5s cubic-bezier(.4,2,.6,1);"/>
                    <!-- Kim phút -->
                    <line id="minute-hand" x1="100" y1="100" x2="100" y2="35" stroke="#38bdf8" stroke-width="4" stroke-linecap="round" style="transition: transform 0.5s cubic-bezier(.4,2,.6,1);"/>
                    <!-- Tâm đồng hồ -->
                    <circle cx="100" cy="100" r="11" fill="#fff" stroke="#38bdf8" stroke-width="4"/>
                    <circle cx="100" cy="100" r="5" fill="#facc15" stroke="#2563eb" stroke-width="2"/>
                </svg>
            </div>
            <div class="grid grid-cols-2 gap-4 w-full mb-6" id="options"></div>
            <button id="new-question" class="w-full mt-2 py-3 rounded-xl text-lg font-bold bg-gradient-to-r from-blue-400 to-green-400 text-white shadow hover:from-green-400 hover:to-blue-400 transition">Câu hỏi mới</button>
        </div>
    </div>
@endsection

@push('scripts')
<script>
        document.addEventListener('DOMContentLoaded', function () {
            const startTimeEl = document.getElementById('start-time');
            const durationLabel = document.getElementById('duration-label');
            const optionsContainer = document.getElementById('options');
            const newQuestionBtn = document.getElementById('new-question');
            const hourHand = document.getElementById('hour-hand');
            const minuteHand = document.getElementById('minute-hand');
            const levelLabel = document.getElementById('level-label');
            const progressBarInner = document.getElementById('progress-bar-inner');

            const questions = @json($questions);
            let level = 1;
            let maxLevel = questions.length;
            let correctAnswer = '';

            function loadQuestion() {
                const q = questions[level - 1];
                levelLabel.textContent = `Câu ${level} / ${maxLevel}`;
                progressBarInner.style.width = ((level - 1) / (maxLevel - 1) * 100) + '%';
                startTimeEl.textContent = q.startTime;
                durationLabel.textContent = q.type === 'minutes' ? `${q.duration} phút` : `${q.duration} giờ`;
                // Tính góc kim giờ và phút
                const [hour, minute] = q.startTime.split(':').map(Number);
                const hourAngle = ((hour % 12) + minute / 60) * 30;
                const minuteAngle = minute * 6;
                hourHand.setAttribute('transform', `rotate(${hourAngle} 100 100)`);
                minuteHand.setAttribute('transform', `rotate(${minuteAngle} 100 100)`);
                correctAnswer = q.endTime;
                optionsContainer.innerHTML = q.options.map(opt => `
                    <button class=\"w-full py-4 rounded-xl text-lg font-bold bg-gradient-to-r from-blue-100 to-yellow-100 text-blue-700 shadow hover:from-yellow-100 hover:to-blue-100 transition option-btn\" data-value=\"${opt}\">${opt}</button>
                `).join('');
                document.querySelectorAll('.option-btn').forEach(btn => {
                    btn.addEventListener('click', handleAnswer);
                });
            }

            function handleAnswer(e) {
                const selectedValue = e.target.dataset.value;
                const isCorrect = selectedValue === correctAnswer;
                if (isCorrect) {
                    e.target.classList.add('ring-4', 'ring-green-400');
                    Swal.fire({
                        title: 'Chính xác!',
                        text: 'Bạn đã chọn đúng mốc thời gian kết thúc!',
                        icon: 'success',
                        timer: 1200,
                        showConfirmButton: false,
                        customClass: {popup: 'swal2-popup swal2-rounded'}
                    });
                    setTimeout(() => {
                        if (level < maxLevel) {
                            level++;
                            loadQuestion();
                        } else {
                            Swal.fire({
                                title: 'Hoàn thành!',
                                text: 'Bạn đã hoàn thành tất cả câu hỏi! Rất xuất sắc!',
                                icon: 'success',
                                confirmButtonText: 'Chơi lại',
                                customClass: {popup: 'swal2-popup swal2-rounded'}
                            }).then(() => {
                                level = 1;
                                loadQuestion();
                            });
                        }
                    }, 1200);
                } else {
                    e.target.classList.add('ring-4', 'ring-red-400');
                    Swal.fire({
                        title: 'Chưa đúng!',
                        text: 'Hãy thử lại nhé!',
                        icon: 'error',
                        timer: 1200,
                        showConfirmButton: false,
                        customClass: {popup: 'swal2-popup swal2-rounded'}
                    });
                }
                document.querySelectorAll('.option-btn').forEach(btn => {
                    if (btn !== e.target) btn.classList.remove('ring-4', 'ring-green-400', 'ring-red-400');
                });
            }

            loadQuestion();
            newQuestionBtn.addEventListener('click', function () {
                level = 1;
                loadQuestion();
            });
        });
</script>
@endpush
