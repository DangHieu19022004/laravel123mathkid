@extends('layouts.app')

@section('content')
<div class="game-container">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 mb-4">Tháp Phân Số 🏰</h1>
        <div class="card d-inline-block mb-4">
            <div class="card-body">
                <h2 class="h4 mb-3">Cấp độ {{ $question['level'] }}/5</h2>
                <p class="h5 text-muted">
                    Sắp xếp các phân số theo thứ tự từ nhỏ đến lớn
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
                    <li>Kéo và thả các phân số vào các tầng của tháp</li>
                    <li>Sắp xếp từ nhỏ đến lớn (từ trên xuống dưới)</li>
                    <li>Phân số nhỏ nhất ở trên cùng</li>
                </ul>
            </div>
        </div>

        <!-- Tower and Fractions -->
        <div class="col-12 col-md-8">
            <div class="tower-container">
                <!-- Tower Levels -->
                <div id="tower" class="tower">
                    @foreach ($question['fractions'] as $index => $fraction)
                        <div class="tower-level" data-index="{{ $index }}" ondrop="drop(event)" ondragover="allowDrop(event)">
                            <div class="tower-block"></div>
                        </div>
                    @endforeach
                </div>

                <!-- Fraction Options -->
                <div id="fractions" class="fraction-options mt-4">
                    @foreach ($question['fractions'] as $index => $fraction)
                        <div class="fraction-card" draggable="true" 
                             ondragstart="drag(event)"
                             data-fraction="{{ $fraction['numerator'] }}/{{ $fraction['denominator'] }}"
                             id="fraction-{{ $index }}">
                            {{ $fraction['numerator'] }}/{{ $fraction['denominator'] }}
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Check Answer Button -->
            <div class="text-center mt-4">
                <button id="checkButton" class="btn btn-primary btn-lg">
                    Kiểm tra
                </button>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <div class="text-center">
        <div id="message" class="alert d-none my-3"></div>

        <form id="resetForm" action="{{ route('games.lop4.phanso.tower.reset') }}" method="POST" class="mt-3">
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
const CHECK_URL = '{{ route('games.lop4.phanso.tower.check') }}';
const CSRF_TOKEN = '{{ csrf_token() }}';
const CORRECT_ORDER = {!! json_encode($question['correctOrder']) !!};

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    const data = ev.dataTransfer.getData("text");
    const draggedElement = document.getElementById(data);
    const dropZone = ev.target.closest('.tower-level');
    
    if (!dropZone) return;

    // If there's already a fraction card, swap them
    const existingCard = dropZone.querySelector('.fraction-card');
    if (existingCard) {
        const originalZone = draggedElement.parentElement;
        originalZone.appendChild(existingCard);
    }
    
    dropZone.appendChild(draggedElement);
}

document.addEventListener('DOMContentLoaded', function() {
    const checkButton = document.getElementById('checkButton');
    const messageDiv = document.getElementById('message');
    const tower = document.getElementById('tower');

    checkButton.addEventListener('click', function() {
        const currentOrder = Array.from(tower.querySelectorAll('.fraction-card'))
            .map(card => card.dataset.fraction);

        const formData = new FormData();
        formData.append('order', JSON.stringify(currentOrder));
        formData.append('correct_order', JSON.stringify(CORRECT_ORDER));
        formData.append('_token', CSRF_TOKEN);

        fetch(CHECK_URL, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN
            }
        })
        .then(response => response.json())
        .then(data => {
            messageDiv.classList.remove('d-none');
            
            if (data.correct) {
                messageDiv.className = 'alert alert-success animate-bounce';
                messageDiv.innerHTML = `
                    <h4 class="alert-heading">🎉 Tuyệt vời!</h4>
                    <p class="mb-0">Bạn đã sắp xếp các phân số đúng thứ tự!</p>
                `;
                
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
                    }, 2000);
                }
            } else {
                messageDiv.className = 'alert alert-warning';
                messageDiv.innerHTML = `
                    <h4 class="alert-heading">⚠️ Hãy thử lại!</h4>
                    <p class="mb-0">Thứ tự các phân số chưa đúng.</p>
                    <hr>
                    <p class="mb-0">💡 Gợi ý: So sánh giá trị của các phân số bằng cách quy đồng mẫu số.</p>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            messageDiv.classList.remove('d-none');
            messageDiv.className = 'alert alert-danger';
            messageDiv.textContent = 'Có lỗi xảy ra, vui lòng thử lại!';
        });
    });
});
</script>
@endpush

@push('styles')
<style>
.tower-container {
    max-width: 500px;
    margin: 0 auto;
}

.tower {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.tower-level {
    width: 100%;
    min-height: 60px;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
}

.tower-block {
    position: absolute;
    width: calc(100% - 20px * var(--level, 0));
    height: 100%;
    background: #f8f9fa;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    z-index: -1;
}

.tower-level:nth-child(1) .tower-block { --level: 0; }
.tower-level:nth-child(2) .tower-block { --level: 1; }
.tower-level:nth-child(3) .tower-block { --level: 2; }
.tower-level:nth-child(4) .tower-block { --level: 3; }
.tower-level:nth-child(5) .tower-block { --level: 4; }
.tower-level:nth-child(6) .tower-block { --level: 5; }
.tower-level:nth-child(7) .tower-block { --level: 6; }
.tower-level:nth-child(8) .tower-block { --level: 7; }

.fraction-options {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
}

.fraction-card {
    background: #fff;
    border: 2px solid #007bff;
    border-radius: 8px;
    padding: 10px 20px;
    font-size: 1.2rem;
    cursor: move;
    user-select: none;
    transition: all 0.3s ease;
}

.fraction-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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