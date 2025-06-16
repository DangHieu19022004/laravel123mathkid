@extends('layouts.game')

@section('title', 'Bài Toán Có Lời Văn')

@section('game_content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Cấp độ {{ $question['level'] }}</h3>
                </div>
                <div class="card-body">
                    <!-- Story Section -->
                    <div class="story-section mb-4">
                        <div class="bg-light p-4 rounded shadow-sm">
                            <p class="h5 mb-0">{{ $question['story'] }}</p>
                        </div>
                    </div>

                    <!-- Input Form -->
                    <form id="answer-form" class="mb-4">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <label class="form-label">Nhập câu trả lời của bạn:</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="numerator" placeholder="Tử số" min="0" required>
                                    <div class="input-group-text">/</div>
                                    <input type="number" class="form-control" id="denominator" placeholder="Mẫu số" min="1" required>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-check"></i> Kiểm tra
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Visualization Section -->
                    <div class="visualization-section mb-4">
                        <div class="text-center">
                            <canvas id="visualCanvas" width="300" height="200"></canvas>
                        </div>
                    </div>

                    <!-- Hints Section -->
                    <div class="hints-section mb-4">
                        <div class="accordion" id="hintsAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#hint1">
                                        <i class="fas fa-lightbulb"></i> Gợi ý 1
                                    </button>
                                </h2>
                                <div id="hint1" class="accordion-collapse collapse" data-bs-parent="#hintsAccordion">
                                    <div class="accordion-body">
                                        Đọc kỹ đề bài và xác định các số liệu quan trọng.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#hint2">
                                        <i class="fas fa-lightbulb"></i> Gợi ý 2
                                    </button>
                                </h2>
                                <div id="hint2" class="accordion-collapse collapse" data-bs-parent="#hintsAccordion">
                                    <div class="accordion-body">
                                        Vẽ sơ đồ hoặc hình vẽ để minh họa bài toán.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Feedback Message -->
                    <div id="feedback" class="alert d-none"></div>

                    <!-- Navigation Buttons -->
                    <div class="text-center mt-4">
                        <a href="{{ route('games.lop4.phanso.word_problem.reset') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Chơi lại
                        </a>
                        <a href="{{ route('games.lop4.phanso') }}" class="btn btn-primary">
                            <i class="fas fa-home"></i> Về trang chính
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('answer-form');
    const numeratorInput = document.getElementById('numerator');
    const denominatorInput = document.getElementById('denominator');
    const feedback = document.getElementById('feedback');
    const canvas = document.getElementById('visualCanvas');
    const ctx = canvas.getContext('2d');
    let isAnswered = false;

    // Draw initial visualization
    function drawVisualization() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.strokeStyle = '#666';
        ctx.lineWidth = 2;

        // Draw based on problem type (can be customized based on the story)
        const story = '{{ $question["story"] }}';
        if (story.includes('pizza') || story.includes('bánh')) {
            drawCircle();
        } else if (story.includes('chocolate') || story.includes('thanh')) {
            drawRectangle();
        } else {
            drawGenericContainer();
        }
    }

    function drawCircle() {
        ctx.beginPath();
        ctx.arc(150, 100, 80, 0, 2 * Math.PI);
        ctx.stroke();
        // Draw divisions based on denominator
        const totalParts = {{ $question['denominator'] }};
        for (let i = 0; i < totalParts; i++) {
            ctx.beginPath();
            ctx.moveTo(150, 100);
            ctx.lineTo(
                150 + 80 * Math.cos(2 * Math.PI * i / totalParts),
                100 + 80 * Math.sin(2 * Math.PI * i / totalParts)
            );
            ctx.stroke();
        }
    }

    function drawRectangle() {
        ctx.strokeRect(50, 50, 200, 100);
        // Draw divisions
        const totalParts = {{ $question['denominator'] }};
        const width = 200 / totalParts;
        for (let i = 1; i < totalParts; i++) {
            ctx.beginPath();
            ctx.moveTo(50 + i * width, 50);
            ctx.lineTo(50 + i * width, 150);
            ctx.stroke();
        }
    }

    function drawGenericContainer() {
        ctx.strokeRect(50, 50, 200, 100);
        ctx.font = '14px Arial';
        ctx.fillStyle = '#666';
        ctx.textAlign = 'center';
        ctx.fillText('Minh họa bài toán', 150, 100);
    }

    // Initial draw
    drawVisualization();

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (isAnswered) return;

        const answer = {
            numerator: parseInt(numeratorInput.value),
            denominator: parseInt(denominatorInput.value)
        };

        // Disable form
        numeratorInput.disabled = true;
        denominatorInput.disabled = true;
        form.querySelector('button').disabled = true;
        isAnswered = true;

        // Send answer to server
        fetch('{{ route("games.lop4.phanso.word_problem.check") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                numerator: answer.numerator,
                denominator: answer.denominator
            })
        })
        .then(response => response.json())
        .then(data => {
            feedback.classList.remove('d-none', 'alert-success', 'alert-danger');
            
            if (data.correct) {
                feedback.classList.add('alert-success');
                feedback.innerHTML = 'Đúng rồi! Bạn đã giải đúng bài toán! 🎉';
                
                // If there's a next level, redirect after 1.5 seconds
                if (data.next_level) {
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                }
            } else {
                feedback.classList.add('alert-danger');
                feedback.innerHTML = 'Chưa đúng. Hãy đọc kỹ đề bài và thử lại! 🤔';
                
                // Reset after 1.5 seconds
                setTimeout(() => {
                    isAnswered = false;
                    numeratorInput.disabled = false;
                    denominatorInput.disabled = false;
                    form.querySelector('button').disabled = false;
                    numeratorInput.value = '';
                    denominatorInput.value = '';
                    feedback.classList.add('d-none');
                }, 1500);
            }
        });
    });
});
</script>

<style>
.story-section {
    border-left: 4px solid #007bff;
}
.input-group input[type="number"] {
    width: 80px;
}
.accordion-button:not(.collapsed) {
    background-color: #e7f1ff;
    color: #0056b3;
}
.accordion-button:focus {
    box-shadow: none;
    border-color: rgba(0,123,255,.25);
}
.visualization-section canvas {
    max-width: 100%;
    height: auto;
}
</style>
@endsection 