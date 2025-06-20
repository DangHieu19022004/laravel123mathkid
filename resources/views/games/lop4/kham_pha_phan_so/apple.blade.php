@extends('layouts.game')

@section('content')
    <div class="flex flex-col items-center min-h-screen bg-gradient-to-br from-pink-100 to-yellow-100">
        <div class="w-full max-w-2xl p-6 bg-white rounded-3xl shadow-xl mt-8 animate-fade-in">
            <div class="text-center mb-6">
                <h1 class="text-4xl font-extrabold text-pink-600 mb-2 animate-bounce">Chia Táo 🍎</h1>
                <div class="inline-block px-6 py-2 bg-pink-100 rounded-full shadow text-lg font-semibold text-pink-700 mb-2">
                    Cấp độ <span id="current-level">1</span>/5
                </div>
                <p class="text-gray-500 mt-2" id="instruction-text"></p>
            </div>
            <div class="mb-4">
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg animate-fade-in">
                    <h3 class="font-bold text-yellow-700 mb-1">🎯 Hướng dẫn chơi:</h3>
                    <ul class="list-disc list-inside text-gray-700 text-base">
                        <li>Có tổng cộng <span id="total-apples"></span> quả táo</li>
                        <li>Bạn cần chia đều vào <span id="total-groups"></span> nhóm</li>
                        <li>Kéo và thả táo vào từng nhóm</li>
                        <li>Mỗi nhóm phải có số táo bằng nhau</li>
                    </ul>
                </div>
            </div>
            <div class="flex flex-col w-full items-center space-y-4">
                <div id="apple-source" class="flex flex-wrap justify-center gap-2 min-h-[56px] py-2"></div>
                <div id="apple-groups" class="flex flex-wrap justify-center gap-6 w-full"></div>
            </div>
            <div class="flex flex-col items-center mt-6 space-y-2">
                <button id="check-btn" class="px-8 py-2 bg-pink-500 hover:bg-pink-600 text-white font-bold rounded-full shadow transition-all duration-200 animate-pulse">Kiểm tra</button>
                <button id="reset-btn" class="text-pink-500 hover:underline text-sm">Chơi lại từ đầu</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.APPLE_QUESTIONS = @json($questions);
        const maxLevel = Object.keys(window.APPLE_QUESTIONS).length;

        function animateApple(el) {
            el.classList.add('animate-bounce-short');
            setTimeout(() => el.classList.remove('animate-bounce-short'), 600);
        }

        function renderGame(level) {
            const q = window.APPLE_QUESTIONS[level];
            document.getElementById('current-level').textContent = level;
            document.getElementById('total-apples').textContent = q.apples;
            document.getElementById('total-groups').textContent = q.students;
            document.getElementById('instruction-text').textContent = `Hãy chia ${q.apples} quả táo vào ${q.students} nhóm sao cho mỗi nhóm đều nhau!`;

            // Render apples
            const source = document.getElementById('apple-source');
            source.innerHTML = '';
            for (let i = 0; i < q.apples; i++) {
                const apple = document.createElement('div');
                apple.className = 'apple draggable select-none text-3xl transition-transform duration-200 hover:scale-125 cursor-grab';
                apple.draggable = true;
                apple.textContent = '🍎';
                apple.setAttribute('data-apple', i);
                source.appendChild(apple);
            }

            // Render groups
            const groups = document.getElementById('apple-groups');
            groups.innerHTML = '';
            for (let i = 1; i <= q.students; i++) {
                const group = document.createElement('div');
                group.className = 'apple-group bg-gradient-to-br from-yellow-200 to-pink-100 rounded-2xl shadow-lg p-2 min-w-[140px] min-h-[160px] flex flex-col items-center dropzone transition-all duration-200';
                group.innerHTML = `<div class='font-bold text-pink-600 mb-2'>Nhóm ${i}</div><div class='group-apples flex flex-wrap justify-center gap-1 p-1 w-32 min-h-28 bg-yellow-50 border border-yellow-300 rounded-xl' data-group='${i}'></div>`;
                groups.appendChild(group);
            }
            initDragAndDrop();
        }

        let draggingApple = null;

        function initDragAndDrop() {
            document.querySelectorAll('.draggable').forEach(el => {
                el.addEventListener('dragstart', e => {
                    draggingApple = el;
                    el.classList.add('opacity-50', 'scale-90');
                    setTimeout(() => el.classList.add('invisible'), 0);
                });
                el.addEventListener('dragend', e => {
                    el.classList.remove('opacity-50', 'scale-90', 'invisible');
                    draggingApple = null;
                });
            });
            document.querySelectorAll('.group-apples').forEach(drop => {
                drop.addEventListener('dragover', e => {
                    e.preventDefault();
                    drop.parentElement.classList.add('ring-4', 'ring-pink-300');
                });
                drop.addEventListener('dragleave', e => {
                    drop.parentElement.classList.remove('ring-4', 'ring-pink-300');
                });
                drop.addEventListener('drop', e => {
                    e.preventDefault();
                    drop.parentElement.classList.remove('ring-4', 'ring-pink-300');
                    if (draggingApple) {
                        drop.appendChild(draggingApple);
                        animateApple(draggingApple);
                    }
                });
            });
            // Allow apples to be dragged back to source
            const source = document.getElementById('apple-source');
            source.addEventListener('dragover', e => e.preventDefault());
            source.addEventListener('drop', e => {
                e.preventDefault();
                if (draggingApple) {
                    source.appendChild(draggingApple);
                    animateApple(draggingApple);
                }
            });
        }

        function checkAnswer(currentLevel) {
            const q = window.APPLE_QUESTIONS[currentLevel];
            const expected = q.apples / q.students;
            const groupEls = document.querySelectorAll('.group-apples');
            const counts = Array.from(groupEls).map(g => g.children.length);
            const allEqual = counts.every(c => c === expected);
            if (allEqual) {
                Swal.fire({
                    icon: 'success',
                    title: '🎉 Đúng rồi!',
                    text: currentLevel < maxLevel ? 'Bạn sẽ lên cấp tiếp theo!' : 'Bạn đã hoàn thành tất cả cấp độ!',
                    showConfirmButton: false,
                    timer: 1500,
                    background: '#fff0f6',
                    color: '#d63384',
                    didOpen: () => {
                        groupEls.forEach(g => g.classList.add('animate-wiggle'));
                        setTimeout(() => groupEls.forEach(g => g.classList.remove('animate-wiggle')), 1000);
                    }
                }).then(() => {
                    if (currentLevel < maxLevel) {
                        level = currentLevel + 1;
                        renderGame(level);
                    }
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: '⚠️ Chưa đúng!',
                    text: `Mỗi nhóm cần có ${expected} táo. Hãy thử lại!`,
                    background: '#fffbea',
                    color: '#d97706',
                    showConfirmButton: false,
                    timer: 1800
                });
                groupEls.forEach(g => {
                    if (g.children.length !== expected) {
                        g.classList.add('animate-shake');
                        setTimeout(() => g.classList.remove('animate-shake'), 600);
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            let level = 1;
            renderGame(level);

            document.getElementById('check-btn').onclick = () => checkAnswer(level);
            document.getElementById('reset-btn').onclick = () => {
                Swal.fire({
                    title: 'Chơi lại từ đầu?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Đồng ý',
                    cancelButtonText: 'Hủy',
                    background: '#fff0f6',
                    color: '#d63384',
                }).then((result) => {
                    if (result.isConfirmed) {
                        level = 1;
                        renderGame(level);
                    }
                });
            };
        });

        // Animation utilities
        const style = document.createElement('style');
        style.innerHTML = `
@keyframes wiggle { 0%{transform:rotate(-2deg);} 25%{transform:rotate(2deg);} 50%{transform:rotate(-2deg);} 75%{transform:rotate(2deg);} 100%{transform:rotate(0);} }
.animate-wiggle { animation: wiggle 0.5s 2; }
@keyframes shake { 0%,100%{transform:translateX(0);} 20%,60%{transform:translateX(-8px);} 40%,80%{transform:translateX(8px);} }
.animate-shake { animation: shake 0.6s; }
@keyframes bounce-short { 0%{transform:scale(1);} 30%{transform:scale(1.2);} 60%{transform:scale(0.95);} 100%{transform:scale(1);} }
.animate-bounce-short { animation: bounce-short 0.6s; }
@keyframes fade-in { from{opacity:0;transform:translateY(30px);} to{opacity:1;transform:translateY(0);} }
.animate-fade-in { animation: fade-in 0.7s; }
`;
        document.head.appendChild(style);
    </script>
@endpush
