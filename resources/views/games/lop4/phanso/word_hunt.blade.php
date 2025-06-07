@extends('games.game')

@section('title', 'Săn Cụm Từ Phân Số - Phân Số Lớp 4')

@section('game_content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Săn Cụm Từ Phân Số</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <p class="lead">Tìm các đối tượng thỏa mãn gợi ý!</p>
                        <div id="level-display" class="mb-3">
                            <span class="badge bg-info">Cấp độ: <span id="current-level">1</span>/5</span>
                        </div>
                    </div>

                    <div id="game-container" class="mb-4">
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <strong>Gợi ý:</strong> <span id="hint-text"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <div id="scene-container" class="position-relative text-center">
                                    <!-- Scene objects will be added here -->
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
            hint: "Tìm các phân số bằng 1/2",
            objects: [
                { id: 1, text: "2/4", correct: true },
                { id: 2, text: "3/4", correct: false },
                { id: 3, text: "3/6", correct: true },
                { id: 4, text: "4/6", correct: false },
                { id: 5, text: "5/10", correct: true },
                { id: 6, text: "6/10", correct: false }
            ]
        },
        {
            hint: "Tìm các phân số bằng 2/3",
            objects: [
                { id: 1, text: "4/6", correct: true },
                { id: 2, text: "3/6", correct: false },
                { id: 3, text: "6/9", correct: true },
                { id: 4, text: "5/9", correct: false },
                { id: 5, text: "8/12", correct: true },
                { id: 6, text: "7/12", correct: false }
            ]
        },
        {
            hint: "Tìm các phân số bằng 3/4",
            objects: [
                { id: 1, text: "6/8", correct: true },
                { id: 2, text: "5/8", correct: false },
                { id: 3, text: "9/12", correct: true },
                { id: 4, text: "8/12", correct: false },
                { id: 5, text: "12/16", correct: true },
                { id: 6, text: "11/16", correct: false }
            ]
        },
        {
            hint: "Tìm các phân số bằng 1/3",
            objects: [
                { id: 1, text: "2/6", correct: true },
                { id: 2, text: "3/6", correct: false },
                { id: 3, text: "3/9", correct: true },
                { id: 4, text: "4/9", correct: false },
                { id: 5, text: "4/12", correct: true },
                { id: 6, text: "5/12", correct: false }
            ]
        },
        {
            hint: "Tìm các phân số bằng 2/5",
            objects: [
                { id: 1, text: "4/10", correct: true },
                { id: 2, text: "5/10", correct: false },
                { id: 3, text: "6/15", correct: true },
                { id: 4, text: "7/15", correct: false },
                { id: 5, text: "8/20", correct: true },
                { id: 6, text: "9/20", correct: false }
            ]
        }
    ];

    let currentLevel = 1;
    let totalLevels = levels.length;
    let selectedObjects = new Set();

    function initializeGame() {
        currentLevel = 1;
        selectedObjects.clear();
        updateLevel();
        generateScene();
    }

    function generateScene() {
        const level = levels[currentLevel - 1];
        $('#hint-text').text(level.hint);
        
        const sceneContainer = $('#scene-container');
        sceneContainer.empty();

        // Create grid layout
        const grid = $('<div class="row g-3"></div>');
        
        level.objects.forEach(obj => {
            const objectDiv = $(`
                <div class="col-md-4">
                    <div class="card object-card" data-id="${obj.id}" data-correct="${obj.correct}">
                        <div class="card-body text-center">
                            <h4 class="mb-0">${obj.text}</h4>
                        </div>
                    </div>
                </div>
            `);
            grid.append(objectDiv);
        });

        sceneContainer.append(grid);

        // Add click handlers
        $('.object-card').click(function() {
            $(this).toggleClass('selected');
            const id = $(this).data('id');
            if (selectedObjects.has(id)) {
                selectedObjects.delete(id);
            } else {
                selectedObjects.add(id);
            }
        });
    }

    function updateLevel() {
        $('#current-level').text(currentLevel);
        const progress = ((currentLevel - 1) / totalLevels) * 100;
        $('#progress-bar').css('width', progress + '%');
    }

    function checkAnswer() {
        const level = levels[currentLevel - 1];
        const correctObjects = level.objects.filter(obj => obj.correct).map(obj => obj.id);
        const selectedArray = Array.from(selectedObjects);

        // Check if selected objects match correct objects
        const isCorrect = correctObjects.length === selectedArray.length &&
            correctObjects.every(id => selectedArray.includes(id));

        if (isCorrect) {
            Swal.fire({
                icon: 'success',
                title: 'Chính xác!',
                text: 'Bạn đã tìm đúng tất cả các phân số!'
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
                .object-card {
                    cursor: pointer;
                    transition: all 0.3s ease;
                }
                .object-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                }
                .object-card.selected {
                    background-color: #e3f2fd;
                    border-color: #2196f3;
                }
            `)
            .appendTo('head');

        initializeGame();

        $('#check-answer').click(checkAnswer);

        $('#next-level').click(function() {
            currentLevel++;
            selectedObjects.clear();
            updateLevel();
            generateScene();
            $(this).addClass('d-none');
            $('#check-answer').removeClass('d-none');
        });
    });
</script>
@endsection 