@extends('layouts.game')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-yellow-100 to-pink-100 py-8">
        <div class="w-full max-w-xl bg-white rounded-3xl shadow-2xl p-8 flex flex-col items-center">
            <h2 class="mb-4 text-3xl font-extrabold text-yellow-600 tracking-tight text-center flex items-center gap-2">
                <span>Ước lượng khối lượng</span>
                <span class="text-4xl">⚖️</span>
            </h2>
            <div class="mb-4 text-center">
                <span id="question-title" class="text-lg font-semibold text-gray-700"></span>
            </div>
            <div id="object-list" class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full mb-6"></div>
            <button id="next-btn" class="hidden w-full py-3 rounded-xl text-lg font-bold bg-gradient-to-r from-green-400 to-blue-400 text-white shadow hover:from-blue-400 hover:to-green-400 transition">Câu hỏi tiếp theo</button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const questions = @json($questions);
        let level = 1;
        let maxLevel = questions.length;
        let answered = false;

        window.onload = function () {
            Swal.fire({
                title: 'Hướng dẫn',
                html: `<div style='font-size:1.15rem;line-height:1.6'><b>Chọn vật nặng nhất hoặc nhẹ nhất</b> theo yêu cầu.<br>Nhấn vào vật thể bạn chọn. Nếu đúng sẽ chuyển sang câu tiếp theo.<br>Hoàn thành tất cả câu hỏi để trở thành "bậc thầy ước lượng"!<br><br><span style='font-size:2rem;'>💡⚖️</span></div>`,
                icon: 'info',
                confirmButtonText: 'Bắt đầu chơi',
                customClass: {popup: 'swal2-popup swal2-rounded'}
            });
            renderQuestion();
        };

        function renderQuestion() {
            const q = questions[level - 1];
            document.getElementById('question-title').innerHTML = q.type === 'max'
                ? 'Chọn vật <span class="text-yellow-600 font-bold">nặng nhất</span>:'
                : 'Chọn vật <span class="text-yellow-600 font-bold">nhẹ nhất</span>:';
            const list = document.getElementById('object-list');
            list.innerHTML = q.objects.map((obj, i) => `
        <button class="object-card flex flex-col items-center justify-center p-6 text-gray-800 text-lg font-semibold focus:outline-none bg-gradient-to-br from-yellow-50 to-pink-50 rounded-2xl shadow-lg border-4 border-transparent transition hover:shadow-2xl hover:border-yellow-300 active:scale-95 option-btn" data-index="${i}">
            <span class="text-6xl mb-2">${obj.emoji}</span>
            <span class="mb-1 text-base">${obj.object}</span>
            <span class="text-base text-gray-500">${obj.weight} ${obj.unit}</span>
        </button>
    `).join('');
            answered = false;
            document.getElementById('next-btn').classList.add('hidden');
            addBtnEvents(q.answer_index);
        }

        function addBtnEvents(answerIndex) {
            document.querySelectorAll('.option-btn').forEach(btn => {
                btn.onclick = function () {
                    if (answered) return;
                    answered = true;
                    const idx = parseInt(this.getAttribute('data-index'));
                    if (idx === answerIndex) {
                        this.classList.add('ring-4', 'ring-green-400');
                        Swal.fire({
                            icon: 'success',
                            title: 'Chính xác!',
                            html: '<span style="font-size:1.2rem">Bạn đã chọn đúng!</span>',
                            showConfirmButton: false,
                            timer: 1200,
                            timerProgressBar: true,
                            customClass: {popup: 'swal2-popup swal2-rounded'}
                        }).then(() => {
                            this.classList.remove('ring-4', 'ring-green-400');
                            if (level < maxLevel) {
                                level++;
                                renderQuestion();
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Hoàn thành!',
                                    html: '<span style="font-size:1.2rem">Bạn đã hoàn thành tất cả câu hỏi!<br>🎉 Bạn thật tuyệt vời!</span>',
                                    confirmButtonText: 'Chơi lại',
                                    customClass: {popup: 'swal2-popup swal2-rounded'}
                                }).then(() => {
                                    level = 1;
                                    renderQuestion();
                                });
                            }
                        });
                    } else {
                        this.classList.add('ring-4', 'ring-red-400');
                        Swal.fire({
                            icon: 'error',
                            title: 'Chưa đúng!',
                            html: '<span style="font-size:1.1rem">Hãy thử lại nhé!</span>',
                            showConfirmButton: false,
                            timer: 1200,
                            timerProgressBar: true,
                            customClass: {popup: 'swal2-popup swal2-rounded'}
                        }).then(() => {
                            answered = false;
                            this.classList.remove('ring-4', 'ring-red-400');
                        });
                    }
                    document.getElementById('next-btn').classList.remove('hidden');
                };
            });
        }

        document.getElementById('next-btn').onclick = function () {
            if (level < maxLevel) {
                level++;
                renderQuestion();
            } else {
                level = 1;
                renderQuestion();
            }
        };
    </script>
@endpush
