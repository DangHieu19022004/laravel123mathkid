@extends('layouts.app')

@section('content')
<div class="game-container">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 mb-4">Thẻ Bài Phân Số 🃏</h1>
        <div class="card d-inline-block mb-4">
            <div class="card-body">
                <h2 class="h4 mb-3">Cấp độ <span id="current-level">{{ $question['level'] }}</span>/5</h2>
                <p class="h5 text-muted">
                    Tìm các cặp phân số bằng nhau
                </p>
            </div>
        </div>
    </div>

    <!-- Message Area - Fixed position -->
    <div id="message" class="alert-float d-none" role="alert"></div>

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
const CHECK_URL = '{!! route('games.lop4.phanso.cards.check') !!}';
const CSRF_TOKEN = '{!! csrf_token() !!}';
const TOTAL_PAIRS = {!! count($question['pairs']) !!};

let hasFlippedCard = false;
let lockBoard = false;
let firstCard, secondCard;
let flips = 0;
let pairs = 0;
let matchedPairs = [];
let currentLevel = parseInt(localStorage.getItem('cardsLevel') || '0');
const totalLevels = 5;

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
        
        // Show success message for matching pair
        showMessage('success', `
            <h4 class="alert-heading">🎉 Tuyệt vời!</h4>
            <p class="mb-0">Bạn đã tìm thấy một cặp phân số bằng nhau!</p>
        `);
        
        // Store the matched pair
        matchedPairs.push([
            parseInt(firstCard.dataset.id),
            parseInt(secondCard.dataset.id)
        ]);

        // Check if we found all pairs
        if (pairs >= TOTAL_PAIRS) {
            // Lock the board immediately
            lockBoard = true;
            
            // Send answer to server
            fetch(CHECK_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    selected_pairs: matchedPairs,
                    _token: CSRF_TOKEN
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.correct) {
                    // Lock the board immediately
                    lockBoard = true;
                    
                    // Show success message
                    showMessage('success', `
                        <h4 class="alert-heading">🎉 Chúc mừng!</h4>
                        <p class="mb-0">Bạn đã tìm thấy tất cả các cặp phân số bằng nhau!</p>
                        <p class="mt-2 mb-0">Đang chuyển sang cấp độ tiếp theo...</p>
                    `);

                    // Play confetti animation
                    if (typeof confetti !== 'undefined') {
                        confetti({
                            particleCount: 100,
                            spread: 70,
                            origin: { y: 0.6 }
                        });
                    }

                    // Automatically go to next level after a short delay
                    if (data.next_level) {
                        setTimeout(() => {
                            window.location.href = "{{ route('games.lop4.phanso.cards') }}";
                        }, 2000);
                    } else {
                        showMessage('success', `
                            <h4 class="alert-heading">🎉 Chúc mừng!</h4>
                            <p class="mb-0">🏆 Bạn đã hoàn thành tất cả các cấp độ!</p>
                        `);
                    }
                } else {
                    // Show error if server validation fails
                    showMessage('danger', `
                        <h4 class="alert-heading">❌ Có lỗi xảy ra</h4>
                        <p class="mb-0">${data.message || 'Vui lòng thử lại'}</p>
                    `);
                    resetGame();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('danger', `
                    <h4 class="alert-heading">❌ Lỗi kết nối</h4>
                    <p class="mb-0">Vui lòng thử lại sau</p>
                `);
                resetGame();
            });
        }
    } else {
        // Show message for incorrect match
        showMessage('danger', `
            <h4 class="alert-heading">❌ Chưa đúng</h4>
            <p class="mb-0">Hai phân số này không bằng nhau. Hãy thử lại nhé!</p>
        `);
        unflipCards();
    }
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

function showMessage(type, html) {
    const messageDiv = document.getElementById('message');
    messageDiv.classList.remove('d-none', 'alert-success', 'alert-danger', 'show');
    messageDiv.classList.add(`alert-${type}`);
    messageDiv.innerHTML = html;
    
    // Force a reflow before adding the show class
    void messageDiv.offsetWidth;
    messageDiv.classList.add('show');
    
    // Auto hide message after 2 seconds for non-final messages
    if (!html.includes('Đang chuyển sang cấp độ tiếp theo')) {
        setTimeout(() => {
            messageDiv.classList.remove('show');
            setTimeout(() => {
                messageDiv.classList.add('d-none');
            }, 300); // Wait for fade out animation
        }, 2000);
    }
}

function resetGame() {
    lockBoard = false;
    pairs = 0;
    document.getElementById('pairs').textContent = pairs;
    matchedPairs = [];
    
    // Re-enable and flip back all cards
    document.querySelectorAll('.memory-card').forEach(card => {
        card.classList.remove('flip');
        card.addEventListener('click', flipCard);
    });
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

#message {
    font-size: 1.2rem;
    padding: 1rem;
    margin: 1rem auto;
    max-width: 600px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}

.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}

/* New styles for floating message */
.alert-float {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000;
    min-width: 300px;
    max-width: 90%;
    padding: 1rem;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.alert-float.show {
    opacity: 1;
}

.alert-float.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}

.alert-float.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}
</style>
@endpush 