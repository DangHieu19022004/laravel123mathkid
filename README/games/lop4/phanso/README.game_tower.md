# Game Tháp Phân Số 🏰

## Mục tiêu
Giúp học sinh học về so sánh và sắp xếp phân số thông qua việc xây dựng tháp phân số theo thứ tự từ nhỏ đến lớn.

## Yêu cầu hệ thống
- PHP >= 7.4
- Laravel >= 8.0
- Node.js >= 14.0
- MySQL >= 5.7
- Trình duyệt hỗ trợ HTML5 Drag & Drop API

## Cài đặt
1. Clone repository
2. Chạy `composer install`
3. Chạy `npm install`
4. Copy `.env.example` thành `.env`
5. Chạy `php artisan key:generate`
6. Cấu hình database trong `.env`
7. Chạy `php artisan migrate`
8. Cài đặt GSAP: `npm install gsap`
9. Chạy `npm run dev`

## Cấu trúc game

### 1. Giao diện
- Các khối phân số có thể kéo thả
- Khu vực xây dựng tháp
- Thanh tiến trình hiển thị level
- Nút kiểm tra và làm lại

### 2. Các level
- **Level 1**: Sắp xếp 3 phân số đơn giản
- **Level 2**: Sắp xếp 4 phân số cùng mẫu số
- **Level 3**: Sắp xếp 4 phân số khác mẫu số
- **Level 4**: Sắp xếp 5 phân số hỗn hợp
- **Level 5**: Sắp xếp 6 phân số phức tạp

### 3. Logic game
```php
// Kiểm tra thứ tự sắp xếp
function checkOrder($selectedOrder, $correctOrder) {
    return $selectedOrder === $correctOrder;
}

// Tạo câu hỏi theo level
function generateQuestion($level) {
    switch($level) {
        case 1:
            return [
                'fractions' => ['1/4', '2/4', '3/4'],
                'correctOrder' => [0, 1, 2]
            ];
        // Các level tiếp theo
    }
}
```

### 4. Cách chơi
1. Quan sát các phân số được cung cấp
2. Kéo thả các phân số để xây tháp
3. Sắp xếp theo thứ tự từ nhỏ đến lớn
4. Nhấn "Kiểm tra" khi hoàn thành
5. Chuyển level khi trả lời đúng

### 5. Kiểm tra đáp án
```javascript
// Frontend gửi dữ liệu
const formData = new FormData();
formData.append('order', JSON.stringify(selectedOrder));

// Backend kiểm tra
$correct = $selectedOrder === $question['correctOrder'];
```

### 6. Phản hồi
- **Đúng**: 
  - Hiển thị thông báo chúc mừng
  - Animation tháp hoàn thành
  - Tự động chuyển level mới
- **Sai**: 
  - Rung lắc nhẹ
  - Cho phép thử lại
  - Hiển thị gợi ý (tùy level)

## Cấu trúc code

### Routes
```php
// Game tháp phân số
Route::get('/phanso/tower', [GameController::class, 'towerGame']);
Route::post('/phanso/tower/check', [GameController::class, 'checkTowerAnswer']);
Route::post('/phanso/tower/reset', [GameController::class, 'resetTowerGame']);
```

### Views
- **File**: `resources/views/games/lop4/phanso/tower.blade.php`
- **Components**:
  - Draggable fraction blocks
  - Tower construction area
  - Progress indicator
  - Message display

### JavaScript
- Xử lý kéo thả (Drag & Drop API)
- Kiểm tra thứ tự sắp xếp
- Animation xây tháp
- Gửi AJAX request kiểm tra đáp án

### Session
- Key: `tower_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- HTML5 Drag & Drop API
- JavaScript thuần cho tương tác
- GSAP cho animation
- Laravel cho backend
- Bootstrap cho UI

## Cải tiến có thể thực hiện
1. Thêm hiệu ứng âm thanh khi xây tháp
2. Thêm chế độ thi đấu 2 người
3. Thêm công cụ so sánh phân số
4. Thêm bảng xếp hạng
5. Thêm chế độ chơi có giới hạn thời gian 