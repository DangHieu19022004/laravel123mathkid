@extends('layouts.game')

@section('title', 'Cân Bằng Hai Bên')

@section('game_content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Cấp độ {{ $question['level'] }}</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h4>Chọn dấu so sánh thích hợp:</h4>
                    </div>

                    <div class="row align-items-center justify-content-center mb-4">
                        <!-- Left Expression -->
                        <div class="col-md-4 text-center">
                            <div class="bg-light p-3 rounded shadow-sm">
                                @foreach($question['left'] as $key => $item)
                                    @if(is_array($item))
                                        <span class="h4">
                                            <sup>{{ $item['numerator'] }}</sup>⁄<sub>{{ $item['denominator'] }}</sub>
                                        </span>
                                    @else
                                        <span class="h4 mx-2">{{ $item }}</span>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Comparison Buttons -->
                        <div class="col-md-2 text-center">
                            <div class="btn-group-vertical">
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
                        </div>

                        <!-- Right Expression -->
                        <div class="col-md-4 text-center">
                            <div class="bg-light p-3 rounded shadow-sm">
                                @foreach($question['right'] as $key => $item)
                                    @if(is_array($item))
                                        <span class="h4">
                                            <sup>{{ $item['numerator'] }}</sup>⁄<sub>{{ $item['denominator'] }}</sub>
                                        </span>
                                    @else
                                        <span class="h4 mx-2">{{ $item }}</span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Balance Scale Visualization -->
                    <div class="text-center mb-4">
                        <div id="balance-scale" class="position-relative" style="height: 200px;">
                            <!-- Scale will be animated with JavaScript -->
                            <div class="scale-beam position-absolute w-100" style="height: 10px; background: #666; top: 50%; transform-origin: center;"></div>
                            <div class="scale-stand position-absolute" style="width: 10px; height: 100px; background: #666; left: 50%; transform: translateX(-50%); bottom: 0;"></div>
                            <div class="scale-base position-absolute" style="width: 100px; height: 10px; background: #666; left: 50%; transform: translateX(-50%); bottom: 0;"></div>
                            <div class="scale-left position-absolute" style="width: 80px; height: 80px; border: 5px solid #666; border-radius: 10px; left: 25%; transform: translateX(-50%) translateY(-50%); top: 50%;"></div>
                            <div class="scale-right position-absolute" style="width: 80px; height: 80px; border: 5px solid #666; border-radius: 10px; left: 75%; transform: translateX(-50%) translateY(-50%); top: 50%;"></div>
                        </div>
                    </div>

                    <!-- Feedback Message -->
                    <div id="feedback" class="alert d-none"></div>

                    <!-- Navigation Buttons -->
                    <div class="text-center mt-4">
                        <a href="{{ route('games.lop4.phanso.balance.reset') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Chơi lại
                        </a>
                        <a href="{{ route('games.lop4.phanso') }}" class="btn btn-primary">
                            <i class="fas fa-home"></i> Về trang chính
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.comparison-btn');
    const feedback = document.getElementById('feedback');
    const scaleBeam = document.querySelector('.scale-beam');
    const correctSymbol = '{{ $question["correct_symbol"] }}';
    let isAnswered = false;

    function animateScale(symbol) {
        const rotation = symbol === '>' ? -10 : (symbol === '<' ? 10 : 0);
        scaleBeam.style.transform = `rotate(${rotation}deg)`;
    }

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            if (isAnswered) return;

            const selectedSymbol = this.dataset.symbol;
            isAnswered = true;

            // Disable all buttons
            buttons.forEach(btn => btn.disabled = true);
            
            // Animate scale
            animateScale(selectedSymbol);

            // Send answer to server
            fetch('{{ route("games.lop4.phanso.balance.check") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    selected_symbol: selectedSymbol,
                    correct_symbol: correctSymbol
                })
            })
            .then(response => response.json())
            .then(data => {
                feedback.classList.remove('d-none', 'alert-success', 'alert-danger');
                
                if (data.correct) {
                    feedback.classList.add('alert-success');
                    feedback.innerHTML = 'Đúng rồi! 🎉';
                    
                    // If there's a next level, redirect after 1.5 seconds
                    if (data.next_level) {
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    }
                } else {
                    feedback.classList.add('alert-danger');
                    feedback.innerHTML = 'Chưa đúng. Hãy thử lại! 🤔';
                    
                    // Reset after 1.5 seconds
                    setTimeout(() => {
                        isAnswered = false;
                        buttons.forEach(btn => btn.disabled = false);
                        feedback.classList.add('d-none');
                        scaleBeam.style.transform = 'rotate(0deg)';
                    }, 1500);
                }
            });
        });
    });
});
</script>

<style>
.scale-beam {
    transition: transform 0.5s ease-in-out;
}
.comparison-btn {
    width: 60px;
    height: 60px;
}
.comparison-btn:hover {
    transform: scale(1.1);
}
.comparison-btn:active {
    transform: scale(0.95);
}
</style>
@endsection 