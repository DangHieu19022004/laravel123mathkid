# Game Bầu Trời Phân Số 🌤️

## Mục tiêu
Giúp học sinh học về phân số thông qua việc thu thập các phân số tương đương trên bầu trời, phát triển khả năng nhận biết và so sánh phân số.

## Yêu cầu hệ thống
- PHP >= 7.4
- Laravel >= 8.0
- Node.js >= 14.0
- MySQL >= 5.7
- Trình duyệt hỗ trợ Canvas và modern JavaScript

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
- Bầu trời với các đám mây chứa phân số
- Nhân vật có thể di chuyển
- Điểm số và thời gian
- Thanh tiến trình level
- Nút điều khiển và làm lại

### 2. Các level
- **Level 1**: Thu thập phân số bằng 1/2
- **Level 2**: Thu thập phân số bằng 1/3
- **Level 3**: Thu thập phân số bằng 3/4
- **Level 4**: Thu thập phân số bằng 2/5
- **Level 5**: Thu thập nhiều loại phân số khác nhau

### 3. Logic game
```php
// Tạo câu hỏi theo level
function generateSkyQuestion($level) {
    $questions = [
        1 => [
            'target' => ['numerator' => 1, 'denominator' => 2],
            'clouds' => [
                ['numerator' => 2, 'denominator' => 4],
                ['numerator' => 3, 'denominator' => 6],
                ['numerator' => 4, 'denominator' => 8],
                ['numerator' => 1, 'denominator' => 3], // không tương đương
                ['numerator' => 3, 'denominator' => 5]  // không tương đương
            ]
        ],
        // Các level tiếp theo
    ];
    return $questions[$level] ?? $questions[1];
}

// Kiểm tra phân số tương đương
function checkEquivalentFraction($fraction1, $fraction2) {
    return ($fraction1['numerator'] * $fraction2['denominator']) ===
           ($fraction2['numerator'] * $fraction1['denominator']);
}
```

### 4. Cách chơi
1. Di chuyển nhân vật trên bầu trời
2. Thu thập các phân số tương đương với mục tiêu
3. Tránh các phân số không tương đương
4. Hoàn thành trong thời gian quy định
5. Chuyển level khi đạt đủ điểm

### 5. Kiểm tra đáp án
```javascript
// Frontend gửi dữ liệu
const formData = new FormData();
formData.append('collected_fraction', JSON.stringify({
    numerator: collectedNumerator,
    denominator: collectedDenominator
}));

// Backend kiểm tra
$correct = checkEquivalentFraction($collectedFraction, $targetFraction);
```

### 6. Phản hồi
- **Đúng**: 
  - Hiển thị điểm cộng
  - Animation mây biến mất
  - Âm thanh vui nhộn
- **Sai**: 
  - Trừ điểm
  - Animation rung lắc
  - Âm thanh cảnh báo

## Cấu trúc code

### Routes
```php
// Game bầu trời phân số
Route::get('/phanso/sky', [GameController::class, 'skyGame']);
Route::post('/phanso/sky/check', [GameController::class, 'checkSkyAnswer']);
Route::post('/phanso/sky/reset', [GameController::class, 'resetSkyGame']);
```

### Views
- **File**: `resources/views/games/lop4/phanso/sky.blade.php`
- **Components**:
  - Canvas game
  - Score display
  - Timer
  - Progress bar
  - Control buttons

### JavaScript
- Canvas rendering
- Character movement
- Collision detection
- Animation effects
- Game state management

### Session
- Key: `sky_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- Canvas API cho game graphics
- JavaScript thuần cho game logic
- GSAP cho animation
- Laravel cho backend
- Web Audio API cho âm thanh

## Cải tiến có thể thực hiện
1. Thêm nhiều nhân vật để chọn
2. Thêm chế độ thi đấu 2 người
3. Thêm power-ups và items đặc biệt
4. Thêm bảng xếp hạng online
5. Thêm chế độ chơi không giới hạn
``` 