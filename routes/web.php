<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('games/lop4')->name('games.lop4.')->group(function () {
    // Game hub
    Route::get('/phanso', [GameController::class, 'gameHub'])->name('phanso');
    
    // Cake game routes
    Route::get('/phanso/cake', [GameController::class, 'cakeGame'])->name('phanso.cake');
    Route::post('/phanso/cake/check', [GameController::class, 'checkCakeAnswer'])->name('phanso.cake.check');
    
    
    // Apple game routes
    Route::get('/phanso/apple', [GameController::class, 'appleGame'])->name('phanso.apple');
    Route::post('/phanso/apple/check', [GameController::class, 'checkChiataoAnswer'])->name('phanso.apple.check');
    
    
    // Bracket game routes
    Route::get('/phanso/bracket', [GameController::class, 'bracketGame'])->name('phanso.bracket');
    Route::post('/phanso/bracket/check', [GameController::class, 'checkBieuthucAnswer'])->name('phanso.bracket.check');
   

    // Game dọn vườn tối giản
    Route::get('/phanso/garden', [GameController::class, 'gardenGame'])->name('phanso.garden');
    Route::post('/phanso/garden/check', [GameController::class, 'checkGardenAnswer'])->name('phanso.garden.check');

    // Game tháp phân số
    Route::get('/phanso/tower', [GameController::class, 'towerGame'])->name('phanso.tower');
    Route::post('/phanso/tower/check', [GameController::class, 'checkTowerAnswer'])->name('phanso.tower.check');

    // Game thẻ bài phân số
    Route::get('/phanso/cards', [GameController::class, 'cardsGame'])->name('phanso.cards');
    Route::post('/phanso/cards/check', [GameController::class, 'checkCardsAnswer'])->name('phanso.cards.check');

    // Game so sánh phân số
    Route::get('/phanso/compare', [GameController::class, 'compareGame'])->name('phanso.compare');
    Route::post('/phanso/compare/check', [GameController::class, 'checkCompareAnswer'])->name('phanso.compare.check');

    // Game phân số và phép chia
    Route::get('/phanso/division', [GameController::class, 'divisionGame'])->name('phanso.division');
    Route::post('/phanso/division/check', [GameController::class, 'checkDivisionAnswer'])->name('phanso.division.check');

    // Game chia bánh công bằng
    Route::get('/phanso/fairshare', [GameController::class, 'fairShareGame'])->name('phanso.fairshare');
    Route::post('/phanso/fairshare/check', [GameController::class, 'checkFairShareAnswer'])->name('phanso.fairshare.check');

    // Game săn kho báu phân số
    Route::get('/phanso/treasure', [GameController::class, 'treasureGame'])->name('phanso.treasure');
    Route::post('/phanso/treasure/check', [GameController::class, 'checkTreasureAnswer'])->name('phanso.treasure.check');
   

    // Game bầu trời phân số
    Route::get('/phanso/sky', [GameController::class, 'skyGame'])->name('phanso.sky');
    Route::post('/phanso/sky/check', [GameController::class, 'checkSkyAnswer'])->name('phanso.sky.check');

    // Game miếng bánh còn lại
    Route::get('/phanso/remaining', [GameController::class, 'remainingGame'])->name('phanso.remaining');
    Route::post('/phanso/remaining/check', [GameController::class, 'checkRemainingAnswer'])->name('phanso.remaining.check');

    // Game ghép câu phân số
    Route::get('/phanso/sentence', [GameController::class, 'sentenceGame'])->name('phanso.sentence');
    Route::post('/phanso/sentence/check', [GameController::class, 'checkSentenceAnswer'])->name('phanso.sentence.check');

    // Khám Phá Phân Số routes
    Route::prefix('kham-pha-phan-so')->name('kham-pha-phan-so.')->group(function () {
        Route::get('/', [KhamPhaPhanSoController::class, 'index'])->name('index');
        Route::get('/apple', [KhamPhaPhanSoController::class, 'appleGame'])->name('apple');
        Route::post('/apple/check', [KhamPhaPhanSoController::class, 'checkAppleAnswer'])->name('apple.check');

        Route::get('/balance', [KhamPhaPhanSoController::class, 'balanceGame'])->name('balance');
        Route::post('/balance/check', [KhamPhaPhanSoController::class, 'checkBalanceAnswer'])->name('balance.check');

        Route::get('/bracket', [KhamPhaPhanSoController::class, 'bracketGame'])->name('bracket');
        Route::post('/bracket/check', [KhamPhaPhanSoController::class, 'checkBracketAnswer'])->name('bracket.check');

        Route::get('/cake', [KhamPhaPhanSoController::class, 'cakeGame'])->name('cake');
        Route::post('/cake/check', [KhamPhaPhanSoController::class, 'checkCakeAnswer'])->name('cake.check');

        Route::get('/cards', [KhamPhaPhanSoController::class, 'cardsGame'])->name('cards');
        Route::post('/cards/check', [KhamPhaPhanSoController::class, 'checkCardsAnswer'])->name('cards.check');

        Route::get('/compare', [KhamPhaPhanSoController::class, 'compareGame'])->name('compare');
        Route::post('/compare/check', [KhamPhaPhanSoController::class, 'checkCompareAnswer'])->name('compare.check');

        Route::get('/division', [KhamPhaPhanSoController::class, 'divisionGame'])->name('division');
        Route::post('/division/check', [KhamPhaPhanSoController::class, 'checkDivisionAnswer'])->name('division.check');

        Route::get('/equal-groups', [KhamPhaPhanSoController::class, 'equalGroupsGame'])->name('equal_groups');

        Route::get('/fair-share', [KhamPhaPhanSoController::class, 'fairShare'])->name('fair_share');

        Route::get('/garden', [KhamPhaPhanSoController::class, 'gardenGame'])->name('garden');
        Route::post('/garden/check', [KhamPhaPhanSoController::class, 'checkGardenAnswer'])->name('garden.check');

        Route::get('/lost-city', [KhamPhaPhanSoController::class, 'lostCityGame'])->name('lost_city');
        Route::post('/lost-city/check', [KhamPhaPhanSoController::class, 'checkLostCityAnswer'])->name('lost_city.check');

        Route::get('/pattern', [KhamPhaPhanSoController::class, 'patternGame'])->name('pattern');
        Route::post('/pattern/check', [KhamPhaPhanSoController::class, 'checkPatternAnswer'])->name('pattern.check');

        Route::get('/phanso', [KhamPhaPhanSoController::class, 'phanso'])->name('phanso');

        Route::get('/remaining-cake', [KhamPhaPhanSoController::class, 'remainingCakeGame'])->name('remaining_cake');
        Route::post('/remaining-cake/check', [KhamPhaPhanSoController::class, 'checkRemainingCakeAnswer'])->name('remaining_cake.check');

        Route::get('/sentence', [KhamPhaPhanSoController::class, 'sentenceGame'])->name('sentence');
        Route::post('/sentence/check', [KhamPhaPhanSoController::class, 'checkSentenceAnswer'])->name('sentence.check');

        Route::get('/sky', [KhamPhaPhanSoController::class, 'skyGame'])->name('sky');
        Route::post('/sky/check', [KhamPhaPhanSoController::class, 'checkSkyAnswer'])->name('sky.check');

        Route::get('/tower', [KhamPhaPhanSoController::class, 'towerGame'])->name('tower');
        Route::post('/tower/check', [KhamPhaPhanSoController::class, 'checkTowerAnswer'])->name('tower.check');

        Route::get('/word-hunt', [KhamPhaPhanSoController::class, 'wordHuntGame'])->name('word_hunt');
        Route::post('/word-hunt/check', [KhamPhaPhanSoController::class, 'checkWordHuntAnswer'])->name('word_hunt.check');

        Route::get('/word-problem', [KhamPhaPhanSoController::class, 'wordProblemGame'])->name('word_problem');
        Route::post('/word-problem/check', [KhamPhaPhanSoController::class, 'checkWordProblemAnswer'])->name('word_problem.check');
    });
});

