# Game Phân Số và Phép Chia ➗

## Mục tiêu
Giúp học sinh học về mối quan hệ giữa phân số và phép chia thông qua việc chuyển đổi giữa phép chia và phân số.

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
- Phép chia hoặc phân số cần chuyển đổi
- Ô nhập kết quả
- Thanh tiến trình level
- Khu vực hiển thị phản hồi
- Nút kiểm tra và làm lại

### 2. Các level
- **Level 1**: Chuyển phép chia đơn giản thành phân số (6 ÷ 2 = 3/1)
- **Level 2**: Chuyển phân số đơn giản thành phép chia (3/4 = 3 ÷ 4)
- **Level 3**: Chuyển phép chia phức tạp thành phân số
- **Level 4**: Chuyển phân số phức tạp thành phép chia
- **Level 5**: Kết hợp cả hai dạng chuyển đổi

### 3. Logic game
```php
// Kiểm tra đáp án
function checkDivisionAnswer($question, $answer) {
    // Chuyển đổi phép chia thành phân số
    if ($question['type'] === 'division') {
        $expectedNumerator = $question['dividend'];
        $expectedDenominator = $question['divisor'];
    } 
    // Chuyển đổi phân số thành phép chia
    else {
        $expectedDividend = $question['numerator'];
        $expectedDivisor = $question['denominator'];
    }
    
    return $answer['numerator'] == $expectedNumerator && 
           $answer['denominator'] == $expectedDenominator;
}

// Tạo câu hỏi theo level
function generateQuestion($level) {
    switch($level) {
        case 1:
            return [
                'type' => 'division',
                'dividend' => 6,
                'divisor' => 2,
                'answer' => ['numerator' => 6, 'denominator' => 2]
            ];
        // Các level tiếp theo
    }
}
```

### 4. Cách chơi
1. Quan sát phép chia hoặc phân số được hiển thị
2. Chuyển đổi sang dạng yêu cầu
3. Nhập kết quả vào ô tương ứng
4. Nhấn "Kiểm tra" để xác nhận đáp án
5. Chuyển level khi trả lời đúng

### 5. Kiểm tra đáp án
```javascript
// Frontend gửi dữ liệu
const formData = new FormData();
formData.append('answer', JSON.stringify({
    numerator: numeratorValue,
    denominator: denominatorValue
}));

// Backend kiểm tra
$correct = checkDivisionAnswer($question, $answer);
```

### 6. Phản hồi
- **Đúng**: 
  - Hiển thị thông báo chúc mừng
  - Animation chuyển đổi
  - Tự động chuyển level mới
- **Sai**: 
  - Rung lắc nhẹ ô nhập
  - Cho phép thử lại
  - Hiển thị gợi ý (tùy level)

## Cấu trúc code

### Routes
```php
// Game phân số và phép chia
Route::get('/phanso/division', [GameController::class, 'divisionGame']);
Route::post('/phanso/division/check', [GameController::class, 'checkDivisionAnswer']);
Route::post('/phanso/division/reset', [GameController::class, 'resetDivisionGame']);
```

### Views
- **File**: `resources/views/games/lop4/phanso/division.blade.php`
- **Components**:
  - Division/Fraction display
  - Input form
  - Progress bar
  - Message display
  - Hint system

### JavaScript
- Xử lý nhập liệu
- Kiểm tra định dạng
- Animation chuyển đổi
- Gửi AJAX request

### Session
- Key: `division_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho tương tác
- GSAP cho animation
- Laravel cho backend
- Bootstrap cho UI
- MathJax cho hiển thị công thức

## Cải tiến có thể thực hiện
1. Thêm công cụ tính toán phân số
2. Thêm chế độ thi đấu 2 người
3. Thêm bảng xếp hạng
4. Thêm hiệu ứng âm thanh
5. Thêm chế độ chơi có giới hạn thời gian
``` 