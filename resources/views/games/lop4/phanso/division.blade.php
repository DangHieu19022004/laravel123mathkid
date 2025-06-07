@extends('layouts.app')

@section('content')
<div class="game-container">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 mb-4">Chia Phân Số 📊</h1>
        <div class="card d-inline-block mb-4">
            <div class="card-body">
                <h2 class="h4 mb-3">Cấp độ {{ $question['level'] }}/5</h2>
                <p class="h5 text-muted">
                    Tính phép chia phân số
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
                    <li>Tính kết quả phép chia phân số</li>
                    <li>Nhập tử số và mẫu số của kết quả</li>
                    <li>Rút gọn phân số nếu có thể</li>
                </ul>
            </div>
        </div>

        <!-- Division Problem -->
        <div class="col-12 col-md-8">
            <div class="division-problem text-center mb-4">
                <span class="h2">
                    {{ $question['dividend']['numerator'] }}/{{ $question['dividend']['denominator'] }}
                    ÷
                    {{ $question['divisor']['numerator'] }}/{{ $question['divisor']['denominator'] }}
                    =
                </span>
            </div>

            <!-- Answer Input -->
            <form id="answer-form" class="mb-4">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="number" class="form-control" id="numerator" placeholder="Tử số" min="1" required>
                            <div class="input-group-text">/</div>
                            <input type="number" class="form-control" id="denominator" placeholder="Mẫu số" min="1" required>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check"></i> Kiểm tra
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Visual Aid -->
            <div class="visual-aid mb-4">
                <canvas id="divisionCanvas" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <div class="text-center">
        <div id="message" class="alert d-none my-3"></div>

        <form id="resetForm" action="{{ route('games.lop4.phanso.division.reset') }}" method="POST" class="mt-3">
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
    const canvas = document.getElementById('divisionCanvas');
    const ctx = canvas.getContext('2d');
    let isAnswered = false;

    // Draw division visualization
    function drawVisualization() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        // Draw dividend
        const dividendWidth = canvas.width * 0.3;
        const dividendHeight = canvas.height * 0.4;
        ctx.strokeStyle = '#007bff';
        ctx.lineWidth = 2;
        ctx.strokeRect(50, 50, dividendWidth, dividendHeight);
        
        // Draw divisor
        const divisorWidth = dividendWidth * 0.5;
        const divisorHeight = dividendHeight * 0.5;
        ctx.strokeStyle = '#28a745';
        ctx.strokeRect(50 + dividendWidth + 50, 50, divisorWidth, divisorHeight);
        
        // Draw labels
        ctx.font = '16px Arial';
        ctx.fillStyle = '#007bff';
        ctx.fillText('Số bị chia', 50, 30);
        ctx.fillStyle = '#28a745';
        ctx.fillText('Số chia', 50 + dividendWidth + 50, 30);
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
        fetch('{{ route("games.lop4.phanso.division.check") }}', {
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
.division-problem {
    background: #f8f9fa;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.visual-aid {
    background: #fff;
    border-radius: 1rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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