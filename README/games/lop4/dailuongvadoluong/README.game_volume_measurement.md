# Game Đo Dung Tích 🥛

## Mục tiêu
Giúp học sinh luyện tập đo và ước lượng dung tích các vật chứa, phát triển kỹ năng sử dụng đơn vị dung tích (ml, l) và nhận biết các vật dụng thực tế.

## Yêu cầu hệ thống
- PHP >= 7.4
- Laravel >= 8.0
- Node.js >= 14.0
- MySQL >= 5.7
- Trình duyệt hỗ trợ modern JavaScript

## Cài đặt
1. Clone repository
2. Chạy `composer install`
3. Chạy `npm install`
4. Copy `.env.example` thành `.env`
5. Chạy `php artisan key:generate`
6. Cấu hình database trong `.env`
7. Chạy `php artisan migrate`
8. Chạy `npm run dev`

## Cấu trúc game

### 1. Giao diện
- Hiển thị hình ảnh bình/chai nước, cốc đo
- Nút điều chỉnh dung tích (tăng/giảm)
- Ô nhập đáp án dung tích
- Thông báo đúng/sai
- Bảng điểm
- Bảng quy đổi dung tích tham khảo

### 2. Các level
- **Level 1**: Đo dung tích đơn giản (ml, l)
- **Level 2**: Thêm vật chứa khó hơn
- **Level 3**: Đơn vị hỗn hợp (ml, l, dm³)
- **Level 4**: Số lượng vật chứa nhiều hơn
- **Level 5**: Thời gian giới hạn

### 3. Logic game
```php
// Kiểm tra đáp án với sai số cho phép
function checkVolume($userAnswer, $actualVolume, $tolerance) {
    return abs($userAnswer - $actualVolume) <= $tolerance;
}
```

### 4. Cách chơi
1. Quan sát vật chứa trên màn hình
2. Nhập đáp án dung tích hoặc điều chỉnh mức nước
3. Nhấn kiểm tra để xác nhận
4. Đúng thì cộng điểm, sai thì trừ điểm
5. Chuyển level khi đạt đủ điểm

### 5. Kiểm tra đáp án
```php
$correct = checkVolume($userAnswer, $actualVolume, $tolerance);
```

### 6. Phản hồi
- **Đúng**: 
  - Hiển thị thông báo chúc mừng
  - Cộng điểm
- **Sai**: 
  - Hiển thị đáp án đúng
  - Trừ điểm

## Cấu trúc code

### Routes
```php
// Game đo dung tích
Route::get('/dailuongvadoluong/volume-measurement', [MeasurementGameController::class, 'volumeMeasurementGame']);
Route::post('/dailuongvadoluong/volume-measurement/check', [MeasurementGameController::class, 'checkVolumeMeasurementAnswer']);
Route::post('/dailuongvadoluong/volume-measurement/reset', [MeasurementGameController::class, 'resetVolumeMeasurementGame']);
```

### Views
- **File**: `resources/views/games/lop4/dailuongvadoluong/do_dung_tich.blade.php`
- **Components**:
  - Hình ảnh vật chứa
  - Input đáp án
  - Nút điều chỉnh dung tích
  - Thông báo
  - Bảng điểm
  - Bảng quy đổi dung tích

### JavaScript
- Sinh vật chứa ngẫu nhiên
- Kiểm tra đáp án
- Quản lý điểm số
- Hiệu ứng thông báo

### Session
- Key: `volume_measurement_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho logic
- HTML5 cho giao diện
- Laravel cho backend
- Bootstrap/Tailwind cho UI

## Cải tiến có thể thực hiện
1. Thêm nhiều vật chứa hơn
2. Thêm chế độ thi đấu thời gian
3. Thêm bảng xếp hạng
4. Thêm giải thích đáp án 