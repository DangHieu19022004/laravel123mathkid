<?php

use App\Http\Controllers\GradeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Games\GameController;
use App\Http\Controllers\Games\MeasurementGameController;
use App\Http\Controllers\Games\HinhHocGameController;
use App\Http\Controllers\Games\DaySoQuyLuatController;
use App\Http\Controllers\Games\GiaiToanLoiVanController;
use App\Http\Controllers\Games\KhamPhaPhanSoController;
use App\Http\Controllers\Games\SoTuNhienVaCacPhepTinhController;
use App\Http\Controllers\Games\ThongKeBieuDoController;
use App\Http\Controllers\Games\ThuThachDoLuongController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Test (Product bỏ đi)
Route::get('/', static function () {
    return redirect()->route('game.lop4.overview');
});

Route::prefix('tro-choi/lop4')->name('game.lop4.')
    ->group(function () {
        // Trang chính
        Route::get('/', [GradeController::class, 'index'])
            ->name('overview');

        // ===========================================
        // KHÁM PHÁ PHÂN SỐ (Fraction Exploration)
        // ===========================================
        Route::prefix('kham-pha-phan-so')->name('fraction_exploration.')
            ->group(function () {
                Route::get('/', [KhamPhaPhanSoController::class, 'index'])
                    ->name('overview');

                // Game Táo
                Route::get('/qua-tao', [KhamPhaPhanSoController::class, 'appleGame'])
                    ->name('apple');
                Route::post('/qua-tao/kiem-tra', [KhamPhaPhanSoController::class, 'checkAppleAnswer'])
                    ->name('apple.check');

                // Game Cân Bằng
                Route::get('/can-bang', [KhamPhaPhanSoController::class, 'balanceGame'])
                    ->name('balance');
                Route::post('/can-bang/kiem-tra', [KhamPhaPhanSoController::class, 'checkBalanceAnswer'])
                    ->name('balance.check');

                // Game Dấu Ngoặc
                Route::get('/dau-ngoac', [KhamPhaPhanSoController::class, 'bracketGame'])
                    ->name('bracket');
                Route::post('/dau-ngoac/kiem-tra', [KhamPhaPhanSoController::class, 'checkBracketAnswer'])
                    ->name('bracket.check');

                // Game Bánh Ngọt
                Route::get('/banh-ngot', [KhamPhaPhanSoController::class, 'cakeGame'])
                    ->name('cake');
                Route::post('/banh-ngot/kiem-tra', [KhamPhaPhanSoController::class, 'checkCakeAnswer'])
                    ->name('cake.check');

                // Game Thẻ Bài
                Route::get('/the-bai', [KhamPhaPhanSoController::class, 'cardsGame'])
                    ->name('cards');
                Route::post('/the-bai/kiem-tra', [KhamPhaPhanSoController::class, 'checkCardsAnswer'])
                    ->name('cards.check');

                // Game So Sánh
                Route::get('/so-sanh', [KhamPhaPhanSoController::class, 'compareGame'])
                    ->name('compare');
                Route::post('/so-sanh/kiem-tra', [KhamPhaPhanSoController::class, 'checkCompareAnswer'])
                    ->name('compare.check');

                // Game Phép Chia
                Route::get('/phep-chia', [KhamPhaPhanSoController::class, 'divisionGame'])
                    ->name('division');
                Route::post('/phep-chia/kiem-tra', [KhamPhaPhanSoController::class, 'checkDivisionAnswer'])
                    ->name('division.check');

                // Game Nhóm Bằng Nhau
                Route::get('/nhom-bang-nhau', [KhamPhaPhanSoController::class, 'equalGroupsGame'])
                    ->name('equal_groups');

                // Game Chia Đều
                Route::get('/chia-deu', [KhamPhaPhanSoController::class, 'fairShare'])
                    ->name('fair_share');

                // Game Vườn Hoa
                Route::get('/vuon-hoa', [KhamPhaPhanSoController::class, 'gardenGame'])
                    ->name('garden');
                Route::post('/vuon-hoa/kiem-tra', [KhamPhaPhanSoController::class, 'checkGardenAnswer'])
                    ->name('garden.check');

                // Game Thành Phố Bí Ẩn
                Route::get('/thanh-pho-bi-an', [KhamPhaPhanSoController::class, 'lostCityGame'])
                    ->name('lost_city');
                Route::post('/thanh-pho-bi-an/kiem-tra', [KhamPhaPhanSoController::class, 'checkLostCityAnswer'])
                    ->name('lost_city.check');

                // Game Quy Luật
                Route::get('/quy-luat', [KhamPhaPhanSoController::class, 'patternGame'])
                    ->name('pattern');
                Route::post('/quy-luat/kiem-tra', [KhamPhaPhanSoController::class, 'checkPatternAnswer'])
                    ->name('pattern.check');

                // Game Phân Số
                Route::get('/phan-so', [KhamPhaPhanSoController::class, 'phanso'])
                    ->name('fraction');

                // Game Bánh Còn Lại
                Route::get('/banh-con-lai', [KhamPhaPhanSoController::class, 'remainingCakeGame'])
                    ->name('remaining_cake');
                Route::post('/banh-con-lai/kiem-tra', [KhamPhaPhanSoController::class, 'checkRemainingCakeAnswer'])
                    ->name('remaining_cake.check');

                // Game Ghép Câu
                Route::get('/ghep-cau', [KhamPhaPhanSoController::class, 'sentenceGame'])
                    ->name('sentence');
                Route::post('/ghep-cau/kiem-tra', [KhamPhaPhanSoController::class, 'checkSentenceAnswer'])
                    ->name('sentence.check');

                // Game Bầu Trời
                Route::get('/bau-troi', [KhamPhaPhanSoController::class, 'skyGame'])
                    ->name('sky');
                Route::post('/bau-troi/kiem-tra', [KhamPhaPhanSoController::class, 'checkSkyAnswer'])
                    ->name('sky.check');

                // Game Tháp Phân Số
                Route::get('/thap-phan-so', [KhamPhaPhanSoController::class, 'towerGame'])
                    ->name('tower');
                Route::post('/thap-phan-so/kiem-tra', [KhamPhaPhanSoController::class, 'checkTowerAnswer'])
                    ->name('tower.check');

                // Game Săn Từ
                Route::get('/san-tu', [KhamPhaPhanSoController::class, 'wordHuntGame'])
                    ->name('word_hunt');
                Route::post('/san-tu/kiem-tra', [KhamPhaPhanSoController::class, 'checkWordHuntAnswer'])
                    ->name('word_hunt.check');

                // Game Bài Toán Lời Văn
                Route::get('/bai-toan-loi-van', [KhamPhaPhanSoController::class, 'wordProblemGame'])
                    ->name('word_problem');
                Route::post('/bai-toan-loi-van/kiem-tra', [KhamPhaPhanSoController::class, 'checkWordProblemAnswer'])
                    ->name('word_problem.check');
            });

        // ===========================================
        // PHÂN SỐ CƠ BẢN (Basic Fractions) - Legacy Routes
        // ===========================================
        Route::prefix('phan-so')->name('basic_fractions.')
            ->group(function () {
                // Trang tổng quan game
                Route::get('/', [GameController::class, 'index'])->name('overview');

//                // Game Bánh Ngọt
//                Route::get('/banh-ngot', [GameController::class, 'cakeGame'])
//                    ->name('cake');
//                Route::post('/banh-ngot/kiem-tra', [GameController::class, 'checkCakeAnswer'])
//                    ->name('cake.check');
//
//                // Game Táo
//                Route::get('/tao', [GameController::class, 'appleGame'])
//                    ->name('apple');
//                Route::post('/tao/kiem-tra', [GameController::class, 'checkAppleAnswer'])
//                    ->name('apple.check');
//
//                // Game Ngoặc Đơn
//                Route::get('/ngoac-don', [GameController::class, 'bracketGame'])
//                    ->name('bracket');
//                Route::post('/ngoac-don/kiem-tra', [GameController::class, 'checkBracketAnswer'])
//                    ->name('bracket.check');
//
//                // Game Vườn Hoa
//                Route::get('/vuon-hoa', [GameController::class, 'gardenGame'])
//                    ->name('garden');
//                Route::post('/vuon-hoa/kiem-tra', [GameController::class, 'checkGardenAnswer'])
//                    ->name('garden.check');
//
//                // Game Tháp
//                Route::get('/thap', [GameController::class, 'towerGame'])
//                    ->name('tower');
//                Route::post('/thap/kiem-tra', [GameController::class, 'checkTowerAnswer'])
//                    ->name('tower.check');
//
//                // Game Thẻ Bài
//                Route::get('/the-bai', [GameController::class, 'cardsGame'])
//                    ->name('cards');
//                Route::post('/the-bai/kiem-tra', [GameController::class, 'checkCardsAnswer'])
//                    ->name('cards.check');
//
//                // Game So Sánh
//                Route::get('/so-sanh', [GameController::class, 'compareGame'])
//                    ->name('compare');
//                Route::post('/so-sanh/kiem-tra', [GameController::class, 'checkCompareAnswer'])
//                    ->name('compare.check');
//
//                // Game Phép Chia
//                Route::get('/phep-chia', [GameController::class, 'divisionGame'])
//                    ->name('division');
//                Route::post('/phep-chia/kiem-tra', [GameController::class, 'checkDivisionAnswer'])
//                    ->name('division.check');
//
//                // Game Chia Công Bằng
//                Route::get('/chia-cong-bang', [GameController::class, 'fairShareGame'])
//                    ->name('fair_share');
//                Route::post('/chia-cong-bang/kiem-tra', [GameController::class, 'checkFairShareAnswer'])
//                    ->name('fair_share.check');
//
//                // Game Săn Kho Báu
//                Route::get('/san-kho-bau', [GameController::class, 'treasureGame'])
//                    ->name('treasure');
//                Route::post('/san-kho-bau/kiem-tra', [GameController::class, 'checkTreasureAnswer'])
//                    ->name('treasure.check');
//
//                // Game Bầu Trời
//                Route::get('/bau-troi', [GameController::class, 'skyGame'])
//                    ->name('sky');
//                Route::post('/bau-troi/kiem-tra', [GameController::class, 'checkSkyAnswer'])
//                    ->name('sky.check');
//
//                // Game Còn Lại
//                Route::get('/con-lai', [GameController::class, 'remainingGame'])
//                    ->name('remaining');
//                Route::post('/con-lai/kiem-tra', [GameController::class, 'checkRemainingAnswer'])
//                    ->name('remaining.check');
//
//                // Game Ghép Câu
//                Route::get('/ghep-cau', [GameController::class, 'sentenceGame'])
//                    ->name('sentence');
//                Route::post('/ghep-cau/kiem-tra', [GameController::class, 'checkSentenceAnswer'])
//                    ->name('sentence.check');
//
//                // Game Cân Bằng
//                Route::get('/can-bang', [GameController::class, 'balanceGame'])
//                    ->name('balance');
//                Route::post('/can-bang/kiem-tra', [GameController::class, 'checkBalanceAnswer'])
//                    ->name('balance.check');
//
//                // Game Quy Luật
//                Route::get('/quy-luat', [GameController::class, 'patternGame'])
//                    ->name('pattern');
//                Route::post('/quy-luat/kiem-tra', [GameController::class, 'checkPatternAnswer'])
//                    ->name('pattern.check');
//
//                // Game Bài Toán Lời Văn
//                Route::get('/bai-toan-loi-van', [GameController::class, 'wordProblemGame'])
//                    ->name('word_problem');
//                Route::post('/bai-toan-loi-van/kiem-tra', [GameController::class, 'checkWordProblemAnswer'])
//                    ->name('word_problem.check');
//
//                // Game Bánh Còn Lại
//                Route::get('/banh-con-lai', [GameController::class, 'remainingCakeGame'])
//                    ->name('remaining_cake');
//                Route::post('/banh-con-lai/kiem-tra', [GameController::class, 'checkRemainingCakeAnswer'])
//                    ->name('remaining_cake.check');
//
//                // Game Săn Từ
//                Route::get('/san-tu', [GameController::class, 'wordHuntGame'])
//                    ->name('word_hunt');
//                Route::post('/san-tu/kiem-tra', [GameController::class, 'checkWordHuntAnswer'])
//                    ->name('word_hunt.check');
//
//                // Game Thành Phố Mất
//                Route::get('/thanh-pho-mat', [GameController::class, 'lostCityGame'])
//                    ->name('lost_city');
//                Route::post('/thanh-pho-mat/kiem-tra', [GameController::class, 'checkLostCityAnswer'])
//                    ->name('lost_city.check');
//
//                // Game Nhóm Bằng Nhau
//                Route::get('/nhom-bang-nhau', [GameController::class, 'equalGroupsGame'])
//                    ->name('equal_groups');
//                Route::post('/nhom-bang-nhau/kiem-tra', [GameController::class, 'checkEqualGroupsAnswer'])
//                    ->name('equal_groups.check');
            });

        // ===========================================
        // ĐO LƯỜNG VÀ ĐƠN VỊ (Measurement and Units)
        // ===========================================
        Route::prefix('do-luong-va-don-vi')->name('measurement_and_units.')
            ->group(function () {
                Route::get('/', [MeasurementGameController::class, 'index'])
                    ->name('overview');

//                // Game Cân Táo Cân Cam
//                Route::get('/can-tao-can-cam', [MeasurementGameController::class, 'fruitWeighingGame'])
//                    ->name('fruit_weighing');
//                Route::post('/can-tao-can-cam/kiem-tra', [MeasurementGameController::class, 'checkFruitWeighingAnswer'])
//                    ->name('fruit_weighing.check');
//
//                // Game Phiêu Lưu Thời Gian
//                Route::get('/phieu-luu-thoi-gian', [MeasurementGameController::class, 'timeAdventureGame'])
//                    ->name('time_adventure');
//                Route::post('/phieu-luu-thoi-gian/kiem-tra', [MeasurementGameController::class, 'checkTimeAdventureAnswer'])
//                    ->name('time_adventure.check');
//
//                // Game Chuyển Đổi Đơn Vị
//                Route::get('/chuyen-doi-don-vi', [MeasurementGameController::class, 'unitConversionGame'])
//                    ->name('unit_conversion');
//                Route::post('/chuyen-doi-don-vi/kiem-tra', [MeasurementGameController::class, 'checkUnitConversionAnswer'])
//                    ->name('unit_conversion.check');
//
//                // Game So Sánh Khoảng Cách
//                Route::get('/so-sanh-khoang-cach', [MeasurementGameController::class, 'distanceComparisonGame'])
//                    ->name('distance_comparison');
//                Route::post('/so-sanh-khoang-cach/kiem-tra', [MeasurementGameController::class, 'checkDistanceComparisonAnswer'])
//                    ->name('distance_comparison.check');
//
//                // Game Sắp Xếp Khối Lượng
//                Route::get('/sap-xep-khoi-luong', [MeasurementGameController::class, 'weightSortingGame'])
//                    ->name('weight_sorting');
//                Route::post('/sap-xep-khoi-luong/kiem-tra', [MeasurementGameController::class, 'checkWeightSortingAnswer'])
//                    ->name('weight_sorting.check');
//
//                // Game Bấm Giờ Chính Xác
//                Route::get('/bam-gio-chinh-xac', [MeasurementGameController::class, 'precisionTimingGame'])
//                    ->name('precision_timing');
//                Route::post('/bam-gio-chinh-xac/kiem-tra', [MeasurementGameController::class, 'checkPrecisionTimingAnswer'])
//                    ->name('precision_timing.check');
//
//                // Game Bảng Quy Đổi
//                Route::get('/bang-quy-doi', [MeasurementGameController::class, 'conversionTableGame'])
//                    ->name('conversion_table');
//                Route::post('/bang-quy-doi/kiem-tra', [MeasurementGameController::class, 'checkConversionTableAnswer'])
//                    ->name('conversion_table.check');
//
//                // Game Đo Độ Dài
//                Route::get('/do-do-dai', [MeasurementGameController::class, 'lengthMeasurementGame'])
//                    ->name('length_measurement');
//                Route::post('/do-do-dai/kiem-tra', [MeasurementGameController::class, 'checkLengthMeasurementAnswer'])
//                    ->name('length_measurement.check');
//
//                // Game Ước Lượng Khối Lượng
//                Route::get('/uoc-luong-khoi-luong', [MeasurementGameController::class, 'weightEstimationGame'])
//                    ->name('weight_estimation');
//                Route::post('/uoc-luong-khoi-luong/kiem-tra', [MeasurementGameController::class, 'checkWeightEstimationAnswer'])
//                    ->name('weight_estimation.check');
//
//                // Game So Sánh Thời Gian
//                Route::get('/so-sanh-thoi-gian', [MeasurementGameController::class, 'timeComparisonGame'])
//                    ->name('time_comparison');
//                Route::post('/so-sanh-thoi-gian/kiem-tra', [MeasurementGameController::class, 'checkTimeComparisonAnswer'])
//                    ->name('time_comparison.check');
//
//                // Game Đo Dung Tích
//                Route::get('/do-dung-tich', [MeasurementGameController::class, 'volumeMeasurementGame'])
//                    ->name('volume_measurement');
//                Route::post('/do-dung-tich/kiem-tra', [MeasurementGameController::class, 'checkVolumeMeasurementAnswer'])
//                    ->name('volume_measurement.check');
//
//                // Game Tính Chu Vi
//                Route::get('/tinh-chu-vi', [MeasurementGameController::class, 'perimeterCalculationGame'])
//                    ->name('perimeter_calculation');
//                Route::post('/tinh-chu-vi/kiem-tra', [MeasurementGameController::class, 'checkPerimeterCalculationAnswer'])
//                    ->name('perimeter_calculation.check');
//
//                // Game Tính Diện Tích
//                Route::get('/tinh-dien-tich', [MeasurementGameController::class, 'areaCalculationGame'])
//                    ->name('area_calculation');
//                Route::post('/tinh-dien-tich/kiem-tra', [MeasurementGameController::class, 'checkAreaCalculationAnswer'])
//                    ->name('area_calculation.check');
//
//                // Game Đo Góc
//                Route::get('/do-goc', [MeasurementGameController::class, 'angleMeasurementGame'])
//                    ->name('angle_measurement');
//                Route::post('/do-goc/kiem-tra', [MeasurementGameController::class, 'checkAngleMeasurementAnswer'])
//                    ->name('angle_measurement.check');
//
//                // Game Thời Gian Nâng Cao
//                Route::get('/thoi-gian-nang-cao', [MeasurementGameController::class, 'advancedTimeGame'])
//                    ->name('advanced_time');
//                Route::post('/thoi-gian-nang-cao/kiem-tra', [MeasurementGameController::class, 'checkAdvancedTimeAnswer'])
//                    ->name('advanced_time.check');
            });

        // ===========================================
        // BÍ ẨN HÌNH HỌC (Geometry Mysteries)
        // ===========================================
        Route::prefix('bi-an-hinh-hoc')->name('geometry_mysteries.')
            ->group(function () {
                Route::get('/', [HinhHocGameController::class, 'index'])->name('overview');

//                Route::get('/tinh-dien-tich', [HinhHocGameController::class, 'areaCalculationGame'])
//                    ->name('area_calculation');
//                Route::get('/tinh-chu-vi', [HinhHocGameController::class, 'perimeterCalculationGame'])
//                    ->name('perimeter_calculation');
//                Route::get('/do-goc', [HinhHocGameController::class, 'angleMeasurementGame'])
//                    ->name('angle_measurement');
//                Route::get('/do-the-tich', [HinhHocGameController::class, 'volumeMeasurementGame'])
//                    ->name('volume_measurement');
            });

        // ===========================================
        // DÃY SỐ QUY LUẬT (Number Sequence Patterns)
        // ===========================================
        Route::prefix('day-so-quy-luat')->name('number_sequence_patterns.')
            ->group(function () {
                Route::get('/', [DaySoQuyLuatController::class, 'index'])->name('overview');

//                Route::get('/tim-quy-luat', [DaySoQuyLuatController::class, 'patternGame'])
//                    ->name('find_pattern');
//                Route::post('/tim-quy-luat/kiem-tra', [DaySoQuyLuatController::class, 'checkAnswer'])
//                    ->name('find_pattern.check');
            });

        // ===========================================
        // GIẢI TOÁN LỜI VĂN (Word Problem Solving)
        // ===========================================
        Route::prefix('giai-toan-loi-van')->name('word_problem_solving.')
            ->group(function () {
                Route::get('/', [GiaiToanLoiVanController::class, 'index'])->name('overview');

                Route::get('/thanh-pho-mat-tich', [GiaiToanLoiVanController::class, 'lostCity'])
                    ->name('lost_city');
                Route::get('/bai-toan-loi-van', [GiaiToanLoiVanController::class, 'wordProblemGame'])
                    ->name('word_problem');
            });

        // ===========================================
        // SỐ TỰ NHIÊN VÀ CÁC PHÉP TÍNH (Natural Numbers and Operations)
        // ===========================================
        Route::prefix('so-tu-nhien-va-cac-phep-tinh')->name('natural_numbers_and_operations.')
            ->group(function () {
                Route::get('/', [SoTuNhienVaCacPhepTinhController::class, 'index'])->name('overview');

                Route::get('/gia-tri-chu-so', [SoTuNhienVaCacPhepTinhController::class, 'numberPlaceValueGame'])
                    ->name('number_place_value');
                Route::get('/cong-tru', [SoTuNhienVaCacPhepTinhController::class, 'additionSubtractionGame'])
                    ->name('addition_subtraction');
                Route::get('/nhan-chia', [SoTuNhienVaCacPhepTinhController::class, 'multiplicationDivisionGame'])
                    ->name('multiplication_division');
                Route::get('/phep-tinh-hon-hop', [SoTuNhienVaCacPhepTinhController::class, 'mixedOperationsGame'])
                    ->name('mixed_operations');
            });

        // ===========================================
        // THỐNG KÊ BIỂU ĐỒ (Statistics and Charts)
        // ===========================================
        Route::prefix('thong-ke-bieu-do')->name('statistics_and_charts.')
            ->group(function () {
                Route::get('/', [ThongKeBieuDoController::class, 'index'])->name('overview');

                Route::get('/thu-thap-du-lieu', [ThongKeBieuDoController::class, 'dataCollectionGame'])
                    ->name('data_collection');
                Route::get('/bieu-do-cot', [ThongKeBieuDoController::class, 'barChartGame'])
                    ->name('bar_chart');
                Route::get('/bieu-do-duong', [ThongKeBieuDoController::class, 'lineChartGame'])
                    ->name('line_chart');
                Route::get('/bieu-do-tron', [ThongKeBieuDoController::class, 'pieChartGame'])
                    ->name('pie_chart');
            });

        // ===========================================
        // THỬ THÁCH ĐO LƯỜNG (Measurement Challenges)
        // ===========================================
        Route::prefix('thu-thach-do-luong')->name('measurement_challenges.')
            ->group(function () {
                Route::get('/', [ThuThachDoLuongController::class, 'index'])->name('overview');

//                Route::get('/do-do-dai', [ThuThachDoLuongController::class, 'lengthMeasurementGame'])
//                    ->name('length_measurement');
//                Route::get('/do-khoi-luong', [ThuThachDoLuongController::class, 'weightMeasurementGame'])
//                    ->name('weight_measurement');
//                Route::get('/do-thoi-gian', [ThuThachDoLuongController::class, 'timeMeasurementGame'])
//                    ->name('time_measurement');
//                Route::get('/tinh-tien', [ThuThachDoLuongController::class, 'moneyCalculationGame'])
//                    ->name('money_calculation');
            });
    });
