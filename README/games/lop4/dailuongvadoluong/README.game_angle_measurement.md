# Game Đo Góc 📐

## Mục tiêu
Giúp học sinh luyện tập đo và ước lượng góc, phát triển kỹ năng sử dụng thước đo góc và nhận biết các loại góc trong thực tế.

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
- Hiển thị hình vẽ các góc
- Ô nhập đáp án số đo góc
- Thông báo đúng/sai
- Bảng điểm
- Bảng quy đổi góc tham khảo

### 2. Các level
- **Level 1**: Đo góc đơn giản (30°, 45°, 90°)
- **Level 2**: Thêm góc nhọn, góc tù, góc bẹt
- **Level 3**: Góc phức tạp hơn
- **Level 4**: Nhiều góc trên một câu hỏi
- **Level 5**: Thời gian giới hạn

### 3. Logic game
```php
// Kiểm tra đáp án với sai số cho phép
function checkAngle($userAnswer, $actualAngle, $tolerance) {
    return abs($userAnswer - $actualAngle) <= $tolerance;
}
```

### 4. Cách chơi
1. Quan sát hình vẽ góc trên màn hình
2. Nhập đáp án số đo góc
3. Nhấn kiểm tra để xác nhận
4. Đúng thì cộng điểm, sai thì trừ điểm
5. Chuyển level khi đạt đủ điểm

### 5. Kiểm tra đáp án
```php
$correct = checkAngle($userAnswer, $actualAngle, $tolerance);
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
// Game đo góc
Route::get('/dailuongvadoluong/angle-measurement', [MeasurementGameController::class, 'angleMeasurementGame']);
Route::post('/dailuongvadoluong/angle-measurement/check', [MeasurementGameController::class, 'checkAngleMeasurementAnswer']);
Route::post('/dailuongvadoluong/angle-measurement/reset', [MeasurementGameController::class, 'resetAngleMeasurementGame']);
```

### Views
- **File**: `resources/views/games/lop4/dailuongvadoluong/angle_measurement.blade.php`
- **Components**:
  - Hình vẽ các góc
  - Input đáp án
  - Thông báo
  - Bảng điểm
  - Bảng quy đổi góc

### JavaScript
- Sinh góc ngẫu nhiên
- Kiểm tra đáp án
- Quản lý điểm số
- Hiệu ứng thông báo

### Session
- Key: `angle_measurement_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho logic
- HTML5 cho giao diện
- Laravel cho backend
- Bootstrap/Tailwind cho UI

## Cải tiến có thể thực hiện
1. Thêm nhiều loại góc hơn
2. Thêm chế độ thi đấu thời gian
3. Thêm bảng xếp hạng
4. Thêm giải thích đáp án 