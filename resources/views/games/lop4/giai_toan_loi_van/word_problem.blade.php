@extends('layouts.game')

@section('title', 'Giải Toán Lời Văn')

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
                        <h4>{{ $question['question'] }}</h4>
                    </div>

                    <!-- Options -->
                    <div class="row justify-content-center mb-4">
                        <div class="col-md-8">
                            <div class="list-group">
                                @foreach($question['options'] as $option)
                                    <button class="list-group-item list-group-item-action text-center option-btn" 
                                            data-answer="{{ $option }}">
                                        {{ $option }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Explanation -->
                    <div id="explanation" class="alert alert-info d-none">
                        <h5 class="alert-heading">Giải thích:</h5>
                        <p class="mb-0">{{ $question['explanation'] }}</p>
                    </div>

                    <!-- Feedback Message -->
                    <div id="feedback" class="alert d-none"></div>

                    <!-- Navigation Buttons -->
                    <div class="text-center mt-4">
                        <a href="{{ route('games.lop4.giai_toan_loi_van.word_problem.reset') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Chơi lại
                        </a>
                        <a href="{{ route('games.lop4.giai_toan_loi_van.index') }}" class="btn btn-primary">
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
    const optionButtons = document.querySelectorAll('.option-btn');
    const feedback = document.getElementById('feedback');
    const explanation = document.getElementById('explanation');
    const correctAnswer = '{{ $question['answer'] }}';
    let isAnswered = false;

    optionButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (isAnswered) return;

            const answer = this.dataset.answer;
            
            // Disable all buttons
            optionButtons.forEach(btn => btn.disabled = true);
            isAnswered = true;

            // Send answer to server
            fetch('{{ route("games.lop4.giai_toan_loi_van.word_problem.check") }}', {
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
                    feedback.innerHTML = 'Đúng rồi! Bạn đã giải đúng bài toán! 🎉';
                    this.classList.add('btn-success');
                    
                    // If there's a next level, redirect after 2 seconds
                    if (data.next_level) {
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }
                } else {
                    feedback.classList.add('alert-danger');
                    feedback.innerHTML = 'Chưa đúng. Hãy thử lại! 🤔';
                    this.classList.add('btn-danger');
                    
                    // Show explanation
                    explanation.classList.remove('d-none');
                    
                    // Reset after 2 seconds
                    setTimeout(() => {
                        isAnswered = false;
                        optionButtons.forEach(btn => {
                            btn.disabled = false;
                            btn.classList.remove('btn-success', 'btn-danger');
                        });
                        feedback.classList.add('d-none');
                        explanation.classList.add('d-none');
                    }, 2000);
                }
            });
        });
    });
});
</script>

<style>
.option-btn {
    transition: all 0.3s ease;
    font-size: 1.1rem;
    padding: 1rem;
}
.option-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.option-btn:disabled {
    cursor: not-allowed;
}
</style>
@endsection 