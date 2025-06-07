@extends('games.game')

@section('title', 'Sếp Lớp Đểu Bằng - Phân Số Lớp 4')

@section('game_content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Sếp Lớp Đểu Bằng</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <p class="lead">Kéo các phân số vào nhóm tương ứng!</p>
                        <div id="level-display" class="mb-3">
                            <span class="badge bg-info">Cấp độ: <span id="current-level">1</span>/5</span>
                        </div>
                    </div>

                    <div id="game-container" class="mb-4">
                        <div class="row mb-4">
                            <div class="col-12">
                                <div id="fraction-groups" class="d-flex justify-content-around mb-4">
                                    <!-- Group containers will be added here -->
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <div id="fraction-cards" class="d-flex flex-wrap justify-content-center">
                                    <!-- Fraction cards will be added here -->
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
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
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    const levels = [
        {
            groups: [
                { id: 1, value: "1/2", name: "Nhóm 1/2" },
                { id: 2, value: "1/3", name: "Nhóm 1/3" }
            ],
            fractions: [
                { id: 1, text: "2/4", group: 1 },
                { id: 2, text: "3/6", group: 1 },
                { id: 3, text: "4/8", group: 1 },
                { id: 4, text: "2/6", group: 2 },
                { id: 5, text: "3/9", group: 2 },
                { id: 6, text: "4/12", group: 2 }
            ]
        },
        {
            groups: [
                { id: 1, value: "2/3", name: "Nhóm 2/3" },
                { id: 2, value: "3/4", name: "Nhóm 3/4" }
            ],
            fractions: [
                { id: 1, text: "4/6", group: 1 },
                { id: 2, text: "6/9", group: 1 },
                { id: 3, text: "8/12", group: 1 },
                { id: 4, text: "6/8", group: 2 },
                { id: 5, text: "9/12", group: 2 },
                { id: 6, text: "12/16", group: 2 }
            ]
        },
        {
            groups: [
                { id: 1, value: "1/4", name: "Nhóm 1/4" },
                { id: 2, value: "3/4", name: "Nhóm 3/4" }
            ],
            fractions: [
                { id: 1, text: "2/8", group: 1 },
                { id: 2, text: "3/12", group: 1 },
                { id: 3, text: "4/16", group: 1 },
                { id: 4, text: "6/8", group: 2 },
                { id: 5, text: "9/12", group: 2 },
                { id: 6, text: "12/16", group: 2 }
            ]
        },
        {
            groups: [
                { id: 1, value: "2/5", name: "Nhóm 2/5" },
                { id: 2, value: "3/5", name: "Nhóm 3/5" }
            ],
            fractions: [
                { id: 1, text: "4/10", group: 1 },
                { id: 2, text: "6/15", group: 1 },
                { id: 3, text: "8/20", group: 1 },
                { id: 4, text: "6/10", group: 2 },
                { id: 5, text: "9/15", group: 2 },
                { id: 6, text: "12/20", group: 2 }
            ]
        },
        {
            groups: [
                { id: 1, value: "5/6", name: "Nhóm 5/6" },
                { id: 2, value: "2/3", name: "Nhóm 2/3" }
            ],
            fractions: [
                { id: 1, text: "10/12", group: 1 },
                { id: 2, text: "15/18", group: 1 },
                { id: 3, text: "20/24", group: 1 },
                { id: 4, text: "8/12", group: 2 },
                { id: 5, text: "12/18", group: 2 },
                { id: 6, text: "16/24", group: 2 }
            ]
        }
    ];

    let currentLevel = 1;
    let totalLevels = levels.length;
    let sortables = [];

    function initializeGame() {
        currentLevel = 1;
        updateLevel();
        generateLevel();
    }

    function generateLevel() {
        const level = levels[currentLevel - 1];
        
        // Clear previous sortables
        sortables.forEach(sortable => sortable.destroy());
        sortables = [];

        // Generate groups
        const groupsContainer = $('#fraction-groups');
        groupsContainer.empty();

        level.groups.forEach(group => {
            const groupDiv = $(`
                <div class="group-container" data-group-id="${group.id}">
                    <h5 class="text-center mb-3">${group.name}</h5>
                    <div class="fraction-group p-3 border rounded min-height-100" 
                        data-group-id="${group.id}">
                    </div>
                </div>
            `);
            groupsContainer.append(groupDiv);
        });

        // Generate fraction cards
        const cardsContainer = $('#fraction-cards');
        cardsContainer.empty();

        // Shuffle fractions
        const shuffledFractions = [...level.fractions].sort(() => Math.random() - 0.5);

        shuffledFractions.forEach(fraction => {
            const cardDiv = $(`
                <div class="fraction-card m-2 p-3 border rounded text-center" 
                    data-id="${fraction.id}" 
                    data-group="${fraction.group}">
                    ${fraction.text}
                </div>
            `);
            cardsContainer.append(cardDiv);
        });

        // Initialize Sortable
        const cardsSort = new Sortable(cardsContainer[0], {
            group: 'shared',
            animation: 150,
            ghostClass: 'fraction-card-ghost'
        });
        sortables.push(cardsSort);

        $('.fraction-group').each(function() {
            const groupSort = new Sortable(this, {
                group: 'shared',
                animation: 150,
                ghostClass: 'fraction-card-ghost'
            });
            sortables.push(groupSort);
        });
    }

    function updateLevel() {
        $('#current-level').text(currentLevel);
        const progress = ((currentLevel - 1) / totalLevels) * 100;
        $('#progress-bar').css('width', progress + '%');
    }

    function checkAnswer() {
        const level = levels[currentLevel - 1];
        let isCorrect = true;

        $('.fraction-group').each(function() {
            const groupId = $(this).data('group-id');
            const cards = $(this).find('.fraction-card');
            
            cards.each(function() {
                const cardId = $(this).data('id');
                const correctGroup = level.fractions.find(f => f.id === cardId).group;
                
                if (correctGroup !== groupId) {
                    isCorrect = false;
                    return false;
                }
            });
        });

        if (isCorrect) {
            Swal.fire({
                icon: 'success',
                title: 'Chính xác!',
                text: 'Bạn đã phân nhóm đúng tất cả các phân số!'
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
                .fraction-group {
                    min-height: 100px;
                    background-color: #f8f9fa;
                    margin: 0 10px;
                }
                .fraction-card {
                    display: inline-block;
                    background-color: white;
                    cursor: move;
                    user-select: none;
                    min-width: 80px;
                    transition: transform 0.2s;
                }
                .fraction-card:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }
                .fraction-card-ghost {
                    opacity: 0.5;
                    background-color: #e3f2fd;
                }
                .group-container {
                    flex: 1;
                    margin: 0 10px;
                }
            `)
            .appendTo('head');

        initializeGame();

        $('#check-answer').click(checkAnswer);

        $('#next-level').click(function() {
            currentLevel++;
            updateLevel();
            generateLevel();
            $(this).addClass('d-none');
            $('#check-answer').removeClass('d-none');
        });
    });
</script>
@endsection 