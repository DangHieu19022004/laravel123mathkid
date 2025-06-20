@extends('layouts.game')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-800 to-gray-900 text-white p-4 font-sans flex flex-col items-center justify-center">
        <div class="w-full max-w-7xl flex flex-col items-center">
            <!-- Header -->
            <div class="text-center mb-4 animate-fade-in-down">
                <div class="w-24 h-24 mb-2 mx-auto text-amber-400 drop-shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.25 2.25a3 3 0 00-3 3v4.306a3 3 0 00.879 2.121l9.58 9.581a1.5 1.5 0 002.122 0l4.306-4.306a1.5 1.5 0 000-2.121l-9.58-9.581a3 3 0 00-2.122-.879H5.25zM6.375 7.5a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-amber-300 drop-shadow-md tracking-wider">Phân Loại Kho Báu</h1>
                <p class="text-amber-100/80 mt-2 font-semibold">Kéo những viên ngọc vào đúng chiếc rương của nó.</p>
            </div>

            <!-- Progress Bar -->
            <div class="w-full max-w-2xl my-4">
                <div class="w-full bg-gray-700 rounded-full h-4 border-2 border-gray-600 shadow-inner">
                    <div id="progress-bar" class="bg-gradient-to-r from-amber-400 to-yellow-500 h-full rounded-full transition-all duration-500" style="width: 0%;"></div>
                </div>
            </div>

            <!-- Gems Area -->
            <div class="w-full flex flex-col items-center">
                <h2 class="text-2xl font-bold text-amber-200/90 mb-2 mt-4">Kho Ngọc Thô</h2>
                <div id="gems-area" class="w-full min-h-[150px] bg-gradient-to-t from-gray-900 to-black/30 rounded-2xl p-4 my-2 flex flex-wrap items-center justify-center gap-4 border-2 border-gray-700 shadow-lg">
                    <!-- Gems will be populated by JS -->
                </div>
            </div>

            <!-- Chests Area -->
            <div id="chests-area" class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
                <!-- Chests will be populated by JS -->
            </div>

            <!-- Control Buttons -->
            <div class="flex items-center gap-4 mt-8">
                <button id="check-btn" class="px-8 py-3 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-full shadow-lg transition-all duration-200 text-lg disabled:bg-gray-400 disabled:cursor-not-allowed">Kiểm tra</button>
                <button id="next-btn" class="hidden px-8 py-3 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-full shadow-lg transition-all">Cấp tiếp theo</button>
            </div>
        </div>
        <audio id="drop-sound" src="https://cdn.pixabay.com/audio/2021/08/04/audio_12b0c7443c.mp3" preload="auto"></audio>
    </div>
@endsection

