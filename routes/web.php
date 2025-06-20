<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Games\GameController;
use App\Http\Controllers\Games\MeasurementGameController;

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
    Route::post('/phanso/cake/reset', [GameController::class, 'resetCakeGame'])->name('phanso.cake.reset');
    
    // Apple game routes
    Route::get('/phanso/apple', [GameController::class, 'appleGame'])->name('phanso.apple');
    Route::post('/phanso/apple/check', [GameController::class, 'checkChiataoAnswer'])->name('phanso.apple.check');
    Route::post('/phanso/apple/reset', [GameController::class, 'resetAppleGame'])->name('phanso.apple.reset');
    
    // Bracket game routes
    Route::get('/phanso/bracket', [GameController::class, 'bracketGame'])->name('phanso.bracket');
    Route::post('/phanso/bracket/check', [GameController::class, 'checkBieuthucAnswer'])->name('phanso.bracket.check');
    Route::post('/phanso/bracket/reset', [GameController::class, 'resetBracketGame'])->name('phanso.bracket.reset');

    // Game dọn vườn tối giản
    Route::get('/phanso/garden', [GameController::class, 'gardenGame'])->name('phanso.garden');
    Route::post('/phanso/garden/check', [GameController::class, 'checkGardenAnswer'])->name('phanso.garden.check');
    Route::post('/phanso/garden/reset', [GameController::class, 'resetGardenGame'])->name('phanso.garden.reset');

    // Game tháp phân số
    Route::get('/phanso/tower', [GameController::class, 'towerGame'])->name('phanso.tower');
    Route::post('/phanso/tower/check', [GameController::class, 'checkTowerAnswer'])->name('phanso.tower.check');
    Route::post('/phanso/tower/reset', [GameController::class, 'resetTowerGame'])->name('phanso.tower.reset');

    // Game thẻ bài phân số
    Route::get('/phanso/cards', [GameController::class, 'cardsGame'])->name('phanso.cards');
    Route::post('/phanso/cards/check', [GameController::class, 'checkCardsAnswer'])->name('phanso.cards.check');
    Route::post('/phanso/cards/reset', [GameController::class, 'resetCardsGame'])->name('phanso.cards.reset');

    // Game so sánh phân số
    Route::get('/phanso/compare', [GameController::class, 'compareGame'])->name('phanso.compare');
    Route::post('/phanso/compare/check', [GameController::class, 'checkCompareAnswer'])->name('phanso.compare.check');
    Route::post('/phanso/compare/reset', [GameController::class, 'resetCompareGame'])->name('phanso.compare.reset');

    // Game phân số và phép chia
    Route::get('/phanso/division', [GameController::class, 'divisionGame'])->name('phanso.division');
    Route::post('/phanso/division/check', [GameController::class, 'checkDivisionAnswer'])->name('phanso.division.check');
    Route::post('/phanso/division/reset', [GameController::class, 'resetDivisionGame'])->name('phanso.division.reset');

    // Game chia bánh công bằng
    Route::get('/phanso/fairshare', [GameController::class, 'fairShareGame'])->name('phanso.fairshare');
    Route::post('/phanso/fairshare/check', [GameController::class, 'checkFairShareAnswer'])->name('phanso.fairshare.check');
    Route::post('/phanso/fairshare/reset', [GameController::class, 'resetFairShareGame'])->name('phanso.fairshare.reset');

    // Game săn kho báu phân số
    Route::get('/phanso/treasure', [GameController::class, 'treasureGame'])->name('phanso.treasure');
    Route::post('/phanso/treasure/check', [GameController::class, 'checkTreasureAnswer'])->name('phanso.treasure.check');
    Route::post('/phanso/treasure/reset', [GameController::class, 'resetTreasureGame'])->name('phanso.treasure.reset');

    // Game bầu trời phân số
    Route::get('/phanso/sky', [GameController::class, 'skyGame'])->name('phanso.sky');
    Route::post('/phanso/sky/check', [GameController::class, 'checkSkyAnswer'])->name('phanso.sky.check');
    Route::post('/phanso/sky/reset', [GameController::class, 'resetSkyGame'])->name('phanso.sky.reset');

    // Game miếng bánh còn lại
    Route::get('/phanso/remaining', [GameController::class, 'remainingGame'])->name('phanso.remaining');
    Route::post('/phanso/remaining/check', [GameController::class, 'checkRemainingAnswer'])->name('phanso.remaining.check');
    Route::post('/phanso/remaining/reset', [GameController::class, 'resetRemainingGame'])->name('phanso.remaining.reset');

    // Game ghép câu phân số
    Route::get('/phanso/sentence', [GameController::class, 'sentenceGame'])->name('phanso.sentence');
    Route::post('/phanso/sentence/check', [GameController::class, 'checkSentenceAnswer'])->name('phanso.sentence.check');
    Route::post('/phanso/sentence/reset', [GameController::class, 'resetSentenceGame'])->name('phanso.sentence.reset');
});

