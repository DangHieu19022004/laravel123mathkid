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
    </div>

    <!-- Game Area -->
    <div class="row justify-content-center mb-5">
        <!-- Instructions -->
        <div class="col-12 mb-4">
            <div class="alert alert-info">
                <h3 class="h5 mb-3">🎯 Hướng dẫn chơi:</h3>
                <ul class="text-start mb-0">
                    <li>Tính giá trị biểu thức trong ngoặc trước</li>
                    <li>Thực hiện phép tính theo thứ tự: nhân/chia trước, cộng/trừ sau</li>
                    <li>Chọn đáp án đúng từ các lựa chọn bên dưới</li>
                </ul>
            </div>
        </div>

        <!-- Options -->
        <div class="col-12">
            <div class="row g-4 justify-content-center">
                @foreach($question['options'] as $option)
                <div class="col-md-3">
                    <button onclick="checkAnswer({{ $option }})" class="btn btn-outline-primary w-100 option-btn">
                        {{ $option }}
                    </button>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Controls -->
    <div class="text-center">
        <div id="message" class="alert d-none my-3"></div>

        <form id="resetForm" action="{{ url(route('games.lop4.phanso.bracket.reset')) }}" method="POST" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-link text-decoration-none">
                Chơi lại từ đầu
            </button>
        </form>

        <a href="{{ url(route('games.lop4.phanso')) }}" class="btn btn-link text-decoration-none">
            ← Quay lại danh sách
        </a>
    </div>
</div>

@push('scripts')
<script>
const CHECK_URL = '{{ url(route('games.lop4.phanso.bracket.check')) }}';
const CSRF_TOKEN = '{{ csrf_token() }}';

function checkAnswer(selectedAnswer) {
    console.log('Checking answer:', selectedAnswer);
    
    const formData = new FormData();
    formData.append('selected_answer', selectedAnswer);
    formData.append('correct_answer', {{ $question['correctAnswer'] }});
    formData.append('_token', CSRF_TOKEN);
    
    console.log('Sending request to:', CHECK_URL);
    
    fetch(CHECK_URL, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN
        },
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('Response received:', response);
        return response.json();
    })
    .then(data => {
        console.log('Data:', data);
        const messageDiv = document.getElementById('message');
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
                <ul class="mb-0 mt-2">
                    <li>1. Tính giá trị trong ngoặc trước</li>
                    <li>2. Thực hiện phép nhân/chia trước</li>
                    <li>3. Thực hiện phép cộng/trừ sau</li>
                </ul>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const messageDiv = document.getElementById('message');
        messageDiv.classList.remove('d-none');
        messageDiv.className = 'alert alert-danger';
        messageDiv.textContent = 'Có lỗi xảy ra, vui lòng thử lại!';
    });
}
</script>
@endpush

@push('styles')
<style>
.option-btn {
    font-size: 1.2rem;
    padding: 1rem;
    transition: all 0.3s;
}
.option-btn:hover {
    transform: scale(1.05);
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