@push('styles')
    <style>
        .gem {
            touch-action: none; /* for mobile drag-drop */
            transition: all 0.2s ease-in-out;
        }

        .gem:hover {
            transform: scale(1.1) rotate(3deg);
            filter: drop-shadow(0 0 10px rgba(250, 204, 21, 0.7));
        }

        .sortable-ghost {
            opacity: 0.4;
            transform: scale(1.1) rotate(5deg);
            background: #fde68a;
        }

        .chest-body.drag-over {
            background-color: rgba(252, 211, 77, 0.2); /* amber-300 with opacity */
            border-style: dashed;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('js/sortable.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const questions = @json($questions);
            let currentLevel = 0;

            // DOM Elements
            const progressBar = document.getElementById('progress-bar');
            const gemsArea = document.getElementById('gems-area');
            const chestsArea = document.getElementById('chests-area');
            const checkBtn = document.getElementById('check-btn');
            const nextBtn = document.getElementById('next-btn');
            const dropSound = document.getElementById('drop-sound');

            function shuffle(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
                return array;
            }

            function createGem(fraction) {
                const gemPalettes = [
                    {name: 'ruby', h: 0, s: 70, l: 50},
                    {name: 'sapphire', h: 215, s: 70, l: 55},
                    {name: 'emerald', h: 145, s: 65, l: 45},
                    {name: 'amethyst', h: 270, s: 60, l: 60},
                    {name: 'topaz', h: 45, s: 80, l: 55}
                ];
                const p = gemPalettes[Math.floor(Math.random() * gemPalettes.length)];

                const baseColor = `hsl(${p.h}, ${p.s}%, ${p.l}%)`;
                const lightColor = `hsl(${p.h}, ${p.s + 10}%, ${p.l + 15}%)`;
                const darkColor = `hsl(${p.h}, ${p.s}%, ${p.l - 15}%)`;
                return `
                    <div class="gem w-24 h-24 relative cursor-grab flex items-center justify-center"
                         data-id="${fraction.id}"
                         data-group="${fraction.group}">
                        <svg viewBox="0 0 100 100" class="w-full h-full absolute transition-all duration-200 ease-in-out" style="filter: drop-shadow(0 4px 6px rgba(0,0,0,0.4));">
                            <path d="M50 0 L100 40 L80 100 L20 100 L0 40 Z" fill="${baseColor}" />
                            <path d="M50 0 L100 40 L50 45 Z" fill="${lightColor}" />
                            <path d="M50 0 L0 40 L50 45 Z" fill="hsl(${p.h}, ${p.s - 10}%, ${p.l + 5}%)" />
                            <path d="M50 45 L100 40 L80 100 L50 100 Z" fill="${darkColor}" />
                            <path d="M50 45 L0 40 L20 100 L50 100 Z" fill="hsl(${p.h}, ${p.s}%, ${p.l - 5}%)" />
                        </svg>
                        <span class="relative font-bold text-white text-2xl" style="text-shadow: 0 0 5px #000, 0 0 5px #000;">
                            ${fraction.text}
                        </span>
                    </div>
                `;
            }

            function createChest(group) {
                return `
                    <div class="chest-container flex flex-col items-center">
                         <div class="w-[105%] h-8 bg-gradient-to-b from-stone-700 to-stone-800 rounded-t-md border-2 border-b-0 border-stone-900 relative -mb-1 z-10">
                            <div class="absolute inset-x-4 top-1/2 -translate-y-1/2 h-2 bg-gradient-to-b from-amber-500 to-amber-600 rounded-sm border border-amber-700"></div>
                        </div>
                        <div class="chest-body w-full min-h-[140px] bg-stone-800/90 rounded-b-md p-4 pt-5 flex flex-wrap justify-center content-start gap-4 border-2 border-stone-900" data-group-id="${group.id}">
                            <!-- gems go here -->
                        </div>
                        <div class="text-xl font-bold text-amber-300 mt-3 p-1 px-4 bg-black/50 rounded-md shadow-lg">${group.name}</div>
                    </div>
                `;
            }

            function showLevel(level) {
                const question = questions[level];

                progressBar.style.width = `${(level / questions.length) * 100}%`;

                // Populate gems
                gemsArea.innerHTML = shuffle(question.fractions).map(createGem).join('');

                // Populate chests
                chestsArea.innerHTML = question.groups.map(createChest).join('');

                const numGroups = question.groups.length;
                let gridCols = 'sm:grid-cols-2';
                if (numGroups > 2) {
                    gridCols += ' lg:grid-cols-3';
                }
                if (numGroups > 3) {
                    gridCols += ' xl:grid-cols-4';
                }
                chestsArea.className = `w-full grid grid-cols-1 ${gridCols} gap-6 mt-6`;


                // Init SortableJS
                new Sortable(gemsArea, {
                    group: 'shared-gems',
                    animation: 150,
                    ghostClass: 'sortable-ghost'
                });

                document.querySelectorAll('.chest-body').forEach(chest => {
                    new Sortable(chest, {
                        group: 'shared-gems',
                        animation: 150,
                        ghostClass: 'sortable-ghost',
                        onAdd: function () {
                            dropSound.currentTime = 0;
                            dropSound.play().catch(e => console.error("Audio play failed:", e));
                        },
                        onStart: function (evt) {
                            document.querySelectorAll('.chest-body').forEach(c => c.classList.add('drag-over'));
                        },
                        onEnd: function (evt) {
                            document.querySelectorAll('.chest-body').forEach(c => c.classList.remove('drag-over'));
                        }
                    });
                });
            }

            function checkAnswer() {
                if (gemsArea.children.length > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Chưa xong!',
                        text: 'Hãy phân loại tất cả các viên ngọc vào rương nhé.',
                        background: '#1f2937',
                        color: '#f3f4f6'
                    });
                    return;
                }

                let allCorrect = true;
                document.querySelectorAll('.chest-body').forEach(chest => {
                    const groupId = chest.dataset.groupId;
                    const gemsInChest = Array.from(chest.children);

                    for (const gem of gemsInChest) {
                        if (gem.dataset.group !== groupId) {
                            allCorrect = false;
                            break;
                        }
                    }
                });

                if (allCorrect) {
                    progressBar.style.width = `${((currentLevel + 1) / questions.length) * 100}%`;
                    Swal.fire({
                        icon: 'success',
                        title: 'Chính xác! 💎',
                        text: 'Bạn đã tìm đúng nhà cho tất cả các viên ngọc!',
                        background: '#1f2937',
                        color: '#f3f4f6'
                    });
                    checkBtn.classList.add('hidden');
                    if (currentLevel < questions.length - 1) {
                        nextBtn.classList.remove('hidden');
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Hoàn thành! 🎉',
                            text: 'Bạn là một chuyên gia phân loại kho báu!',
                            background: '#1f2937',
                            color: '#f3f4f6',
                            confirmButtonText: 'Chơi lại'
                        }).then(() => {
                            currentLevel = 0;
                            showLevel(currentLevel);
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sai rồi... 🧐',
                        text: 'Có vẻ một vài viên ngọc đã bị lạc vào nhầm rương. Hãy thử lại!',
                        background: '#1f2937',
                        color: '#f3f4f6'
                    });
                }
            }

            function goToNextLevel() {
                currentLevel++;
                showLevel(currentLevel);
                nextBtn.classList.add('hidden');
                checkBtn.classList.remove('hidden');
            }

            // Event Listeners
            checkBtn.addEventListener('click', checkAnswer);
            nextBtn.addEventListener('click', goToNextLevel);

            // Initial game start
            showLevel(currentLevel);
        });
    </script>
@endpush
