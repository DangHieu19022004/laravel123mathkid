@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center mb-0">Đo Diện Tích</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h4>Cấp độ: {{ $question['level'] }}</h4>
                        <p class="lead">Chọn hình có diện tích {{ $question['type'] === 'max' ? 'lớn nhất' : 'nhỏ nhất' }}</p>
                    </div>

                    <div class="row">
                        @foreach($question['objects'] as $index => $object)
                        <div class="col-md-4">
                            <div class="card mb-3 object-card" data-index="{{ $index }}">
                                <div class="card-body text-center">
                                    {{-- SVG minh họa hình học --}}
                                    @if(Str::contains(Str::lower($object['object']), 'tam giác'))
                                        <svg width="120" height="100" viewBox="0 0 120 100">
                                            <polygon points="10,90 110,90 60,20" style="fill:#e3f0fc;stroke:#4285f4;stroke-width:4" />
                                        </svg>
                                    @elseif(Str::contains(Str::lower($object['object']), 'thang'))
                                        <svg width="120" height="100" viewBox="0 0 120 100">
                                            <polygon points="30,90 90,90 100,30 20,30" style="fill:#e3f0fc;stroke:#4285f4;stroke-width:4" />
                                        </svg>
                                    @elseif(Str::contains(Str::lower($object['object']), 'chữ nhật'))
                                        <svg width="120" height="100" viewBox="0 0 120 100">
                                            <rect x="20" y="30" width="80" height="60" style="fill:#e3f0fc;stroke:#4285f4;stroke-width:4" />
                                        </svg>
                                    @elseif(Str::contains(Str::lower($object['object']), 'tròn'))
                                        <svg width="100" height="100" viewBox="0 0 100 100">
                                            <circle cx="50" cy="50" r="40" style="fill:#e3f0fc;stroke:#4285f4;stroke-width:4" />
                                        </svg>
                                    @elseif(Str::contains(Str::lower($object['object']), 'bình hành'))
                                        <svg width="120" height="100" viewBox="0 0 120 100">
                                            <polygon points="30,90 110,90 90,30 10,30" style="fill:#e3f0fc;stroke:#4285f4;stroke-width:4" />
                                        </svg>
                                    @else
                                        <div class="display-1 mb-3">{{ $object['emoji'] }}</div>
                                    @endif
                                    <h5>{{ $object['object'] }}</h5>
                                    <p class="mb-1">{{ $object['area'] }} {{ $object['unit'] }}</p>
                                    <small class="text-muted">{{ $object['description'] }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-4">
                        <button class="btn btn-primary" id="checkAnswer">Kiểm tra</button>
                        <button class="btn btn-secondary" id="resetGame">Chơi lại</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.object-card {
    cursor: pointer;
    transition: all 0.3s ease;
}

.object-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.object-card.selected {
    border: 2px solid #007bff;
    background-color: #f8f9fa;
}

.display-1 {
    font-size: 4rem;
}

.text-muted {
    font-size: 0.875rem;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedCard = null;
    const cards = document.querySelectorAll('.object-card');
    const checkButton = document.getElementById('checkAnswer');
    const resetButton = document.getElementById('resetGame');
    let currentLevel = parseInt(localStorage.getItem('areaMeasurementLevel') || '0');
    const totalLevels = 5;
    const levelSpan = document.getElementById('level');
    const nextLevelBtn = document.getElementById('nextLevelBtn');
    const messageEl = document.getElementById('message');

    function renderAll() {
        levelSpan.textContent = currentLevel + 1;
        renderTable(currentLevel);
        renderDraggables(currentLevel);
        resetDropzones();
        messageEl.classList.add('hidden');
        nextLevelBtn.classList.add('hidden');
    }

    cards.forEach(card => {
        card.addEventListener('click', function() {
            cards.forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            selectedCard = this;
        });
    });

    checkButton.addEventListener('click', function() {
        if (!selectedCard) {
            alert('Vui lòng chọn một đáp án!');
            return;
        }

        const selectedIndex = selectedCard.dataset.index;
        
        fetch('/games/lop4/bi-an-hinh-hoc/area-measurement/check', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                selected_index: selectedIndex
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.correct) {
                if (data.next_level) {
                    alert('Chính xác! Chuyển sang cấp độ tiếp theo.');
                    currentLevel++;
                    localStorage.setItem('areaMeasurementLevel', currentLevel);
                    renderAll();
                } else {
                    alert('Chính xác! Bạn đã hoàn thành tất cả các cấp độ!');
                }
            } else {
                alert('Chưa đúng! Hãy thử lại.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra, vui lòng thử lại!');
        });
    });

    nextLevelBtn.addEventListener('click', function() {
        if (currentLevel < totalLevels - 1) {
            currentLevel++;
            localStorage.setItem('areaMeasurementLevel', currentLevel);
        }
    });

    resetButton.addEventListener('click', function() {
        if (confirm('Bạn có chắc muốn chơi lại từ đầu?')) {
            currentLevel = 0;
            localStorage.removeItem('areaMeasurementLevel');
            window.location.reload();
        }
    });

    if (resetButton) {
        resetButton.onclick = function() {
            currentLevel = 0;
            localStorage.setItem('areaMeasurementLevel', currentLevel);
            renderAll();
        };
    }
});
</script>
@endpush
@endsection 