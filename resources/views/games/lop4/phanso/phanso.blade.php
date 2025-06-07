@extends('layouts.game')

@section('title', 'Trò Chơi Phân Số - Lớp 4')

@section('game_content')
<div class="container py-5">
    <div class="row">
        <!-- Cake Game -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 mb-3">🍰</div>
                    <h5 class="card-title">Chia Bánh</h5>
                    <p class="card-text">Tập chia bánh thành các phần bằng nhau và tô màu theo phân số.</p>
                    <div class="mt-3">
                        <span class="badge bg-info me-1">Trực quan</span>
                        <span class="badge bg-warning me-1">Tô màu</span>
                    </div>
                    <div class="progress mt-3" style="height: 10px;">
                        @php
                            $cakeLevel = session('cake_level', 1);
                            $cakeProgress = ($cakeLevel - 1) * 20;
                        @endphp
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $cakeProgress }}%"></div>
                    </div>
                    <p class="mt-2 small text-muted">Cấp độ {{ $cakeLevel }}/5</p>
                    <a href="{{ route('games.lop4.phanso.cake') }}" class="btn btn-primary mt-3">
                        {{ $cakeLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Apple Game -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 mb-3">🍎</div>
                    <h5 class="card-title">Chia Táo</h5>
                    <p class="card-text">Chia số táo cho số học sinh để hiểu về phân số.</p>
                    <div class="mt-3">
                        <span class="badge bg-info me-1">Chia đều</span>
                        <span class="badge bg-warning me-1">Thực tế</span>
                    </div>
                    <div class="progress mt-3" style="height: 10px;">
                        @php
                            $appleLevel = session('apple_level', 1);
                            $appleProgress = ($appleLevel - 1) * 20;
                        @endphp
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $appleProgress }}%"></div>
                    </div>
                    <p class="mt-2 small text-muted">Cấp độ {{ $appleLevel }}/5</p>
                    <a href="{{ route('games.lop4.phanso.apple') }}" class="btn btn-primary mt-3">
                        {{ $appleLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Bracket Game -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 mb-3">🎯</div>
                    <h5 class="card-title">Biểu Thức</h5>
                    <p class="card-text">Tính giá trị biểu thức phân số có dấu ngoặc.</p>
                    <div class="mt-3">
                        <span class="badge bg-info me-1">Tính toán</span>
                        <span class="badge bg-warning me-1">Dấu ngoặc</span>
                    </div>
                    <div class="progress mt-3" style="height: 10px;">
                        @php
                            $bracketLevel = session('bracket_level', 1);
                            $bracketProgress = ($bracketLevel - 1) * 20;
                        @endphp
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $bracketProgress }}%"></div>
                    </div>
                    <p class="mt-2 small text-muted">Cấp độ {{ $bracketLevel }}/5</p>
                    <a href="{{ route('games.lop4.phanso.bracket') }}" class="btn btn-primary mt-3">
                        {{ $bracketLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Garden Game -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 mb-3">🌺</div>
                    <h5 class="card-title">Vườn Hoa</h5>
                    <p class="card-text">Rút gọn phân số qua việc chăm sóc vườn hoa.</p>
                    <div class="mt-3">
                        <span class="badge bg-info me-1">Rút gọn</span>
                        <span class="badge bg-warning me-1">Trực quan</span>
                    </div>
                    <div class="progress mt-3" style="height: 10px;">
                        @php
                            $gardenLevel = session('garden_level', 1);
                            $gardenProgress = ($gardenLevel - 1) * 20;
                        @endphp
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $gardenProgress }}%"></div>
                    </div>
                    <p class="mt-2 small text-muted">Cấp độ {{ $gardenLevel }}/5</p>
                    <a href="{{ route('games.lop4.phanso.garden') }}" class="btn btn-primary mt-3">
                        {{ $gardenLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Tower Game -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 mb-3">🏰</div>
                    <h5 class="card-title">Xây Tháp</h5>
                    <p class="card-text">Sắp xếp các phân số theo thứ tự tăng dần để xây tháp.</p>
                    <div class="mt-3">
                        <span class="badge bg-info me-1">Sắp xếp</span>
                        <span class="badge bg-warning me-1">So sánh</span>
                    </div>
                    <div class="progress mt-3" style="height: 10px;">
                        @php
                            $towerLevel = session('tower_level', 1);
                            $towerProgress = ($towerLevel - 1) * 20;
                        @endphp
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $towerProgress }}%"></div>
                    </div>
                    <p class="mt-2 small text-muted">Cấp độ {{ $towerLevel }}/5</p>
                    <a href="{{ route('games.lop4.phanso.tower') }}" class="btn btn-primary mt-3">
                        {{ $towerLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Cards Game -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 mb-3">🃏</div>
                    <h5 class="card-title">Thẻ Bài</h5>
                    <p class="card-text">Ghép các thẻ bài chứa phân số bằng nhau.</p>
                    <div class="mt-3">
                        <span class="badge bg-info me-1">Ghép đôi</span>
                        <span class="badge bg-warning me-1">Phân số bằng nhau</span>
                    </div>
                    <div class="progress mt-3" style="height: 10px;">
                        @php
                            $cardsLevel = session('cards_level', 1);
                            $cardsProgress = ($cardsLevel - 1) * 20;
                        @endphp
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $cardsProgress }}%"></div>
                    </div>
                    <p class="mt-2 small text-muted">Cấp độ {{ $cardsLevel }}/5</p>
                    <a href="{{ route('games.lop4.phanso.cards') }}" class="btn btn-primary mt-3">
                        {{ $cardsLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Compare Game -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 mb-3">⚖️</div>
                    <h5 class="card-title">Ai Nhiều Hơn?</h5>
                    <p class="card-text">So sánh hai phân số để tìm ra giá trị lớn hơn.</p>
                    <div class="mt-3">
                        <span class="badge bg-info me-1">So sánh</span>
                        <span class="badge bg-warning me-1">Quy đồng</span>
                    </div>
                    <div class="progress mt-3" style="height: 10px;">
                        @php
                            $compareLevel = session('compare_level', 1);
                            $compareProgress = ($compareLevel - 1) * 20;
                        @endphp
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $compareProgress }}%"></div>
                    </div>
                    <p class="mt-2 small text-muted">Cấp độ {{ $compareLevel }}/5</p>
                    <a href="{{ route('games.lop4.phanso.compare') }}" class="btn btn-primary mt-3">
                        {{ $compareLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Division Game -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 mb-3">➗</div>
                    <h5 class="card-title">Phép Chia</h5>
                    <p class="card-text">Liên hệ giữa phép chia và phân số.</p>
                    <div class="mt-3">
                        <span class="badge bg-info me-1">Phép chia</span>
                        <span class="badge bg-warning me-1">Chuyển đổi</span>
                    </div>
                    <div class="progress mt-3" style="height: 10px;">
                        @php
                            $divisionLevel = session('division_level', 1);
                            $divisionProgress = ($divisionLevel - 1) * 20;
                        @endphp
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $divisionProgress }}%"></div>
                    </div>
                    <p class="mt-2 small text-muted">Cấp độ {{ $divisionLevel }}/5</p>
                    <a href="{{ route('games.lop4.phanso.division') }}" class="btn btn-primary mt-3">
                        {{ $divisionLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Fair Share Game -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 mb-3">🤝</div>
                    <h5 class="card-title">Chia Đều</h5>
                    <p class="card-text">Học cách chia đều các vật thể thành phân số.</p>
                    <div class="mt-3">
                        <span class="badge bg-info me-1">Chia đều</span>
                        <span class="badge bg-warning me-1">Trực quan</span>
                    </div>
                    <div class="progress mt-3" style="height: 10px;">
                        @php
                            $fairShareLevel = session('fair_share_level', 1);
                            $fairShareProgress = ($fairShareLevel - 1) * 20;
                        @endphp
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $fairShareProgress }}%"></div>
                    </div>
                    <p class="mt-2 small text-muted">Cấp độ {{ $fairShareLevel }}/5</p>
                    <a href="{{ route('games.lop4.phanso.fair_share') }}" class="btn btn-primary mt-3">
                        {{ $fairShareLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Balance Game -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 mb-3">⚖️</div>
                    <h5 class="card-title">Cân Bằng Hai Bên</h5>
                    <p class="card-text">So sánh hai biểu thức phân số bằng cách chọn dấu >, < hoặc =.</p>
                    <div class="mt-3">
                        <span class="badge bg-info me-1">Tư duy</span>
                        <span class="badge bg-warning me-1">So sánh</span>
                    </div>
                    <div class="progress mt-3" style="height: 10px;">
                        @php
                            $balanceLevel = session('balance_level', 1);
                            $balanceProgress = ($balanceLevel - 1) * 20;
                        @endphp
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $balanceProgress }}%"></div>
                    </div>
                    <p class="mt-2 small text-muted">Cấp độ {{ $balanceLevel }}/5</p>
                    <a href="{{ route('games.lop4.phanso.balance') }}" class="btn btn-primary mt-3">
                        {{ $balanceLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Pattern Game -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 mb-3">🎯</div>
                    <h5 class="card-title">Tâm Nhảy Phân Số</h5>
                    <p class="card-text">Tìm ra quy luật và điền phân số tiếp theo trong dãy số.</p>
                    <div class="mt-3">
                        <span class="badge bg-info me-1">Quy luật</span>
                        <span class="badge bg-warning me-1">Dự đoán</span>
                    </div>
                    <div class="progress mt-3" style="height: 10px;">
                        @php
                            $patternLevel = session('pattern_level', 1);
                            $patternProgress = ($patternLevel - 1) * 20;
                        @endphp
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $patternProgress }}%"></div>
                    </div>
                    <p class="mt-2 small text-muted">Cấp độ {{ $patternLevel }}/5</p>
                    <a href="{{ route('games.lop4.phanso.pattern') }}" class="btn btn-primary mt-3">
                        {{ $patternLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Word Problem Game -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 mb-3">📚</div>
                    <h5 class="card-title">Bài Toán Có Lời Văn</h5>
                    <p class="card-text">Giải các bài toán thực tế liên quan đến phân số.</p>
                    <div class="mt-3">
                        <span class="badge bg-info me-1">Ứng dụng</span>
                        <span class="badge bg-warning me-1">Thực tế</span>
                    </div>
                    <div class="progress mt-3" style="height: 10px;">
                        @php
                            $wordProblemLevel = session('word_problem_level', 1);
                            $wordProblemProgress = ($wordProblemLevel - 1) * 20;
                        @endphp
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $wordProblemProgress }}%"></div>
                    </div>
                    <p class="mt-2 small text-muted">Cấp độ {{ $wordProblemLevel }}/5</p>
                    <a href="{{ route('games.lop4.phanso.word_problem') }}" class="btn btn-primary mt-3">
                        {{ $wordProblemLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Sky Game -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 mb-3">🌤️</div>
                    <h5 class="card-title">Bầu Trời Phân Số</h5>
                    <p class="card-text">Tìm các phân số bằng nhau trên bầu trời.</p>
                    <div class="mt-3">
                        <span class="badge bg-info me-1">Phân số bằng nhau</span>
                        <span class="badge bg-warning me-1">Tương đương</span>
                    </div>
                    <div class="progress mt-3" style="height: 10px;">
                        @php
                            $skyLevel = session('sky_level', 1);
                            $skyProgress = ($skyLevel - 1) * 20;
                        @endphp
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $skyProgress }}%"></div>
                    </div>
                    <p class="mt-2 small text-muted">Cấp độ {{ $skyLevel }}/5</p>
                    <a href="{{ route('games.lop4.phanso.sky') }}" class="btn btn-primary mt-3">
                        {{ $skyLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Remaining Cake Game -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 mb-3">🍰</div>
                    <h5 class="card-title">Miếng Bánh Còn Lại</h5>
                    <p class="card-text">Tính phần bánh còn lại sau khi ăn.</p>
                    <div class="mt-3">
                        <span class="badge bg-info me-1">Phép trừ</span>
                        <span class="badge bg-warning me-1">Trực quan</span>
                    </div>
                    <div class="progress mt-3" style="height: 10px;">
                        @php
                            $remainingCakeLevel = session('remaining_cake_level', 1);
                            $remainingCakeProgress = ($remainingCakeLevel - 1) * 20;
                        @endphp
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $remainingCakeProgress }}%"></div>
                    </div>
                    <p class="mt-2 small text-muted">Cấp độ {{ $remainingCakeLevel }}/5</p>
                    <a href="{{ route('games.lop4.phanso.remaining_cake') }}" class="btn btn-primary mt-3">
                        {{ $remainingCakeLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Sentence Game -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 mb-3">📝</div>
                    <h5 class="card-title">Ghép Câu Phân Số</h5>
                    <p class="card-text">Ghép các từ để tạo câu về phân số.</p>
                    <div class="mt-3">
                        <span class="badge bg-info me-1">Ngôn ngữ</span>
                        <span class="badge bg-warning me-1">Ứng dụng</span>
                    </div>
                    <div class="progress mt-3" style="height: 10px;">
                        @php
                            $sentenceLevel = session('sentence_level', 1);
                            $sentenceProgress = ($sentenceLevel - 1) * 20;
                        @endphp
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $sentenceProgress }}%"></div>
                    </div>
                    <p class="mt-2 small text-muted">Cấp độ {{ $sentenceLevel }}/5</p>
                    <a href="{{ route('games.lop4.phanso.sentence') }}" class="btn btn-primary mt-3">
                        {{ $sentenceLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Word Hunt Game -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 mb-3">🔍</div>
                    <h5 class="card-title">Săn Cụm Từ Phân Số</h5>
                    <p class="card-text">Tìm các phân số bằng nhau theo gợi ý.</p>
                    <div class="mt-3">
                        <span class="badge bg-info me-1">Tìm kiếm</span>
                        <span class="badge bg-warning me-1">Phân số bằng nhau</span>
                    </div>
                    <div class="progress mt-3" style="height: 10px;">
                        @php
                            $wordHuntLevel = session('word_hunt_level', 1);
                            $wordHuntProgress = ($wordHuntLevel - 1) * 20;
                        @endphp
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $wordHuntProgress }}%"></div>
                    </div>
                    <p class="mt-2 small text-muted">Cấp độ {{ $wordHuntLevel }}/5</p>
                    <a href="{{ route('games.lop4.phanso.word_hunt') }}" class="btn btn-primary mt-3">
                        {{ $wordHuntLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Lost City Game -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 mb-3">🏛️</div>
                    <h5 class="card-title">Thành Phố Bị Lạc</h5>
                    <p class="card-text">Điền số thích hợp vào tên đường để hoàn thiện phân số.</p>
                    <div class="mt-3">
                        <span class="badge bg-info me-1">Điền số</span>
                        <span class="badge bg-warning me-1">Tư duy</span>
                    </div>
                    <div class="progress mt-3" style="height: 10px;">
                        @php
                            $lostCityLevel = session('lost_city_level', 1);
                            $lostCityProgress = ($lostCityLevel - 1) * 20;
                        @endphp
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $lostCityProgress }}%"></div>
                    </div>
                    <p class="mt-2 small text-muted">Cấp độ {{ $lostCityLevel }}/5</p>
                    <a href="{{ route('games.lop4.phanso.lost_city') }}" class="btn btn-primary mt-3">
                        {{ $lostCityLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Equal Groups Game -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 mb-3">🎯</div>
                    <h5 class="card-title">Sếp Lớp Đểu Bằng</h5>
                    <p class="card-text">Kéo các phân số vào nhóm tương ứng.</p>
                    <div class="mt-3">
                        <span class="badge bg-info me-1">Phân nhóm</span>
                        <span class="badge bg-warning me-1">Kéo thả</span>
                    </div>
                    <div class="progress mt-3" style="height: 10px;">
                        @php
                            $equalGroupsLevel = session('equal_groups_level', 1);
                            $equalGroupsProgress = ($equalGroupsLevel - 1) * 20;
                        @endphp
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $equalGroupsProgress }}%"></div>
                    </div>
                    <p class="mt-2 small text-muted">Cấp độ {{ $equalGroupsLevel }}/5</p>
                    <a href="{{ route('games.lop4.phanso.equal_groups') }}" class="btn btn-primary mt-3">
                        {{ $equalGroupsLevel > 1 ? 'Tiếp tục' : 'Bắt đầu' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Placeholder for future games -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm bg-light">
                <div class="card-body text-center">
                    <div class="display-4 mb-3">🎮</div>
                    <h5 class="card-title text-muted">Sắp ra mắt</h5>
                    <p class="card-text text-muted">Các trò chơi mới đang được phát triển...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Instructions Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Hướng dẫn</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-star text-warning"></i>
                            Mỗi trò chơi có 5 cấp độ với độ khó tăng dần
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-trophy text-success"></i>
                            Hoàn thành một cấp độ để mở khóa cấp độ tiếp theo
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-undo text-primary"></i>
                            Bạn có thể chơi lại từ đầu bất cứ lúc nào
                        </li>
                        <li>
                            <i class="fas fa-graduation-cap text-info"></i>
                            Học và chơi cùng nhau để hiểu sâu hơn về phân số
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-5px);
}
.progress {
    background-color: #e9ecef;
}
.badge {
    font-weight: normal;
}
</style>
@endsection 