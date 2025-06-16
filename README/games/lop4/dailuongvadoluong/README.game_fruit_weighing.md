# Game Cân Táo Cân Cam ⚖️🍎

## Mục tiêu
Giúp học sinh luyện tập cân bằng khối lượng, phát triển kỹ năng so sánh và cộng/trừ khối lượng qua các bài toán thực tế với trái cây.

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
- Hiển thị hình ảnh cân, táo, cam và các vật khác
- Kéo thả trái cây lên hai bên cân
- Hiển thị kết quả cân bằng hoặc lệch
- Thông báo đúng/sai
- Bảng điểm

### 2. Các level
- **Level 1**: Cân bằng đơn giản với 2-3 vật
- **Level 2**: Thêm nhiều vật hơn
- **Level 3**: Kết hợp nhiều loại trái cây
- **Level 4**: Cân bằng với số lượng lớn
- **Level 5**: Thời gian giới hạn

### 3. Logic game
```php
// Tính tổng khối lượng mỗi bên cân
function totalWeight($items) {
    return array_sum(array_map(fn($i) => $i['weight'], $items));
}

// Kiểm tra cân bằng
function isBalanced($left, $right) {
    return totalWeight($left) === totalWeight($right);
}
```

### 4. Cách chơi
1. Kéo thả trái cây lên hai bên cân
2. Đảm bảo hai bên cân bằng nhau
3. Nhấn kiểm tra để xác nhận
4. Đúng thì cộng điểm, sai thì trừ điểm
5. Chuyển level khi đạt đủ điểm

### 5. Kiểm tra đáp án
```php
$correct = isBalanced($leftItems, $rightItems);
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
// Game cân táo cân cam
Route::get('/dailuongvadoluong/fruit-weighing', [MeasurementGameController::class, 'fruitWeighingGame']);
Route::post('/dailuongvadoluong/fruit-weighing/check', [MeasurementGameController::class, 'checkFruitWeighingAnswer']);
Route::post('/dailuongvadoluong/fruit-weighing/reset', [MeasurementGameController::class, 'resetFruitWeighingGame']);
```

### Views
- **File**: `resources/views/games/lop4/dailuongvadoluong/can_tao_cam.blade.php`
- **Components**:
  - Hình ảnh cân, trái cây
  - Kéo thả vật
  - Thông báo
  - Bảng điểm

### JavaScript
- Tính tổng khối lượng
- Kiểm tra cân bằng
- Hiệu ứng thông báo

### Session
- Key: `fruit_weighing_level`
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