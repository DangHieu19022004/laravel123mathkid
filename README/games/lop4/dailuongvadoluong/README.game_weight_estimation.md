# Game Ước Lượng Khối Lượng ⚖️

## Mục tiêu
Giúp học sinh luyện tập ước lượng khối lượng của các vật thể, phát triển kỹ năng phán đoán và nhận biết đơn vị khối lượng.

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
- Hiển thị hình ảnh hoặc tên vật thể
- Ô nhập đáp án ước lượng khối lượng
- Thông báo đúng/sai
- Bảng điểm

### 2. Các level
- **Level 1**: Ước lượng khối lượng đơn giản (g, kg)
- **Level 2**: Thêm vật thể khó hơn
- **Level 3**: Đơn vị hỗn hợp
- **Level 4**: Số lượng vật thể nhiều hơn
- **Level 5**: Thời gian giới hạn

### 3. Logic game
```php
// Kiểm tra đáp án với sai số cho phép
function checkEstimation($userAnswer, $actualWeight, $tolerance) {
    return abs($userAnswer - $actualWeight) <= $tolerance;
}
```

### 4. Cách chơi
1. Quan sát vật thể trên màn hình
2. Nhập đáp án ước lượng khối lượng
3. Nhấn kiểm tra để xác nhận
4. Đúng thì cộng điểm, sai thì trừ điểm
5. Chuyển level khi đạt đủ điểm

### 5. Kiểm tra đáp án
```php
$correct = checkEstimation($userAnswer, $actualWeight, $tolerance);
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
// Game ước lượng khối lượng
Route::get('/dailuongvadoluong/weight-estimation', [MeasurementGameController::class, 'weightEstimationGame']);
Route::post('/dailuongvadoluong/weight-estimation/check', [MeasurementGameController::class, 'checkWeightEstimationAnswer']);
Route::post('/dailuongvadoluong/weight-estimation/reset', [MeasurementGameController::class, 'resetWeightEstimationGame']);
```

### Views
- **File**: `resources/views/games/lop4/dailuongvadoluong/weight_estimation.blade.php`
- **Components**:
  - Hình ảnh/tên vật thể
  - Input đáp án
  - Thông báo
  - Bảng điểm

### JavaScript
- Sinh vật thể ngẫu nhiên
- Kiểm tra đáp án
- Quản lý điểm số
- Hiệu ứng thông báo

### Session
- Key: `weight_estimation_level`
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