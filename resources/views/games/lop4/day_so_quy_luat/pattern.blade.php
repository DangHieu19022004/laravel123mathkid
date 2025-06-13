@extends('layouts.game')

@section('title', 'Dãy Số Quy Luật')

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
                        <h4>Tìm số tiếp theo trong dãy:</h4>
                    </div>

                    <!-- Pattern Sequence -->
                    <div class="row justify-content-center mb-5">
                        <div class="col-12">
                            <div class="d-flex justify-content-center align-items-center">
                                @foreach($question['sequence'] as $fraction)
                                    <div class="fraction-box mx-3 text-center">
                                        <div class="bg-light p-3 rounded shadow-sm">
                                            <span class="h4">
                                                <sup>{{ $fraction['numerator'] }}</sup>⁄<sub>{{ $fraction['denominator'] }}</sub>
                                            </span>
                                        </div>
                                        <div class="arrow-right">
                                            <i class="fas fa-arrow-right h4 text-primary"></i>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="fraction-box mx-3 text-center">
                                    <div class="bg-light p-3 rounded shadow-sm">
                                        <span class="h4">?</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Input Form -->
                    <form id="answer-form" class="mb-4">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="number" class="form-control" id="numerator" placeholder="Tử số" min="1" required>
                                    <div class="input-group-text">/</div>
                                    <input type="number" class="form-control" id="denominator" placeholder="Mẫu số" min="1" required>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-check"></i> Kiểm tra
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Pattern Hint -->
                    <div class="text-center mb-4">
                        <p class="text-muted">
                            <i class="fas fa-lightbulb"></i>
                            Gợi ý: Quan sát kỹ quy luật thay đổi của tử số và mẫu số
                        </p>
                    </div>

                    <!-- Feedback Message -->
                    <div id="feedback" class="alert d-none"></div>

                    <!-- Navigation Buttons -->
                    <div class="text-center mt-4">
                        <a href="{{ route('games.lop4.day_so_quy_luat.pattern.reset') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Chơi lại
                        </a>
                        <a href="{{ route('games.lop4.day_so_quy_luat.index') }}" class="btn btn-primary">
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
    const form = document.getElementById('answer-form');
    const numeratorInput = document.getElementById('numerator');
    const denominatorInput = document.getElementById('denominator');
    const feedback = document.getElementById('feedback');
    const correctAnswer = {
        numerator: {{ $question['answer']['numerator'] }},
        denominator: {{ $question['answer']['denominator'] }}
    };
    let isAnswered = false;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (isAnswered) return;

        const answer = {
            numerator: parseInt(numeratorInput.value),
            denominator: parseInt(denominatorInput.value)
        };

        // Disable form
        numeratorInput.disabled = true;
        denominatorInput.disabled = true;
        form.querySelector('button').disabled = true;
        isAnswered = true;

        // Send answer to server
        fetch('{{ route("games.lop4.day_so_quy_luat.pattern.check") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                answer: answer,
                correct_answer: correctAnswer
            })
        })
        .then(response => response.json())
        .then(data => {
            feedback.classList.remove('d-none', 'alert-success', 'alert-danger');
            
            if (data.correct) {
                feedback.classList.add('alert-success');
                feedback.innerHTML = 'Đúng rồi! Bạn đã tìm ra quy luật! 🎉';
                
                // If there's a next level, redirect after 1.5 seconds
                if (data.next_level) {
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                }
            } else {
                feedback.classList.add('alert-danger');
                feedback.innerHTML = 'Chưa đúng. Hãy quan sát kỹ quy luật và thử lại! 🤔';
                
                // Reset after 1.5 seconds
                setTimeout(() => {
                    isAnswered = false;
                    numeratorInput.disabled = false;
                    denominatorInput.disabled = false;
                    form.querySelector('button').disabled = false;
                    numeratorInput.value = '';
                    denominatorInput.value = '';
                    feedback.classList.add('d-none');
                }, 1500);
            }
        });
    });
});
</script>

<style>
.fraction-box {
    position: relative;
    display: inline-block;
}
.arrow-right {
    position: absolute;
    right: -25px;
    top: 50%;
    transform: translateY(-50%);
}
.fraction-box:last-child .arrow-right {
    display: none;
}
input[type="number"] {
    width: 80px;
}
</style>
@endsection 