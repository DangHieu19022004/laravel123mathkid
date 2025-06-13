# Game Bấm Giờ Chuẩn ⏱️

## Mục tiêu
Giúp học sinh luyện tập ước lượng và bấm giờ chính xác, phát triển kỹ năng cảm nhận thời gian và phản xạ.

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
- Hiển thị đồng hồ hoặc thanh thời gian
- Nút bắt đầu và dừng bấm giờ
- Hiển thị mục tiêu thời gian cần đạt
- Thông báo đúng/sai
- Bảng điểm

### 2. Các level
- **Level 1**: Ước lượng 5 giây
- **Level 2**: Ước lượng 10 giây
- **Level 3**: Ước lượng 15 giây
- **Level 4**: Ước lượng 30 giây
- **Level 5**: Ước lượng 60 giây

### 3. Logic game
```php
// Kiểm tra sai số thời gian
function checkTiming($userTime, $targetTime, $tolerance) {
    return abs($userTime - $targetTime) <= $tolerance;
}
```

### 4. Cách chơi
1. Đọc mục tiêu thời gian trên màn hình
2. Nhấn bắt đầu, sau đó nhấn dừng khi cảm thấy đủ thời gian
3. Xem kết quả và sai số
4. Đúng thì cộng điểm, sai thì trừ điểm
5. Chuyển level khi đạt đủ điểm

### 5. Kiểm tra đáp án
```php
$correct = checkTiming($userTime, $targetTime, $tolerance);
```

### 6. Phản hồi
- **Đúng**: 
  - Hiển thị thông báo chúc mừng
  - Cộng điểm
- **Sai**: 
  - Hiển thị đáp án đúng và sai số
  - Trừ điểm

## Cấu trúc code

### Routes
```php
// Game bấm giờ chuẩn
Route::get('/dailuongvadoluong/precision-timing', [MeasurementGameController::class, 'precisionTimingGame']);
Route::post('/dailuongvadoluong/precision-timing/check', [MeasurementGameController::class, 'checkPrecisionTimingAnswer']);
Route::get('/dailuongvadoluong/precision-timing/reset', [MeasurementGameController::class, 'resetPrecisionTimingGame']);
```

### Views
- **File**: `resources/views/games/lop4/dailuongvadoluong/precision_timing.blade.php`
- **Components**:
  - Đồng hồ/thanh thời gian
  - Nút bắt đầu/dừng
  - Thông báo
  - Bảng điểm

### JavaScript
- Đếm thời gian
- Kiểm tra sai số
- Quản lý điểm số
- Hiệu ứng thông báo

### Session
- Key: `precision_timing_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho logic
- HTML5 cho giao diện
- Laravel cho backend
- Bootstrap/Tailwind cho UI

## Cải tiến có thể thực hiện
1. Thêm nhiều mức thời gian hơn
2. Thêm chế độ thi đấu thời gian
3. Thêm bảng xếp hạng
4. Thêm giải thích đáp án 