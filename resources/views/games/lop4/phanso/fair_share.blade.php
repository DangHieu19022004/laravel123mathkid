@extends('layouts.app')

@section('content')
<div class="game-container">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 mb-4">Chia Đều Phân Số 🎯</h1>
        <div class="card d-inline-block mb-4">
            <div class="card-body">
                <h2 class="h4 mb-3">Cấp độ {{ $question['level'] }}/5</h2>
                <p class="h5 text-muted">
                    Chia đều các phần cho mọi người
                </p>
            </div>
        </div>
    </div>

    <!-- Game Area -->
    <div class="row justify-content-center mb-5">
        <!-- Instructions -->
        <div class="col-12 mb-4">
            <div class="alert alert-info">
                <h3 class="h5 mb-3">🎯 Hướng dẫn chơi:</h3>
                <ul class="text-start mb-0">
                    <li>Quan sát số phần cần chia và số người</li>
                    <li>Tính phần mỗi người nhận được</li>
                    <li>Nhập tử số và mẫu số của kết quả</li>
                </ul>
            </div>
        </div>

        <!-- Fair Share Problem -->
        <div class="col-12 col-md-8">
            <div class="fair-share-problem text-center mb-4">
                <div class="fair-share-visualization mb-4">
                    <canvas id="fairShareCanvas" width="400" height="200"></canvas>
                </div>
                <p class="h4 mb-4">
                    Có {{ $question['total']['numerator'] }}/{{ $question['total']['denominator'] }} phần bánh,
                    chia đều cho {{ $question['people'] }} người.
                    <br>Mỗi người được bao nhiêu phần?
                </p>
            </div>

            <!-- Answer Input -->
            <form id="answer-form" class="mb-4">
                <div class="row justify-content-center">
                    <div class="col-md-6">
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
        </div>
    </div>

    <!-- Controls -->
    <div class="text-center">
        <div id="message" class="alert d-none my-3"></div>

        <form id="resetForm" action="{{ route('games.lop4.phanso.fair_share.reset') }}" method="POST" class="mt-3">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('answer-form');
    const numeratorInput = document.getElementById('numerator');
    const denominatorInput = document.getElementById('denominator');
    const messageDiv = document.getElementById('message');
    const canvas = document.getElementById('fairShareCanvas');
    const ctx = canvas.getContext('2d');
    let isAnswered = false;

    // Draw fair share visualization
    function drawVisualization() {
        const total = {{ $question['total']['numerator'] }};
        const people = {{ $question['people'] }};
        const width = canvas.width;
        const height = canvas.height;
        const itemWidth = width / total;
        const itemHeight = height / people;
        
        ctx.clearRect(0, 0, width, height);
        
        // Draw grid
        ctx.strokeStyle = '#ddd';
        ctx.lineWidth = 1;
        
        // Vertical lines
        for (let i = 0; i <= total; i++) {
            ctx.beginPath();
            ctx.moveTo(i * itemWidth, 0);
            ctx.lineTo(i * itemWidth, height);
            ctx.stroke();
        }
        
        // Horizontal lines
        for (let i = 0; i <= people; i++) {
            ctx.beginPath();
            ctx.moveTo(0, i * itemHeight);
            ctx.lineTo(width, i * itemHeight);
            ctx.stroke();
        }
        
        // Draw items
        ctx.fillStyle = 'rgba(0, 123, 255, 0.2)';
        for (let i = 0; i < total; i++) {
            ctx.fillRect(i * itemWidth, 0, itemWidth, height);
        }
        
        // Draw people
        ctx.fillStyle = '#333';
        ctx.font = '14px Arial';
        for (let i = 0; i < people; i++) {
            ctx.fillText(`Người ${i + 1}`, 5, (i + 0.5) * itemHeight + 5);
        }
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
        fetch('{{ route("games.lop4.phanso.fair_share.check") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                answer: answer,
                correct_answer: {
                    numerator: {{ $question['answer']['numerator'] }},
                    denominator: {{ $question['answer']['denominator'] }}
                }
            })
        })
        .then(response => response.json())
        .then(data => {
            messageDiv.classList.remove('d-none', 'alert-success', 'alert-danger');
            
            if (data.correct) {
                messageDiv.className = 'alert alert-success animate-bounce';
                messageDiv.innerHTML = 'Đúng rồi! 🎉';
                
                if (typeof confetti !== 'undefined') {
                    confetti({
                        particleCount: 100,
                        spread: 70,
                        origin: { y: 0.6 }
                    });
                }

                if (data.next_level) {
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                }
            } else {
                messageDiv.className = 'alert alert-danger';
                messageDiv.innerHTML = 'Chưa đúng. Hãy thử lại! 🤔';
                
                // Reset after 1.5 seconds
                setTimeout(() => {
                    isAnswered = false;
                    numeratorInput.disabled = false;
                    denominatorInput.disabled = false;
                    form.querySelector('button').disabled = false;
                    numeratorInput.value = '';
                    denominatorInput.value = '';
                    messageDiv.classList.add('d-none');
                }, 1500);
            }
        });
    });
});
</script>
@endpush

@push('styles')
<style>
.fair-share-problem {
    background: #f8f9fa;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.fair-share-visualization {
    background: white;
    border-radius: 1rem;
    padding: 1rem;
}

.animate-bounce {
    animation: bounce 0.5s;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}
</style>
@endpush
@endsection 