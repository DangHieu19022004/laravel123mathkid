@extends('layouts.app')

@section('content')
<div class="game-container">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 mb-4">Dọn Vườn Tối Giản 🌱</h1>
        <div class="card d-inline-block mb-4">
            <div class="card-body">
                <h2 class="h4 mb-3">Cấp độ {{ $question['level'] }}/5</h2>
                <p class="h5 text-muted">
                    Rút gọn phân số: <strong>{{ $question['numerator'] }}/{{ $question['denominator'] }}</strong>
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
                    <li>Click vào các ô để gộp thành ô lớn hơn</li>
                    <li>Hoặc chọn phân số tối giản từ các lựa chọn bên dưới</li>
                    <li>Mỗi ô đại diện cho 1 phần của phân số</li>
                </ul>
            </div>
        </div>

        <!-- Garden Grid -->
        <div class="col-12 mb-4">
            <div class="garden-grid" style="--rows: {{ $question['gridRows'] }}; --cols: {{ $question['gridCols'] }}">
                @for ($i = 0; $i < $question['denominator']; $i++)
                    <div class="garden-cell @if($i < $question['numerator']) selected @endif" data-index="{{ $i }}"></div>
                @endfor
            </div>
        </div>

        <!-- Answer Options -->
        <div class="col-12">
            <div class="row g-3 justify-content-center">
                @php
                    $options = [
                        [$question['simplifiedNumerator'], $question['simplifiedDenominator']],
                        [$question['numerator'] + 1, $question['denominator']],
                        [$question['numerator'], $question['denominator'] - 1],
                        [$question['simplifiedNumerator'] + 1, $question['simplifiedDenominator']]
                    ];
                    shuffle($options);
                @endphp

                @foreach ($options as $option)
                    <div class="col-md-3">
                        <button class="btn btn-outline-primary w-100 fraction-option"
                                data-numerator="{{ $option[0] }}"
                                data-denominator="{{ $option[1] }}">
                            {{ $option[0] }}/{{ $option[1] }}
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Controls -->
    <div class="text-center">
        <div id="message" class="alert d-none my-3"></div>

        <form id="resetForm" action="{{ route('games.lop4.phanso.garden.reset') }}" method="POST" class="mt-3">
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
const CHECK_URL = '{{ route('games.lop4.phanso.garden.check') }}';
const CSRF_TOKEN = '{{ csrf_token() }}';
const CORRECT_NUMERATOR = {{ $question['simplifiedNumerator'] }};
const CORRECT_DENOMINATOR = {{ $question['simplifiedDenominator'] }};

document.addEventListener('DOMContentLoaded', function() {
    const fractionOptions = document.querySelectorAll('.fraction-option');
    const messageDiv = document.getElementById('message');
    let selectedCells = document.querySelectorAll('.garden-cell.selected').length;

    // Handle fraction option clicks
    fractionOptions.forEach(option => {
        option.addEventListener('click', function() {
            const numerator = parseInt(this.dataset.numerator);
            const denominator = parseInt(this.dataset.denominator);
            checkAnswer(numerator, denominator);
        });
    });

    // Handle garden cell clicks
    document.querySelectorAll('.garden-cell').forEach(cell => {
        cell.addEventListener('click', function() {
            this.classList.toggle('selected');
            selectedCells = document.querySelectorAll('.garden-cell.selected').length;
            
            // Check if selection matches any fraction option
            fractionOptions.forEach(option => {
                const numerator = parseInt(option.dataset.numerator);
                const denominator = {{ $question['denominator'] }};
                if (selectedCells === numerator) {
                    checkAnswer(numerator, denominator);
                }
            });
        });
    });

    function checkAnswer(numerator, denominator) {
        const formData = new FormData();
        formData.append('numerator', numerator);
        formData.append('denominator', denominator);
        formData.append('correct_numerator', CORRECT_NUMERATOR);
        formData.append('correct_denominator', CORRECT_DENOMINATOR);
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
                    <p class="mb-0">Phân số ${numerator}/${denominator} là dạng tối giản của 
                    {{ $question['numerator'] }}/{{ $question['denominator'] }}</p>
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
                    <p class="mb-0">Phân số ${numerator}/${denominator} chưa phải là dạng tối giản.</p>
                    <hr>
                    <p class="mb-0">💡 Gợi ý: Tìm ước số chung lớn nhất của tử số và mẫu số.</p>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            messageDiv.classList.remove('d-none');
            messageDiv.className = 'alert alert-danger';
            messageDiv.textContent = 'Có lỗi xảy ra, vui lòng thử lại!';
        });
    }
});
</script>
@endpush

@push('styles')
<style>
.garden-grid {
    display: grid;
    grid-template-rows: repeat(var(--rows), 1fr);
    grid-template-columns: repeat(var(--cols), 1fr);
    gap: 10px;
    max-width: 600px;
    margin: 0 auto;
    aspect-ratio: var(--cols) / var(--rows);
}

.garden-cell {
    background: #e9ecef;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.garden-cell::after {
    content: '🌱';
    font-size: 1.5rem;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.garden-cell.selected {
    background: #d4edda;
    border-color: #28a745;
}

.garden-cell.selected::after {
    opacity: 1;
}

.garden-cell:hover {
    transform: scale(1.05);
}

.fraction-option {
    font-size: 1.2rem;
    padding: 10px 20px;
    transition: all 0.3s ease;
}

.fraction-option:hover {
    transform: translateY(-2px);
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