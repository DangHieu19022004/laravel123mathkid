@extends('layouts.game')

@section('content')
    <div class="min-h-screen flex flex-col items-center bg-gradient-to-br from-yellow-100 to-orange-200 p-4 font-sans">
        <div class="w-full max-w-4xl bg-stone-100/80 backdrop-blur-sm rounded-3xl shadow-2xl p-4 md:p-8 flex flex-col items-center animate-fade-in">
            <!-- Header -->
            <div class="flex flex-col items-center text-center mb-4">
                <div class="w-20 h-20 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-stone-600 drop-shadow-lg">
                        <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h12a3 3 0 013 3v12a3 3 0 01-3 3H6a3 3 0 01-3-3V6zm4.5 9a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM12 15a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm4.5 0a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm-9-4.5a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-stone-700 drop-shadow">Tháp Phân Số</h1>
                <p class="text-stone-500 mt-1">Kéo và thả các phiến đá để sắp xếp phân số từ nhỏ đến lớn.</p>
            </div>

            <!-- Progress Bar -->
            <div class="w-full max-w-lg px-4 md:px-8 my-4">
                <div class="flex justify-between items-center mb-1 text-stone-600 font-semibold">
                    <span id="level-indicator">Cấp độ 1/5</span>
                    <span>Tiến trình</span>
                </div>
                <div class="w-full bg-stone-300 rounded-full h-4 border-2 border-stone-400/50 shadow-inner">
                    <div id="progress-bar" class="bg-gradient-to-r from-amber-400 to-orange-500 h-full rounded-full transition-all duration-500" style="width: 20%"></div>
                </div>
            </div>

            <!-- Game Area -->
            <div class="w-full flex flex-col lg:flex-row items-start justify-center gap-8 mt-6">
                <!-- Tower -->
                <div id="tower-container" class="w-full lg:w-1/2 flex flex-col items-center">
                    <p class="font-bold text-stone-600 mb-2 text-lg">Xếp vào đây (Nhỏ -> Lớn)</p>
                    <div id="tower-slots" class="w-full max-w-xs flex flex-col gap-2">
                        <!-- Slots will be injected by JS -->
                    </div>
                </div>

                <!-- Fraction Pool -->
                <div id="pool-container" class="w-full lg:w-1/2 flex flex-col items-center">
                    <p class="font-bold text-stone-600 mb-2 text-lg">Lấy đá từ đây</p>
                    <div id="fraction-pool" class="w-full max-w-sm min-h-[150px] bg-stone-300/70 rounded-2xl p-4 flex flex-wrap justify-center items-center gap-4 border-2 border-dashed border-stone-400">
                        <!-- Fraction stones will be injected by JS -->
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <div class="flex items-center gap-4 mt-8">
                <button id="check-btn" class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-full shadow-lg transition-all duration-200 text-lg disabled:bg-gray-400 disabled:cursor-not-allowed">Kiểm tra</button>
                <button id="replay-btn" class="hidden px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold rounded-full shadow-lg transition-all duration-200">Chơi lại</button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .tower-slot, .fraction-stone {
            transition: all 0.2s ease-in-out;
        }

        .tower-slot.drag-over {
            background-color: rgba(250, 251, 205, 1); /* yellow-100 */
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(234, 179, 8, 0.5);
        }

        .fraction-stone.is-dragging {
            opacity: 0.5;
            transform: scale(0.9) rotate(5deg);
            cursor: grabbing;
        }
    </style>
