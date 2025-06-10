# Game Nhóm Bằng Nhau 🎯

## Mục tiêu
Giúp học sinh học về phân số tương đương thông qua việc nhóm các phân số có giá trị bằng nhau, phát triển khả năng nhận biết và so sánh phân số.

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
- Các thẻ phân số di chuyển được
- Khu vực nhóm phân số
- Thanh tiến trình level
- Điểm số và thời gian
- Hệ thống gợi ý

### 2. Các level
- **Level 1**: Nhóm phân số đơn giản (1/2, 2/4, 3/6)
- **Level 2**: Nhóm phân số phức tạp hơn (2/3, 4/6, 6/9)
- **Level 3**: Nhóm nhiều phân số (1/4, 2/8, 3/12, 4/16)
- **Level 4**: Nhóm phân số hỗn hợp
- **Level 5**: Nhóm phân số với thời gian giới hạn

### 3. Logic game
```php
// Tạo danh sách phân số theo level
function generateEqualGroups($level) {
    $groups = [
        1 => [
            'fractions' => [
                ['numerator' => 1, 'denominator' => 2],
                ['numerator' => 2, 'denominator' => 4],
                ['numerator' => 3, 'denominator' => 6],
                ['numerator' => 4, 'denominator' => 8],
                ['numerator' => 1, 'denominator' => 3], // không tương đương
                ['numerator' => 3, 'denominator' => 4]  // không tương đương
            ],
            'target_value' => 0.5,
            'time_limit' => 120
        ],
        // Các level tiếp theo
    ];
    
    return $groups[$level] ?? $groups[1];
}

// Kiểm tra nhóm phân số tương đương
function checkEqualGroup($fractions) {
    if (count($fractions) < 2) return false;
    
    $firstValue = $fractions[0]['numerator'] / $fractions[0]['denominator'];
    
    foreach ($fractions as $fraction) {
        $value = $fraction['numerator'] / $fraction['denominator'];
        if (abs($value - $firstValue) > 0.0001) {
            return false;
        }
    }
    
    return true;
}
```

### 4. Cách chơi
1. Quan sát các phân số trên màn hình
2. Kéo và thả phân số vào các nhóm
3. Tạo nhóm các phân số tương đương
4. Hoàn thành trước thời gian
5. Chuyển level khi đạt đủ điểm

### 5. Kiểm tra đáp án
```javascript
// Frontend gửi dữ liệu
const formData = new FormData();
formData.append('group', JSON.stringify({
    fractions: selectedFractions,
    groupId: currentGroup
}));

// Backend kiểm tra
$correct = checkEqualGroup($group['fractions']);
```

### 6. Phản hồi
- **Đúng**: 
  - Highlight nhóm phân số đúng
  - Animation chúc mừng
  - Cộng điểm
- **Sai**: 
  - Rung lắc nhóm phân số
  - Cho phép thử lại
  - Hiển thị gợi ý

## Cấu trúc code

### Routes
```php
// Game nhóm bằng nhau
Route::get('/phanso/equal-groups', [GameController::class, 'equalGroupsGame']);
Route::post('/phanso/equal-groups/check', [GameController::class, 'checkEqualGroups']);
Route::post('/phanso/equal-groups/reset', [GameController::class, 'resetEqualGroups']);
```

### Views
- **File**: `resources/views/games/lop4/phanso/equal_groups.blade.php`
- **Components**:
  - Fraction cards
  - Group containers
  - Timer display
  - Score counter
  - Progress bar

### JavaScript
- Drag and drop functionality
- Group management
- Timer control
- Animation effects
- AJAX requests

### Session
- Key: `equal_groups_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho tương tác
- HTML5 Drag and Drop API
- GSAP cho animation
- Laravel cho backend
- Bootstrap cho UI

## Cải tiến có thể thực hiện
1. Thêm chế độ thi đấu 2 người
2. Thêm hiệu ứng âm thanh
3. Thêm công cụ tính toán
4. Thêm bảng xếp hạng
5. Thêm chế độ tạo nhóm tùy chỉnh
``` 