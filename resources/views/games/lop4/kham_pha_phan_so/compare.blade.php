@extends('layouts.app')

@section('content')
<div class="game-container">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 mb-4">So Sánh Phân Số 🔍</h1>
        <div class="card d-inline-block mb-4">
            <div class="card-body">
                <h2 class="h4 mb-3">Cấp độ {{ $question['level'] }}/5</h2>
                <p class="h5 text-muted">
                    So sánh các phân số sau
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
                    <li>So sánh hai phân số</li>
                    <li>Chọn dấu so sánh thích hợp (>, <, =)</li>
                    <li>Quy đồng mẫu số nếu cần thiết</li>
                </ul>
            </div>
        </div>

        <!-- Comparison Area -->
        <div class="col-12 col-md-8">
            <div class="comparison-area">
                <!-- Left Fraction -->
                <div class="fraction-display">
                    <span class="h2">{{ $question['left']['numerator'] }}/{{ $question['left']['denominator'] }}</span>
                </div>

                <!-- Comparison Buttons -->
                <div class="comparison-buttons mx-4">
                    <button class="btn btn-outline-primary mb-2 comparison-btn" data-symbol="<">
                        <span class="h4">&lt;</span>
                    </button>
                    <button class="btn btn-outline-primary mb-2 comparison-btn" data-symbol="=">
                        <span class="h4">=</span>
                    </button>
                    <button class="btn btn-outline-primary comparison-btn" data-symbol=">">
                        <span class="h4">&gt;</span>
                    </button>
                </div>

                <!-- Right Fraction -->
                <div class="fraction-display">
                    <span class="h2">{{ $question['right']['numerator'] }}/{{ $question['right']['denominator'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <div class="text-center">
        <div id="message" class="alert d-none my-3"></div>

        <form id="resetForm" action="{{ route('games.lop4.phanso.compare.reset') }}" method="POST" class="mt-3">
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
    const buttons = document.querySelectorAll('.comparison-btn');
    const messageDiv = document.getElementById('message');
    let isAnswered = false;

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            if (isAnswered) return;

            const selectedSymbol = this.dataset.symbol;
            isAnswered = true;

            // Disable all buttons
            buttons.forEach(btn => btn.disabled = true);

            // Send answer to server
            fetch('{{ route("games.lop4.phanso.compare.check") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    selected_symbol: selectedSymbol,
                    correct_symbol: '{{ $question["correct_symbol"] }}'
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
                        buttons.forEach(btn => btn.disabled = false);
                        messageDiv.classList.add('d-none');
                    }, 1500);
                }
            });
        });
    });
});
</script>
@endpush

@push('styles')
<style>
.comparison-area {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 2rem;
}

.fraction-display {
    background: #f8f9fa;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.comparison-buttons {
    display: flex;
    flex-direction: column;
}

.comparison-btn {
    width: 60px;
    height: 60px;
    margin: 0.5rem;
    transition: all 0.3s ease;
}

.comparison-btn:hover {
    transform: scale(1.1);
}

.comparison-btn:active {
    transform: scale(0.95);
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