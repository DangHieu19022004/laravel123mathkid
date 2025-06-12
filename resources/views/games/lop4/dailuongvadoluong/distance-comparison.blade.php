@extends('layouts.game')

@section('title', 'So Sánh Quãng Đường')

@section('styles')
<style>
.track-container {
    position: relative;
    height: 300px;
    background: #f3f4f6;
    border-radius: 20px;
    overflow: visible;
    margin-bottom: 2rem;
    box-shadow: 0 4px 24px #60a5fa22;
}
.track-lines {
    position: absolute;
    inset: 0;
    z-index: 1;
    pointer-events: none;
}
.lane {
    display: flex;
    align-items: center;
    height: 50%;
    position: relative;
    z-index: 2;
}
.car-outer {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 3;
    height: 60px;
    display: flex;
    align-items: center;
}
.car-label {
    position: absolute;
    top: -38px;
    left: 50%;
    transform: translateX(-50%);
    font-weight: bold;
    background: #fffbe7;
    border-radius: 16px;
    padding: 6px 18px;
    box-shadow: 0 2px 8px #fbbf2422;
    z-index: 4;
    white-space: nowrap;
    font-size: 1.1rem;
    color: #f59e42;
    border: 2px solid #fde68a;
    transition: all 0.2s;
}
.vehicle {
    width: 80px;
    height: 60px;
    display: flex;
    align-items: center;
    filter: drop-shadow(0 2px 8px #60a5fa33);
    transition: transform 0.15s;
}
.vehicle:active {
    transform: scale(1.08) rotate(-2deg);
}
.vehicle.red-car svg path { fill: #ef4444; }
.vehicle.blue-car svg path { fill: #3b82f6; }

.button, .button-primary, .button-secondary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.9rem 2rem;
    font-weight: 700;
    font-size: 1.15rem;
    border-radius: 1.5rem;
    transition: all 0.18s cubic-bezier(.4,2,.55,.44);
    cursor: pointer;
    box-shadow: 0 2px 8px #60a5fa22;
    border: none;
    outline: none;
    margin: 0 0.5rem;
}
.button-primary {
    background: linear-gradient(90deg, #38bdf8 60%, #4ade80 100%);
    color: #fff;
    box-shadow: 0 4px 16px #38bdf822;
}
.button-primary:hover, .button-primary:focus {
    background: linear-gradient(90deg, #4ade80 60%, #38bdf8 100%);
    transform: scale(1.08) translateY(-2px);
    box-shadow: 0 8px 24px #4ade8033;
}
.button-secondary {
    background: linear-gradient(90deg, #fbbf24 60%, #f472b6 100%);
    color: #fff;
    box-shadow: 0 4px 16px #fbbf2422;
}
.button-secondary:hover, .button-secondary:focus {
    background: linear-gradient(90deg, #f472b6 60%, #fbbf24 100%);
    transform: scale(1.08) translateY(-2px);
    box-shadow: 0 8px 24px #f472b633;
}
.button:active {
    transform: scale(0.96);
}
.result-message {
    position: fixed;
    top: 1.5rem;
    right: 1.5rem;
    min-width: 220px;
    padding: 1.2rem 2rem 1.2rem 2.5rem;
    border-radius: 1.5rem;
    color: #fff;
    font-weight: bold;
    font-size: 1.2rem;
    opacity: 0;
    transform: translateY(-1rem) scale(0.95);
    transition: all 0.35s cubic-bezier(.4,2,.55,.44);
    z-index: 50;
    box-shadow: 0 8px 32px #0002;
    display: flex;
    align-items: center;
    gap: 0.7em;
}
.result-message.show {
    opacity: 1;
    transform: translateY(0) scale(1.05);
}
.result-message.correct {
    background: linear-gradient(90deg, #4ade80 60%, #38bdf8 100%);
    box-shadow: 0 8px 32px #4ade8033;
}
.result-message.incorrect {
    background: linear-gradient(90deg, #f87171 60%, #fbbf24 100%);
    box-shadow: 0 8px 32px #f8717133;
    animation: shake 0.4s;
}
@keyframes shake {
    0%, 100% { transform: translateY(0) scale(1.05); }
    20% { transform: translateY(-2px) scale(1.05) rotate(-2deg); }
    40% { transform: translateY(2px) scale(1.05) rotate(2deg); }
    60% { transform: translateY(-2px) scale(1.05) rotate(-2deg); }
    80% { transform: translateY(2px) scale(1.05) rotate(2deg); }
}
</style>
@endsection

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600">So Sánh Quãng Đường 🏎️</h1>
        <p class="text-lg mt-2">So sánh quãng đường của hai xe và chọn xe đi xa hơn</p>
    </div>
    <div class="track-container">
        <!-- Đường kẻ ngang -->
        <div class="track-lines flex flex-col justify-around h-full">
            <div class="border-t-2 border-dashed border-gray-300 w-full"></div>
            <div class="border-t-2 border-dashed border-gray-300 w-full"></div>
            <div class="border-t-2 border-dashed border-gray-300 w-full"></div>
            <div class="border-t-2 border-dashed border-gray-300 w-full"></div>
        </div>
        <!-- Lane Xe A -->
        <div class="absolute inset-0 flex flex-col justify-around h-full pointer-events-none">
            <div class="lane" style="height: 50%">
                <div class="car-outer" id="car-a-outer">
                    <div class="car-label" id="label-a"></div>
                    <div class="vehicle red-car" id="car-a">
                        <svg viewBox="0 0 640 512">
                            <path d="M640 320v48c0 17.7-14.3 32-32 32h-64c-17.7 0-32-14.3-32-32v-16H128v16c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32v-48c0-17.7 14.3-32 32-32h18.7l90.6-180.6C149.9 89.6 167.2 80 186.1 80h267.8c18.9 0 36.2 9.6 44.8 27.4L589.3 288H608c17.7 0 32 14.3 32 32zM64 336c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-16H64v16zm512 16c8.8 0 16-7.2 16-16v-16h-64v16c0 8.8 7.2 16 16 16h32zM160 192h320l-64-128H224l-64 128zm96 128c0-26.5-21.5-48-48-48s-48 21.5-48 48s21.5 48 48 48s48-21.5 48-48zm272 48c26.5 0 48-21.5 48-48s-21.5-48-48-48s-48 21.5-48 48s21.5 48 48 48z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <!-- Lane Xe B -->
            <div class="lane" style="height: 50%">
                <div class="car-outer" id="car-b-outer">
                    <div class="car-label" id="label-b"></div>
                    <div class="vehicle blue-car" id="car-b">
                        <svg viewBox="0 0 640 512">
                            <path d="M640 320v48c0 17.7-14.3 32-32 32h-64c-17.7 0-32-14.3-32-32v-16H128v16c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32v-48c0-17.7 14.3-32 32-32h18.7l90.6-180.6C149.9 89.6 167.2 80 186.1 80h267.8c18.9 0 36.2 9.6 44.8 27.4L589.3 288H608c17.7 0 32 14.3 32 32zM64 336c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-16H64v16zm512 16c8.8 0 16-7.2 16-16v-16h-64v16c0 8.8 7.2 16 16 16h32zM160 192h320l-64-128H224l-64 128zm96 128c0-26.5-21.5-48-48-48s-48 21.5-48 48s21.5 48 48 48s48-21.5 48-48zm272 48c26.5 0 48-21.5 48-48s-21.5-48-48-48s-48 21.5-48 48s21.5 48 48 48z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bảng điều khiển -->
    <div class="bg-white rounded-xl shadow-lg p-6 mt-8 max-w-4xl mx-auto">
        <div class="grid grid-cols-2 gap-8">
            <!-- Xe A -->
            <div>
                <h3 class="text-xl font-bold mb-4">Xe A</h3>
                <div class="flex items-center gap-4 mb-4">
                    <input type="number" id="value-a" class="w-24 p-2 border rounded text-center" value="1.2" readonly>
                    <select id="unit-a" class="p-2 border rounded">
                        <option value="km">km</option>
                        <option value="m">m</option>
                    </select>
                </div>
            </div>
            <!-- Xe B -->
            <div>
                <h3 class="text-xl font-bold mb-4">Xe B</h3>
                <div class="flex items-center gap-4 mb-4">
                    <input type="number" id="value-b" class="w-24 p-2 border rounded text-center" value="950" readonly>
                    <select id="unit-b" class="p-2 border rounded">
                        <option value="m">m</option>
                        <option value="km">km</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- Nút chuyển đổi -->
        <div class="text-center mt-6">
            <button id="convert" class="button button-secondary mb-4">
                Chuyển đổi đơn vị
            </button>
        </div>
        <!-- Câu trả lời -->
        <div class="text-center">
            <p class="mb-4 font-bold">Xe nào đi xa hơn?</p>
            <div class="flex justify-center gap-4">
                <button id="choose-a" class="button button-primary">
                    Xe A
                </button>
                <button id="choose-b" class="button button-primary">
                    Xe B
                </button>
            </div>
        </div>
    </div>
    <!-- Thông báo -->
    <div id="message" class="result-message"></div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const carAOuter = document.getElementById('car-a-outer');
    const carBOuter = document.getElementById('car-b-outer');
    const carA = document.getElementById('car-a');
    const carB = document.getElementById('car-b');
    const labelA = document.getElementById('label-a');
    const labelB = document.getElementById('label-b');
    const valueAInput = document.getElementById('value-a');
    const valueBInput = document.getElementById('value-b');
    const unitASelect = document.getElementById('unit-a');
    const unitBSelect = document.getElementById('unit-b');
    const convertBtn = document.getElementById('convert');
    const chooseABtn = document.getElementById('choose-a');
    const chooseBBtn = document.getElementById('choose-b');
    const messageEl = document.getElementById('message');

    let distanceA = 1.2; // km
    let distanceB = 0.95; // km

    function getDisplayValue(distance, unit) {
        return unit === 'km' ? distance + ' km' : (distance * 1000) + ' m';
    }

    function updateCarPositions() {
        const track = document.querySelector('.track-container');
        const trackWidth = track.offsetWidth;
        const carWidth = 80;
        const padding = 24;
        const usableWidth = trackWidth - carWidth - padding * 2;
        const maxDistance = Math.max(distanceA, distanceB);
        // Tính vị trí (từ padding đến usableWidth+padding)
        const posA = padding + (distanceA / maxDistance) * usableWidth;
        const posB = padding + (distanceB / maxDistance) * usableWidth;
        carAOuter.style.left = `${posA}px`;
        carBOuter.style.left = `${posB}px`;
        // Label luôn ở giữa đầu xe
        labelA.textContent = getDisplayValue(unitASelect.value === 'km' ? distanceA : distanceA, unitASelect.value);
        labelB.textContent = getDisplayValue(unitBSelect.value === 'km' ? distanceB : distanceB, unitBSelect.value);
    }

    function convertToKm(value, unit) {
        return unit === 'km' ? value : value / 1000;
    }

    function convertToM(value, unit) {
        return unit === 'm' ? value : value * 1000;
    }

    function updateDisplay() {
        // Hiển thị giá trị theo đơn vị đã chọn
        if (unitASelect.value === 'km') {
            valueAInput.value = distanceA;
        } else {
            valueAInput.value = distanceA * 1000;
        }
        if (unitBSelect.value === 'km') {
            valueBInput.value = distanceB;
        } else {
            valueBInput.value = distanceB * 1000;
        }
        updateCarPositions();
    }

    function showMessage(text, isCorrect) {
        let icon = isCorrect
            ? '🎉'
            : '😅';
        messageEl.innerHTML = `<span style="font-size:2rem;">${icon}</span> <span>${text}</span>`;
        messageEl.className = `result-message ${isCorrect ? 'correct' : 'incorrect'} show`;
        setTimeout(() => {
            messageEl.classList.remove('show');
        }, 2500);
    }

    function checkAnswer(choice) {
        const isCorrect = (choice === 'A' && distanceA > distanceB) || 
                         (choice === 'B' && distanceB > distanceA);
        if (isCorrect) {
            showMessage('Đúng rồi! 🎉', true);
            generateNewQuestion();
        } else {
            showMessage('Chưa đúng, thử lại!', false);
        }
    }

    function generateNewQuestion() {
        // Tạo khoảng cách ngẫu nhiên
        const useKmA = Math.random() < 0.5;
        const useKmB = Math.random() < 0.5;
        if (useKmA) {
            distanceA = Math.round((Math.random() * 4 + 1) * 10) / 10; // 1.0-5.0 km
            unitASelect.value = 'km';
        } else {
            distanceA = Math.round(Math.random() * 4000 + 1000) / 1000; // 1000-5000m in km
            unitASelect.value = 'm';
        }
        if (useKmB) {
            distanceB = Math.round((Math.random() * 4 + 1) * 10) / 10; // 1.0-5.0 km
            unitBSelect.value = 'km';
        } else {
            distanceB = Math.round(Math.random() * 4000 + 1000) / 1000; // 1000-5000m in km
            unitBSelect.value = 'm';
        }
        updateDisplay();
    }

    // Sự kiện chuyển đổi đơn vị
    convertBtn.addEventListener('click', () => {
        unitASelect.value = unitASelect.value === 'km' ? 'm' : 'km';
        unitBSelect.value = unitBSelect.value === 'km' ? 'm' : 'km';
        updateDisplay();
    });
    // Sự kiện chọn xe
    chooseABtn.addEventListener('click', () => checkAnswer('A'));
    chooseBBtn.addEventListener('click', () => checkAnswer('B'));
    // Khởi tạo game
    updateDisplay();
    // Cập nhật vị trí xe khi thay đổi kích thước màn hình
    window.addEventListener('resize', updateCarPositions);
});
</script>
@endsection 