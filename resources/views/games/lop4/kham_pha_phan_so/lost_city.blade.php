@extends('layouts.game')

@section('title', 'Thành Phố Bị Lạc - Phân Số Lớp 4')

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
                        <div class="row">
                            <div class="col-12">
                                <div id="city-map" class="position-relative">
                                    @foreach($question['streets'] as $street)
                                    <div class="street-container mb-4 p-3 border rounded">
                                        <h5 class="street-name mb-3">
                                            <i class="fas fa-road me-2"></i>{{ $street['name'] }}
                                        </h5>
                                        <div class="street-description mb-3">
                                            {{ $street['description'] }}
                                        </div>
                                        <div class="input-group">
                                            <input type="number" class="form-control street-input" 
                                                data-id="{{ $street['id'] }}" placeholder="Điền số">
                                            <button class="btn btn-outline-secondary hint-btn" type="button"
                                                data-hint="{{ $street['hint'] }}">
                                                <i class="fas fa-lightbulb"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button id="check-answer" class="btn btn-primary btn-lg">
                                Kiểm tra
                            </button>
                            <button id="next-level" class="btn btn-success btn-lg d-none">
                                Tiếp theo
                            </button>
                        </div>
                    </div>

                    <div class="progress mb-3">
                        <div id="progress-bar" class="progress-bar" role="progressbar" 
                             style="width: {{ ($question['level'] - 1) * 20 }}%"></div>
                    </div>

                    <!-- Controls -->
                    <div class="text-center mt-4">
                        <form action="{{ route('games.lop4.phanso.lost_city.reset') }}" method="GET" class="d-inline">
                            <button type="submit" class="btn btn-link text-decoration-none">
                                Chơi lại từ đầu
                            </button>
                        </form>

                        <a href="{{ route('games.lop4.phanso') }}" class="btn btn-link text-decoration-none">
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
    $(document).ready(function() {
        // Add custom styles
        $('<style>')
            .text(`
                .street-container {
                    background-color: #f8f9fa;
                    transition: all 0.3s ease;
                }
                .street-container:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                }
                .street-name {
                    color: #2196f3;
                }
                .hint-btn:hover {
                    background-color: #e3f2fd;
                }
            `)
            .appendTo('head');

        // Handle hint button clicks
        $('.hint-btn').click(function() {
            const hint = $(this).data('hint');
            Swal.fire({
                icon: 'info',
                title: 'Gợi ý',
                text: hint
            });
        });

        // Handle check answer button
        $('#check-answer').click(function() {
            const answers = {};
            $('.street-input').each(function() {
                const id = $(this).data('id');
                answers[id - 1] = $(this).val();
            });

            $.ajax({
                url: '{{ route("games.lop4.phanso.lost_city.check") }}',
                method: 'POST',
                data: {
                    answers: answers,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.correct) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Chính xác!',
                            text: 'Bạn đã tìm đúng tất cả các con số!'
                        }).then(() => {
                            if (response.next_level) {
                                $('#check-answer').addClass('d-none');
                                $('#next-level').removeClass('d-none');
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Chúc mừng!',
                                    text: 'Bạn đã hoàn thành tất cả các cấp độ!',
                                    confirmButtonText: 'Chơi lại'
                                }).then(() => {
                                    window.location.href = '{{ route("games.lop4.phanso.lost_city.reset") }}';
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Chưa đúng!',
                            text: 'Hãy thử lại nhé!'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Có lỗi xảy ra',
                        text: 'Vui lòng thử lại sau!'
                    });
                }
            });
        });

        // Handle next level button
        $('#next-level').click(function() {
            window.location.reload();
        });

        // Handle enter key
        $('.street-input').keypress(function(e) {
            if(e.which == 13) {
                $('#check-answer').click();
            }
        });

        let currentLevel = parseInt(localStorage.getItem('lostCityLevel') || '0');
        const totalLevels = 5;

        // Thêm logic chuyển cấp, lưu localStorage, reset tương tự mẫu conversion_table
    });
</script>
@endsection 