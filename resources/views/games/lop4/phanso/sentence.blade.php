@extends('layouts.app')

@section('content')
<div class="game-container">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 mb-4">Câu Đố Phân Số 📝</h1>
        <div class="card d-inline-block mb-4">
            <div class="card-body">
                <h2 class="h4 mb-3">Cấp độ {{ $question['level'] }}/5</h2>
                <p class="h5 text-muted">
                    Hoàn thành câu đố
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
                    <li>Đọc câu đố cẩn thận</li>
                    <li>Điền phân số thích hợp vào chỗ trống</li>
                    <li>Rút gọn phân số nếu có thể</li>
                </ul>
            </div>
        </div>

        <!-- Sentence Problem -->
        <div class="col-12 col-md-8">
            <div class="sentence-problem text-center mb-4">
                <p class="h4 mb-4">{{ $question['text'] }}</p>
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

            <!-- Hint -->
            <div id="hint" class="alert alert-warning d-none">
                <i class="fas fa-lightbulb"></i> {{ $question['hint'] }}
            </div>
        </div>
    </div>

    <!-- Controls -->
    <div class="text-center">
        <div id="message" class="alert d-none my-3"></div>

        <form id="resetForm" action="{{ route('games.lop4.phanso.sentence.reset') }}" method="POST" class="mt-3">
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
    const hintDiv = document.getElementById('hint');
    let isAnswered = false;
    let wrongAttempts = 0;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (isAnswered) return;

        const answer = {
            numerator: parseInt(numeratorInput.value),
            denominator: parseInt(denominatorInput.value)
        };

        // Validate input
        if (isNaN(answer.numerator) || isNaN(answer.denominator) || answer.denominator <= 0) {
            messageDiv.className = 'alert alert-danger';
            messageDiv.innerHTML = 'Vui lòng nhập số hợp lệ!';
            messageDiv.classList.remove('d-none');
            return;
        }

        // Disable form
        numeratorInput.disabled = true;
        denominatorInput.disabled = true;
        form.querySelector('button').disabled = true;
        isAnswered = true;

        // Send answer to server
        fetch('{{ route("games.lop4.phanso.sentence.check") }}', {
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
            messageDiv.classList.remove('d-none', 'alert-success', 'alert-danger');
            
            if (data.correct) {
                messageDiv.className = 'alert alert-success animate-bounce';
                messageDiv.innerHTML = 'Đúng rồi! 🎉';
                hintDiv.classList.add('d-none');
                
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
                wrongAttempts++;
                
                // Show hint after 2 wrong attempts
                if (wrongAttempts >= 2) {
                    hintDiv.classList.remove('d-none');
                }
                
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
.sentence-problem {
    background: #f8f9fa;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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