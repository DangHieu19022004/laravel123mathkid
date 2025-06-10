# Game Mẫu Phân Số 🔄

## Mục tiêu
Giúp học sinh học về quy luật và dãy số phân số thông qua việc tìm ra phân số tiếp theo trong một dãy có quy luật.

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
- Dãy phân số có quy luật
- Dấu hỏi cho phân số cần điền
- Ô nhập tử số và mẫu số
- Thanh tiến trình level
- Nút kiểm tra và làm lại

### 2. Các level
- **Level 1**: Dãy tăng/giảm đơn giản (1/4, 2/4, 3/4, ?)
- **Level 2**: Dãy có quy luật cộng/trừ (1/2, 2/3, 3/4, ?)
- **Level 3**: Dãy có quy luật nhân/chia (1/2, 1/4, 1/8, ?)
- **Level 4**: Dãy có quy luật phức tạp (1/2, 2/3, 3/4, 4/5, ?)
- **Level 5**: Dãy có nhiều quy luật kết hợp

### 3. Logic game
```php
// Tạo câu hỏi theo level
function generatePatternQuestion($level) {
    $questions = [
        1 => [
            'sequence' => [
                ['numerator' => 1, 'denominator' => 4],
                ['numerator' => 2, 'denominator' => 4],
                ['numerator' => 3, 'denominator' => 4]
            ],
            'answer' => ['numerator' => 4, 'denominator' => 4]
        ],
        // Các level tiếp theo
    ];
    return $questions[$level] ?? $questions[1];
}

// Kiểm tra đáp án
function checkPatternAnswer($answer, $question) {
    return $answer['numerator'] === $question['answer']['numerator'] &&
           $answer['denominator'] === $question['answer']['denominator'];
}
```

### 4. Cách chơi
1. Quan sát dãy phân số
2. Tìm ra quy luật của dãy
3. Tính toán phân số tiếp theo
4. Nhập tử số và mẫu số
5. Nhấn "Kiểm tra" để xác nhận đáp án

### 5. Kiểm tra đáp án
```javascript
// Frontend gửi dữ liệu
const formData = new FormData();
formData.append('answer', JSON.stringify({
    numerator: numeratorValue,
    denominator: denominatorValue
}));

// Backend kiểm tra
$correct = checkPatternAnswer($answer, $question);
```

### 6. Phản hồi
- **Đúng**: 
  - Hiển thị thông báo chúc mừng
  - Animation hiển thị quy luật
  - Tự động chuyển level mới
- **Sai**: 
  - Rung lắc nhẹ ô nhập
  - Cho phép thử lại
  - Hiển thị gợi ý về quy luật (tùy level)

## Cấu trúc code

### Routes
```php
// Game mẫu phân số
Route::get('/phanso/pattern', [GameController::class, 'patternGame']);
Route::post('/phanso/pattern/check', [GameController::class, 'checkPatternAnswer']);
Route::post('/phanso/pattern/reset', [GameController::class, 'resetPatternGame']);
```

### Views
- **File**: `resources/views/games/lop4/phanso/pattern.blade.php`
- **Components**:
  - Sequence display
  - Input form
  - Progress bar
  - Message display
  - Hint system

### JavaScript
- Xử lý nhập liệu
- Kiểm tra định dạng phân số
- Animation hiển thị quy luật
- Gửi AJAX request

### Session
- Key: `pattern_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho tương tác
- GSAP cho animation
- Laravel cho backend
- Bootstrap cho UI
- MathJax cho hiển thị công thức

## Cải tiến có thể thực hiện
1. Thêm công cụ phân tích quy luật
2. Thêm chế độ thi đấu 2 người
3. Thêm bảng xếp hạng
4. Thêm hiệu ứng âm thanh
5. Thêm chế độ chơi có giới hạn thời gian
``` 