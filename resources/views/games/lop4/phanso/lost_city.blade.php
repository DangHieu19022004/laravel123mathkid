@extends('games.game')

@section('title', 'Thành Phố Bị Lạc - Phân Số Lớp 4')

@section('game_content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Thành Phố Bị Lạc</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <p class="lead">Điền số thích hợp vào chỗ trống để hoàn thiện các tên đường!</p>
                        <div id="level-display" class="mb-3">
                            <span class="badge bg-info">Cấp độ: <span id="current-level">1</span>/5</span>
                        </div>
                    </div>

                    <div id="game-container" class="mb-4">
                        <div class="row">
                            <div class="col-12">
                                <div id="city-map" class="position-relative">
                                    <!-- Streets will be added here -->
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button id="check-answer" class="btn btn-primary btn-lg">
                                Kiểm tra
                            </button>
                            <button id="next-level" class="btn btn-success btn-lg d-none">
                                Tiếp theo
                            </button>
                        </div>
                    </div>

                    <div class="progress mb-3">
                        <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('game_scripts')
<script>
    const levels = [
        {
            streets: [
                {
                    id: 1,
                    name: "Đường Phân Số",
                    description: "Một phần tư của 8 là ___",
                    answer: "2",
                    hint: "Lấy 8 chia cho 4"
                },
                {
                    id: 2,
                    name: "Phố Toán Học",
                    description: "Ba phần ___ bằng 1/2",
                    answer: "6",
                    hint: "3/6 = 1/2"
                },
                {
                    id: 3,
                    name: "Ngõ Số Học",
                    description: "___ phần năm của 15 là 9",
                    answer: "3",
                    hint: "9 = (3/5) × 15"
                }
            ]
        },
        {
            streets: [
                {
                    id: 1,
                    name: "Đường Tính Toán",
                    description: "Hai phần ___ của 18 là 6",
                    answer: "6",
                    hint: "6 = (2/6) × 18"
                },
                {
                    id: 2,
                    name: "Phố Chia Số",
                    description: "___ phần tám của 24 là 9",
                    answer: "3",
                    hint: "9 = (3/8) × 24"
                },
                {
                    id: 3,
                    name: "Ngõ Phép Tính",
                    description: "Bốn phần ___ của 15 là 12",
                    answer: "5",
                    hint: "12 = (4/5) × 15"
                }
            ]
        },
        {
            streets: [
                {
                    id: 1,
                    name: "Đường Số Học",
                    description: "___ phần sáu của 30 là 20",
                    answer: "4",
                    hint: "20 = (4/6) × 30"
                },
                {
                    id: 2,
                    name: "Phố Phân Số",
                    description: "Năm phần ___ của 24 là 15",
                    answer: "8",
                    hint: "15 = (5/8) × 24"
                },
                {
                    id: 3,
                    name: "Ngõ Toán Học",
                    description: "Ba phần ___ của 20 là 12",
                    answer: "5",
                    hint: "12 = (3/5) × 20"
                }
            ]
        },
        {
            streets: [
                {
                    id: 1,
                    name: "Đường Tính Toán",
                    description: "___ phần bảy của 28 là 16",
                    answer: "4",
                    hint: "16 = (4/7) × 28"
                },
                {
                    id: 2,
                    name: "Phố Số Học",
                    description: "Năm phần ___ của 36 là 30",
                    answer: "6",
                    hint: "30 = (5/6) × 36"
                },
                {
                    id: 3,
                    name: "Ngõ Chia Số",
                    description: "Hai phần ___ của 45 là 18",
                    answer: "5",
                    hint: "18 = (2/5) × 45"
                }
            ]
        },
        {
            streets: [
                {
                    id: 1,
                    name: "Đường Phép Tính",
                    description: "___ phần chín của 36 là 24",
                    answer: "6",
                    hint: "24 = (6/9) × 36"
                },
                {
                    id: 2,
                    name: "Phố Toán Học",
                    description: "Bảy phần ___ của 40 là 35",
                    answer: "8",
                    hint: "35 = (7/8) × 40"
                },
                {
                    id: 3,
                    name: "Ngõ Phân Số",
                    description: "Ba phần ___ của 50 là 30",
                    answer: "5",
                    hint: "30 = (3/5) × 50"
                }
            ]
        }
    ];

    let currentLevel = 1;
    let totalLevels = levels.length;

    function initializeGame() {
        currentLevel = 1;
        updateLevel();
        generateStreets();
    }

    function generateStreets() {
        const level = levels[currentLevel - 1];
        const cityMap = $('#city-map');
        cityMap.empty();

        level.streets.forEach(street => {
            const streetDiv = $(`
                <div class="street-container mb-4 p-3 border rounded">
                    <h5 class="street-name mb-3">
                        <i class="fas fa-road me-2"></i>${street.name}
                    </h5>
                    <div class="street-description mb-3">
                        ${street.description}
                    </div>
                    <div class="input-group">
                        <input type="number" class="form-control street-input" 
                            data-id="${street.id}" placeholder="Điền số">
                        <button class="btn btn-outline-secondary hint-btn" type="button"
                            data-hint="${street.hint}">
                            <i class="fas fa-lightbulb"></i>
                        </button>
                    </div>
                </div>
            `);
            cityMap.append(streetDiv);
        });

        // Add hint button handlers
        $('.hint-btn').click(function() {
            const hint = $(this).data('hint');
            Swal.fire({
                icon: 'info',
                title: 'Gợi ý',
                text: hint
            });
        });
    }

    function updateLevel() {
        $('#current-level').text(currentLevel);
        const progress = ((currentLevel - 1) / totalLevels) * 100;
        $('#progress-bar').css('width', progress + '%');
    }

    function checkAnswer() {
        const level = levels[currentLevel - 1];
        let allCorrect = true;
        let answers = [];

        $('.street-input').each(function() {
            const id = $(this).data('id');
            const value = $(this).val();
            const street = level.streets.find(s => s.id === id);
            
            answers.push({
                id: id,
                input: value,
                correct: street.answer === value
            });

            if (street.answer !== value) {
                allCorrect = false;
            }
        });

        if (allCorrect) {
            Swal.fire({
                icon: 'success',
                title: 'Chính xác!',
                text: 'Bạn đã tìm đúng tất cả các con số!'
            }).then(() => {
                if (currentLevel < totalLevels) {
                    $('#check-answer').addClass('d-none');
                    $('#next-level').removeClass('d-none');
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Chúc mừng!',
                        text: 'Bạn đã hoàn thành tất cả các cấp độ!',
                        confirmButtonText: 'Chơi lại'
                    }).then(() => {
                        initializeGame();
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Chưa đúng!',
                text: 'Hãy thử lại nhé!'
            });
        }
    }

    $(document).ready(function() {
        // Add custom styles
        $('<style>')
            .text(`
                .street-container {
                    background-color: #f8f9fa;
                    transition: all 0.3s ease;
                }
                .street-container:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                }
                .street-name {
                    color: #2196f3;
                }
                .hint-btn:hover {
                    background-color: #e3f2fd;
                }
            `)
            .appendTo('head');

        initializeGame();

        $('#check-answer').click(checkAnswer);

        $('#next-level').click(function() {
            currentLevel++;
            updateLevel();
            generateStreets();
            $(this).addClass('d-none');
            $('#check-answer').removeClass('d-none');
        });

        // Handle enter key
        $(document).on('keypress', '.street-input', function(e) {
            if(e.which == 13) {
                checkAnswer();
            }
        });
    });
</script>
@endsection 