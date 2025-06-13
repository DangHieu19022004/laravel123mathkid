@extends('layouts.app')

@section('content')
<div class="game-container">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 mb-4">Chia Bánh Sinh Nhật 🎂</h1>
        <div class="card d-inline-block mb-4">
            <div class="card-body">
                <h2 class="h4 mb-3">Cấp độ {{ $question['level'] }}/5</h2>
                <p class="h5 text-muted">
                    Hãy chọn <strong>{{ $question['numerator'] }}/{{ $question['denominator'] }}</strong> phần của chiếc bánh
                </p>
            </div>
        </div>

        <!-- Instructions -->
        <div class="alert alert-info d-inline-block">
            <h3 class="h5 mb-3">🎯 Hướng dẫn chơi:</h3>
            <ul class="text-start mb-0">
                <li>Chiếc bánh được chia thành {{ $question['denominator'] }} phần bằng nhau</li>
                <li>Bạn cần chọn đúng {{ $question['numerator'] }} phần</li>
                <li>Click vào từng phần bánh để chọn hoặc bỏ chọn</li>
                <li>Các phần được chọn sẽ có màu vàng</li>
            </ul>
        </div>
    </div>

    <div class="cake-container mb-5" id="cake-container">
        <!-- Cake will be drawn here by JavaScript -->
    </div>

    <!-- Controls -->
    <div class="text-center">
        <button id="check-answer" class="btn btn-game mb-3">
            Kiểm tra
        </button>

        <div id="message" class="alert d-none my-3"></div>

        <form id="resetForm" action="{{ url(route('games.lop4.phanso.cake.reset')) }}" method="POST" class="mt-3">
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
document.addEventListener('DOMContentLoaded', function() {
    const pieces = {{ $question['denominator'] }};
    const numerator = {{ $question['numerator'] }};
    const selectedPieces = new Set();
    const CHECK_URL = '{{ url(route('games.lop4.phanso.cake.check')) }}';
    const CSRF_TOKEN = '{{ csrf_token() }}';

    function drawCake() {
        const container = document.getElementById('cake-container');
        const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
        svg.setAttribute('viewBox', '0 0 400 400');
        svg.setAttribute('width', '100%');
        svg.setAttribute('height', '100%');
        
        // Draw cake plate
        const plate = document.createElementNS("http://www.w3.org/2000/svg", "circle");
        plate.setAttribute('cx', '200');
        plate.setAttribute('cy', '200');
        plate.setAttribute('r', '190');
        plate.setAttribute('fill', '#fce7f3');
        plate.setAttribute('stroke', '#f472b6');
        plate.setAttribute('stroke-width', '8');
        svg.appendChild(plate);

        // Draw cake base
        const base = document.createElementNS("http://www.w3.org/2000/svg", "circle");
        base.setAttribute('cx', '200');
        base.setAttribute('cy', '200');
        base.setAttribute('r', '170');
        base.setAttribute('fill', '#fbcfe8');
        svg.appendChild(base);
        
        // Draw cake pieces
        const radius = 150;
        for (let i = 0; i < pieces; i++) {
            const angle = (360 / pieces) * i;
            const nextAngle = (360 / pieces) * (i + 1);
            
            const startX = 200 + radius * Math.cos(angle * Math.PI / 180);
            const startY = 200 + radius * Math.sin(angle * Math.PI / 180);
            const endX = 200 + radius * Math.cos(nextAngle * Math.PI / 180);
            const endY = 200 + radius * Math.sin(nextAngle * Math.PI / 180);

            const piece = document.createElementNS("http://www.w3.org/2000/svg", "path");
            piece.setAttribute('d', `M200,200 L${startX},${startY} A${radius},${radius} 0 0,1 ${endX},${endY} Z`);
            piece.setAttribute('fill', '#fdf2f8');
            piece.setAttribute('stroke', '#db2777');
            piece.setAttribute('stroke-width', '2');
            piece.setAttribute('class', 'cake-piece');
            piece.setAttribute('data-index', i);
            
            piece.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-index'));
                if (selectedPieces.has(index)) {
                    selectedPieces.delete(index);
                    this.setAttribute('fill', '#fdf2f8');
                } else {
                    selectedPieces.add(index);
                    this.setAttribute('fill', '#ffc107');
                }
            });
            
            svg.appendChild(piece);
        }

        container.innerHTML = '';
        container.appendChild(svg);
    }

    drawCake();

    // Check answer handler
    document.getElementById('check-answer').addEventListener('click', function() {
        const formData = new FormData();
        formData.append('selected_pieces', JSON.stringify(Array.from(selectedPieces)));
        formData.append('numerator', numerator);
        formData.append('_token', CSRF_TOKEN);

        fetch(CHECK_URL, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }

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
                    <p class="mb-0">Bạn đã chọn ${selectedPieces.size} phần, nhưng cần chọn ${numerator} phần.</p>
                    <hr>
                    <p class="mb-0">💡 Gợi ý: Hãy đếm số phần bánh bạn đã chọn và so sánh với yêu cầu.</p>
                `;
            }
        })
        .catch(error => {
            console.error('Error details:', error);
            const messageDiv = document.getElementById('message');
            messageDiv.classList.remove('d-none');
            messageDiv.className = 'alert alert-danger';
            messageDiv.textContent = error.message || 'Có lỗi xảy ra, vui lòng thử lại!';
        });
    });
});
</script>
@endpush

@push('styles')
<style>
.btn-game {
    background: linear-gradient(45deg, #ff69b4, #ff1493);
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
}
.animate-bounce {
    animation: bounce 0.5s;
}
@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}
.cake-container {
    width: 400px;
    max-width: 100%;
    margin: 0 auto;
}
.cake-piece {
    cursor: pointer;
    transition: fill 0.3s;
}
.cake-piece:hover {
    fill: #ffe4e1;
}
</style>
@endpush
@endsection 