Route::middleware(['web'])->group(function () {
    // Base Games
    Route::get('/games/lop4/phanso/cake', [GameController::class, 'cakeGame'])->name('games.lop4.phanso.cake');
    Route::post('/games/lop4/phanso/cake/check', [GameController::class, 'checkCakeAnswer'])->name('games.lop4.phanso.cake.check');
    Route::get('/games/lop4/phanso/cake/reset', [GameController::class, 'resetCakeGame'])->name('games.lop4.phanso.cake.reset');

    Route::get('/games/lop4/phanso/apple', [GameController::class, 'appleGame'])->name('games.lop4.phanso.apple');
    Route::post('/games/lop4/phanso/apple/check', [GameController::class, 'checkAppleAnswer'])->name('games.lop4.phanso.apple.check');
    Route::get('/games/lop4/phanso/apple/reset', [GameController::class, 'resetAppleGame'])->name('games.lop4.phanso.apple.reset');

    Route::get('/games/lop4/phanso/bracket', [GameController::class, 'bracketGame'])->name('games.lop4.phanso.bracket');
    Route::post('/games/lop4/phanso/bracket/check', [GameController::class, 'checkBracketAnswer'])->name('games.lop4.phanso.bracket.check');
    Route::get('/games/lop4/phanso/bracket/reset', [GameController::class, 'resetBracketGame'])->name('games.lop4.phanso.bracket.reset');

    // Garden Game Routes
    Route::get('/games/lop4/phanso/garden', [GameController::class, 'gardenGame'])->name('games.lop4.phanso.garden');
    Route::post('/games/lop4/phanso/garden/check', [GameController::class, 'checkGardenAnswer'])->name('games.lop4.phanso.garden.check');
    Route::get('/games/lop4/phanso/garden/reset', [GameController::class, 'resetGardenGame'])->name('games.lop4.phanso.garden.reset');

    // Tower Game Routes
    Route::get('/games/lop4/phanso/tower', [GameController::class, 'towerGame'])->name('games.lop4.phanso.tower');
    Route::post('/games/lop4/phanso/tower/check', [GameController::class, 'checkTowerAnswer'])->name('games.lop4.phanso.tower.check');
    Route::get('/games/lop4/phanso/tower/reset', [GameController::class, 'resetTowerGame'])->name('games.lop4.phanso.tower.reset');

    // Cards Game Routes
    Route::get('/games/lop4/phanso/cards', [GameController::class, 'cardsGame'])->name('games.lop4.phanso.cards');
    Route::post('/games/lop4/phanso/cards/check', [GameController::class, 'checkCardsAnswer'])->name('games.lop4.phanso.cards.check');
    Route::get('/games/lop4/phanso/cards/reset', [GameController::class, 'resetCardsGame'])->name('games.lop4.phanso.cards.reset');

    // Compare Game Routes
    Route::get('/games/lop4/phanso/compare', [GameController::class, 'compareGame'])->name('games.lop4.phanso.compare');
    Route::post('/games/lop4/phanso/compare/check', [GameController::class, 'checkCompareAnswer'])->name('games.lop4.phanso.compare.check');
    Route::get('/games/lop4/phanso/compare/reset', [GameController::class, 'resetCompareGame'])->name('games.lop4.phanso.compare.reset');

    // Division Game Routes
    Route::get('/games/lop4/phanso/division', [GameController::class, 'divisionGame'])->name('games.lop4.phanso.division');
    Route::post('/games/lop4/phanso/division/check', [GameController::class, 'checkDivisionAnswer'])->name('games.lop4.phanso.division.check');
    Route::get('/games/lop4/phanso/division/reset', [GameController::class, 'resetDivisionGame'])->name('games.lop4.phanso.division.reset');

    // Fair Share Game Routes
    Route::get('/games/lop4/phanso/fair-share', [GameController::class, 'fairShareGame'])->name('games.lop4.phanso.fair_share');
    Route::post('/games/lop4/phanso/fair-share/check', [GameController::class, 'checkFairShareAnswer'])->name('games.lop4.phanso.fair_share.check');
    Route::get('/games/lop4/phanso/fair-share/reset', [GameController::class, 'resetFairShareGame'])->name('games.lop4.phanso.fair_share.reset');

    // Balance Game Routes
    Route::get('/games/lop4/phanso/balance', [GameController::class, 'balanceGame'])->name('games.lop4.phanso.balance');
    Route::post('/games/lop4/phanso/balance/check', [GameController::class, 'checkBalanceAnswer'])->name('games.lop4.phanso.balance.check');
    Route::get('/games/lop4/phanso/balance/reset', [GameController::class, 'resetBalanceGame'])->name('games.lop4.phanso.balance.reset');

    // Pattern Game Routes
    Route::get('/games/lop4/phanso/pattern', [GameController::class, 'patternGame'])->name('games.lop4.phanso.pattern');
    Route::post('/games/lop4/phanso/pattern/check', [GameController::class, 'checkPatternAnswer'])->name('games.lop4.phanso.pattern.check');
    Route::get('/games/lop4/phanso/pattern/reset', [GameController::class, 'resetPatternGame'])->name('games.lop4.phanso.pattern.reset');

    // Word Problem Game Routes
    Route::get('/games/lop4/phanso/word-problem', [GameController::class, 'wordProblemGame'])->name('games.lop4.phanso.word_problem');
    Route::post('/games/lop4/phanso/word-problem/check', [GameController::class, 'checkWordProblemAnswer'])->name('games.lop4.phanso.word_problem.check');
    Route::get('/games/lop4/phanso/word-problem/reset', [GameController::class, 'resetWordProblemGame'])->name('games.lop4.phanso.word_problem.reset');

    // Sky Game Routes
    Route::get('/games/lop4/phanso/sky', [GameController::class, 'skyGame'])->name('games.lop4.phanso.sky');
    Route::post('/games/lop4/phanso/sky/check', [GameController::class, 'checkSkyAnswer'])->name('games.lop4.phanso.sky.check');
    Route::get('/games/lop4/phanso/sky/reset', [GameController::class, 'resetSkyGame'])->name('games.lop4.phanso.sky.reset');

    // Remaining Cake Game Routes
    Route::get('/games/lop4/phanso/remaining-cake', [GameController::class, 'remainingCakeGame'])->name('games.lop4.phanso.remaining_cake');
    Route::post('/games/lop4/phanso/remaining-cake/check', [GameController::class, 'checkRemainingCakeAnswer'])->name('games.lop4.phanso.remaining_cake.check');
    Route::get('/games/lop4/phanso/remaining-cake/reset', [GameController::class, 'resetRemainingCakeGame'])->name('games.lop4.phanso.remaining_cake.reset');

    // Sentence Game Routes
    Route::get('/games/lop4/phanso/sentence', [GameController::class, 'sentenceGame'])->name('games.lop4.phanso.sentence');
    Route::post('/games/lop4/phanso/sentence/check', [GameController::class, 'checkSentenceAnswer'])->name('games.lop4.phanso.sentence.check');
    Route::get('/games/lop4/phanso/sentence/reset', [GameController::class, 'resetSentenceGame'])->name('games.lop4.phanso.sentence.reset');

    // Word Hunt Game Routes
    Route::get('/games/lop4/phanso/word-hunt', [GameController::class, 'wordHuntGame'])->name('games.lop4.phanso.word_hunt');
    Route::post('/games/lop4/phanso/word-hunt/check', [GameController::class, 'checkWordHuntAnswer'])->name('games.lop4.phanso.word_hunt.check');
    Route::get('/games/lop4/phanso/word-hunt/reset', [GameController::class, 'resetWordHuntGame'])->name('games.lop4.phanso.word_hunt.reset');

    // Lost City Game Routes
    Route::get('/games/lop4/phanso/lost-city', [GameController::class, 'lostCityGame'])->name('games.lop4.phanso.lost_city');
    Route::post('/games/lop4/phanso/lost-city/check', [GameController::class, 'checkLostCityAnswer'])->name('games.lop4.phanso.lost_city.check');
    Route::get('/games/lop4/phanso/lost-city/reset', [GameController::class, 'resetLostCityGame'])->name('games.lop4.phanso.lost_city.reset');

    // Equal Groups Game Routes
    Route::get('/games/lop4/phanso/equal-groups', [GameController::class, 'equalGroupsGame'])->name('games.lop4.phanso.equal_groups');
    Route::post('/games/lop4/phanso/equal-groups/check', [GameController::class, 'checkEqualGroupsAnswer'])->name('games.lop4.phanso.equal_groups.check');
    Route::get('/games/lop4/phanso/equal-groups/reset', [GameController::class, 'resetEqualGroupsGame'])->name('games.lop4.phanso.equal_groups.reset');

    // Main Game Hub Route
    Route::get('/games/lop4/phanso', [GameController::class, 'index'])->name('games.lop4.phanso');
});