Route::middleware(['web'])->group(function () {
    // Base Games
    Route::get('/games/lop4/phanso/cake', [GameController::class, 'cakeGame'])->name('games.lop4.phanso.cake');
    Route::post('/games/lop4/phanso/cake/check', [GameController::class, 'checkCakeAnswer'])->name('games.lop4.phanso.cake.check');

    Route::get('/games/lop4/phanso/apple', [GameController::class, 'appleGame'])->name('games.lop4.phanso.apple');
    Route::post('/games/lop4/phanso/apple/check', [GameController::class, 'checkAppleAnswer'])->name('games.lop4.phanso.apple.check');

    Route::get('/games/lop4/phanso/bracket', [GameController::class, 'bracketGame'])->name('games.lop4.phanso.bracket');
    Route::post('/games/lop4/phanso/bracket/check', [GameController::class, 'checkBracketAnswer'])->name('games.lop4.phanso.bracket.check');

    // Garden Game Routes
    Route::get('/games/lop4/phanso/garden', [GameController::class, 'gardenGame'])->name('games.lop4.phanso.garden');
    Route::post('/games/lop4/phanso/garden/check', [GameController::class, 'checkGardenAnswer'])->name('games.lop4.phanso.garden.check');

    // Tower Game Routes
    Route::get('/games/lop4/phanso/tower', [GameController::class, 'towerGame'])->name('games.lop4.phanso.tower');
    Route::post('/games/lop4/phanso/tower/check', [GameController::class, 'checkTowerAnswer'])->name('games.lop4.phanso.tower.check');

    // Cards Game Routes
    Route::get('/games/lop4/phanso/cards', [GameController::class, 'cardsGame'])->name('games.lop4.phanso.cards');
    Route::post('/games/lop4/phanso/cards/check', [GameController::class, 'checkCardsAnswer'])->name('games.lop4.phanso.cards.check');

    // Compare Game Routes
    Route::get('/games/lop4/phanso/compare', [GameController::class, 'compareGame'])->name('games.lop4.phanso.compare');
    Route::post('/games/lop4/phanso/compare/check', [GameController::class, 'checkCompareAnswer'])->name('games.lop4.phanso.compare.check');

    // Division Game Routes
    Route::get('/games/lop4/phanso/division', [GameController::class, 'divisionGame'])->name('games.lop4.phanso.division');
    Route::post('/games/lop4/phanso/division/check', [GameController::class, 'checkDivisionAnswer'])->name('games.lop4.phanso.division.check');

    // Fair Share Game Routes
    Route::get('/games/lop4/phanso/fair-share', [GameController::class, 'fairShareGame'])->name('games.lop4.phanso.fair_share');
    Route::post('/games/lop4/phanso/fair-share/check', [GameController::class, 'checkFairShareAnswer'])->name('games.lop4.phanso.fair_share.check');

    // Balance Game Routes
    Route::get('/games/lop4/phanso/balance', [GameController::class, 'balanceGame'])->name('games.lop4.phanso.balance');
    Route::post('/games/lop4/phanso/balance/check', [GameController::class, 'checkBalanceAnswer'])->name('games.lop4.phanso.balance.check');

    // Pattern Game Routes
    Route::get('/games/lop4/phanso/pattern', [GameController::class, 'patternGame'])->name('games.lop4.phanso.pattern');
    Route::post('/games/lop4/phanso/pattern/check', [GameController::class, 'checkPatternAnswer'])->name('games.lop4.phanso.pattern.check');

    // Word Problem Game Routes
    Route::get('/games/lop4/phanso/word-problem', [GameController::class, 'wordProblemGame'])->name('games.lop4.phanso.word_problem');
    Route::post('/games/lop4/phanso/word-problem/check', [GameController::class, 'checkWordProblemAnswer'])->name('games.lop4.phanso.word_problem.check');

    // Sky Game Routes
    Route::get('/games/lop4/phanso/sky', [GameController::class, 'skyGame'])->name('games.lop4.phanso.sky');
    Route::post('/games/lop4/phanso/sky/check', [GameController::class, 'checkSkyAnswer'])->name('games.lop4.phanso.sky.check');

    // Remaining Cake Game Routes
    Route::get('/games/lop4/phanso/remaining-cake', [GameController::class, 'remainingCakeGame'])->name('games.lop4.phanso.remaining_cake');
    Route::post('/games/lop4/phanso/remaining-cake/check', [GameController::class, 'checkRemainingCakeAnswer'])->name('games.lop4.phanso.remaining_cake.check');

    // Sentence Game Routes
    Route::get('/games/lop4/phanso/sentence', [GameController::class, 'sentenceGame'])->name('games.lop4.phanso.sentence');
    Route::post('/games/lop4/phanso/sentence/check', [GameController::class, 'checkSentenceAnswer'])->name('games.lop4.phanso.sentence.check');

    // Word Hunt Game Routes
    Route::get('/games/lop4/phanso/word-hunt', [GameController::class, 'wordHuntGame'])->name('games.lop4.phanso.word_hunt');
    Route::post('/games/lop4/phanso/word-hunt/check', [GameController::class, 'checkWordHuntAnswer'])->name('games.lop4.phanso.word_hunt.check');

    // Lost City Game Routes
    Route::get('/games/lop4/phanso/lost-city', [GameController::class, 'lostCityGame'])->name('games.lop4.phanso.lost_city');
    Route::post('/games/lop4/phanso/lost-city/check', [GameController::class, 'checkLostCityAnswer'])->name('games.lop4.phanso.lost_city.check');

    // Equal Groups Game Routes
    Route::get('/games/lop4/phanso/equal-groups', [GameController::class, 'equalGroupsGame'])->name('games.lop4.phanso.equal_groups');
    Route::post('/games/lop4/phanso/equal-groups/check', [GameController::class, 'checkEqualGroupsAnswer'])->name('games.lop4.phanso.equal_groups.check');

    // Main Game Hub Route
    Route::get('/games/lop4/phanso', function() {
        return view('games.lop4.phanso.index');
    })->name('games.lop4.phanso.index');
});

