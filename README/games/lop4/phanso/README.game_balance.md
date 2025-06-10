# Game Cân Bằng Phân Số ⚖️

## Mục tiêu
Giúp học sinh học về phân số tương đương và so sánh phân số thông qua hình ảnh cân hai đĩa, từ đó hiểu được khái niệm cân bằng và bằng nhau giữa các phân số.

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
- Hình ảnh cân hai đĩa
- Phân số trên mỗi đĩa cân
- Nút chọn dấu (=, >, <)
- Thanh tiến trình level
- Nút kiểm tra và làm lại

### 2. Các level
- **Level 1**: So sánh phân số đơn giản (1/2 = 2/4)
- **Level 2**: So sánh phân số khác mẫu số (3/4 > 2/4)
- **Level 3**: So sánh phân số với số nguyên (2/6 < 1)
- **Level 4**: So sánh phân số phức tạp (4/8 = 2/4)
- **Level 5**: So sánh phân số hỗn hợp (5/6 > 4/6)

### 3. Logic game
```php
// Tạo câu hỏi theo level
function generateBalanceQuestion($level) {
    $questions = [
        1 => [
            'left' => ['numerator' => 1, 'denominator' => 2],
            'right' => ['numerator' => 2, 'denominator' => 4],
            'correct_symbol' => '=',
            'valid_symbols' => ['=']
        ],
        // Các level tiếp theo
    ];
    return $questions[$level] ?? $questions[1];
}

// Kiểm tra đáp án
function checkBalanceAnswer($selectedSymbol, $question) {
    return $selectedSymbol === $question['correct_symbol'];
}
```

### 4. Cách chơi
1. Quan sát hai phân số trên hai đĩa cân
2. So sánh giá trị của hai phân số
3. Chọn dấu thích hợp (=, >, <)
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
  - Animation cân nghiêng theo đáp án
  - Tự động chuyển level mới
- **Sai**: 
  - Rung lắc nhẹ
  - Cho phép thử lại
  - Hiển thị gợi ý (tùy level)

## Cấu trúc code

### Routes
```php
// Game cân bằng phân số
Route::get('/phanso/balance', [GameController::class, 'balanceGame']);
Route::post('/phanso/balance/check', [GameController::class, 'checkBalanceAnswer']);
Route::post('/phanso/balance/reset', [GameController::class, 'resetBalanceGame']);
```

### Views
- **File**: `resources/views/games/lop4/phanso/balance.blade.php`
- **Components**:
  - Balance scale SVG
  - Fraction display
  - Symbol buttons
  - Progress bar
  - Message display

### JavaScript
- Xử lý chọn dấu
- Animation cân
- Kiểm tra đáp án
- Gửi AJAX request

### Session
- Key: `balance_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho tương tác
- GSAP cho animation
- Laravel cho backend
- Bootstrap cho UI
- SVG cho hiển thị cân

## Cải tiến có thể thực hiện
1. Thêm hiệu ứng âm thanh khi cân nghiêng
2. Thêm chế độ thi đấu 2 người
3. Thêm công cụ quy đồng mẫu số
4. Thêm bảng xếp hạng
5. Thêm chế độ chơi có giới hạn thời gian
``` 