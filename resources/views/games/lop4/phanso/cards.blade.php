@extends('layouts.app')

@section('content')
<div class="game-container">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 mb-4">Thẻ Bài Phân Số 🃏</h1>
        <div class="card d-inline-block mb-4">
            <div class="card-body">
                <h2 class="h4 mb-3">Cấp độ {{ $question['level'] }}/5</h2>
                <p class="h5 text-muted">
                    Tìm các cặp phân số bằng nhau
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
                    <li>Click vào thẻ để lật</li>
                    <li>Tìm các cặp phân số bằng nhau</li>
                    <li>Ghi nhớ vị trí các thẻ đã lật</li>
                </ul>
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="col-12 col-md-8">
            <div class="cards-grid">
                @foreach ($question['cards'] as $card)
                    <div class="memory-card" data-id="{{ $card['id'] }}" data-pair-id="{{ $card['pairId'] }}">
                        <div class="card-inner">
                            <div class="card-front">
                                ?
                            </div>
                            <div class="card-back">
                                {{ $card['numerator'] }}/{{ $card['denominator'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Score Display -->
            <div class="text-center mt-4">
                <div class="score-display">
                    <span>Số lần lật: <span id="flips">0</span></span>
                    <span class="ms-4">Cặp đã tìm thấy: <span id="pairs">0</span>/{{ count($question['pairs']) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <div class="text-center">
        <div id="message" class="alert d-none my-3"></div>

        <form id="resetForm" action="{{ route('games.lop4.phanso.cards.reset') }}" method="POST" class="mt-3">
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
const CHECK_URL = '{{ route('games.lop4.phanso.cards.check') }}';
const CSRF_TOKEN = '{{ csrf_token() }}';
const TOTAL_PAIRS = {{ count($question['pairs']) }};

let hasFlippedCard = false;
let lockBoard = false;
let firstCard, secondCard;
let flips = 0;
let pairs = 0;

function flipCard() {
    if (lockBoard) return;
    if (this === firstCard) return;

    this.classList.add('flip');
    flips++;
    document.getElementById('flips').textContent = flips;

    if (!hasFlippedCard) {
        // First click
        hasFlippedCard = true;
        firstCard = this;
        return;
    }

    // Second click
    secondCard = this;
    checkForMatch();
}

function checkForMatch() {
    const isMatch = firstCard.dataset.pairId === secondCard.dataset.pairId;

    if (isMatch) {
        disableCards();
        pairs++;
        document.getElementById('pairs').textContent = pairs;

        // Check if all pairs are found
        if (pairs === TOTAL_PAIRS) {
            // Send answer to server
            const formData = new FormData();
            formData.append('_token', CSRF_TOKEN);

            fetch(CHECK_URL, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const messageDiv = document.getElementById('message');
                messageDiv.classList.remove('d-none');
                
                if (data.correct) {
                    messageDiv.className = 'alert alert-success animate-bounce';
                    messageDiv.textContent = '🎉 Tuyệt vời! Cùng tiếp tục nào!';
                    
                    if (typeof confetti !== 'undefined') {
                        confetti({
                            particleCount: 100,
                            spread: 70,
                            origin: { y: 0.6 }
                        });
                    }

                    // Force reload after a short delay
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
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
    } else {
        unflipCards();
    }

    [firstCard, secondCard] = [null, null];
}

function disableCards() {
    firstCard.removeEventListener('click', flipCard);
    secondCard.removeEventListener('click', flipCard);
    resetBoard();
}

function unflipCards() {
    lockBoard = true;

    setTimeout(() => {
        firstCard.classList.remove('flip');
        secondCard.classList.remove('flip');
        resetBoard();
    }, 1000);
}

function resetBoard() {
    [hasFlippedCard, lockBoard] = [false, false];
    [firstCard, secondCard] = [null, null];
}

document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.memory-card');
    cards.forEach(card => card.addEventListener('click', flipCard));

    // Shuffle cards
    cards.forEach(card => {
        const randomPos = Math.floor(Math.random() * cards.length);
        card.style.order = randomPos;
    });
});
</script>
@endpush

@push('styles')
<style>
.cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
    gap: 15px;
    max-width: 600px;
    margin: 0 auto;
    perspective: 1000px;
}

.memory-card {
    aspect-ratio: 2/3;
    position: relative;
    transform-style: preserve-3d;
    transition: transform 0.5s;
    cursor: pointer;
}

.memory-card.flip {
    transform: rotateY(180deg);
}

.card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    text-align: center;
    transform-style: preserve-3d;
}

.card-front,
.card-back {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.card-front {
    background: #007bff;
    color: white;
}

.card-back {
    background: white;
    border: 2px solid #007bff;
    color: #007bff;
    transform: rotateY(180deg);
}

.score-display {
    font-size: 1.2rem;
    color: #6c757d;
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