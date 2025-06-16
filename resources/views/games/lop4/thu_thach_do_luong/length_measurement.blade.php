@extends('layouts.app')
@section('content')
<div class="container" style="max-width: 500px; margin: 0 auto;">
    <h2 class="mb-4 text-center">So sánh độ dài</h2>
    <div class="mb-3 text-center">
        <strong>
            @if($question['type'] === 'max')
                Chọn vật <span style="color: #007bff">dài nhất</span>:
            @else
                Chọn vật <span style="color: #007bff">ngắn nhất</span>:
            @endif
        </strong>
    </div>
    <div class="row justify-content-center">
        @foreach($question['objects'] as $i => $obj)
            <div class="col-12 mb-4">
                <button class="choose-btn btn w-100 py-4 d-flex flex-column align-items-center justify-content-center object-btn" data-index="{{$i}}" style="background: #e3f2fd; border: none; border-radius: 18px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); transition: box-shadow 0.2s;">
                    <div style="font-size: 3.2rem; line-height: 1;">{{$obj['emoji']}}</div>
                    <div style="font-size: 1.2rem; font-weight: 600; margin-top: 10px; color: #222;">{{$obj['object']}}</div>
                    <div style="font-size: 1rem; color: #666; margin-top: 2px;">{{$obj['length']}} {{$obj['unit']}}</div>
                </button>
            </div>
        @endforeach
    </div>
    <div id="result" class="text-center mt-3" style="font-size: 1.2rem;"></div>
    <div class="text-center mt-4">
        <button id="next-btn" class="btn btn-primary" style="display:none;">Câu hỏi khác</button>
    </div>
</div>
<script>
    const answerIndex = {{ $question['answer_index'] }};
    let answered = false;
    document.querySelectorAll('.choose-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if(answered) return;
            answered = true;
            const idx = parseInt(this.getAttribute('data-index'));
            if(idx === answerIndex) {
                this.style.borderColor = '#28a745';
                document.getElementById('result').innerHTML = '🎉 Đúng rồi!';
            } else {
                this.style.borderColor = '#dc3545';
                document.getElementById('result').innerHTML = '❌ Chưa đúng. Hãy thử lại!';
            }
            document.getElementById('next-btn').style.display = 'inline-block';
        });
    });
    document.getElementById('next-btn').onclick = function() {
        window.location.reload();
    };
</script>
<style>
    .object-btn:hover, .object-btn:focus {
        box-shadow: 0 4px 16px rgba(33,150,243,0.15);
        background: #bbdefb;
    }
</style>
@endsection 