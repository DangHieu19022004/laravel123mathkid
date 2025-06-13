# Game Cuộc Đua Đơn Vị Đo 🏎️

## Mục tiêu
Giúp học sinh luyện tập so sánh các khoảng cách với các đơn vị đo khác nhau, phát triển kỹ năng chuyển đổi và so sánh độ dài.

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
- Hiển thị danh sách các khoảng cách với đơn vị khác nhau (m, km, cm...)
- Kéo thả hoặc chọn để sắp xếp các khoảng cách theo thứ tự tăng dần/giảm dần
- Thông báo đúng/sai
- Bảng điểm

### 2. Các level
- **Level 1**: So sánh các khoảng cách đơn giản (m, cm)
- **Level 2**: Thêm đơn vị km, mm
- **Level 3**: Kết hợp nhiều đơn vị hỗn hợp
- **Level 4**: Số lượng khoảng cách nhiều hơn
- **Level 5**: Thời gian giới hạn

### 3. Logic game
```php
// Chuyển đổi về mét để so sánh
function convertToMeters($value, $unit) {
    return $unit === 'km' ? $value * 1000 : $value;
}

// So sánh thứ tự các khoảng cách
function checkOrder($distances, $userOrder) {
    $converted = array_map(fn($d) => convertToMeters($d['value'], $d['unit']), $distances);
    $sorted = $converted;
    sort($sorted);
    foreach ($userOrder as $i => $idx) {
        if ($converted[$idx] !== $sorted[$i]) return false;
    }
    return true;
}
```

### 4. Cách chơi
1. Quan sát các khoảng cách trên màn hình
2. Sắp xếp các khoảng cách theo thứ tự đúng
3. Nhấn kiểm tra để xác nhận
4. Đúng thì cộng điểm, sai thì trừ điểm
5. Chuyển level khi đạt đủ điểm

### 5. Kiểm tra đáp án
```php
$correct = checkOrder($distances, $userOrder);
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
// Game so sánh khoảng cách
Route::get('/dailuongvadoluong/distance-comparison', [MeasurementGameController::class, 'distanceComparisonGame']);
Route::post('/dailuongvadoluong/distance-comparison/check', [MeasurementGameController::class, 'checkDistanceComparisonAnswer']);
Route::post('/dailuongvadoluong/distance-comparison/reset', [MeasurementGameController::class, 'resetDistanceComparisonGame']);
```

### Views
- **File**: `resources/views/games/lop4/dailuongvadoluong/distance-comparison.blade.php`
- **Components**:
  - Danh sách khoảng cách
  - Kéo thả/sắp xếp
  - Thông báo
  - Bảng điểm

### JavaScript
- Chuyển đổi đơn vị
- Sắp xếp khoảng cách
- Kiểm tra đáp án
- Hiệu ứng thông báo

### Session
- Key: `distance_comparison_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho logic
- HTML5 cho giao diện
- Laravel cho backend
- Bootstrap/Tailwind cho UI

## Cải tiến có thể thực hiện
1. Thêm nhiều loại đơn vị hơn
2. Thêm chế độ thi đấu thời gian
3. Thêm bảng xếp hạng
4. Thêm giải thích đáp án 