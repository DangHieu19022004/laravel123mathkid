@extends('layouts.app')
@section('content')
<div class="container" style="max-width: 500px; margin: 0 auto;">
    <h2 class="mb-4 text-center">So sánh dung tích</h2>
    <div class="mb-3 text-center">
        <strong>
            @if($question['type'] === 'max')
                Chọn vật <span style="color: #007bff">có dung tích lớn nhất</span>:
            @else
                Chọn vật <span style="color: #007bff">có dung tích nhỏ nhất</span>:
            @endif
        </strong>
    </div>
    <div class="row justify-content-center">
        @foreach($question['objects'] as $i => $obj)
            <div class="col-12 mb-4">
                <button class="choose-btn btn w-100 py-4 d-flex flex-column align-items-center justify-content-center object-btn" data-index="{{$i}}" style="background: #e0f7fa; border: none; border-radius: 18px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); transition: box-shadow 0.2s;">
                    <div style="font-size: 3.2rem; line-height: 1;">{{$obj['emoji']}}</div>
                    <div style="font-size: 1.2rem; font-weight: 600; margin-top: 10px; color: #222;">{{$obj['object']}}</div>
                    <div style="font-size: 1rem; color: #666; margin-top: 2px;">{{$obj['volume']}} {{$obj['unit']}}</div>
                </button>
            </div>
        @endforeach
    </div>
    <div id="result" class="text-center mt-3" style="font-size: 1.2rem; min-height: 48px;"></div>
    <div class="text-center mt-4">
        <button id="next-btn" class="btn btn-primary" style="display:none;">Câu hỏi khác</button>
    </div>
    <div id="toast" style="position: fixed; top: 32px; right: 32px; z-index: 9999; min-width: 220px; display: none;"></div>
</div>
<script>
    const answerIndex = {{ $question['answer_index'] }};
    let answered = false;
    function showToast(html, bg) {
        const toast = document.getElementById('toast');
        toast.innerHTML = html;
        toast.style.background = bg;
        toast.style.display = 'block';
        toast.style.color = '#222';
        toast.style.borderRadius = '12px';
        toast.style.padding = '18px 28px';
        toast.style.boxShadow = '0 4px 16px rgba(0,0,0,0.10)';
        setTimeout(() => { toast.style.display = 'none'; }, 1500);
    }
    document.querySelectorAll('.choose-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if(answered) return;
            const idx = parseInt(this.getAttribute('data-index'));
            if(idx === answerIndex) {
                answered = true;
                this.style.borderColor = '#28a745';
                showToast('<span style="font-size:2rem;">🎉</span> <span style="color:#009688;font-weight:600;">Chính xác! Bạn thật giỏi!</span>', '#e0f7fa');
                document.getElementById('next-btn').style.display = 'inline-block';
            } else {
                this.style.borderColor = '#dc3545';
                showToast('<span style="font-size:2rem;">😢</span> <span style="color:#d32f2f;font-weight:600;">Chưa đúng, hãy thử lại!</span>', '#ffebee');
                document.getElementById('next-btn').style.display = 'none';
            }
        });
    });
    document.getElementById('next-btn').onclick = function() {
        window.location.reload();
    };
</script>
<style>
    .object-btn:hover, .object-btn:focus {
        box-shadow: 0 4px 16px rgba(0,188,212,0.15);
        background: #b2ebf2;
    }
</style>
@endsection 