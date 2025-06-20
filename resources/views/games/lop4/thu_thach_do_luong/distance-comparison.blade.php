@extends('layouts.game')

@push('styles')
    <style>
        body {
            background: linear-gradient(135deg, #e3f2fd 0%, #fceabb 100%);
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
        }

        .distance-bg {
            background: linear-gradient(135deg, #e3f2fd 0%, #fceabb 100%);
            min-height: 100vh;
            min-width: 100vw;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding-top: 32px;
            padding-bottom: 32px;
        }

        .distance-card {
            width: 100%;
            max-width: 540px;
            background: #fff;
            border-radius: 2rem;
            box-shadow: 0 8px 32px 0 rgba(33, 150, 243, 0.10);
            padding: 2.5rem 1.5rem 2rem 1.5rem;
            margin-bottom: 2.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .distance-title {
            font-size: 2.2rem;
            font-weight: 900;
            color: #2563eb;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
            display: flex;
            align-items: center;
            gap: 0.5em;
        }

        .distance-desc {
            font-size: 1.15rem;
            color: #374151;
            margin-bottom: 1.2rem;
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
        }

        .level-label {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1976d2;
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
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

        .track-container {
            position: relative;
            height: 220px;
            background: #f3f4f6;
            border-radius: 1.5rem;
            overflow: visible;
            box-shadow: 0 4px 24px #60a5fa22;
            width: 100%;
            max-width: 440px;
            margin-left: auto;
            margin-right: auto;
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

        .vehicle.red-car svg path {
            fill: #ef4444;
        }

        .vehicle.blue-car svg path {
            fill: #3b82f6;
        }

        .control-card {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 4px 24px #60a5fa22;
            padding: 2rem 1.2rem 1.5rem 1.2rem;
            width: 100%;
            max-width: 440px;
            margin-left: auto;
            margin-right: auto;
        }

        .control-label {
            font-size: 1.1rem;
            font-weight: 700;
            color: #f59e42;
            margin-bottom: 0.5rem;
            font-family: 'Segoe UI Rounded', 'Segoe UI', Arial, sans-serif;
        }

        .input-group {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.2rem;
        }

        .input-group input[type=number] {
            width: 80px;
            padding: 0.7rem 0.5rem;
            border-radius: 0.8rem;
            border: 2px solid #e0e7ef;
            text-align: center;
            font-size: 1.1rem;
            font-weight: 700;
            background: #f9fafb;
            color: #2563eb;
        }

        .input-group select {
            padding: 0.7rem 1.2rem;
            border-radius: 0.8rem;
            border: 2px solid #e0e7ef;
            font-size: 1.1rem;
            font-weight: 700;
            background: #f9fafb;
            color: #f59e42;
        }

        .choose-label {
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 0.7rem;
            color: #2563eb;
        }

        .choose-btn {
            min-width: 120px;
            padding: 0.9rem 2rem;
            font-size: 1.15rem;
            font-weight: 700;
            border-radius: 1.5rem;
            background: linear-gradient(90deg, #38bdf8 60%, #4ade80 100%);
            color: #fff;
            box-shadow: 0 4px 16px #38bdf822;
            border: none;
            outline: none;
            margin: 0 0.5rem;
            transition: all 0.18s cubic-bezier(.4, 2, .55, .44);
            cursor: pointer;
        }

        .choose-btn:hover, .choose-btn:focus {
            background: linear-gradient(90deg, #4ade80 60%, #38bdf8 100%);
            transform: scale(1.08) translateY(-2px);
            box-shadow: 0 8px 24px #4ade8033;
        }

        .convert-btn {
            background: linear-gradient(90deg, #fbbf24 60%, #f472b6 100%);
            color: #fff;
            box-shadow: 0 4px 16px #fbbf2422;
            border-radius: 1.5rem;
            font-weight: 700;
            font-size: 1.1rem;
            padding: 0.7rem 2rem;
            border: none;
            outline: none;
            margin-bottom: 1.2rem;
            transition: all 0.18s cubic-bezier(.4, 2, .55, .44);
            cursor: pointer;
        }

        .convert-btn:hover, .convert-btn:focus {
            background: linear-gradient(90deg, #f472b6 60%, #fbbf24 100%);
            transform: scale(1.08) translateY(-2px);
            box-shadow: 0 8px 24px #f472b633;
        }

        @media (max-width: 640px) {
            .distance-card, .control-card, .track-container {
                max-width: 98vw;
                padding: 1.2rem 0.5rem;
            }

            .track-container {
                height: 120px;
            }

            .vehicle {
                width: 44px;
                height: 32px;
            }

            .car-label {
                font-size: 0.95rem;
                padding: 4px 10px;
                top: -22px;
            }

            .input-group input[type=number] {
                width: 54px;
                font-size: 1rem;
            }

            .input-group select {
                font-size: 1rem;
                padding: 0.5rem 0.7rem;
            }

            .choose-btn, .convert-btn {
                font-size: 1rem;
                padding: 0.7rem 1.2rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="distance-bg">
        <div class="distance-card">
            <div class="distance-title">So Sánh Quãng Đường <span>🏎️</span></div>
            <div class="distance-desc">So sánh quãng đường của hai xe và chọn xe đi xa hơn</div>
            <div class="level-label" id="level-indicator"></div>
            <div class="level-bar mb-4">
                <div class="level-bar-inner" id="progress-bar-inner"></div>
            </div>
            <div class="track-container">
                <div class="track-lines flex flex-col justify-around h-full">
                    <div class="border-t-2 border-dashed border-gray-300 w-full"></div>
                    <div class="border-t-2 border-dashed border-gray-300 w-full"></div>
                    <div class="border-t-2 border-dashed border-gray-300 w-full"></div>
                    <div class="border-t-2 border-dashed border-gray-300 w-full"></div>
                </div>
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
            <div class="control-card">
                <div class="grid grid-cols-2 gap-8 mb-4">
                    <div>
                        <div class="control-label">Xe A</div>
                        <div class="input-group">
                            <input type="number" id="value-a" readonly>
                            <select id="unit-a">
                                <option value="km">km</option>
                                <option value="m">m</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <div class="control-label">Xe B</div>
                        <div class="input-group">
                            <input type="number" id="value-b" readonly>
                            <select id="unit-b">
                                <option value="m">m</option>
                                <option value="km">km</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-center mb-4">
                    <button id="convert" class="convert-btn">Chuyển đổi đơn vị</button>
                </div>
                <div class="text-center">
                    <div class="choose-label mb-2">Xe nào đi xa hơn?</div>
                    <button id="choose-a" class="choose-btn">Xe A</button>
                    <button id="choose-b" class="choose-btn">Xe B</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/js/sweetalert2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const questions = @json($questions);
            let level = 1;
            const maxLevel = questions.length;

            // DOM
            const carAOuter = document.getElementById('car-a-outer');
            const carBOuter = document.getElementById('car-b-outer');
            const labelA = document.getElementById('label-a');
            const labelB = document.getElementById('label-b');
            const valueAInput = document.getElementById('value-a');
            const valueBInput = document.getElementById('value-b');
            const unitASelect = document.getElementById('unit-a');
            const unitBSelect = document.getElementById('unit-b');
            const convertBtn = document.getElementById('convert');
            const chooseABtn = document.getElementById('choose-a');
            const chooseBBtn = document.getElementById('choose-b');
            const progressBarInner = document.getElementById('progress-bar-inner');
            const levelIndicator = document.getElementById('level-indicator');

            let distanceA = 0;
            let distanceB = 0;
            let unitA = 'km';
            let unitB = 'km';

            function getDisplayValue(distance, unit) {
                return unit === 'km' ? distance + ' km' : (distance * 1000) + ' m';
            }

            function convertToKm(value, unit) {
                return unit === 'km' ? value : value / 1000;
            }

            function updateCarPositions() {
                const track = document.querySelector('.track-container');
                const trackWidth = track.offsetWidth;
                const carWidth = 80;
                const padding = 24;
                const usableWidth = trackWidth - carWidth - padding * 2;
                const maxDistance = Math.max(convertToKm(distanceA, unitA), convertToKm(distanceB, unitB));
                const posA = padding + (convertToKm(distanceA, unitA) / maxDistance) * usableWidth;
                const posB = padding + (convertToKm(distanceB, unitB) / maxDistance) * usableWidth;
                carAOuter.style.left = `${posA}px`;
                carBOuter.style.left = `${posB}px`;
                labelA.textContent = getDisplayValue(distanceA, unitA);
                labelB.textContent = getDisplayValue(distanceB, unitB);
            }

            function updateDisplay() {
                if (unitA === 'km') {
                    valueAInput.value = distanceA;
                } else {
                    valueAInput.value = distanceA * 1000;
                }
                if (unitB === 'km') {
                    valueBInput.value = distanceB;
                } else {
                    valueBInput.value = distanceB * 1000;
                }
                updateCarPositions();
            }

            function showFeedback(isCorrect, isComplete = false) {
                if (isComplete) {
                    Swal.fire({
                        title: '🎉 Hoàn thành!',
                        text: 'Bạn đã hoàn thành tất cả câu hỏi! Rất xuất sắc!',
                        icon: 'success',
                        confirmButtonText: 'Chơi lại',
                        customClass: {popup: 'swal2-popup swal2-rounded'},
                    }).then(() => {
                        level = 1;
                        loadQuestion();
                    });
                } else if (isCorrect) {
                    Swal.fire({
                        title: 'Chính xác!',
                        text: 'Bạn đã chọn đúng xe đi xa hơn!',
                        icon: 'success',
                        timer: 1200,
                        showConfirmButton: false,
                        customClass: {popup: 'swal2-popup swal2-rounded'}
                    });
                } else {
                    Swal.fire({
                        title: 'Chưa đúng!',
                        text: 'Hãy thử lại nhé!',
                        icon: 'error',
                        timer: 1200,
                        showConfirmButton: false,
                        customClass: {popup: 'swal2-popup swal2-rounded'}
                    });
                }
            }

            function checkAnswer(choice) {
                const aKm = convertToKm(distanceA, unitA);
                const bKm = convertToKm(distanceB, unitB);
                const isCorrect = (choice === 'A' && aKm > bKm) || (choice === 'B' && bKm > aKm);
                if (isCorrect) {
                    if (level < maxLevel) {
                        showFeedback(true);
                        setTimeout(() => {
                            level++;
                            loadQuestion();
                        }, 1200);
                    } else {
                        showFeedback(true, true);
                    }
                } else {
                    showFeedback(false);
                }
            }

            function loadQuestion() {
                const q = questions[level - 1];
                distanceA = q.distances[0].unit === 'km' ? q.distances[0].value : q.distances[0].value / 1000;
                unitA = q.distances[0].unit;
                distanceB = q.distances[1].unit === 'km' ? q.distances[1].value : q.distances[1].value / 1000;
                unitB = q.distances[1].unit;
                unitASelect.value = unitA;
                unitBSelect.value = unitB;
                updateDisplay();
                // Progress bar & level
                progressBarInner.style.width = ((level - 1) / (maxLevel - 1) * 100) + '%';
                levelIndicator.textContent = `Câu ${level} / ${maxLevel}`;
            }

            // Sự kiện chuyển đổi đơn vị
            convertBtn.addEventListener('click', () => {
                unitA = unitA === 'km' ? 'm' : 'km';
                unitB = unitB === 'km' ? 'm' : 'km';
                unitASelect.value = unitA;
                unitBSelect.value = unitB;
                updateDisplay();
            });
            chooseABtn.addEventListener('click', () => checkAnswer('A'));
            chooseBBtn.addEventListener('click', () => checkAnswer('B'));
            loadQuestion();
            window.addEventListener('resize', updateCarPositions);
        });
    </script>
@endpush
