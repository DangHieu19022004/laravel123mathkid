@extends('layouts.game')

@section('title', 'Thành Phố Bị Lạc - Giải Toán Lời Văn Lớp 4')

@section('game_content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Thành Phố Bị Lạc</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <p class="lead">Điền số thích hợp vào chỗ trống để hoàn thiện các tên đường!</p>
                        <div id="level-display" class="mb-3">
                            <span class="badge bg-info">Cấp độ: <span id="current-level">{{ $question['level'] }}</span>/5</span>
                        </div>
                    </div>

                    <div id="game-container" class="mb-4">
                        <div id="city-map">
                            @foreach($question['streets'] as $index => $street)
                            <div class="street-container mb-4 p-3 border rounded">
                                <h5 class="street-name mb-2">
                                    <i class="fas fa-road me-2"></i>{{ $street['name'] }}
                                </h5>
                                <p class="street-description mb-3">{{ $street['description'] }}</p>
                                <div class="input-group mb-1">
                                    <input type="text" class="form-control street-input" data-index="{{ $index }}" placeholder="Điền số">
                                    <button type="button" class="btn btn-outline-secondary hint-btn" data-hint="{{ $street['hint'] }}">
                                        <i class="fas fa-lightbulb"></i>
                                    </button>
                                </div>
                                <div class="text-danger small hint-text d-none"></div>
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <button id="check-answer" class="btn btn-primary btn-lg">Kiểm tra</button>
                            <button id="next-level" class="btn btn-success btn-lg d-none">Tiếp theo</button>
                        </div>
                    </div>

                    <div class="progress mb-3">
                        <div id="progress-bar" class="progress-bar" role="progressbar" style="width: {{ ($question['level'] - 1) * 20 }}%"></div>
                    </div>

                    <div class="text-center mt-3">
                        <button id="reset-btn" class="btn btn-link">
                            <i class="fas fa-redo"></i> Chơi lại từ đầu
                        </button>
                        <a href="{{ route('games.lop4.giai_toan_loi_van.index') }}" class="btn btn-link">
                            ← Quay lại danh sách
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
    const totalLevels = 5;
    // Lấy level từ localStorage hoặc fallback
    let stored = parseInt(localStorage.getItem('lostCityLevel'), 10);
    let currentLevel = isNaN(stored) ? ({{ $question['level'] }} - 1) : stored;

    // Cập nhật hiển thị
    document.getElementById('current-level').textContent = currentLevel + 1;
    document.getElementById('progress-bar').style.width = (currentLevel * 20) + '%';

    // Xác định xem có cần %
    const percentMap = @json(array_map(fn($s) => str_ends_with($s['answer'], '%'), $question['streets']));

    // Hint button
    document.querySelectorAll('.hint-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            Swal.fire({ icon: 'info', title: 'Gợi ý', text: btn.dataset.hint });
        });
    });

    // Kiểm tra đáp án
    document.getElementById('check-answer').addEventListener('click', () => {
        const answers = {};
        document.querySelectorAll('.street-input').forEach(input => {
            let raw = input.value.trim();
            let val = raw.replace(/[^0-9%]/g, '');
            const idx = parseInt(input.dataset.index, 10);
            if (percentMap[idx] && val && !val.endsWith('%')) val += '%';
            answers[idx] = val;
        });
        fetch('{{ route("games.lop4.giai_toan_loi_van.lost_city.check") }}', {
            method: 'POST', headers: {'Content-Type': 'application/json','X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: JSON.stringify({ answers })
        })
        .then(res => res.json())
        .then(data => {
            if (data.correct) {
                Swal.fire({ icon: 'success', title: 'Chính xác!', text: 'Bạn đã hoàn thành cấp độ này!' })
                .then(() => {
                    if (data.next_level) {
                        currentLevel++;
                        localStorage.setItem('lostCityLevel', currentLevel);
                        document.getElementById('check-answer').classList.add('d-none');
                        document.getElementById('next-level').classList.remove('d-none');
                    } else {
                        Swal.fire({ icon: 'success', title: 'Hoàn thành!', text: 'Bạn đã hoàn thành tất cả cấp độ!', confirmButtonText: 'Chơi lại' })
                        .then(() => {
                            localStorage.removeItem('lostCityLevel');
                            window.location.reload();
                        });
                    }
                });
            } else {
                Swal.fire({ icon: 'error', title: 'Chưa đúng!', text: 'Hãy thử lại!' });
            }
        });
    });

    // Next level
    document.getElementById('next-level').addEventListener('click', () => window.location.reload());
    // Reset
    document.getElementById('reset-btn').addEventListener('click', () => {
        if (confirm('Bạn có muốn chơi lại từ đầu?')) {
            localStorage.removeItem('lostCityLevel');
            window.location.reload();
        }
    });
});
</script>
@endsection
