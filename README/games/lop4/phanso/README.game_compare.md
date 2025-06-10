# Game So Sánh Phân Số 🔍

## Mục tiêu
Giúp học sinh học về so sánh phân số thông qua việc chọn dấu so sánh thích hợp (>, <, =) giữa hai phân số.

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
8. Cài đặt GSAP: `npm install gsap`
9. Chạy `npm run dev`

## Cấu trúc game

### 1. Giao diện
- Hai phân số cần so sánh
- Ba nút dấu so sánh (>, <, =)
- Thanh tiến trình level
- Khu vực hiển thị phản hồi
- Nút kiểm tra và làm lại

### 2. Các level
- **Level 1**: So sánh phân số cùng mẫu số
- **Level 2**: So sánh phân số khác mẫu số đơn giản
- **Level 3**: So sánh phân số với số nguyên
- **Level 4**: So sánh phân số khác mẫu số phức tạp
- **Level 5**: So sánh phân số hỗn hợp

### 3. Logic game
```php
// Kiểm tra dấu so sánh
function checkComparison($fraction1, $fraction2, $symbol) {
    list($num1, $den1) = explode('/', $fraction1);
    list($num2, $den2) = explode('/', $fraction2);
    
    $value1 = $num1 / $den1;
    $value2 = $num2 / $den2;
    
    switch ($symbol) {
        case '>': return $value1 > $value2;
        case '<': return $value1 < $value2;
        case '=': return abs($value1 - $value2) < 0.000001;
        default: return false;
    }
}

// Tạo câu hỏi theo level
function generateQuestion($level) {
    switch($level) {
        case 1:
            return [
                'left' => '3/4',
                'right' => '2/4',
                'correct_symbol' => '>'
            ];
        // Các level tiếp theo
    }
}
```

### 4. Cách chơi
1. Quan sát hai phân số được hiển thị
2. So sánh giá trị của hai phân số
3. Chọn dấu so sánh thích hợp (>, <, =)
4. Nhấn "Kiểm tra" để xác nhận đáp án
5. Chuyển level khi trả lời đúng

### 5. Kiểm tra đáp án
```javascript
// Frontend gửi dữ liệu
const formData = new FormData();
formData.append('selected_symbol', selectedSymbol);

// Backend kiểm tra
$correct = $selectedSymbol === $question['correct_symbol'];
```

### 6. Phản hồi
- **Đúng**: 
  - Hiển thị thông báo chúc mừng
  - Animation dấu so sánh
  - Tự động chuyển level mới
- **Sai**: 
  - Rung lắc nhẹ
  - Cho phép thử lại
  - Hiển thị gợi ý (tùy level)

## Cấu trúc code

### Routes
```php
// Game so sánh phân số
Route::get('/phanso/compare', [GameController::class, 'compareGame']);
Route::post('/phanso/compare/check', [GameController::class, 'checkCompareAnswer']);
Route::post('/phanso/compare/reset', [GameController::class, 'resetCompareGame']);
```

### Views
- **File**: `resources/views/games/lop4/phanso/compare.blade.php`
- **Components**:
  - Fraction display
  - Comparison symbols
  - Progress bar
  - Message display
  - Hint system

### JavaScript
- Xử lý chọn dấu so sánh
- Kiểm tra đáp án
- Animation phản hồi
- Gửi AJAX request

### Session
- Key: `compare_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho tương tác
- GSAP cho animation
- Laravel cho backend
- Bootstrap cho UI
- SVG cho hiển thị phân số

## Cải tiến có thể thực hiện
1. Thêm công cụ quy đồng mẫu số
2. Thêm chế độ thi đấu 2 người
3. Thêm bảng xếp hạng
4. Thêm hiệu ứng âm thanh
5. Thêm chế độ chơi có giới hạn thời gian 