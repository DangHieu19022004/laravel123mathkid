# Game Tính Diện Tích 🟥

## Mục tiêu
Giúp học sinh luyện tập tính diện tích các hình học cơ bản (hình vuông, hình chữ nhật, tam giác, tròn...), phát triển kỹ năng nhận biết công thức và áp dụng vào thực tế.

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
- Hiển thị hình vẽ các hình học (vuông, chữ nhật, tam giác, tròn...)
- Hiển thị các cạnh và số đo
- Ô nhập đáp án diện tích
- Thông báo đúng/sai
- Bảng điểm

### 2. Các level
- **Level 1**: Tính diện tích hình vuông, hình chữ nhật đơn giản
- **Level 2**: Thêm hình tam giác, hình tròn
- **Level 3**: Hình phức tạp hơn
- **Level 4**: Nhiều hình trên một câu hỏi
- **Level 5**: Thời gian giới hạn

### 3. Logic game
```php
// Tính diện tích hình học
function calculateArea($shape) {
    switch($shape['type']) {
        case 'square': return pow($shape['side'], 2);
        case 'rectangle': return $shape['width'] * $shape['height'];
        case 'triangle': return 0.5 * $shape['base'] * $shape['height'];
        case 'circle': return 3.14 * pow($shape['radius'], 2);
        default: return 0;
    }
}

// Kiểm tra đáp án
function checkArea($userAnswer, $area, $tolerance) {
    return abs($userAnswer - $area) <= $tolerance;
}
```

### 4. Cách chơi
1. Quan sát hình vẽ và số đo trên màn hình
2. Nhập đáp án diện tích
3. Nhấn kiểm tra để xác nhận
4. Đúng thì cộng điểm, sai thì trừ điểm
5. Chuyển level khi đạt đủ điểm

### 5. Kiểm tra đáp án
```php
$correct = checkArea($userAnswer, $area, $tolerance);
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
// Game tính diện tích
Route::get('/dailuongvadoluong/area-calculation', [MeasurementGameController::class, 'areaCalculationGame']);
Route::post('/dailuongvadoluong/area-calculation/check', [MeasurementGameController::class, 'checkAreaCalculationAnswer']);
Route::post('/dailuongvadoluong/area-calculation/reset', [MeasurementGameController::class, 'resetAreaCalculationGame']);
```

### Views
- **File**: `resources/views/games/lop4/dailuongvadoluong/area_calculation.blade.php`
- **Components**:
  - Hình vẽ các hình học
  - Input đáp án
  - Thông báo
  - Bảng điểm

### JavaScript
- Sinh hình học ngẫu nhiên
- Tính diện tích
- Kiểm tra đáp án
- Hiệu ứng thông báo

### Session
- Key: `area_calculation_level`
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