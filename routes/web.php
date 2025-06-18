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
    return redirect()->route('game.lop4.tong_quan');
});

Route::prefix('tro-choi/lop4')->name('game.lop4.')
    ->group(function () {
        // Trang chính
        Route::get('/', [GradeController::class, 'index'])
            ->name('tong_quan');

        // ===========================================
        // KHÁM PHÁ PHÂN SỐ (Fraction Exploration)
        // ===========================================
        Route::prefix('kham-pha-phan-so')->name('kham_pha_phan_so.')
            ->group(function () {
                Route::get('/', [KhamPhaPhanSoController::class, 'index'])
                    ->name('tong_quan');

                // Game Táo
                Route::get('/qua-tao', [KhamPhaPhanSoController::class, 'appleGame'])
                    ->name('qua_tao');
                Route::post('/qua-tao/kiem-tra', [KhamPhaPhanSoController::class, 'checkAppleAnswer'])
                    ->name('qua_tao.kiem_tra');

                // Game Cân Bằng
                Route::get('/can-bang', [KhamPhaPhanSoController::class, 'balanceGame'])
                    ->name('can_bang');
                Route::post('/can-bang/kiem-tra', [KhamPhaPhanSoController::class, 'checkBalanceAnswer'])
                    ->name('can_bang.kiem_tra');

                // Game Dấu Ngoặc
                Route::get('/dau-ngoac', [KhamPhaPhanSoController::class, 'bracketGame'])
                    ->name('dau_ngoac');
                Route::post('/dau-ngoac/kiem-tra', [KhamPhaPhanSoController::class, 'checkBracketAnswer'])
                    ->name('dau_ngoac.kiem_tra');

                // Game Bánh Ngọt
                Route::get('/banh-ngot', [KhamPhaPhanSoController::class, 'cakeGame'])
                    ->name('banh_ngot');
                Route::post('/banh-ngot/kiem-tra', [KhamPhaPhanSoController::class, 'checkCakeAnswer'])
                    ->name('banh_ngot.kiem_tra');

                // Game Thẻ Bài
                Route::get('/the-bai', [KhamPhaPhanSoController::class, 'cardsGame'])
                    ->name('the_bai');
                Route::post('/the-bai/kiem-tra', [KhamPhaPhanSoController::class, 'checkCardsAnswer'])
                    ->name('the_bai.kiem_tra');

                // Game So Sánh
                Route::get('/so-sanh', [KhamPhaPhanSoController::class, 'compareGame'])
                    ->name('so_sanh');
                Route::post('/so-sanh/kiem-tra', [KhamPhaPhanSoController::class, 'checkCompareAnswer'])
                    ->name('so_sanh.kiem_tra');

                // Game Phép Chia
                Route::get('/phep-chia', [KhamPhaPhanSoController::class, 'divisionGame'])
                    ->name('phep_chia');
                Route::post('/phep-chia/kiem-tra', [KhamPhaPhanSoController::class, 'checkDivisionAnswer'])
                    ->name('phep_chia.kiem_tra');

                // Game Nhóm Bằng Nhau
                Route::get('/nhom-bang-nhau', [KhamPhaPhanSoController::class, 'equalGroupsGame'])
                    ->name('nhom_bang_nhau');

                // Game Chia Đều
                Route::get('/chia-deu', [KhamPhaPhanSoController::class, 'fairShare'])
                    ->name('chia_deu');

                // Game Vườn Hoa
                Route::get('/vuon-hoa', [KhamPhaPhanSoController::class, 'gardenGame'])
                    ->name('vuon_hoa');
                Route::post('/vuon-hoa/kiem-tra', [KhamPhaPhanSoController::class, 'checkGardenAnswer'])
                    ->name('vuon_hoa.kiem_tra');

                // Game Thành Phố Bí Ẩn
                Route::get('/thanh-pho-bi-an', [KhamPhaPhanSoController::class, 'lostCityGame'])
                    ->name('thanh_pho_bi_an');
                Route::post('/thanh-pho-bi-an/kiem-tra', [KhamPhaPhanSoController::class, 'checkLostCityAnswer'])
                    ->name('thanh_pho_bi_an.kiem_tra');

                // Game Quy Luật
                Route::get('/quy-luat', [KhamPhaPhanSoController::class, 'patternGame'])
                    ->name('quy_luat');
                Route::post('/quy-luat/kiem-tra', [KhamPhaPhanSoController::class, 'checkPatternAnswer'])
                    ->name('quy_luat.kiem_tra');

                // Game Phân Số
                Route::get('/phan-so', [KhamPhaPhanSoController::class, 'phanso'])
                    ->name('phan_so');

                // Game Bánh Còn Lại
                Route::get('/banh-con-lai', [KhamPhaPhanSoController::class, 'remainingCakeGame'])
                    ->name('banh_con_lai');
                Route::post('/banh-con-lai/kiem-tra', [KhamPhaPhanSoController::class, 'checkRemainingCakeAnswer'])
                    ->name('banh_con_lai.kiem_tra');

                // Game Ghép Câu
                Route::get('/ghep-cau', [KhamPhaPhanSoController::class, 'sentenceGame'])
                    ->name('ghep_cau');
                Route::post('/ghep-cau/kiem-tra', [KhamPhaPhanSoController::class, 'checkSentenceAnswer'])
                    ->name('ghep_cau.kiem_tra');

                // Game Bầu Trời
                Route::get('/bau-troi', [KhamPhaPhanSoController::class, 'skyGame'])
                    ->name('bau_troi');
                Route::post('/bau-troi/kiem-tra', [KhamPhaPhanSoController::class, 'checkSkyAnswer'])
                    ->name('bau_troi.kiem_tra');

                // Game Tháp Phân Số
                Route::get('/thap-phan-so', [KhamPhaPhanSoController::class, 'towerGame'])
                    ->name('thap_phan_so');
                Route::post('/thap-phan-so/kiem-tra', [KhamPhaPhanSoController::class, 'checkTowerAnswer'])
                    ->name('thap_phan_so.kiem_tra');

                // Game Săn Từ
                Route::get('/san-tu', [KhamPhaPhanSoController::class, 'wordHuntGame'])
                    ->name('san_tu');
                Route::post('/san-tu/kiem-tra', [KhamPhaPhanSoController::class, 'checkWordHuntAnswer'])
                    ->name('san_tu.kiem_tra');

                // Game Bài Toán Lời Văn
                Route::get('/bai-toan-loi-van', [KhamPhaPhanSoController::class, 'wordProblemGame'])
                    ->name('bai_toan_loi_van');
                Route::post('/bai-toan-loi-van/kiem-tra', [KhamPhaPhanSoController::class, 'checkWordProblemAnswer'])
                    ->name('bai_toan_loi_van.kiem_tra');
            });

        // ===========================================
        // PHÂN SỐ CƠ BẢN (Basic Fractions) - Legacy Routes
        // ===========================================
        Route::prefix('phan-so')->name('phan_so.')
            ->group(function () {
                // Trang tổng quan game
                Route::get('/', [GameController::class, 'index'])->name('tong_quan');

//                // Game Bánh Ngọt
//                Route::get('/banh-ngot', [GameController::class, 'cakeGame'])
//                    ->name('banh_ngot');
//                Route::post('/banh-ngot/kiem-tra', [GameController::class, 'checkCakeAnswer'])
//                    ->name('banh_ngot.kiem_tra');
//
//                // Game Táo
//                Route::get('/tao', [GameController::class, 'appleGame'])
//                    ->name('tao');
//                Route::post('/tao/kiem-tra', [GameController::class, 'checkAppleAnswer'])
//                    ->name('tao.kiem_tra');
//
//                // Game Ngoặc Đơn
//                Route::get('/ngoac-don', [GameController::class, 'bracketGame'])
//                    ->name('ngoac_don');
//                Route::post('/ngoac-don/kiem-tra', [GameController::class, 'checkBracketAnswer'])
//                    ->name('ngoac_don.kiem_tra');
//
//                // Game Vườn Hoa
//                Route::get('/vuon-hoa', [GameController::class, 'gardenGame'])
//                    ->name('vuon_hoa');
//                Route::post('/vuon-hoa/kiem-tra', [GameController::class, 'checkGardenAnswer'])
//                    ->name('vuon_hoa.kiem_tra');
//
//                // Game Tháp
//                Route::get('/thap', [GameController::class, 'towerGame'])
//                    ->name('thap');
//                Route::post('/thap/kiem-tra', [GameController::class, 'checkTowerAnswer'])
//                    ->name('thap.kiem_tra');
//
//                // Game Thẻ Bài
//                Route::get('/the-bai', [GameController::class, 'cardsGame'])
//                    ->name('the_bai');
//                Route::post('/the-bai/kiem-tra', [GameController::class, 'checkCardsAnswer'])
//                    ->name('the_bai.kiem_tra');
//
//                // Game So Sánh
//                Route::get('/so-sanh', [GameController::class, 'compareGame'])
//                    ->name('so_sanh');
//                Route::post('/so-sanh/kiem-tra', [GameController::class, 'checkCompareAnswer'])
//                    ->name('so_sanh.kiem_tra');
//
//                // Game Phép Chia
//                Route::get('/phep-chia', [GameController::class, 'divisionGame'])
//                    ->name('phep_chia');
//                Route::post('/phep-chia/kiem-tra', [GameController::class, 'checkDivisionAnswer'])
//                    ->name('phep_chia.kiem_tra');
//
//                // Game Chia Công Bằng
//                Route::get('/chia-cong-bang', [GameController::class, 'fairShareGame'])
//                    ->name('chia_cong_bang');
//                Route::post('/chia-cong-bang/kiem-tra', [GameController::class, 'checkFairShareAnswer'])
//                    ->name('chia_cong_bang.kiem_tra');
//
//                // Game Săn Kho Báu
//                Route::get('/san-kho-bau', [GameController::class, 'treasureGame'])
//                    ->name('san_kho_bau');
//                Route::post('/san-kho-bau/kiem-tra', [GameController::class, 'checkTreasureAnswer'])
//                    ->name('san_kho_bau.kiem_tra');
//
//                // Game Bầu Trời
//                Route::get('/bau-troi', [GameController::class, 'skyGame'])
//                    ->name('bau_troi');
//                Route::post('/bau-troi/kiem-tra', [GameController::class, 'checkSkyAnswer'])
//                    ->name('bau_troi.kiem_tra');
//
//                // Game Còn Lại
//                Route::get('/con-lai', [GameController::class, 'remainingGame'])
//                    ->name('con_lai');
//                Route::post('/con-lai/kiem-tra', [GameController::class, 'checkRemainingAnswer'])
//                    ->name('con_lai.kiem_tra');
//
//                // Game Ghép Câu
//                Route::get('/ghep-cau', [GameController::class, 'sentenceGame'])
//                    ->name('ghep_cau');
//                Route::post('/ghep-cau/kiem-tra', [GameController::class, 'checkSentenceAnswer'])
//                    ->name('ghep_cau.kiem_tra');
//
//                // Game Cân Bằng
//                Route::get('/can-bang', [GameController::class, 'balanceGame'])
//                    ->name('can_bang');
//                Route::post('/can-bang/kiem-tra', [GameController::class, 'checkBalanceAnswer'])
//                    ->name('can_bang.kiem_tra');
//
//                // Game Quy Luật
//                Route::get('/quy-luat', [GameController::class, 'patternGame'])
//                    ->name('quy_luat');
//                Route::post('/quy-luat/kiem-tra', [GameController::class, 'checkPatternAnswer'])
//                    ->name('quy_luat.kiem_tra');
//
//                // Game Bài Toán Lời Văn
//                Route::get('/bai-toan-loi-van', [GameController::class, 'wordProblemGame'])
//                    ->name('bai_toan_loi_van');
//                Route::post('/bai-toan-loi-van/kiem-tra', [GameController::class, 'checkWordProblemAnswer'])
//                    ->name('bai_toan_loi_van.kiem_tra');
//
//                // Game Bánh Còn Lại
//                Route::get('/banh-con-lai', [GameController::class, 'remainingCakeGame'])
//                    ->name('banh_con_lai');
//                Route::post('/banh-con-lai/kiem-tra', [GameController::class, 'checkRemainingCakeAnswer'])
//                    ->name('banh_con_lai.kiem_tra');
//
//                // Game Săn Từ
//                Route::get('/san-tu', [GameController::class, 'wordHuntGame'])
//                    ->name('san_tu');
//                Route::post('/san-tu/kiem-tra', [GameController::class, 'checkWordHuntAnswer'])
//                    ->name('san_tu.kiem_tra');
//
//                // Game Thành Phố Mất
//                Route::get('/thanh-pho-mat', [GameController::class, 'lostCityGame'])
//                    ->name('thanh_pho_mat');
//                Route::post('/thanh-pho-mat/kiem-tra', [GameController::class, 'checkLostCityAnswer'])
//                    ->name('thanh_pho_mat.kiem_tra');
//
//                // Game Nhóm Bằng Nhau
//                Route::get('/nhom-bang-nhau', [GameController::class, 'equalGroupsGame'])
//                    ->name('nhom_bang_nhau');
//                Route::post('/nhom-bang-nhau/kiem-tra', [GameController::class, 'checkEqualGroupsAnswer'])
//                    ->name('nhom_bang_nhau.kiem_tra');
            });

        // ===========================================
        // ĐO LƯỜNG VÀ ĐƠN VỊ (Measurement and Units)
        // ===========================================
        Route::prefix('do-luong-va-don-vi')->name('do_luong_va_don_vi.')
            ->group(function () {
                Route::get('/', [MeasurementGameController::class, 'index'])
                    ->name('tong_quan');

//                // Game Cân Táo Cân Cam
//                Route::get('/can-tao-can-cam', [MeasurementGameController::class, 'fruitWeighingGame'])
//                    ->name('can_tao_can_cam');
//                Route::post('/can-tao-can-cam/kiem-tra', [MeasurementGameController::class, 'checkFruitWeighingAnswer'])
//                    ->name('can_tao_can_cam.kiem_tra');
//
//                // Game Phiêu Lưu Thời Gian
//                Route::get('/phieu-luu-thoi-gian', [MeasurementGameController::class, 'timeAdventureGame'])
//                    ->name('phieu_luu_thoi_gian');
//                Route::post('/phieu-luu-thoi-gian/kiem-tra', [MeasurementGameController::class, 'checkTimeAdventureAnswer'])
//                    ->name('phieu_luu_thoi_gian.kiem_tra');
//
//                // Game Chuyển Đổi Đơn Vị
//                Route::get('/chuyen-doi-don-vi', [MeasurementGameController::class, 'unitConversionGame'])
//                    ->name('chuyen_doi_don_vi');
//                Route::post('/chuyen-doi-don-vi/kiem-tra', [MeasurementGameController::class, 'checkUnitConversionAnswer'])
//                    ->name('chuyen_doi_don_vi.kiem_tra');
//
//                // Game So Sánh Khoảng Cách
//                Route::get('/so-sanh-khoang-cach', [MeasurementGameController::class, 'distanceComparisonGame'])
//                    ->name('so_sanh_khoang_cach');
//                Route::post('/so-sanh-khoang-cach/kiem-tra', [MeasurementGameController::class, 'checkDistanceComparisonAnswer'])
//                    ->name('so_sanh_khoang_cach.kiem_tra');
//
//                // Game Sắp Xếp Khối Lượng
//                Route::get('/sap-xep-khoi-luong', [MeasurementGameController::class, 'weightSortingGame'])
//                    ->name('sap_xep_khoi_luong');
//                Route::post('/sap-xep-khoi-luong/kiem-tra', [MeasurementGameController::class, 'checkWeightSortingAnswer'])
//                    ->name('sap_xep_khoi_luong.kiem_tra');
//
//                // Game Bấm Giờ Chính Xác
//                Route::get('/bam-gio-chinh-xac', [MeasurementGameController::class, 'precisionTimingGame'])
//                    ->name('bam_gio_chinh_xac');
//                Route::post('/bam-gio-chinh-xac/kiem-tra', [MeasurementGameController::class, 'checkPrecisionTimingAnswer'])
//                    ->name('bam_gio_chinh_xac.kiem_tra');
//
//                // Game Bảng Quy Đổi
//                Route::get('/bang-quy-doi', [MeasurementGameController::class, 'conversionTableGame'])
//                    ->name('bang_quy_doi');
//                Route::post('/bang-quy-doi/kiem-tra', [MeasurementGameController::class, 'checkConversionTableAnswer'])
//                    ->name('bang_quy_doi.kiem_tra');
//
//                // Game Đo Độ Dài
//                Route::get('/do-do-dai', [MeasurementGameController::class, 'lengthMeasurementGame'])
//                    ->name('do_do_dai');
//                Route::post('/do-do-dai/kiem-tra', [MeasurementGameController::class, 'checkLengthMeasurementAnswer'])
//                    ->name('do_do_dai.kiem_tra');
//
//                // Game Ước Lượng Khối Lượng
//                Route::get('/uoc-luong-khoi-luong', [MeasurementGameController::class, 'weightEstimationGame'])
//                    ->name('uoc_luong_khoi_luong');
//                Route::post('/uoc-luong-khoi-luong/kiem-tra', [MeasurementGameController::class, 'checkWeightEstimationAnswer'])
//                    ->name('uoc_luong_khoi_luong.kiem_tra');
//
//                // Game So Sánh Thời Gian
//                Route::get('/so-sanh-thoi-gian', [MeasurementGameController::class, 'timeComparisonGame'])
//                    ->name('so_sanh_thoi_gian');
//                Route::post('/so-sanh-thoi-gian/kiem-tra', [MeasurementGameController::class, 'checkTimeComparisonAnswer'])
//                    ->name('so_sanh_thoi_gian.kiem_tra');
//
//                // Game Đo Dung Tích
//                Route::get('/do-dung-tich', [MeasurementGameController::class, 'volumeMeasurementGame'])
//                    ->name('do_dung_tich');
//                Route::post('/do-dung-tich/kiem-tra', [MeasurementGameController::class, 'checkVolumeMeasurementAnswer'])
//                    ->name('do_dung_tich.kiem_tra');
//
//                // Game Tính Chu Vi
//                Route::get('/tinh-chu-vi', [MeasurementGameController::class, 'perimeterCalculationGame'])
//                    ->name('tinh_chu_vi');
//                Route::post('/tinh-chu-vi/kiem-tra', [MeasurementGameController::class, 'checkPerimeterCalculationAnswer'])
//                    ->name('tinh_chu_vi.kiem_tra');
//
//                // Game Tính Diện Tích
//                Route::get('/tinh-dien-tich', [MeasurementGameController::class, 'areaCalculationGame'])
//                    ->name('tinh_dien_tich');
//                Route::post('/tinh-dien-tich/kiem-tra', [MeasurementGameController::class, 'checkAreaCalculationAnswer'])
//                    ->name('tinh_dien_tich.kiem_tra');
//
//                // Game Đo Góc
//                Route::get('/do-goc', [MeasurementGameController::class, 'angleMeasurementGame'])
//                    ->name('do_goc');
//                Route::post('/do-goc/kiem-tra', [MeasurementGameController::class, 'checkAngleMeasurementAnswer'])
//                    ->name('do_goc.kiem_tra');
//
//                // Game Thời Gian Nâng Cao
//                Route::get('/thoi-gian-nang-cao', [MeasurementGameController::class, 'advancedTimeGame'])
//                    ->name('thoi_gian_nang_cao');
//                Route::post('/thoi-gian-nang-cao/kiem-tra', [MeasurementGameController::class, 'checkAdvancedTimeAnswer'])
//                    ->name('thoi_gian_nang_cao.kiem_tra');
            });

        // ===========================================
        // BÍ ẨN HÌNH HỌC (Geometry Mysteries)
        // ===========================================
        Route::prefix('bi-an-hinh-hoc')->name('bi_an_hinh_hoc.')
            ->group(function () {
                Route::get('/', static function () {
                    return view('games.lop4.bi_an_hinh_hoc.bi_an_hinh_hoc');
                })->name('tong_quan');

//                Route::get('/tinh-dien-tich', [HinhHocGameController::class, 'areaCalculationGame'])
//                    ->name('tinh_dien_tich');
//                Route::get('/tinh-chu-vi', [HinhHocGameController::class, 'perimeterCalculationGame'])
//                    ->name('tinh_chu_vi');
//                Route::get('/do-goc', [HinhHocGameController::class, 'angleMeasurementGame'])
//                    ->name('do_goc');
//                Route::get('/do-the-tich', [HinhHocGameController::class, 'volumeMeasurementGame'])
//                    ->name('do_the_tich');
            });

        // ===========================================
        // DÃY SỐ QUY LUẬT (Number Sequence Patterns)
        // ===========================================
        Route::prefix('day-so-quy-luat')->name('day_so_quy_luat.')
            ->group(function () {
                Route::get('/', static function () {
                    return view('games.lop4.day_so_quy_luat.day_so_quy_luat');
                })->name('tong_quan');

//                Route::get('/tim-quy-luat', [DaySoQuyLuatController::class, 'patternGame'])
//                    ->name('tim_quy_luat');
//                Route::post('/tim-quy-luat/kiem-tra', [DaySoQuyLuatController::class, 'checkAnswer'])
//                    ->name('tim_quy_luat.kiem_tra');
            });

        // ===========================================
        // GIẢI TOÁN LỜI VĂN (Word Problem Solving)
        // ===========================================
        Route::prefix('giai-toan-loi-van')->name('giai_toan_loi_van.')
            ->group(function () {
                Route::get('/', static function () {
                    return view('games.lop4.giai_toan_loi_van.giai_toan_loi_van');
                })->name('tong_quan');

//                Route::get('/thanh-pho-mat-tich', [GiaiToanLoiVanController::class, 'lostCity'])
//                    ->name('thanh_pho_mat_tich');
//                Route::post('/thanh-pho-mat-tich/kiem-tra', [GiaiToanLoiVanController::class, 'checkLostCityAnswer'])
//                    ->name('thanh_pho_mat_tich.kiem_tra');
//                Route::get('/bai-toan-loi-van', [GiaiToanLoiVanController::class, 'wordProblemGame'])
//                    ->name('bai_toan_loi_van');
//                Route::post('/bai-toan-loi-van/kiem-tra', [GiaiToanLoiVanController::class, 'checkAnswer'])
//                    ->name('bai_toan_loi_van.kiem_tra');
            });

        // ===========================================
        // SỐ TỰ NHIÊN VÀ CÁC PHÉP TÍNH (Natural Numbers and Operations)
        // ===========================================
        Route::prefix('so-tu-nhien-va-cac-phep-tinh')->name('so_tu_nhien_va_cac_phep_tinh.')
            ->group(function () {
                Route::get('/', static function () {
                    return view('games.lop4.so_tu_nhien_va_cac_phep_tinh.so_tu_nhien_va_cac_phep_tinh');
                })->name('tong_quan');

//                Route::get('/gia-tri-chu-so', [SoTuNhienVaCacPhepTinhController::class, 'numberPlaceValueGame'])
//                    ->name('gia_tri_chu_so');
//                Route::get('/cong-tru', [SoTuNhienVaCacPhepTinhController::class, 'additionSubtractionGame'])
//                    ->name('cong_tru');
//                Route::get('/nhan-chia', [SoTuNhienVaCacPhepTinhController::class, 'multiplicationDivisionGame'])
//                    ->name('nhan_chia');
//                Route::get('/phep-tinh-hon-hop', [SoTuNhienVaCacPhepTinhController::class, 'mixedOperationsGame'])
//                    ->name('phep_tinh_hon_hop');
            });

        // ===========================================
        // THỐNG KÊ BIỂU ĐỒ (Statistics and Charts)
        // ===========================================
        Route::prefix('thong-ke-bieu-do')->name('thong_ke_bieu_do.')
            ->group(function () {
                Route::get('/', static function () {
                    return view('games.lop4.thong_ke_bieu_do.thong_ke_bieu_do');
                })->name('tong_quan');

//                Route::get('/thu-thap-du-lieu', [ThongKeBieuDoController::class, 'dataCollectionGame'])
//                    ->name('thu_thap_du_lieu');
//                Route::get('/bieu-do-cot', [ThongKeBieuDoController::class, 'barChartGame'])
//                    ->name('bieu_do_cot');
//                Route::get('/bieu-do-duong', [ThongKeBieuDoController::class, 'lineChartGame'])
//                    ->name('bieu_do_duong');
//                Route::get('/bieu-do-tron', [ThongKeBieuDoController::class, 'pieChartGame'])
//                    ->name('bieu_do_tron');
            });

        // ===========================================
        // THỬ THÁCH ĐO LƯỜNG (Measurement Challenges)
        // ===========================================
        Route::prefix('thu-thach-do-luong')->name('thu_thach_do_luong.')
            ->group(function () {
                Route::get('/', static function () {
                    return view('games.lop4.thu_thach_do_luong.thu_thach_do_luong');
                })->name('tong_quan');

//                Route::get('/do-do-dai', [ThuThachDoLuongController::class, 'lengthMeasurementGame'])
//                    ->name('do_do_dai');
//                Route::get('/do-khoi-luong', [ThuThachDoLuongController::class, 'weightMeasurementGame'])
//                    ->name('do_khoi_luong');
//                Route::get('/do-thoi-gian', [ThuThachDoLuongController::class, 'timeMeasurementGame'])
//                    ->name('do_thoi_gian');
//                Route::get('/tinh-tien', [ThuThachDoLuongController::class, 'moneyCalculationGame'])
//                    ->name('tinh_tien');
            });
    });
