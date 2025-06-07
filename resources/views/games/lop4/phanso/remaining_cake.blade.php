@extends('layouts.app')

@section('content')
<div class="game-container">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 mb-4">Phần Bánh Còn Lại 🍰</h1>
        <div class="card d-inline-block mb-4">
            <div class="card-body">
                <h2 class="h4 mb-3">Cấp độ {{ $question['level'] }}/5</h2>
                <p class="h5 text-muted">
                    Tính phần bánh còn lại
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
                    <li>Quan sát phần bánh đã ăn</li>
                    <li>Tính phần bánh còn lại</li>
                    <li>Nhập tử số và mẫu số của phần còn lại</li>
                </ul>
            </div>
        </div>

        <!-- Cake Problem -->
        <div class="col-12 col-md-8">
            <div class="cake-problem text-center mb-4">
                <div class="cake-visualization mb-4">
                    <canvas id="cakeCanvas" width="300" height="300"></canvas>
                </div>
                <p class="h4 mb-4">
                    Đã ăn {{ $question['eaten']['numerator'] }}/{{ $question['eaten']['denominator'] }} phần bánh.
                    <br>Còn lại bao nhiêu phần?
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

        <form id="resetForm" action="{{ route('games.lop4.phanso.remaining_cake.reset') }}" method="POST" class="mt-3">
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
    const canvas = document.getElementById('cakeCanvas');
    const ctx = canvas.getContext('2d');
    let isAnswered = false;

    // Draw cake visualization
    function drawCake() {
        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;
        const radius = Math.min(canvas.width, canvas.height) * 0.4;
        
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        // Draw full cake
        ctx.beginPath();
        ctx.arc(centerX, centerY, radius, 0, 2 * Math.PI);
        ctx.fillStyle = '#FFE4E1';
        ctx.fill();
        ctx.strokeStyle = '#FF69B4';
        ctx.lineWidth = 2;
        ctx.stroke();
        
        // Draw slices
        const slices = {{ $question['eaten']['denominator'] }};
        for (let i = 0; i < slices; i++) {
            const angle = (i * 2 * Math.PI) / slices;
            ctx.beginPath();
            ctx.moveTo(centerX, centerY);
            ctx.lineTo(centerX + radius * Math.cos(angle), centerY + radius * Math.sin(angle));
            ctx.stroke();
        }
        
        // Color eaten slices
        const eatenSlices = {{ $question['eaten']['numerator'] }};
        for (let i = 0; i < eatenSlices; i++) {
            const startAngle = (i * 2 * Math.PI) / slices;
            const endAngle = ((i + 1) * 2 * Math.PI) / slices;
            
            ctx.beginPath();
            ctx.moveTo(centerX, centerY);
            ctx.arc(centerX, centerY, radius, startAngle, endAngle);
            ctx.lineTo(centerX, centerY);
            ctx.fillStyle = 'rgba(255, 105, 180, 0.3)';
            ctx.fill();
        }
    }

    // Initial draw
    drawCake();

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
        fetch('{{ route("games.lop4.phanso.remaining_cake.check") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                answer: answer,
                correct_answer: {
                    numerator: {{ $question['remaining']['numerator'] }},
                    denominator: {{ $question['remaining']['denominator'] }}
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
.cake-problem {
    background: #f8f9fa;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.cake-visualization {
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