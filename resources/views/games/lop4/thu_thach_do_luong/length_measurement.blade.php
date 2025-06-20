@extends('layouts.game')

@section('content')
    <div class="length-game-bg flex flex-col items-center min-h-screen py-8">
        <div class="w-full max-w-xl bg-white rounded-3xl shadow-2xl p-8 flex flex-col items-center">
            <h2 class="mb-4 text-3xl font-extrabold text-blue-600 tracking-tight text-center flex items-center gap-2" style="font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;">
                <span>So sánh độ dài</span>
                <span class="text-4xl">📏</span>
            </h2>
            <div class="level-label" id="level-label"></div>
            <div class="level-bar">
                <div class="level-bar-inner" id="level-bar-inner"></div>
            </div>
            <div class="mb-4 text-center">
                <span id="question-title" class="text-lg font-semibold text-gray-700"></span>
            </div>
            <div id="object-list" class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full mb-6"></div>
            <button id="next-btn" class="hidden mt-4">Câu hỏi tiếp theo</button>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        body {
            background: linear-gradient(135deg, #e3f2fd 0%, #fceabb 100%);
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
        }

        .length-game-bg {
            background: linear-gradient(135deg, #e3f2fd 0%, #fceabb 100%);
        }

        .level-bar {
            width: 100%;
            background: #e3f2fd;
            border-radius: 1.2rem;
            height: 18px;
            margin-bottom: 1.2rem;
            box-shadow: 0 2px 8px 0 rgba(33, 150, 243, 0.08);
            overflow: hidden;
        }

        .level-bar-inner {
            height: 100%;
            background: linear-gradient(90deg, #42a5f5 0%, #29b6f6 100%);
            border-radius: 1.2rem;
            transition: width 0.5s cubic-bezier(.4, 2, .6, 1);
        }

        .level-label {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1976d2;
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
        }

        .object-card {
            background: linear-gradient(120deg, #e3f2fd 60%, #ffe0f7 100%);
            border-radius: 2rem;
            box-shadow: 0 6px 32px 0 rgba(0, 0, 0, 0.10), 0 1.5px 6px 0 rgba(33, 150, 243, 0.10);
            border: 4px solid transparent;
            transition: box-shadow 0.2s, border 0.2s, transform 0.12s;
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
            position: relative;
            overflow: hidden;
            min-height: 170px;
        }

        .object-card:hover, .object-card:focus {
            box-shadow: 0 12px 40px 0 rgba(33, 150, 243, 0.18), 0 2px 8px 0 rgba(0, 0, 0, 0.08);
            border-image: linear-gradient(90deg, #42a5f5, #29b6f6, #6dd5ed) 1;
            background: linear-gradient(120deg, #e3f2fd 40%, #ffe0f7 100%);
            transform: translateY(-4px) scale(1.04);
            z-index: 2;
        }

        .object-card.selected-correct {
            border-image: linear-gradient(90deg, #43e97b, #38f9d7) 1;
            animation: correctPop 0.5s;
        }

        .object-card.selected-wrong {
            border-image: linear-gradient(90deg, #ff5858, #f09819) 1;
            animation: wrongShake 0.4s;
        }

        @keyframes correctPop {
            0% {
                transform: scale(1);
            }
            60% {
                transform: scale(1.12);
            }
            100% {
                transform: scale(1.04);
            }
        }

        @keyframes wrongShake {
            0% {
                transform: translateX(0);
            }
            20% {
                transform: translateX(-8px);
            }
            40% {
                transform: translateX(8px);
            }
            60% {
                transform: translateX(-6px);
            }
            80% {
                transform: translateX(6px);
            }
            100% {
                transform: translateX(0);
            }
        }

        #next-btn {
            background: linear-gradient(90deg, #42a5f5 0%, #29b6f6 100%);
            color: #fff;
            border: none;
            border-radius: 1.5rem;
            font-size: 1.2rem;
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
            font-weight: 700;
            padding: 0.9rem 2.5rem;
            box-shadow: 0 4px 16px 0 rgba(33, 150, 243, 0.18);
            transition: background 0.2s, transform 0.15s;
            outline: none;
        }

        #next-btn:hover, #next-btn:focus {
            background: linear-gradient(90deg, #29b6f6 0%, #42a5f5 100%);
            transform: scale(1.05);
        }

        @media (max-width: 640px) {
            .object-card {
                min-height: 120px;
                padding: 1.2rem 0.5rem;
                font-size: 1rem;
            }

            .text-6xl {
                font-size: 2.5rem !important;
            }

            .w-full.max-w-xl {
                padding: 1.2rem !important;
            }
        }

        /* SweetAlert2 custom style */
        .swal2-popup.swal2-rounded {
            border-radius: 1.5rem !important;
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
            font-size: 1.1rem;
            box-shadow: 0 8px 32px 0 rgba(33, 150, 243, 0.10);
        }

        .swal2-title {
            color: #1976d2 !important;
            font-weight: 700;
            font-size: 1.5rem !important;
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
        }

        .swal2-icon-success {
            color: #43e97b !important;
            border-color: #43e97b !important;
        }

        .swal2-icon-error {
            color: #ff5858 !important;
            border-color: #ff5858 !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const questions = @json($questions);
        let level = 1;
        let maxLevel = questions.length;
        let answered = false;

        window.onload = function () {
            Swal.fire({
                title: 'Hướng dẫn',
                html: `<div style='font-size:1.15rem;line-height:1.6'><b>Chọn vật dài nhất hoặc ngắn nhất</b> theo yêu cầu.<br>Nhấn vào vật thể bạn chọn. Nếu đúng sẽ chuyển sang level tiếp theo.<br>Hoàn thành tất cả level để trở thành "bậc thầy đo độ dài"!<br><br><span style='font-size:2rem;'>📏✨</span></div>`,
                icon: 'info',
                confirmButtonText: 'Bắt đầu chơi',
                customClass: {popup: 'swal2-popup swal2-rounded'}
            });
            renderQuestion();
        };

        function renderQuestion() {
            document.getElementById('level-label').innerHTML = `Level <span style='color:#1565c0'>${level}</span> / ${maxLevel}`;
            document.getElementById('level-bar-inner').style.width = ((level - 1) / maxLevel * 100) + '%';

            const q = questions[level - 1];
            document.getElementById('question-title').innerHTML = q.type === 'max'
                ? 'Chọn vật <span class="text-blue-600 font-bold">dài nhất</span>:'
                : 'Chọn vật <span class="text-blue-600 font-bold">ngắn nhất</span>:';
            const list = document.getElementById('object-list');
            list.innerHTML = q.objects.map((obj, i) => `
        <button class="object-card flex flex-col items-center justify-center p-6 text-gray-800 text-lg font-semibold focus:outline-none" data-index="${i}">
            <span class="text-6xl mb-2">${obj.emoji}</span>
            <span class="mb-1" style="font-size:1.2rem;">${obj.object}</span>
            <span class="text-base text-gray-500">${obj.length} ${obj.unit}</span>
        </button>
    `).join('');
            answered = false;
            document.getElementById('next-btn').classList.add('hidden');
            addBtnEvents(q.answer_index);
        }

        function addBtnEvents(answerIndex) {
            document.querySelectorAll('.object-card').forEach(btn => {
                btn.onclick = function () {
                    if (answered) return;
                    answered = true;
                    const idx = parseInt(this.getAttribute('data-index'));
                    if (idx === answerIndex) {
                        this.classList.add('selected-correct');
                        if (level < maxLevel) {
                            Swal.fire({
                                icon: 'success',
                                title: `Level ${level} hoàn thành!`,
                                html: '<span style="font-size:1.2rem">Bạn đã chọn đúng!<br>Tiếp tục level tiếp theo nhé!</span>',
                                showConfirmButton: false,
                                timer: 1200,
                                timerProgressBar: true
                            }).then(() => {
                                this.classList.remove('selected-correct');
                                level++;
                                document.getElementById('level-bar-inner').style.width = ((level - 1) / maxLevel * 100) + '%';
                                renderQuestion();
                            });
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: '🎉 Hoàn thành tất cả level! 🎉',
                                html: '<span style="font-size:1.2rem">Bạn đã trở thành bậc thầy đo độ dài!<br>👏👏👏</span>',
                                confirmButtonText: 'Chơi lại',
                                customClass: {popup: 'swal2-popup swal2-rounded'}
                            }).then(() => {
                                level = 1;
                                renderQuestion();
                            });
                        }
                    } else {
                        this.classList.add('selected-wrong');
                        Swal.fire({
                            icon: 'error',
                            title: 'Chưa đúng!',
                            html: '<span style="font-size:1.1rem">Hãy thử lại nhé!</span>',
                            showConfirmButton: false,
                            timer: 1200,
                            timerProgressBar: true
                        }).then(() => {
                            answered = false;
                            this.classList.remove('selected-wrong');
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
