@extends('layouts.game')

@section('title', 'Dãy Số Quy Luật')

@section('game_content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Cấp độ <span id="levelNum"></span>/5</h3>
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
                        <button id="next-btn" class="btn btn-primary" style="display:none;"><i class="fas fa-arrow-right"></i> Tiếp tục</button>
                        <button id="reset-btn" class="btn btn-secondary"><i class="fas fa-redo"></i> Chơi lại</button>
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
    const totalLevels = 5;
    // Load saved or default to controller level-1
    let stored = parseInt(localStorage.getItem('patternLevel'), 10);
    const initial = isNaN(stored) ? {{ $question['level'] - 1 }} : stored;
    let currentLevel = initial;

    // Update UI
    const levelNum = document.getElementById('levelNum');
    const seq = document.querySelectorAll('.fraction-box');
    const progWidth = (currentLevel + 1) / totalLevels * 100;
    levelNum.textContent = currentLevel + 1;

    // Elements
    const form = document.getElementById('answer-form');
    const numInput = document.getElementById('numerator');
    const denInput = document.getElementById('denominator');
    const feedback = document.getElementById('feedback');
    const nextBtn = document.getElementById('next-btn');
    const resetBtn = document.getElementById('reset-btn');

    let answered = false;
    const correct = { numerator: {{ $question['answer']['numerator'] }}, denominator: {{ $question['answer']['denominator'] }} };

    form.addEventListener('submit', function(e) {
        e.preventDefault(); if (answered) return;
        const ans = { numerator: +numInput.value, denominator: +denInput.value };
        numInput.disabled = true; denInput.disabled = true; form.querySelector('button').disabled = true;
        answered = true;

        // Check locally
        if (ans.numerator===correct.numerator && ans.denominator===correct.denominator) {
            feedback.className = 'alert alert-success';
            feedback.textContent = 'Đúng rồi! 🎉';
            // advance
            if (currentLevel < totalLevels-1) {
                currentLevel++;
                localStorage.setItem('patternLevel', currentLevel);
                nextBtn.style.display='inline-block';
            }
        } else {
            feedback.className = 'alert alert-danger';
            feedback.textContent = 'Chưa đúng. 🤔';
            // allow retry after timeout
            setTimeout(()=>{
                answered=false;
                numInput.disabled=false; denInput.disabled=false; form.querySelector('button').disabled=false;
                numInput.value=''; denInput.value=''; feedback.classList.add('d-none');
            },1500);
        }
        feedback.classList.remove('d-none');
    });

    nextBtn.addEventListener('click', () => location.reload());
    resetBtn.addEventListener('click', () => {
        if(confirm('Chơi lại từ đầu?')){
            localStorage.removeItem('patternLevel');
            location.reload();
        }
    });
});
</script>

<style>
.fraction-box { position: relative; display:inline-block; }
.arrow-right{position:absolute; right:-25px; top:50%; transform:translateY(-50%);} 
.fraction-box:last-child .arrow-right{display:none;}
input[type=number]{width:80px;}
</style>
@endsection