// Measurement and Units Games Routes
Route::prefix('games/lop4/dailuongvadoluong')->name('games.lop4.dailuongvadoluong.')->group(function () {
    // Overview
    Route::get('/', [MeasurementGameController::class, 'index'])->name('index');

    // 1. Cân Táo Cân Cam
    Route::get('/can-tao-cam', [MeasurementGameController::class, 'fruitWeighingGame'])->name('fruit_weighing');
    Route::post('/can-tao-cam/check', [MeasurementGameController::class, 'checkFruitWeighingAnswer'])->name('fruit_weighing.check');
    Route::get('/can-tao-cam/reset', [MeasurementGameController::class, 'resetFruitWeighingGame'])->name('fruit_weighing.reset');

    // 2. Thời Gian Phiêu Lưu
    Route::get('/time-adventure', [MeasurementGameController::class, 'timeAdventureGame'])->name('time_adventure');
    Route::post('/time-adventure/check', [MeasurementGameController::class, 'checkTimeAdventureAnswer'])->name('time_adventure.check');
    Route::get('/time-adventure/reset', [MeasurementGameController::class, 'resetTimeAdventureGame'])->name('time_adventure.reset');

    // 3. Chuyển Đổi Đơn Vị Thần Tốc
    Route::get('/unit-conversion', [MeasurementGameController::class, 'unitConversionGame'])->name('unit_conversion');
    Route::post('/unit-conversion/check', [MeasurementGameController::class, 'checkUnitConversionAnswer'])->name('unit_conversion.check');
    Route::get('/unit-conversion/reset', [MeasurementGameController::class, 'resetUnitConversionGame'])->name('unit_conversion.reset');

    // 4. Cuộc Đua Đơn Vị Đo
    Route::get('/distance-comparison', [MeasurementGameController::class, 'distanceComparisonGame'])->name('distance_comparison');
    Route::post('/distance-comparison/check', [MeasurementGameController::class, 'checkDistanceComparisonAnswer'])->name('distance_comparison.check');
    Route::get('/distance-comparison/reset', [MeasurementGameController::class, 'resetDistanceComparisonGame'])->name('distance_comparison.reset');

    // 5. Xếp Hàng Theo Khối Lượng
    Route::get('/weight-sorting', [MeasurementGameController::class, 'weightSortingGame'])->name('weight_sorting');
    Route::post('/weight-sorting/check', [MeasurementGameController::class, 'checkWeightSortingAnswer'])->name('weight_sorting.check');
    Route::get('/weight-sorting/reset', [MeasurementGameController::class, 'resetWeightSortingGame'])->name('weight_sorting.reset');

    // 6. Bấm Giờ Chuẩn
    Route::get('/precision-timing', [MeasurementGameController::class, 'precisionTimingGame'])->name('precision_timing');
    Route::post('/precision-timing/check', [MeasurementGameController::class, 'checkPrecisionTimingAnswer'])->name('precision_timing.check');
    Route::get('/precision-timing/reset', [MeasurementGameController::class, 'resetPrecisionTimingGame'])->name('precision_timing.reset');

    // 7. Bảng Quy Đổi
    Route::get('/conversion-table', [MeasurementGameController::class, 'conversionTableGame'])->name('conversion_table');
    Route::post('/conversion-table/check', [MeasurementGameController::class, 'checkConversionTableAnswer'])->name('conversion_table.check');
    Route::get('/conversion-table/reset', [MeasurementGameController::class, 'resetConversionTableGame'])->name('conversion_table.reset');

    // 8. Đo Độ Dài
    Route::get('/length-measurement', [MeasurementGameController::class, 'lengthMeasurementGame'])->name('length_measurement');
    Route::post('/length-measurement/check', [MeasurementGameController::class, 'checkLengthMeasurementAnswer'])->name('length_measurement.check');
    Route::get('/length-measurement/reset', [MeasurementGameController::class, 'resetLengthMeasurementGame'])->name('length_measurement.reset');

    // 9. Ước Lượng Khối Lượng
    Route::get('/weight-estimation', [MeasurementGameController::class, 'weightEstimationGame'])->name('weight_estimation');
    Route::post('/weight-estimation/check', [MeasurementGameController::class, 'checkWeightEstimationAnswer'])->name('weight_estimation.check');
    Route::get('/weight-estimation/reset', [MeasurementGameController::class, 'resetWeightEstimationGame'])->name('weight_estimation.reset');

    // 10. So Sánh Thời Gian
    Route::get('/time-comparison', [MeasurementGameController::class, 'timeComparisonGame'])->name('time_comparison');
    Route::post('/time-comparison/check', [MeasurementGameController::class, 'checkTimeComparisonAnswer'])->name('time_comparison.check');
    Route::get('/time-comparison/reset', [MeasurementGameController::class, 'resetTimeComparisonGame'])->name('time_comparison.reset');

    // 11. Đo Dung Tích
    Route::get('/volume-measurement', [MeasurementGameController::class, 'volumeMeasurementGame'])->name('volume_measurement');
    Route::post('/volume-measurement/check', [MeasurementGameController::class, 'checkVolumeMeasurementAnswer'])->name('volume_measurement.check');
    Route::get('/volume-measurement/reset', [MeasurementGameController::class, 'resetVolumeMeasurementGame'])->name('volume_measurement.reset');

    // 12. Tính Chu Vi
    Route::get('/perimeter-calculation', [MeasurementGameController::class, 'perimeterCalculationGame'])->name('perimeter_calculation');
    Route::post('/perimeter-calculation/check', [MeasurementGameController::class, 'checkPerimeterCalculationAnswer'])->name('perimeter_calculation.check');
    Route::get('/perimeter-calculation/reset', [MeasurementGameController::class, 'resetPerimeterCalculationGame'])->name('perimeter_calculation.reset');

    // 13. Tính Diện Tích
    Route::get('/area-calculation', [MeasurementGameController::class, 'areaCalculationGame'])->name('area_calculation');
    Route::post('/area-calculation/check', [MeasurementGameController::class, 'checkAreaCalculationAnswer'])->name('area_calculation.check');
    Route::get('/area-calculation/reset', [MeasurementGameController::class, 'resetAreaCalculationGame'])->name('area_calculation.reset');

    // 14. Đo Góc
    Route::get('/angle-measurement', [MeasurementGameController::class, 'angleMeasurementGame'])->name('angle_measurement');
    Route::post('/angle-measurement/check', [MeasurementGameController::class, 'checkAngleMeasurementAnswer'])->name('angle_measurement.check');
    Route::get('/angle-measurement/reset', [MeasurementGameController::class, 'resetAngleMeasurementGame'])->name('angle_measurement.reset');

    // 15. Thời Gian Nâng Cao
    Route::get('/advanced-time', [MeasurementGameController::class, 'advancedTimeGame'])->name('advanced_time');
    Route::post('/advanced-time/check', [MeasurementGameController::class, 'checkAdvancedTimeAnswer'])->name('advanced_time.check');
    Route::get('/advanced-time/reset', [MeasurementGameController::class, 'resetAdvancedTimeGame'])->name('advanced_time.reset');
});