// Measurement and Units Games Routes
Route::prefix('games/lop4/dailuongvadoluong')->name('games.lop4.dailuongvadoluong.')->group(function () {
    // Overview
    Route::get('/', [MeasurementGameController::class, 'index'])->name('index');

    // 1. Cân Táo Cân Cam
    Route::get('/can-tao-cam', [MeasurementGameController::class, 'fruitWeighingGame'])->name('fruit_weighing');
    Route::post('/can-tao-cam/check', [MeasurementGameController::class, 'checkFruitWeighingAnswer'])->name('fruit_weighing.check');

    // 2. Thời Gian Phiêu Lưu
    Route::get('/time-adventure', [MeasurementGameController::class, 'timeAdventureGame'])->name('time_adventure');
    Route::post('/time-adventure/check', [MeasurementGameController::class, 'checkTimeAdventureAnswer'])->name('time_adventure.check');

    // 3. Chuyển Đổi Đơn Vị Thần Tốc
    Route::get('/unit-conversion', [MeasurementGameController::class, 'unitConversionGame'])->name('unit_conversion');
    Route::post('/unit-conversion/check', [MeasurementGameController::class, 'checkUnitConversionAnswer'])->name('unit_conversion.check');

    // 4. Cuộc Đua Đơn Vị Đo
    Route::get('/distance-comparison', [MeasurementGameController::class, 'distanceComparisonGame'])->name('distance_comparison');
    Route::post('/distance-comparison/check', [MeasurementGameController::class, 'checkDistanceComparisonAnswer'])->name('distance_comparison.check');

    // 5. Xếp Hàng Theo Khối Lượng
    Route::get('/weight-sorting', [MeasurementGameController::class, 'weightSortingGame'])->name('weight_sorting');
    Route::post('/weight-sorting/check', [MeasurementGameController::class, 'checkWeightSortingAnswer'])->name('weight_sorting.check');

    // 6. Bấm Giờ Chuẩn
    Route::get('/precision-timing', [MeasurementGameController::class, 'precisionTimingGame'])->name('precision_timing');
    Route::post('/precision-timing/check', [MeasurementGameController::class, 'checkPrecisionTimingAnswer'])->name('precision_timing.check');

    // 7. Bảng Quy Đổi
    Route::get('/conversion-table', [MeasurementGameController::class, 'conversionTableGame'])->name('conversion_table');
    Route::post('/conversion-table/check', [MeasurementGameController::class, 'checkConversionTableAnswer'])->name('conversion_table.check');

    // 8. Đo Độ Dài
    Route::get('/length-measurement', [MeasurementGameController::class, 'lengthMeasurementGame'])->name('length_measurement');
    Route::post('/length-measurement/check', [MeasurementGameController::class, 'checkLengthMeasurementAnswer'])->name('length_measurement.check');

    // 9. Ước Lượng Khối Lượng
    Route::get('/weight-estimation', [MeasurementGameController::class, 'weightEstimationGame'])->name('weight_estimation');
    Route::post('/weight-estimation/check', [MeasurementGameController::class, 'checkWeightEstimationAnswer'])->name('weight_estimation.check');

    // 10. So Sánh Thời Gian
    Route::get('/time-comparison', [MeasurementGameController::class, 'timeComparisonGame'])->name('time_comparison');
    Route::post('/time-comparison/check', [MeasurementGameController::class, 'checkTimeComparisonAnswer'])->name('time_comparison.check');

    // 11. Đo Dung Tích
    Route::get('/volume-measurement', [MeasurementGameController::class, 'volumeMeasurementGame'])->name('volume_measurement');
    Route::post('/volume-measurement/check', [MeasurementGameController::class, 'checkVolumeMeasurementAnswer'])->name('volume_measurement.check');

    // 12. Tính Chu Vi
    Route::get('/perimeter-calculation', [MeasurementGameController::class, 'perimeterCalculationGame'])->name('perimeter_calculation');
    Route::post('/perimeter-calculation/check', [MeasurementGameController::class, 'checkPerimeterCalculationAnswer'])->name('perimeter_calculation.check');

    // 13. Tính Diện Tích
    Route::get('/area-calculation', [MeasurementGameController::class, 'areaCalculationGame'])->name('area_calculation');
    Route::post('/area-calculation/check', [MeasurementGameController::class, 'checkAreaCalculationAnswer'])->name('area_calculation.check');

    // 14. Đo Góc
    Route::get('/angle-measurement', [MeasurementGameController::class, 'angleMeasurementGame'])->name('angle_measurement');
    Route::post('/angle-measurement/check', [MeasurementGameController::class, 'checkAngleMeasurementAnswer'])->name('angle_measurement.check');

    // 15. Thời Gian Nâng Cao
    Route::get('/advanced-time', [MeasurementGameController::class, 'advancedTimeGame'])->name('advanced_time');
    Route::post('/advanced-time/check', [MeasurementGameController::class, 'checkAdvancedTimeAnswer'])->name('advanced_time.check');
});

