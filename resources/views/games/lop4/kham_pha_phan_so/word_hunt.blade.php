@extends('layouts.app')

@section('content')
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
                            <span class="badge bg-info">Cấp độ: <span id="current-level">{{ $question['level'] }}</span>/5</span>
                        </div>
                    </div>

                    <div id="game-container" class="mb-4">
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <strong>Gợi ý:</strong> <span id="hint-text">{{ $question['hint'] }}</span>
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
                        <div id="progress-bar" class="progress-bar" role="progressbar" style="width: {{ ($question['level'] - 1) * 20 }}%"></div>
                    </div>

                    <!-- Controls -->
                    <div class="text-center mt-4">
                        <form id="resetForm" action="{{ route('games.lop4.phanso.word_hunt.reset') }}" method="POST" class="mt-3">
                            @csrf
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

@push('scripts')
<script>
    const currentLevel = {{ $question['level'] }};
    const totalLevels = 5;
    let selectedObjects = new Set();

    function generateScene() {
        const sceneContainer = $('#scene-container');
        sceneContainer.empty();

        // Create grid layout
        const grid = $('<div class="row g-3"></div>');
        
        // Generate objects for the current level
        const objects = [
            @foreach($question['options'] as $index => $option)
            {
                id: {{ $index + 1 }},
                text: "{{ $option }}",
                correct: true
            }@if(!$loop->last),@endif
            @endforeach
        ];

        // Add some incorrect options that are not equal to the target
        const incorrectOptions = [
            @foreach(['3/4', '5/6', '7/8', '9/10'] as $index => $option)
            {
                id: {{ count($question['options']) + $index + 1 }},
                text: "{{ $option }}",
                correct: false
            }@if(!$loop->last),@endif
            @endforeach
        ];

        objects.push(...incorrectOptions);

        // Shuffle the objects array
        for (let i = objects.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [objects[i], objects[j]] = [objects[j], objects[i]];
        }
        
        objects.forEach(obj => {
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

    function checkAnswer() {
        const selectedFractions = Array.from(document.querySelectorAll('.object-card.selected')).map(card => card.querySelector('h4').textContent);

        fetch('{{ route("games.lop4.phanso.word_hunt.check") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                selected_fractions: selectedFractions
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.correct) {
                Swal.fire({
                    icon: 'success',
                    title: 'Chính xác!',
                    text: 'Bạn đã tìm đúng tất cả các phân số!'
                }).then(() => {
                    if (data.next_level) {
                        window.location.reload();
                    }
                });

                if (typeof confetti !== 'undefined') {
                    confetti({
                        particleCount: 150,
                        spread: 70,
                        origin: { y: 0.6 }
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Chưa đúng!',
                    text: 'Hãy thử lại nhé!'
                });
            }
        });
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

        generateScene();

        $('#check-answer').click(checkAnswer);
    });
</script>
@endpush

@push('styles')
<style>
.progress {
    height: 10px;
}
.progress-bar {
    transition: width 0.3s ease;
}
</style>
@endpush
@endsection 