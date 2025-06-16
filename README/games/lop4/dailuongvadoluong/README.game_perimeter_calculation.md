# Game Tính Chu Vi 📐

## Mục tiêu
Giúp học sinh luyện tập tính chu vi các hình học cơ bản (hình vuông, hình chữ nhật, tam giác...), phát triển kỹ năng nhận biết công thức và áp dụng vào thực tế.

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
- Hiển thị hình vẽ các hình học (vuông, chữ nhật, tam giác...)
- Hiển thị các cạnh và số đo
- Ô nhập đáp án chu vi
- Thông báo đúng/sai
- Bảng điểm

### 2. Các level
- **Level 1**: Tính chu vi hình vuông, hình chữ nhật đơn giản
- **Level 2**: Thêm hình tam giác, hình tròn
- **Level 3**: Hình phức tạp hơn
- **Level 4**: Nhiều hình trên một câu hỏi
- **Level 5**: Thời gian giới hạn

### 3. Logic game
```php
// Tính chu vi hình học
function calculatePerimeter($shape) {
    switch($shape['type']) {
        case 'square': return 4 * $shape['side'];
        case 'rectangle': return 2 * ($shape['width'] + $shape['height']);
        case 'triangle': return array_sum($shape['sides']);
        case 'circle': return 2 * 3.14 * $shape['radius'];
        default: return 0;
    }
}

// Kiểm tra đáp án
function checkPerimeter($userAnswer, $perimeter, $tolerance) {
    return abs($userAnswer - $perimeter) <= $tolerance;
}
```

### 4. Cách chơi
1. Quan sát hình vẽ và số đo trên màn hình
2. Nhập đáp án chu vi
3. Nhấn kiểm tra để xác nhận
4. Đúng thì cộng điểm, sai thì trừ điểm
5. Chuyển level khi đạt đủ điểm

### 5. Kiểm tra đáp án
```php
$correct = checkPerimeter($userAnswer, $perimeter, $tolerance);
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
// Game tính chu vi
Route::get('/dailuongvadoluong/perimeter-calculation', [MeasurementGameController::class, 'perimeterCalculationGame']);
Route::post('/dailuongvadoluong/perimeter-calculation/check', [MeasurementGameController::class, 'checkPerimeterCalculationAnswer']);
Route::post('/dailuongvadoluong/perimeter-calculation/reset', [MeasurementGameController::class, 'resetPerimeterCalculationGame']);
```

### Views
- **File**: `resources/views/games/lop4/dailuongvadoluong/perimeter_calculation.blade.php`
- **Components**:
  - Hình vẽ các hình học
  - Input đáp án
  - Thông báo
  - Bảng điểm

### JavaScript
- Sinh hình học ngẫu nhiên
- Tính chu vi
- Kiểm tra đáp án
- Hiệu ứng thông báo

### Session
- Key: `perimeter_calculation_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho logic
- HTML5 cho giao diện
- Laravel cho backend
- Bootstrap/Tailwind cho UI

## Cải tiến có thể thực hiện
1. Thêm nhiều loại hình học hơn
2. Thêm chế độ thi đấu thời gian
3. Thêm bảng xếp hạng
4. Thêm giải thích đáp án 