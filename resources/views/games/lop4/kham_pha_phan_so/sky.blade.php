@extends('layouts.app')

@section('content')
<div class="game-container">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 mb-4">Bầu Trời Phân Số 🌤️</h1>
        <div class="card d-inline-block mb-4">
            <div class="card-body">
                <h2 class="h4 mb-3">Cấp độ {{ $question['level'] }}/5</h2>
                <p class="h5 text-muted">
                    Chọn phân số lớn nhất
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
                    <li>Quan sát các phân số trên bầu trời</li>
                    <li>Chọn phân số có giá trị lớn nhất</li>
                    <li>Quy đồng mẫu số nếu cần thiết</li>
                </ul>
            </div>
        </div>

        <!-- Sky Area -->
        <div class="col-12 col-md-8">
            <div class="sky-area">
                @foreach($question['fractions'] as $index => $fraction)
                <button class="fraction-cloud" data-index="{{ $index }}">
                    <span class="h3">{{ $fraction['numerator'] }}/{{ $fraction['denominator'] }}</span>
                </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Controls -->
    <div class="text-center">
        <div id="message" class="alert d-none my-3"></div>

        <form id="resetForm" action="{{ route('games.lop4.phanso.sky.reset') }}" method="POST" class="mt-3">
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
    const clouds = document.querySelectorAll('.fraction-cloud');
    const messageDiv = document.getElementById('message');
    let isAnswered = false;

    clouds.forEach(cloud => {
        cloud.addEventListener('click', function() {
            if (isAnswered) return;

            const selectedIndex = parseInt(this.dataset.index);
            isAnswered = true;

            // Disable all clouds
            clouds.forEach(c => c.disabled = true);

            // Send answer to server
            fetch('{{ route("games.lop4.phanso.sky.check") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    selected_index: selectedIndex
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
                        clouds.forEach(c => c.disabled = false);
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
.sky-area {
    background: linear-gradient(180deg, #87CEEB 0%, #E0F6FF 100%);
    min-height: 400px;
    border-radius: 1rem;
    padding: 2rem;
    position: relative;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    align-items: center;
}

.fraction-cloud {
    background: white;
    border: none;
    padding: 1.5rem 2.5rem;
    border-radius: 2rem;
    margin: 1rem;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    cursor: pointer;
}

.fraction-cloud:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.fraction-cloud:active {
    transform: translateY(-5px);
}

.fraction-cloud:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
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