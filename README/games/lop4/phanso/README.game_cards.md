# Game Thẻ Bài Phân Số 🃏

## Mục tiêu
Giúp học sinh học về phân số tương đương thông qua việc ghép các thẻ bài phân số có giá trị bằng nhau.

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
- Bộ thẻ bài phân số
- Khu vực ghép cặp
- Thanh tiến trình
- Bảng điểm
- Nút kiểm tra và làm lại

### 2. Các level
- **Level 1**: Ghép cặp phân số đơn giản (2/4 = 1/2)
- **Level 2**: Ghép cặp phân số trung bình (3/6 = 1/2)
- **Level 3**: Ghép cặp phân số phức tạp (4/8 = 2/4 = 1/2)
- **Level 4**: Ghép cặp phân số hỗn hợp
- **Level 5**: Ghép cặp nhiều phân số tương đương

### 3. Logic game
```php
// Kiểm tra phân số tương đương
function checkEquivalentFractions($fraction1, $fraction2) {
    list($num1, $den1) = explode('/', $fraction1);
    list($num2, $den2) = explode('/', $fraction2);
    return ($num1 * $den2) === ($num2 * $den1);
}

// Tạo bộ thẻ bài theo level
function generateCards($level) {
    switch($level) {
        case 1:
            return [
                ['value' => '1/2', 'equivalent' => ['2/4', '3/6']],
                ['value' => '1/3', 'equivalent' => ['2/6', '3/9']]
            ];
        // Các level tiếp theo
    }
}
```

### 4. Cách chơi
1. Quan sát các thẻ bài phân số
2. Tìm các thẻ có giá trị bằng nhau
3. Kéo thả để ghép cặp các thẻ
4. Nhấn "Kiểm tra" khi hoàn thành
5. Chuyển level khi ghép đúng tất cả

### 5. Kiểm tra đáp án
```javascript
// Frontend gửi dữ liệu
const formData = new FormData();
formData.append('pairs', JSON.stringify(selectedPairs));

// Backend kiểm tra
$correct = true;
foreach ($pairs as $pair) {
    if (!checkEquivalentFractions($pair[0], $pair[1])) {
        $correct = false;
        break;
    }
}
```

### 6. Phản hồi
- **Đúng**: 
  - Hiển thị thông báo chúc mừng
  - Animation thẻ bài khớp nhau
  - Tự động chuyển level mới
- **Sai**: 
  - Rung lắc thẻ bài
  - Cho phép thử lại
  - Hiển thị gợi ý (tùy level)

## Cấu trúc code

### Routes
```php
// Game thẻ bài phân số
Route::get('/phanso/cards', [GameController::class, 'cardsGame']);
Route::post('/phanso/cards/check', [GameController::class, 'checkCardsAnswer']);
Route::post('/phanso/cards/reset', [GameController::class, 'resetCardsGame']);
```

### Views
- **File**: `resources/views/games/lop4/phanso/cards.blade.php`
- **Components**:
  - Card component
  - Matching area
  - Progress bar
  - Score display
  - Message display

### JavaScript
- Xử lý kéo thả thẻ bài
- Kiểm tra phân số tương đương
- Animation thẻ bài
- Gửi AJAX request kiểm tra đáp án

### Session
- Key: `cards_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- HTML5 Drag & Drop API
- JavaScript thuần cho tương tác
- GSAP cho animation
- Laravel cho backend
- Bootstrap cho UI

## Cải tiến có thể thực hiện
1. Thêm hiệu ứng âm thanh khi ghép thẻ
2. Thêm chế độ thi đấu nhiều người
3. Thêm công cụ tính toán phân số
4. Thêm bảng xếp hạng
5. Thêm chế độ chơi có giới hạn thời gian
``` 