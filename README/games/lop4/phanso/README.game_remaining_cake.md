# Game Miếng Bánh Còn Lại 🍰

## Mục tiêu
Giúp học sinh học về phép trừ phân số thông qua việc tính toán phần bánh còn lại sau khi đã ăn một phần, phát triển khả năng tư duy về phân số trong tình huống thực tế.

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
- Hình ảnh bánh với các phần đã ăn
- Ô nhập phân số còn lại
- Thanh tiến trình level
- Nút kiểm tra và làm lại
- Khu vực hiển thị phản hồi

### 2. Các level
- **Level 1**: Tính phần còn lại khi ăn 1/4 bánh
- **Level 2**: Tính phần còn lại khi ăn 2/5 bánh
- **Level 3**: Tính phần còn lại khi ăn 3/8 bánh
- **Level 4**: Tính phần còn lại khi ăn nhiều phần khác nhau
- **Level 5**: Tính phần còn lại với phân số phức tạp

### 3. Logic game
```php
// Tạo câu hỏi theo level
function generateRemainingQuestion($level) {
    $questions = [
        1 => [
            'total' => ['numerator' => 1, 'denominator' => 1],
            'eaten' => ['numerator' => 1, 'denominator' => 4],
            'answer' => ['numerator' => 3, 'denominator' => 4],
            'hint' => 'Nếu ăn 1/4 bánh, phần còn lại là bao nhiêu?'
        ],
        // Các level tiếp theo
    ];
    return $questions[$level] ?? $questions[1];
}

// Kiểm tra đáp án
function checkRemainingAnswer($answer, $question) {
    // Tính phần còn lại: 1 - phần đã ăn
    $remaining = [
        'numerator' => $question['total']['numerator'] * $question['eaten']['denominator'] - 
                      $question['eaten']['numerator'] * $question['total']['denominator'],
        'denominator' => $question['total']['denominator'] * $question['eaten']['denominator']
    ];
    
    return $answer['numerator'] * $remaining['denominator'] === 
           $remaining['numerator'] * $answer['denominator'];
}
```

### 4. Cách chơi
1. Quan sát hình ảnh bánh và phần đã ăn
2. Tính toán phần bánh còn lại
3. Nhập phân số vào ô đáp án
4. Nhấn "Kiểm tra" để xác nhận
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
$correct = checkRemainingAnswer($answer, $question);
```

### 6. Phản hồi
- **Đúng**: 
  - Hiển thị thông báo chúc mừng
  - Animation minh họa phần còn lại
  - Tự động chuyển level mới
- **Sai**: 
  - Rung lắc nhẹ ô nhập
  - Cho phép thử lại
  - Hiển thị gợi ý tính toán

## Cấu trúc code

### Routes
```php
// Game miếng bánh còn lại
Route::get('/phanso/remaining', [GameController::class, 'remainingGame']);
Route::post('/phanso/remaining/check', [GameController::class, 'checkRemainingAnswer']);
Route::post('/phanso/remaining/reset', [GameController::class, 'resetRemainingGame']);
```

### Views
- **File**: `resources/views/games/lop4/phanso/remaining.blade.php`
- **Components**:
  - Cake visualization
  - Input form
  - Progress bar
  - Message display
  - Hint system

### JavaScript
- Xử lý nhập liệu
- Kiểm tra định dạng phân số
- Animation bánh
- Gửi AJAX request

### Session
- Key: `remaining_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho tương tác
- GSAP cho animation
- Laravel cho backend
- Bootstrap cho UI
- SVG cho hiển thị bánh

## Cải tiến có thể thực hiện
1. Thêm nhiều loại bánh khác nhau
2. Thêm công cụ tính toán phân số
3. Thêm chế độ thi đấu 2 người
4. Thêm bảng xếp hạng
5. Thêm video hướng dẫn giải
``` 