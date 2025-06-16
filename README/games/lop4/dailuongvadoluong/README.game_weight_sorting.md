# Game Xếp Hàng Theo Khối Lượng 📊

## Mục tiêu
Giúp học sinh luyện tập sắp xếp các vật theo thứ tự khối lượng, phát triển kỹ năng so sánh và nhận biết đơn vị khối lượng.

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
- Hiển thị danh sách các vật với khối lượng khác nhau (g, kg)
- Kéo thả hoặc chọn để sắp xếp các vật theo thứ tự tăng dần/giảm dần khối lượng
- Thông báo đúng/sai
- Bảng điểm

### 2. Các level
- **Level 1**: Sắp xếp 3 vật đơn giản
- **Level 2**: Thêm vật và đơn vị hỗn hợp
- **Level 3**: Số lượng vật nhiều hơn
- **Level 4**: Đơn vị nhỏ (mg, g, kg)
- **Level 5**: Thời gian giới hạn

### 3. Logic game
```php
// Chuyển đổi về gam để so sánh
function convertToGrams($value, $unit) {
    if ($unit === 'kg') return $value * 1000;
    if ($unit === 'mg') return $value / 1000;
    return $value;
}

// So sánh thứ tự các vật
function checkOrder($weights, $userOrder) {
    $converted = array_map(fn($w) => convertToGrams($w['value'], $w['unit']), $weights);
    $sorted = $converted;
    sort($sorted);
    foreach ($userOrder as $i => $idx) {
        if ($converted[$idx] !== $sorted[$i]) return false;
    }
    return true;
}
```

### 4. Cách chơi
1. Quan sát các vật và khối lượng trên màn hình
2. Sắp xếp các vật theo thứ tự đúng
3. Nhấn kiểm tra để xác nhận
4. Đúng thì cộng điểm, sai thì trừ điểm
5. Chuyển level khi đạt đủ điểm

### 5. Kiểm tra đáp án
```php
$correct = checkOrder($weights, $userOrder);
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
// Game xếp hàng theo khối lượng
Route::get('/dailuongvadoluong/weight-sorting', [MeasurementGameController::class, 'weightSortingGame']);
Route::post('/dailuongvadoluong/weight-sorting/check', [MeasurementGameController::class, 'checkWeightSortingAnswer']);
Route::post('/dailuongvadoluong/weight-sorting/reset', [MeasurementGameController::class, 'resetWeightSortingGame']);
```

### Views
- **File**: `resources/views/games/lop4/dailuongvadoluong/weight_sorting.blade.php`
- **Components**:
  - Danh sách vật và khối lượng
  - Kéo thả/sắp xếp
  - Thông báo
  - Bảng điểm

### JavaScript
- Chuyển đổi đơn vị
- Sắp xếp vật
- Kiểm tra đáp án
- Hiệu ứng thông báo

### Session
- Key: `weight_sorting_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho logic
- HTML5 cho giao diện
- Laravel cho backend
- Bootstrap/Tailwind cho UI

## Cải tiến có thể thực hiện
1. Thêm nhiều loại vật hơn
2. Thêm chế độ thi đấu thời gian
3. Thêm bảng xếp hạng
4. Thêm giải thích đáp án 