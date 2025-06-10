# Game Chia Bánh Công Bằng 🍰

## Mục tiêu
Giúp học sinh học về phân số thông qua việc chia đều một số lượng đồ vật cho một số người, từ đó hiểu được mối quan hệ giữa phép chia và phân số.

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
- Hiển thị số lượng đồ vật cần chia (bánh, táo, kẹo,...)
- Hiển thị số người cần chia
- Ô nhập kết quả phân số
- Thanh tiến trình level
- Nút kiểm tra và làm lại

### 2. Các level
- **Level 1**: Chia đều 4 đồ vật cho 2 người
- **Level 2**: Chia đều 6 đồ vật cho 2 người
- **Level 3**: Chia đều 6 đồ vật cho 3 người
- **Level 4**: Chia đều 8 đồ vật cho 4 người
- **Level 5**: Chia đều 10 đồ vật cho 5 người

### 3. Logic game
```php
// Tạo câu hỏi theo level
function generateFairShareQuestion($level) {
    $questions = [
        1 => [
            'total' => ['numerator' => 4, 'denominator' => 1],
            'people' => 2,
            'answer' => ['numerator' => 2, 'denominator' => 1],
            'answers' => [
                ['numerator' => 2, 'denominator' => 1],
                ['numerator' => 4, 'denominator' => 2]
            ],
            'item_type' => 'apple'
        ],
        // Các level tiếp theo
    ];
    return $questions[$level] ?? $questions[1];
}

// Kiểm tra đáp án
function checkFairShareAnswer($answer, $question) {
    foreach ($question['answers'] as $validAnswer) {
        if ($answer['numerator'] * $validAnswer['denominator'] === 
            $answer['denominator'] * $validAnswer['numerator']) {
            return true;
        }
    }
    return false;
}
```

### 4. Cách chơi
1. Quan sát số lượng đồ vật và số người
2. Tính toán phần mỗi người nhận được
3. Nhập kết quả dưới dạng phân số
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
$correct = checkFairShareAnswer($answer, $question);
```

### 6. Phản hồi
- **Đúng**: 
  - Hiển thị thông báo chúc mừng
  - Animation chia đồ vật
  - Tự động chuyển level mới
- **Sai**: 
  - Rung lắc nhẹ ô nhập
  - Cho phép thử lại
  - Hiển thị gợi ý (tùy level)

## Cấu trúc code

### Routes
```php
// Game chia bánh công bằng
Route::get('/phanso/fair-share', [GameController::class, 'fairShareGame']);
Route::post('/phanso/fair-share/check', [GameController::class, 'checkFairShareAnswer']);
Route::post('/phanso/fair-share/reset', [GameController::class, 'resetFairShareGame']);
```

### Views
- **File**: `resources/views/games/lop4/phanso/fair_share.blade.php`
- **Components**:
  - Item display (bánh, táo, kẹo)
  - People display
  - Input form
  - Progress bar
  - Message display

### JavaScript
- Xử lý nhập liệu
- Kiểm tra định dạng phân số
- Animation chia đồ vật
- Gửi AJAX request

### Session
- Key: `fair_share_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho tương tác
- GSAP cho animation
- Laravel cho backend
- Bootstrap cho UI
- SVG cho hiển thị đồ vật

## Cải tiến có thể thực hiện
1. Thêm nhiều loại đồ vật khác nhau
2. Thêm chế độ thi đấu 2 người
3. Thêm bảng xếp hạng
4. Thêm hiệu ứng âm thanh
5. Thêm chế độ chơi có giới hạn thời gian
``` 