@extends('layouts.game')

@section('content')
<div class="min-h-screen flex flex-col items-center bg-gradient-to-br from-blue-100 via-purple-100 to-indigo-200 p-4 font-sans">
    <div class="w-full max-w-6xl bg-white/80 backdrop-blur-md rounded-3xl shadow-2xl p-4 md:p-8 flex flex-col lg:flex-row items-center justify-center gap-8 animate-fade-in" style="background-image: url('https://www.transparenttextures.com/patterns/notebook-dark.png');">

        <!-- Left Side: Story & Input -->
        <div class="w-full lg:w-1/2 flex flex-col items-center">
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="w-24 h-24 mb-2 mx-auto text-purple-600 drop-shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.25 4.533A9.707 9.707 0 006 3a9.735 9.735 0 00-3.25.555.75.75 0 00-.5.707v14.25a.75.75 0 001 .707A9.707 9.707 0 006 21a9.735 9.735 0 003.25-.555.75.75 0 00.5-.707V5.24a.75.75 0 00-1-.707zM12.75 4.533A9.707 9.707 0 0118 3a9.735 9.735 0 013.25.555.75.75 0 01.5.707v14.25a.75.75 0 01-1 .707A9.707 9.707 0 0118 21a9.735 9.735 0 01-3.25-.555.75.75 0 01-.5-.707V5.24a.75.75 0 011-.707z" />
                    </svg>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-purple-800 drop-shadow">Giải Toán Có Lời Văn</h1>
                <p class="text-purple-600 mt-1 font-semibold">Đọc kỹ đề bài và điền đáp án nhé!</p>
            </div>

            <!-- Progress Bar -->
            <div class="w-full max-w-md my-4">
                <div class="w-full bg-purple-200/80 rounded-full h-4 border-2 border-purple-300/50 shadow-inner">
                    <div id="progress-bar" class="bg-gradient-to-r from-indigo-400 to-purple-500 h-full rounded-full transition-all duration-500" style="width: 0%;"></div>
                </div>
            </div>

            <!-- Story Box -->
            <div id="story-box" class="w-full max-w-md bg-amber-50 border-l-8 border-amber-300 p-5 rounded-xl shadow-lg my-4 text-gray-800 text-lg leading-relaxed">
                <!-- Story text will be injected by JS -->
            </div>

            <!-- Answer Input -->
            <div class="flex items-center justify-center gap-4 mt-4">
                <input type="number" id="numerator" placeholder="Tử số" class="w-36 text-center font-bold p-3 rounded-lg border-2 border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200 transition">
                <div class="text-4xl font-light text-gray-400">/</div>
                <input type="number" id="denominator" placeholder="Mẫu số" class="w-36 text-center font-bold p-3 rounded-lg border-2 border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200 transition">
            </div>

            <!-- Control Buttons -->
            <div class="flex items-center gap-4 mt-8">
                <button id="check-btn" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-full shadow-lg transition-all duration-200 text-lg disabled:bg-gray-400 disabled:cursor-not-allowed">Kiểm tra</button>
                <button id="replay-btn" class="hidden px-6 py-3 bg-orange-400 hover:bg-orange-500 text-white font-bold rounded-full shadow-lg transition-all duration-200">Chơi lại</button>
            </div>
        </div>

        <!-- Right Side: Visualization -->
        <div class="w-full lg:w-1/2 h-96 flex items-center justify-center p-4">
            <div id="visualization-box" class="w-full h-full max-w-md max-h-md flex items-center justify-center transition-all duration-500">
                <!-- SVG Visualization will be injected here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const questions = @json($questions);
    let currentLevel = 0;

    // DOM Elements
    const progressBar = document.getElementById('progress-bar');
    const storyBox = document.getElementById('story-box');
    const numeratorInput = document.getElementById('numerator');
    const denominatorInput = document.getElementById('denominator');
    const checkBtn = document.getElementById('check-btn');
    const replayBtn = document.getElementById('replay-btn');
    const visualizationBox = document.getElementById('visualization-box');

    // --- SVG Visualization Functions ---
    function createPieSVG(totalParts) {
        const svgNS = "http://www.w3.org/2000/svg";
        const svg = document.createElementNS(svgNS, "svg");
        svg.setAttribute('viewBox', '0 0 100 100');
        svg.setAttribute('class', 'w-full h-full drop-shadow-lg');

        const radius = 45;
        const cx = 50;
        const cy = 50;

        for (let i = 0; i < totalParts; i++) {
            const angle1 = (i / totalParts) * 2 * Math.PI - Math.PI / 2;
            const angle2 = ((i + 1) / totalParts) * 2 * Math.PI - Math.PI / 2;

            const x1 = cx + radius * Math.cos(angle1);
            const y1 = cy + radius * Math.sin(angle1);
            const x2 = cx + radius * Math.cos(angle2);
            const y2 = cy + radius * Math.sin(angle2);

            const path = document.createElementNS(svgNS, "path");
            path.setAttribute('d', `M${cx},${cy} L${x1},${y1} A${radius},${radius} 0 0,1 ${x2},${y2} Z`);
            path.setAttribute('class', 'slice transition-all duration-300');
            path.setAttribute('fill', '#E5E7EB'); // gray-200
            path.setAttribute('stroke', '#9CA3AF'); // gray-400
            path.setAttribute('stroke-width', '0.5');
            svg.appendChild(path);
        }
        return svg;
    }

    function createBarSVG(totalParts) {
        const svgNS = "http://www.w3.org/2000/svg";
        const svg = document.createElementNS(svgNS, "svg");
        svg.setAttribute('viewBox', `0 0 ${totalParts * 12} 24`);
        svg.setAttribute('class', 'w-full h-24 drop-shadow-lg');

        for (let i = 0; i < totalParts; i++) {
            const rect = document.createElementNS(svgNS, "rect");
            rect.setAttribute('x', i * 12 + 1);
            rect.setAttribute('y', 2);
            rect.setAttribute('width', 10);
            rect.setAttribute('height', 20);
            rect.setAttribute('rx', 2);
            rect.setAttribute('class', 'slice transition-all duration-300');
            rect.setAttribute('fill', '#E5E7EB'); // gray-200
            rect.setAttribute('stroke', '#9CA3AF'); // gray-400
            rect.setAttribute('stroke-width', '0.2');
            svg.appendChild(rect);
        }
        return svg;
    }

    function updateVisualization() {
        const num = parseInt(numeratorInput.value) || 0;
        const den = parseInt(denominatorInput.value) || 0;
        const question = questions[currentLevel];
        const slices = visualizationBox.querySelectorAll('.slice');

        if (den !== question.total_parts) {
            slices.forEach((slice, i) => {
                slice.setAttribute('fill', '#FECACA'); // red-200
            });
            return;
        }

        slices.forEach((slice, i) => {
            if (i < num) {
                slice.setAttribute('fill', '#818CF8'); // indigo-400
            } else {
                slice.setAttribute('fill', '#E5E7EB'); // gray-200
            }
        });
    }

    // --- Game Logic ---
    function showLevel(level) {
        const question = questions[level];

        // Update UI
        progressBar.style.width = `${((level) / questions.length) * 100}%`;
        storyBox.innerHTML = `<p>${question.story}</p>`;
        numeratorInput.value = '';
        denominatorInput.value = '';
        numeratorInput.focus();

        // Create visualization
        visualizationBox.innerHTML = '';
        let svg;
        if (question.type === 'pie') {
            svg = createPieSVG(question.total_parts);
        } else {
            svg = createBarSVG(question.total_parts);
        }
        visualizationBox.appendChild(svg);
        updateVisualization();
    }

    function checkAnswer() {
        const userNumerator = parseInt(numeratorInput.value);
        const userDenominator = parseInt(denominatorInput.value);
        const correctAnswer = questions[currentLevel].answer;

        const isCorrect = userNumerator === correctAnswer.numerator && userDenominator === correctAnswer.denominator;

        if (isCorrect) {
            progressBar.style.width = `${((currentLevel + 1) / questions.length) * 100}%`;
            Swal.fire({
                icon: 'success',
                title: 'Chính xác! 🥳',
                text: 'Bạn giải toán giỏi quá!',
                timer: 2000,
                showConfirmButton: false,
            });

            setTimeout(() => {
                if (currentLevel < questions.length - 1) {
                    currentLevel++;
                    showLevel(currentLevel);
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Hoàn thành xuất sắc! 🏆',
                        html: 'Bạn đã giải hết các bài toán. <br>Một nhà toán học tài ba!',
                        confirmButtonText: 'Tuyệt vời!',
                    });
                    checkBtn.classList.add('hidden');
                    replayBtn.classList.remove('hidden');
                }
            }, 2000);
        } else {
             Swal.fire({
                icon: 'error',
                title: 'Chưa đúng rồi... 🧐',
                text: 'Hãy đọc lại đề bài và kiểm tra lại phép tính của bạn nhé!',
                confirmButtonText: 'Thử lại',
            });
        }
    }

    // Event Listeners
    checkBtn.addEventListener('click', checkAnswer);
    replayBtn.addEventListener('click', () => {
        currentLevel = 0;
        showLevel(0);
        progressBar.style.width = '0%';
        checkBtn.classList.remove('hidden');
        replayBtn.classList.add('hidden');
    });
    numeratorInput.addEventListener('input', updateVisualization);
    denominatorInput.addEventListener('input', updateVisualization);

    // Initial game start
    showLevel(currentLevel);
});
</script>
@endpush
