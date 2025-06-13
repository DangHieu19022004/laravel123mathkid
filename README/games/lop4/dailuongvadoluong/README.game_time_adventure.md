# Game Thời Gian Phiêu Lưu ⏰

## Mục tiêu
Giúp học sinh luyện tập tính toán khoảng thời gian giữa hai mốc, phát triển kỹ năng cộng, trừ thời gian và nhận biết đơn vị thời gian.

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
8. Chạy `npm run dev`

## Cấu trúc game

### 1. Giao diện
- Hiển thị thời gian bắt đầu và khoảng thời gian cần tính
- Ô nhập đáp án thời gian kết thúc hoặc khoảng thời gian
- Thông báo đúng/sai
- Bảng điểm

### 2. Các level
- **Level 1**: Cộng phút vào giờ
- **Level 2**: Cộng giờ vào giờ
- **Level 3**: Cộng phút phức tạp
- **Level 4**: Cộng giờ lẻ
- **Level 5**: Cộng nhiều mốc thời gian

### 3. Logic game
```php
// Tính thời gian kết thúc
function calculateEndTime($startTime, $duration, $type) {
    $time = strtotime($startTime);
    if ($type === 'minutes') {
        $time += $duration * 60;
    } else {
        $time += $duration * 3600;
    }
    return date('H:i', $time);
}

// Kiểm tra đáp án
function checkTimeAdventure($userAnswer, $correctAnswer) {
    return $userAnswer === $correctAnswer;
}
```

### 4. Cách chơi
1. Đọc thời gian bắt đầu và khoảng thời gian trên màn hình
2. Nhập đáp án thời gian kết thúc
3. Nhấn kiểm tra để xác nhận
4. Đúng thì cộng điểm, sai thì trừ điểm
5. Chuyển level khi đạt đủ điểm

### 5. Kiểm tra đáp án
```php
$correct = checkTimeAdventure($userAnswer, $correctAnswer);
```

### 6. Phản hồi
- **Đúng**: 
  - Hiển thị thông báo chúc mừng
  - Cộng điểm
- **Sai**: 
  - Hiển thị đáp án đúng
  - Trừ điểm

## Cấu trúc code

### Routes
```php
// Game thời gian phiêu lưu
Route::get('/dailuongvadoluong/time-adventure', [MeasurementGameController::class, 'timeAdventureGame']);
Route::post('/dailuongvadoluong/time-adventure/check', [MeasurementGameController::class, 'checkTimeAdventureAnswer']);
Route::get('/dailuongvadoluong/time-adventure/reset', [MeasurementGameController::class, 'resetTimeAdventureGame']);
```

### Views
- **File**: `resources/views/games/lop4/dailuongvadoluong/thoi_gian_phieu_luu.blade.php`
- **Components**:
  - Thời gian bắt đầu
  - Input đáp án
  - Thông báo
  - Bảng điểm

### JavaScript
- Tính toán thời gian
- Kiểm tra đáp án
- Quản lý điểm số
- Hiệu ứng thông báo

### Session
- Key: `time_adventure_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho logic
- HTML5 cho giao diện
- Laravel cho backend
- Bootstrap/Tailwind cho UI

## Cải tiến có thể thực hiện
1. Thêm nhiều dạng bài toán hơn
2. Thêm chế độ thi đấu thời gian
3. Thêm bảng xếp hạng
4. Thêm giải thích đáp án 