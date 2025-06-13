# Game Đo Độ Dài 📏

## Mục tiêu
Giúp học sinh luyện tập đo và ước lượng độ dài các vật thể, phát triển kỹ năng sử dụng thước đo và nhận biết đơn vị độ dài.

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
- Hiển thị hình ảnh hoặc mô tả vật thể cần đo
- Ô nhập đáp án độ dài
- Thông báo đúng/sai
- Bảng điểm
- Bảng quy đổi độ dài tham khảo

### 2. Các level
- **Level 1**: Đo độ dài đơn giản (cm, m)
- **Level 2**: Thêm vật thể khó hơn
- **Level 3**: Đơn vị hỗn hợp (mm, cm, m, km)
- **Level 4**: Số lượng vật thể nhiều hơn
- **Level 5**: Thời gian giới hạn

### 3. Logic game
```php
// Kiểm tra đáp án với sai số cho phép
function checkLength($userAnswer, $actualLength, $tolerance) {
    return abs($userAnswer - $actualLength) <= $tolerance;
}
```

### 4. Cách chơi
1. Quan sát vật thể trên màn hình
2. Nhập đáp án độ dài
3. Nhấn kiểm tra để xác nhận
4. Đúng thì cộng điểm, sai thì trừ điểm
5. Chuyển level khi đạt đủ điểm

### 5. Kiểm tra đáp án
```php
$correct = checkLength($userAnswer, $actualLength, $tolerance);
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
// Game đo độ dài
Route::get('/dailuongvadoluong/length-measurement', [MeasurementGameController::class, 'lengthMeasurementGame']);
Route::post('/dailuongvadoluong/length-measurement/check', [MeasurementGameController::class, 'checkLengthMeasurementAnswer']);
Route::post('/dailuongvadoluong/length-measurement/reset', [MeasurementGameController::class, 'resetLengthMeasurementGame']);
```

### Views
- **File**: `resources/views/games/lop4/dailuongvadoluong/length_measurement.blade.php`
- **Components**:
  - Hình ảnh/tên vật thể
  - Input đáp án
  - Thông báo
  - Bảng điểm
  - Bảng quy đổi độ dài

### JavaScript
- Sinh vật thể ngẫu nhiên
- Kiểm tra đáp án
- Quản lý điểm số
- Hiệu ứng thông báo

### Session
- Key: `length_measurement_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho logic
- HTML5 cho giao diện
- Laravel cho backend
- Bootstrap/Tailwind cho UI

## Cải tiến có thể thực hiện
1. Thêm nhiều vật thể hơn
2. Thêm chế độ thi đấu thời gian
3. Thêm bảng xếp hạng
4. Thêm giải thích đáp án 