@endpush


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const questions = @json($questions);
            let currentLevel = 0;

            // DOM Elements
            const levelIndicator = document.getElementById('level-indicator');
            const progressBar = document.getElementById('progress-bar');
            const towerSlotsContainer = document.getElementById('tower-slots');
            const fractionPool = document.getElementById('fraction-pool');
            const checkBtn = document.getElementById('check-btn');
            const replayBtn = document.getElementById('replay-btn');

            // Drag and Drop State
            let draggedElement = null;

            function createTowerSlot(index) {
                const slot = document.createElement('div');
                slot.className = 'tower-slot w-full h-16 bg-stone-200/90 rounded-lg border-2 border-stone-400/60 flex justify-center items-center shadow-inner';
                slot.dataset.index = index;
                return slot;
            }

            function createFractionStone(fraction, originalIndex) {
                const stone = document.createElement('div');
                stone.className = 'fraction-stone w-28 h-14 bg-stone-500 hover:bg-stone-600 rounded-lg shadow-md cursor-grab flex justify-center items-center text-white font-bold text-xl';
                stone.draggable = true;
                stone.dataset.originalIndex = originalIndex;
                stone.textContent = `${fraction.numerator}/${fraction.denominator}`;
                return stone;
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
                levelIndicator.textContent = `Cấp độ ${level + 1}/${questions.length}`;
                progressBar.style.width = `${((level) / questions.length) * 100}%`;
                checkBtn.disabled = true;

                // Clear previous level
                towerSlotsContainer.innerHTML = '';
                fractionPool.innerHTML = '';

                // Create tower slots
                question.fractions.forEach((_, index) => {
                    towerSlotsContainer.appendChild(createTowerSlot(index));
                });

                // Create and shuffle fraction stones
                const stones = question.fractions.map((frac, index) => createFractionStone(frac, index));
                shuffle(stones).forEach(stone => fractionPool.appendChild(stone));

                addDragAndDropListeners();
            }

            function updateCheckButtonState() {
                const placedStones = towerSlotsContainer.querySelectorAll('.fraction-stone').length;
                const totalSlots = questions[currentLevel].fractions.length;
                checkBtn.disabled = placedStones !== totalSlots;
            }

            function addDragAndDropListeners() {
                const stones = document.querySelectorAll('.fraction-stone');
                const containers = document.querySelectorAll('.tower-slot, #fraction-pool');

                stones.forEach(stone => {
                    stone.addEventListener('dragstart', (e) => {
                        draggedElement = stone;
                        setTimeout(() => stone.classList.add('is-dragging'), 0);
                    });
                    stone.addEventListener('dragend', () => {
                        if (draggedElement) { // Check if it hasn't been cleared
                            draggedElement.classList.remove('is-dragging');
                        }
                        draggedElement = null;
                    });
                });

                containers.forEach(container => {
                    container.addEventListener('dragover', (e) => {
                        e.preventDefault();
                        if (container.classList.contains('tower-slot') && container.children.length === 0) {
                            container.classList.add('drag-over');
                        }
                    });

                    container.addEventListener('dragleave', () => {
                        if (container.classList.contains('tower-slot')) {
                            container.classList.remove('drag-over');
                        }
                    });

                    container.addEventListener('drop', (e) => {
                        e.preventDefault();
                        if (container.classList.contains('tower-slot')) {
                            container.classList.remove('drag-over');
                        }

                        if (draggedElement) {
                            // If dropping on a slot that is occupied, do a swap
                            if (container.classList.contains('tower-slot') && container.children.length > 0) {
                                const existingStone = container.children[0];
                                const originalParent = draggedElement.parentElement;
                                container.appendChild(draggedElement);
                                originalParent.appendChild(existingStone);
                            } else { // Otherwise, just append
                                container.appendChild(draggedElement);
                            }
                        }
                        updateCheckButtonState();
                    });
                });
            }

            function checkAnswer() {
                const placedStones = towerSlotsContainer.querySelectorAll('.fraction-stone');
                const currentOrder = Array.from(placedStones).map(stone => parseInt(stone.dataset.originalIndex));
                const correctOrder = questions[currentLevel].correctOrder;

                const isCorrect = JSON.stringify(currentOrder) === JSON.stringify(correctOrder);

                if (isCorrect) {
                    progressBar.style.width = `${((currentLevel + 1) / questions.length) * 100}%`;
                    Swal.fire({
                        icon: 'success',
                        title: 'Chính xác! 🎉',
                        text: 'Bạn đã xây tháp thành công!',
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
                                title: 'Hoàn thành tất cả các màn! 🏆',
                                text: 'Bạn là một kiến trúc sư phân số đại tài!',
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
                        html: 'Thứ tự của các phiến đá chưa chính xác. <br>Hãy thử sắp xếp lại nhé!',
                        confirmButtonText: 'Thử lại',
                    });
                }
            }

            checkBtn.addEventListener('click', checkAnswer);
            replayBtn.addEventListener('click', () => {
                currentLevel = 0;
                showLevel(0);
                checkBtn.classList.remove('hidden');
                replayBtn.classList.add('hidden');
            });

            // Initial game start
            showLevel(currentLevel);
        });
    </script>
@endpush