Route::prefix('games/lop4/bi-an-hinh-hoc')->name('games.lop4.bi_an_hinh_hoc.')->group(function () {
    Route::get('/', function() { return view('games.lop4.bi_an_hinh_hoc.bi_an_hinh_hoc'); })->name('index');
    Route::get('/area-calculation', [HinhHocGameController::class, 'areaCalculationGame'])->name('area_calculation');
    Route::get('/perimeter-calculation', [HinhHocGameController::class, 'perimeterCalculationGame'])->name('perimeter_calculation');
    Route::get('/angle-measurement', [HinhHocGameController::class, 'angleMeasurementGame'])->name('angle_measurement');
    Route::get('/volume-measurement', [HinhHocGameController::class, 'volumeMeasurementGame'])->name('volume_measurement');
});

Route::prefix('games/lop4/day-so-quy-luat')->name('games.lop4.day_so_quy_luat.')->group(function () {
    Route::get('/', function() { return view('games.lop4.day_so_quy_luat.day_so_quy_luat'); })->name('index');
    Route::get('/pattern', [DaySoQuyLuatController::class, 'patternGame'])->name('pattern');
    Route::post('/pattern/check', [DaySoQuyLuatController::class, 'checkAnswer'])->name('pattern.check');
});

Route::prefix('games/lop4/giai-toan-loi-van')->name('games.lop4.giai_toan_loi_van.')->group(function () {
    Route::get('/', function() { return view('games.lop4.giai_toan_loi_van.giai_toan_loi_van'); })->name('index');
    Route::get('/lost-city', [GiaiToanLoiVanController::class, 'lostCity'])->name('lost_city');
    Route::post('/lost-city/check', [GiaiToanLoiVanController::class, 'checkLostCityAnswer'])->name('lost_city.check');
    Route::get('/word-problem', [GiaiToanLoiVanController::class, 'wordProblemGame'])->name('word_problem');
    Route::post('/word-problem/check', [GiaiToanLoiVanController::class, 'checkAnswer'])->name('word_problem.check');
});

