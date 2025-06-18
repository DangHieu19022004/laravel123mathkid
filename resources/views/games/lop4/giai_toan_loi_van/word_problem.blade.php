@extends('layouts.game')

@section('title', 'Giải Toán Lời Văn')

@section('game_content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow">
        <div class="card-header bg-primary text-white">
          <h3 class="mb-0">Cấp độ <span id="current-level">{{ $question['level'] }}</span>/5</h3>
        </div>
        <div class="card-body">
          <!-- Progress Bar -->
          <div class="progress mb-4" style="height: 10px;">
            <div id="progress-bar" class="progress-bar bg-success" role="progressbar"
                 style="width: {{ ($question['level'] - 1) * 25 }}%"
                 aria-valuenow="{{ ($question['level'] - 1) * 25 }}"
                 aria-valuemin="0" aria-valuemax="100"></div>
          </div>

          <!-- Difficulty Indicator -->
          <div class="difficulty-indicator mb-4">
            <div class="d-flex justify-content-between align-items-center">
              <span class="text-muted">Độ khó:</span>
              <div class="stars">
                @for($i = 1; $i <= 5; $i++)
                  <i class="fas fa-star {{ $i <= $question['level'] ? 'text-warning' : 'text-muted' }}"></i>
                @endfor
              </div>
            </div>
          </div>

          <!-- Question Text -->
          <div class="text-center mb-4">
            <h4 class="question-text">{{ $question['question'] }}</h4>
          </div>

          <!-- Options -->
          <div class="row justify-content-center mb-4">
            <div class="col-md-8">
              <div id="options-container" class="list-group">
                @foreach($question['options'] as $option)
                  <button class="list-group-item list-group-item-action text-center option-btn"
                          data-answer="{{ $option }}">{{ $option }}</button>
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
            <button id="next-btn" class="btn btn-success d-none">
              <i class="fas fa-arrow-right"></i> Tiếp theo
            </button>
            <button id="reset-btn" class="btn btn-secondary">
              <i class="fas fa-redo"></i> Chơi lại từ đầu
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const level = {{ $question['level'] }};
    document.getElementById('current-level').textContent = level;

    const progressBar = document.getElementById('progress-bar');
    progressBar.style.width = ((level - 1) * 25) + '%';

    document.querySelectorAll('.stars .fa-star').forEach((star, idx) => {
      star.classList.toggle('text-warning', idx < level);
      star.classList.toggle('text-muted', idx >= level);
    });

    const optionButtons = document.querySelectorAll('.option-btn');
    const feedback = document.getElementById('feedback');
    const explanation = document.getElementById('explanation');
    const nextBtn = document.getElementById('next-btn');
    const resetBtn = document.getElementById('reset-btn');
    const correctAnswer = "{{ $question['answer'] }}";

    optionButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        if (btn.disabled) return;
        optionButtons.forEach(b => b.disabled = true);
        const answer = btn.dataset.answer;

        fetch('{{ route("games.lop4.giai_toan_loi_van.word_problem.check") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ answer, correct_answer: correctAnswer })
        })
        .then(res => res.json())
        .then(data => {
          feedback.classList.remove('d-none', 'alert-success', 'alert-danger');
          if (data.correct) {
            feedback.classList.add('alert-success');
            feedback.textContent = 'Đúng rồi! 🎉';
            btn.classList.add('btn-success');
            explanation.classList.remove('d-none');
            if (data.next_level) nextBtn.classList.remove('d-none');
            else resetBtn.textContent = 'Chơi lại từ đầu';
          } else {
            feedback.classList.add('alert-danger');
            feedback.textContent = 'Chưa đúng. 🤔';
            btn.classList.add('btn-danger');
            explanation.classList.add('d-none');
            setTimeout(() => {
              feedback.classList.add('d-none');
              optionButtons.forEach(b => {
                b.disabled = false;
                b.classList.remove('btn-success','btn-danger');
              });
            }, 1500);
          }
        });
      });
    });

    nextBtn.addEventListener('click', () => window.location.reload());
    resetBtn.addEventListener('click', () => {
      if (confirm('Chơi lại từ đầu?')) location.reload();
    });
  });
</script>

<style>
  .option-btn { transition: all .3s ease; padding: 1rem; }
  .option-btn:hover:not(:disabled) { background-color: #f0f8ff; }
  .option-btn:disabled { opacity: .6; cursor: not-allowed; }
  .progress { background-color: #e9ecef; border-radius: .25rem; }
  .difficulty-indicator { background-color: #f8f9fa; padding: .5rem 1rem; border-radius: .25rem; }
  .stars { font-size: 1.2rem; }
</style>
@endsection
