# Game Thành Phố Bị Mất 🏰

## Mục tiêu
Giúp học sinh học về phân số thông qua việc giải các câu đố phân số để khám phá và khôi phục thành phố bị mất, phát triển tư duy logic và kỹ năng giải quyết vấn đề.

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
- Bản đồ thành phố với các khu vực bị khóa
- Câu đố phân số tại mỗi khu vực
- Thanh tiến trình khám phá
- Kho tàng và vật phẩm thu thập được
- Hệ thống gợi ý

### 2. Các level
- **Level 1**: Khám phá khu chợ (phân số cơ bản)
- **Level 2**: Khám phá công viên (so sánh phân số)
- **Level 3**: Khám phá trường học (phép cộng trừ phân số)
- **Level 4**: Khám phá bảo tàng (phép nhân chia phân số)
- **Level 5**: Khám phá lâu đài (bài toán tổng hợp)

### 3. Logic game
```php
// Tạo câu đố theo khu vực
function generateLostCityPuzzle($area) {
    $puzzles = [
        'market' => [
            'puzzle' => 'Tìm phân số thể hiện phần hàng hóa còn lại trong kho',
            'data' => [
                'total' => ['numerator' => 1, 'denominator' => 1],
                'sold' => ['numerator' => 3, 'denominator' => 4]
            ],
            'answer' => ['numerator' => 1, 'denominator' => 4],
            'hint' => 'Hãy tính phần còn lại bằng cách lấy tổng trừ đi phần đã bán'
        ],
        // Các khu vực khác
    ];
    
    return $puzzles[$area] ?? $puzzles['market'];
}

// Kiểm tra đáp án và mở khóa khu vực
function checkAreaAnswer($answer, $puzzle) {
    if ($answer['numerator'] * $puzzle['answer']['denominator'] === 
        $puzzle['answer']['numerator'] * $answer['denominator']) {
        unlockArea($puzzle['area']);
        return true;
    }
    return false;
}

// Mở khóa khu vực mới
function unlockArea($area) {
    // Cập nhật trạng thái khu vực trong database
    return Area::where('name', $area)->update(['unlocked' => true]);
}
```

### 4. Cách chơi
1. Khám phá bản đồ thành phố
2. Giải câu đố tại mỗi khu vực
3. Thu thập vật phẩm và manh mối
4. Mở khóa các khu vực mới
5. Khôi phục toàn bộ thành phố

### 5. Kiểm tra đáp án
```javascript
// Frontend gửi dữ liệu
const formData = new FormData();
formData.append('answer', JSON.stringify({
    area: currentArea,
    fraction: {
        numerator: numeratorValue,
        denominator: denominatorValue
    }
}));

// Backend kiểm tra
$correct = checkAreaAnswer($answer, $puzzle);
```

### 6. Phản hồi
- **Đúng**: 
  - Animation mở khóa khu vực
  - Hiển thị phần thưởng
  - Mở khóa khu vực tiếp theo
- **Sai**: 
  - Hiển thị gợi ý
  - Cho phép thử lại
  - Không mất vật phẩm

## Cấu trúc code

### Routes
```php
// Game thành phố bị mất
Route::get('/phanso/lost-city', [GameController::class, 'lostCityGame']);
Route::post('/phanso/lost-city/check', [GameController::class, 'checkLostCity']);
Route::post('/phanso/lost-city/unlock', [GameController::class, 'unlockArea']);
```

### Views
- **File**: `resources/views/games/lop4/phanso/lost_city.blade.php`
- **Components**:
  - City map
  - Puzzle interface
  - Inventory system
  - Progress tracker
  - Hint display

### JavaScript
- Map interaction
- Puzzle mechanics
- Inventory management
- Animation effects
- AJAX requests

### Session
- Key: `lost_city_progress`
- Giá trị: Object chứa trạng thái các khu vực
- Lưu tiến độ khám phá

## Công nghệ sử dụng
- JavaScript thuần cho tương tác
- Canvas API cho map rendering
- GSAP cho animation
- Laravel cho backend
- Bootstrap cho UI

## Cải tiến có thể thực hiện
1. Thêm nhân vật hướng dẫn
2. Thêm mini-game trong mỗi khu vực
3. Thêm hệ thống thành tích
4. Thêm chế độ chơi theo nhóm
5. Thêm tính năng chia sẻ tiến độ
``` 