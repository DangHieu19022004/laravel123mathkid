@extends('layouts.game')

@section('title', 'Nhóm Phân Số Bằng Nhau - Phân Số Lớp 4')

@section('game_content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Nhóm Phân Số Bằng Nhau</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <p class="lead">Kéo các phân số vào nhóm tương ứng để tạo thành các nhóm phân số bằng nhau!</p>
                        <div id="level-display" class="mb-3">
                            <span class="badge bg-info">Cấp độ: <span id="current-level">{{ session('equal_groups_level', 1) }}</span>/5</span>
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
                        <div id="progress-bar" class="progress-bar" role="progressbar" 
                             style="width: {{ (session('equal_groups_level', 1) - 1) * 20 }}%"></div>
                    </div>

                    <!-- Controls -->
                    <div class="text-center mt-4">
                        <form action="{{ route('games.lop4.phanso.equal_groups.reset') }}" method="GET" class="d-inline">
                            <button type="submit" class="btn btn-link text-decoration-none">
                                Chơi lại từ đầu
                            </button>
                        </form>

                        <a href="{{ route('games.lop4.phanso') }}" class="btn btn-link text-decoration-none">
                            ← Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    const levels = [
        // Cấp 1: Cơ bản - Phân số đơn giản 1/2 và 1/3
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
        // Cấp 2: Phân số với mẫu số lớn hơn
        {
            groups: [
                { id: 1, value: "3/4", name: "Nhóm 3/4" },
                { id: 2, value: "2/3", name: "Nhóm 2/3" },
                { id: 3, value: "1/2", name: "Nhóm 1/2" }
            ],
            fractions: [
                { id: 1, text: "6/8", group: 1 },
                { id: 2, text: "9/12", group: 1 },
                { id: 3, text: "4/6", group: 2 },
                { id: 4, text: "8/12", group: 2 },
                { id: 5, text: "3/6", group: 3 },
                { id: 6, text: "4/8", group: 3 },
                { id: 7, text: "5/10", group: 3 }
            ]
        },
        // Cấp 3: Ba nhóm với phân số phức tạp hơn
        {
            groups: [
                { id: 1, value: "5/6", name: "Nhóm 5/6" },
                { id: 2, value: "3/4", name: "Nhóm 3/4" },
                { id: 3, value: "2/3", name: "Nhóm 2/3" }
            ],
            fractions: [
                { id: 1, text: "10/12", group: 1 },
                { id: 2, text: "15/18", group: 1 },
                { id: 3, text: "9/12", group: 2 },
                { id: 4, text: "12/16", group: 2 },
                { id: 5, text: "8/12", group: 3 },
                { id: 6, text: "10/15", group: 3 },
                { id: 7, text: "14/21", group: 3 },
                { id: 8, text: "16/24", group: 3 }
            ]
        },
        // Cấp 4: Phân số với tử số lớn
        {
            groups: [
                { id: 1, value: "7/8", name: "Nhóm 7/8" },
                { id: 2, value: "5/6", name: "Nhóm 5/6" },
                { id: 3, value: "4/5", name: "Nhóm 4/5" }
            ],
            fractions: [
                { id: 1, text: "14/16", group: 1 },
                { id: 2, text: "21/24", group: 1 },
                { id: 3, text: "28/32", group: 1 },
                { id: 4, text: "15/18", group: 2 },
                { id: 5, text: "20/24", group: 2 },
                { id: 6, text: "25/30", group: 2 },
                { id: 7, text: "12/15", group: 3 },
                { id: 8, text: "16/20", group: 3 },
                { id: 9, text: "24/30", group: 3 }
            ]
        },
        // Cấp 5: Thử thách - Phân số phức tạp và nhiều nhóm
        {
            groups: [
                { id: 1, value: "5/8", name: "Nhóm 5/8" },
                { id: 2, value: "3/4", name: "Nhóm 3/4" },
                { id: 3, value: "7/12", name: "Nhóm 7/12" },
                { id: 4, value: "2/3", name: "Nhóm 2/3" }
            ],
            fractions: [
                { id: 1, text: "10/16", group: 1 },
                { id: 2, text: "15/24", group: 1 },
                { id: 3, text: "20/32", group: 1 },
                { id: 4, text: "9/12", group: 2 },
                { id: 5, text: "12/16", group: 2 },
                { id: 6, text: "15/20", group: 2 },
                { id: 7, text: "14/24", group: 3 },
                { id: 8, text: "21/36", group: 3 },
                { id: 9, text: "28/48", group: 3 },
                { id: 10, text: "8/12", group: 4 },
                { id: 11, text: "10/15", group: 4 },
                { id: 12, text: "14/21", group: 4 }
            ]
        }
    ];

    let currentLevel = {{ session('equal_groups_level', 1) }};
    let totalLevels = levels.length;
    let sortables = [];

    function initializeGame() {
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

        // Check if all cards have been sorted into groups
        const unplacedCards = $('#fraction-cards .fraction-card');
        if (unplacedCards.length > 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Chưa hoàn thành!',
                text: 'Vui lòng phân loại tất cả các phân số vào nhóm!'
            });
            return;
        }

        // Check each group
        $('.fraction-group').each(function() {
            const groupId = $(this).data('group-id');
            const cards = $(this).find('.fraction-card');
            
            // Check if group has correct number of cards
            const expectedCards = level.fractions.filter(f => f.group === groupId);
            if (cards.length !== expectedCards.length) {
                isCorrect = false;
                return false;
            }
            
            // Check if each card is in correct group
            cards.each(function() {
                const cardId = parseInt($(this).data('id'));
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
                        window.location.href = '{{ route("games.lop4.phanso.equal_groups.reset") }}';
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Chưa đúng!',
                text: 'Hãy kiểm tra lại các phân số trong từng nhóm!'
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
                .min-height-100 {
                    min-height: 100px;
                }
            `)
            .appendTo('head');

        initializeGame();

        $('#check-answer').click(checkAnswer);

        $('#next-level').click(function() {
            console.log('Current level before next:', currentLevel);
            
            if (currentLevel < totalLevels) {
                currentLevel++;
                console.log('Moving to level:', currentLevel);
                
                // Lưu level mới vào session thông qua AJAX
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                $.ajax({
                    url: '{{ route("games.lop4.phanso.equal_groups.check") }}',
                    method: 'POST',
                    data: {
                        level: currentLevel - 1  // Gửi level hiện tại
                    }
                });
                
                // Cập nhật UI ngay lập tức không cần đợi response
                updateLevel();
                generateLevel();
                $('#next-level').addClass('d-none');
                $('#check-answer').removeClass('d-none');
                
                // Hiển thị thông báo chuyển cấp
                Swal.fire({
                    icon: 'success',
                    title: 'Chuyển cấp!',
                    text: 'Chào mừng bạn đến với cấp độ ' + currentLevel,
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                // Đã hoàn thành tất cả các cấp
                Swal.fire({
                    icon: 'success',
                    title: 'Chúc mừng!',
                    text: 'Bạn đã hoàn thành tất cả các cấp độ!',
                    confirmButtonText: 'Chơi lại'
                }).then(() => {
                    window.location.href = '{{ route("games.lop4.phanso.equal_groups.reset") }}';
                });
            }
        });
    });
</script>
@endsection 