Route::prefix('games/lop4/so-tu-nhien-va-cac-phep-tinh')->name('games.lop4.so_tu_nhien_va_cac_phep_tinh.')->group(function () {
    Route::get('/', function() { return view('games.lop4.so_tu_nhien_va_cac_phep_tinh.so_tu_nhien_va_cac_phep_tinh'); })->name('index');
    Route::get('/number-place-value', [SoTuNhienVaCacPhepTinhController::class, 'numberPlaceValueGame'])->name('number_place_value');
    Route::get('/addition-subtraction', [SoTuNhienVaCacPhepTinhController::class, 'additionSubtractionGame'])->name('addition_subtraction');
    Route::get('/multiplication-division', [SoTuNhienVaCacPhepTinhController::class, 'multiplicationDivisionGame'])->name('multiplication_division');
    Route::get('/mixed-operations', [SoTuNhienVaCacPhepTinhController::class, 'mixedOperationsGame'])->name('mixed_operations');
});

Route::prefix('games/lop4/thong-ke-bieu-do')->name('games.lop4.thong_ke_bieu_do.')->group(function () {
    Route::get('/', function() { return view('games.lop4.thong_ke_bieu_do.thong_ke_bieu_do'); })->name('index');
    Route::get('/data-collection', [ThongKeBieuDoController::class, 'dataCollectionGame'])->name('data_collection');
    Route::get('/bar-chart', [ThongKeBieuDoController::class, 'barChartGame'])->name('bar_chart');
    Route::get('/line-chart', [ThongKeBieuDoController::class, 'lineChartGame'])->name('line_chart');
    Route::get('/pie-chart', [ThongKeBieuDoController::class, 'pieChartGame'])->name('pie_chart');
});

Route::prefix('games/lop4/thu-thach-do-luong')->name('games.lop4.thu_thach_do_luong.')->group(function () {
    Route::get('/', function() { return view('games.lop4.thu_thach_do_luong.thu_thach_do_luong'); })->name('index');
    Route::get('/length-measurement', [ThuThachDoLuongController::class, 'lengthMeasurementGame'])->name('length_measurement');
    Route::get('/weight-measurement', [ThuThachDoLuongController::class, 'weightMeasurementGame'])->name('weight_measurement');
    Route::get('/time-measurement', [ThuThachDoLuongController::class, 'timeMeasurementGame'])->name('time_measurement');
    Route::get('/money-calculation', [ThuThachDoLuongController::class, 'moneyCalculationGame'])->name('money_calculation');
});

Route::get('/games/lop4', function() {
    return view('games.lop4.index');
})->name('games.lop4.index');
