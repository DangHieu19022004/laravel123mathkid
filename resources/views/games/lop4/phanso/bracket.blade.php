@extends('layouts.app')

@section('content')
<div class="game-container">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 mb-4">Biểu Thức Ngoặc 🎯</h1>
        <div class="card d-inline-block mb-4">
            <div class="card-body">
                <h2 class="h4 mb-3">Cấp độ {{ $question['level'] }}/5</h2>
                <p class="h5 text-muted">
                    Tính giá trị của biểu thức: {{ $question['expression'] }}
                </p>
            </div>
        </div>

        <!-- Instructions -->
        <div class="alert alert-info d-inline-block">
            <h3 class="h5 mb-3">🎯 Hướng dẫn chơi:</h3>
            <ul class="text-start mb-0">
                <li>Tính giá trị biểu thức trong ngoặc trước</li>
                <li>Thực hiện phép tính theo thứ tự: nhân/chia trước, cộng/trừ sau</li>
                <li>Chọn đáp án đúng từ các lựa chọn bên dưới</li>
            </ul>
        </div>
    </div>

    <!-- Options -->
    <div class="row g-4 justify-content-center mb-5">
        @foreach($question['options'] as $option)
        <div class="col-md-3">
            <button onclick="checkAnswer({{ json_encode($option) }})" class="btn btn-game w-100 option-btn">
                {{ $option['numerator'] }}/{{ $option['denominator'] }}
            </button>
        </div>
        @endforeach
    </div>

    <!-- Controls -->
    <div class="text-center">
        <div id="message" class="alert d-none my-3"></div>

        <form id="resetForm" action="{{ route('games.lop4.phanso.bracket.reset') }}" method="POST" class="mt-3">
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
    const CHECK_URL = '{{ route("games.lop4.phanso.bracket.check") }}';
    const CSRF_TOKEN = '{{ csrf_token() }}';
    let isAnswered = false;

    window.checkAnswer = function(answer) {
        if (isAnswered) return;
        
        const messageDiv = document.getElementById('message');
        const buttons = document.querySelectorAll('.option-btn');
        
        // Disable all buttons
        buttons.forEach(btn => btn.disabled = true);
        
        fetch(CHECK_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ answer: answer })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            isAnswered = true;
            messageDiv.classList.remove('d-none');
            
            if (data.correct) {
                messageDiv.className = 'alert alert-success animate-bounce';
                messageDiv.textContent = '🎉 Tuyệt vời! Cùng tiếp tục nào! 🎉';
                
                if (typeof confetti !== 'undefined') {
                    confetti({
                        particleCount: 150,
                        spread: 70,
                        origin: { y: 0.6 },
                        colors: ['#ff69b4', '#ff1493', '#ff69b4', '#dda0dd']
                    });
                }

                if (data.next_level) {
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }
            } else {
                messageDiv.className = 'alert alert-warning';
                messageDiv.innerHTML = `
                    <h4 class="alert-heading">⚠️ Hãy thử lại!</h4>
                    <p class="mb-0">Đáp án chưa chính xác.</p>
                    <hr>
                    <p class="mb-0">💡 Gợi ý: Hãy tính từng bước theo thứ tự:</p>
                    <ul class="mb-0">
                        <li>1. Tính giá trị trong ngoặc trước</li>
                        <li>2. Thực hiện phép nhân/chia trước</li>
                        <li>3. Thực hiện phép cộng/trừ sau</li>
                    </ul>
                `;
                
                // Re-enable buttons after 2 seconds
                setTimeout(() => {
                    isAnswered = false;
                    buttons.forEach(btn => btn.disabled = false);
                    messageDiv.classList.add('d-none');
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            messageDiv.classList.remove('d-none');
            messageDiv.className = 'alert alert-danger';
            messageDiv.textContent = error.message || 'Có lỗi xảy ra, vui lòng thử lại!';
            buttons.forEach(btn => btn.disabled = false);
        });
    }
});
</script>
@endpush

@push('styles')
<style>
.btn-game {
    background: linear-gradient(45deg, #4CAF50, #8BC34A);
    color: white;
    border: none;
    padding: 10px 30px;
    border-radius: 25px;
    font-size: 1.2rem;
    transition: transform 0.2s;
}
.btn-game:hover {
    transform: scale(1.05);
    color: white;
    background: linear-gradient(45deg, #8BC34A, #4CAF50);
}
.btn-game:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
    background: linear-gradient(45deg, #9E9E9E, #757575);
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