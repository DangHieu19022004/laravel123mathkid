@extends('layouts.app')
@section('content')
<div class="container" style="max-width: 500px; margin: 0 auto;">

    <!-- Level Progress Bar -->
    <div class="level-progress mb-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h4 class="mb-0">Cấp độ <span id="levelNum">1</span>/5</h4>
            <div class="progress" style="width: 70%; height: 10px;">
                <div id="progBar" class="progress-bar bg-primary" role="progressbar"
                     style="width: 0%;"
                     aria-valuenow="0"
                     aria-valuemin="0"
                     aria-valuemax="100">
                </div>
            </div>
        </div>
    </div>

    <h2 class="mb-4 text-center">So sánh dung tích</h2>
    <div class="mb-3 text-center">
        <strong>
            @if($question['type'] === 'max')
                Chọn vật <span class="text-primary">có dung tích lớn nhất</span>:
            @else
                Chọn vật <span class="text-primary">có dung tích nhỏ nhất</span>:
            @endif
        </strong>
    </div>
    <div class="row justify-content-center">
        @foreach($question['objects'] as $i => $obj)
            <div class="col-12 mb-4">
                <button
                  class="choose-btn btn w-100 py-4 d-flex flex-column align-items-center object-btn"
                  data-index="{{ $i }}"
                  style="background: #e0f7fa; border: none; border-radius: 18px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); transition: box-shadow 0.2s;">
                    <div style="font-size: 3.2rem; line-height: 1;">{{ $obj['emoji'] }}</div>
                    <div class="fw-semibold mt-2" style="font-size: 1.2rem; color: #222;">{{ $obj['object'] }}</div>
                    <div class="text-secondary" style="font-size: 1rem;">{{ $obj['volume'] }} {{ $obj['unit'] }}</div>
                </button>
            </div>
        @endforeach
    </div>

    <div id="result" class="text-center mt-3" style="font-size: 1.2rem; min-height: 48px;"></div>

    <div class="text-center mt-4">
        <button id="next-btn" class="btn btn-primary" style="display:none;">Tiếp tục</button>
        <button id="resetGame" class="btn btn-secondary">Chơi lại</button>
    </div>
    <div id="toast" style="position: fixed; top: 32px; right: 32px; z-index: 9999; min-width: 220px; display: none;"></div>
</div>

<script>
    // Khởi tạo cấp độ mặc định từ Blade vào JS
    const initialLevel = @json($question['level'] ?? 1) - 1;
    const totalLevels = 5;
    let currentLevel = parseInt(localStorage.getItem('volumeMeasurementLevel') || initialLevel, 10);

    // Cập nhật hiển thị cấp độ và thanh tiến độ
    const levelNumEl = document.getElementById('levelNum');
    const progBarEl  = document.getElementById('progBar');
    const display    = currentLevel + 1;
    const percent    = (display / totalLevels) * 100;
    levelNumEl.textContent = display;
    progBarEl.style.width  = percent + '%';
    progBarEl.setAttribute('aria-valuenow', percent);

    // Logic chọn đáp án
    let answered      = false;
    const answerIndex = @json($question['answer_index']);
    const nextBtn     = document.getElementById('next-btn');

    function showToast(html, bg) {
        const toast = document.getElementById('toast');
        toast.innerHTML        = html;
        toast.style.background = bg;
        toast.style.display    = 'block';
        toast.style.color      = '#222';
        toast.style.borderRadius = '12px';
        toast.style.padding     = '18px 28px';
        toast.style.boxShadow   = '0 4px 16px rgba(0,0,0,0.10)';
        setTimeout(() => { toast.style.display = 'none'; }, 1500);
    }

    document.querySelectorAll('.choose-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (answered) return;
            const idx = parseInt(this.dataset.index, 10);
            if (idx === answerIndex) {
                answered = true;
                this.style.border = '2px solid #28a745';
                showToast('🎉 <strong class="text-success">Chính xác!</strong>', '#e0f7fa');

                if (display < totalLevels) {
                    currentLevel++;
                    localStorage.setItem('volumeMeasurementLevel', currentLevel);
                    nextBtn.style.display = 'inline-block';
                }
            } else {
                this.style.border = '2px solid #dc3545';
                showToast('😢 <strong class="text-danger">Chưa đúng, thử lại!</strong>', '#ffebee');
                nextBtn.style.display = 'none';
            }
        });
    });

    // Nút Tiếp tục
    nextBtn.addEventListener('click', () => {
        window.location.href = '{{ route("games.lop4.dailuongvadoluong.volume_measurement") }}';
    });

    // Nút chơi lại
    document.getElementById('resetGame').addEventListener('click', () => {
        if (confirm('Bạn chắc chắn muốn chơi lại từ đầu?')) {
            localStorage.removeItem('volumeMeasurementLevel');
            window.location.href = '{{ route("games.lop4.dailuongvadoluong.volume_measurement") }}';
        }
    });
</script>

<style>
.object-btn:hover, .object-btn:focus {
    box-shadow: 0 4px 16px rgba(0,188,212,0.15);
    background: #b2ebf2;
}
.level-progress {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}
.progress {
    background-color: #e9ecef;
    border-radius: 5px;
}
.progress-bar {
    transition: width 0.3s ease;
}
</style>
@endsection
