@extends('layouts.game')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-200 py-10 flex flex-col items-center">
        <div class="w-full max-w-2xl">
            <div class="mb-6 text-center">
                <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-400 drop-shadow-lg mb-2 flex items-center justify-center gap-2">
                    <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3"/>
                        <circle cx="12" cy="12" r="10"/>
                    </svg>
                    Thời Gian Nâng Cao
                </h1>
                <div class="inline-block px-4 py-1 rounded-full bg-blue-100 text-blue-700 font-semibold text-lg shadow">Câu
                    <span id="progress-current">1</span>/<span id="progress-total">5</span></div>
            </div>
            <div class="mb-6">
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded shadow text-gray-700">
                    <div class="font-bold text-yellow-700 mb-1 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-yellow-500 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"/>
                        </svg>
                        Hướng dẫn chơi
                    </div>
                    <ul class="list-disc pl-5 text-base">
                        <li><b>Mục tiêu:</b> Trả lời đúng các câu hỏi về thời gian nâng cao.</li>
                        <li><b>Nhập đáp án:</b> Nếu câu hỏi yêu cầu số phút, nhập số phút vào ô và nhấn
                            <span class="inline-block bg-blue-600 text-white px-2 py-1 rounded">Kiểm tra</span>. Nếu yêu cầu nhập giờ, nhập theo định dạng
                            <b>HH:mm</b> (ví dụ: 09:15).
                        </li>
                        <li><b>Kiểm tra:</b> Nhấn
                            <span class="inline-block bg-blue-600 text-white px-2 py-1 rounded">Kiểm tra</span> để xem kết quả.
                        </li>
                        <li><b>Chuyển màn:</b> Nếu đúng, nhấn
                            <span class="inline-block bg-blue-600 text-white px-2 py-1 rounded">Tiếp tục ▶</span> để sang câu tiếp theo.
                        </li>
                        <li><b>Chơi lại:</b> Khi hoàn thành, nhấn
                            <span class="inline-block bg-blue-600 text-white px-2 py-1 rounded">Chơi lại 🔄</span> để làm lại từ đầu.
                        </li>
                    </ul>
                </div>
            </div>
            <div id="question-card" class="bg-white rounded-2xl shadow-2xl p-8 mb-8 transition-all duration-300">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-blue-400 to-cyan-300 text-white text-2xl font-bold shadow">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3"/>
                                <circle cx="12" cy="12" r="10"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div id="game-scenario" class="text-lg font-semibold text-blue-700"></div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" id="game-info"></div>
                    <div class="flex flex-col items-center gap-4 mt-4">
                        <div class="w-full max-w-xs" id="answer-input-wrapper"></div>
                        <button id="check" class="w-full py-3 bg-gradient-to-r from-blue-500 to-cyan-400 text-white rounded-xl text-lg font-bold shadow-lg hover:from-blue-600 hover:to-cyan-500 transition">Kiểm tra</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const questions = @json($questions);
        let currentLevel = 1;
        const maxLevel = questions.length;

        function pad(num) {
            return num.toString().padStart(2, '0');
        }

        function calculateTimeDifference(start, end, nextDay = false) {
            const [sh, sm] = start.split(':').map(Number);
            const [eh, em] = end.split(':').map(Number);
            let startMinutes = sh * 60 + sm;
            let endMinutes = eh * 60 + em;
            if (nextDay && endMinutes <= startMinutes) {
                endMinutes += 24 * 60;
            }
            return endMinutes - startMinutes;
        }

        function addMinutesToTime(start, duration) {
            const [sh, sm] = start.split(':').map(Number);
            let total = sh * 60 + sm + duration;
            let h = Math.floor(total / 60) % 24;
            let m = total % 60;
            return pad(h) + ':' + pad(m);
        }

        function renderQuestion(level) {
            const q = questions[level - 1] || questions[0];
            document.getElementById('progress-current').textContent = level;
            document.getElementById('progress-total').textContent = maxLevel;
            document.getElementById('game-scenario').textContent = q.scenario;

            let infoHtml = '';
            if (q.start_time) {
                infoHtml += `<div><p class=\"text-sm text-gray-600\">Thời gian bắt đầu:</p><p class=\"text-xl font-bold\">${q.start_time}</p></div>`;
            }
            if (q.end_time) {
                infoHtml += `<div><p class=\"text-sm text-gray-600\">Thời gian kết thúc:</p><p class=\"text-xl font-bold\">${q.end_time}</p></div>`;
            }
            if (q.duration) {
                infoHtml += `<div><p class=\"text-sm text-gray-600\">Thời gian:</p><p class=\"text-xl font-bold\">${Math.floor(q.duration / 60)} giờ ${q.duration % 60} phút</p></div>`;
            }
            if (q.next_day) {
                infoHtml += `<div class=\"col-span-2\"><p class=\"text-sm text-red-600\">* Kết thúc vào ngày hôm sau</p></div>`;
            }
            document.getElementById('game-info').innerHTML = infoHtml;

            let inputHtml = '';
            if (q.answer_unit === 'time') {
                inputHtml = `<div class=\"flex items-center space-x-4\"><input type=\"time\" id=\"answer\" class=\"w-full p-4 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg\" placeholder=\"00:00\"></div>`;
            } else {
                inputHtml = `<div class=\"flex items-center space-x-4\"><input type=\"number\" id=\"answer\" class=\"w-full p-4 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg\" placeholder=\"Nhập số phút\"><span class=\"text-lg font-medium\">phút</span></div>`;
            }
            document.getElementById('answer-input-wrapper').innerHTML = inputHtml;
        }

        function checkAnswer(level, answer) {
            const q = questions[level - 1] || questions[0];
            let correct = false;
            if (q.answer_unit === 'phút') {
                const duration = calculateTimeDifference(q.start_time, q.end_time, q.next_day || false);
                correct = Number(answer) === duration;
            } else {
                const endTime = addMinutesToTime(q.start_time, q.duration);
                correct = answer === endTime;
            }
            return correct;
        }

        document.addEventListener('DOMContentLoaded', function () {
            renderQuestion(currentLevel);

            document.getElementById('check').onclick = function () {
                const answerInput = document.getElementById('answer');
                let answer = answerInput ? answerInput.value : '';
                if (!answer) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Thiếu đáp án',
                        text: 'Vui lòng nhập đáp án!',
                        confirmButtonColor: '#2563eb'
                    });
                    return;
                }
                if (questions[currentLevel - 1].answer_unit === 'time') {
                    if (!/^\d{2}:\d{2}$/.test(answer)) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Sai định dạng',
                            text: 'Vui lòng nhập đúng định dạng giờ:phút (HH:mm)',
                            confirmButtonColor: '#fbbf24'
                        });
                        return;
                    }
                }
                const correct = checkAnswer(currentLevel, answer);
                if (correct) {
                    if (currentLevel < maxLevel) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Chính xác!',
                            text: 'Bạn đã trả lời đúng, tiếp tục nào!',
                            confirmButtonColor: '#22c55e',
                            showDenyButton: true,
                            denyButtonText: 'Tiếp tục ▶',
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isDenied) {
                                currentLevel++;
                                renderQuestion(currentLevel);
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Hoàn thành!',
                            text: 'Chúc mừng! Bạn đã hoàn thành tất cả các cấp độ!',
                            confirmButtonColor: '#22c55e',
                            showDenyButton: true,
                            denyButtonText: 'Chơi lại 🔄',
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isDenied) {
                                currentLevel = 1;
                                renderQuestion(currentLevel);
                            }
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sai rồi!',
                        text: 'Đáp án chưa đúng, hãy thử lại.',
                        confirmButtonColor: '#f87171',
                        showDenyButton: true,
                        denyButtonText: 'Thử lại 🔄',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isDenied) {
                            renderQuestion(currentLevel);
                        }
                    });
                }
            };
        });
    </script>
@endpush
