# Game Thời Gian Nâng Cao ⏰

## Mục tiêu
Giúp học sinh luyện tập giải các bài toán thời gian phức tạp, phát triển kỹ năng cộng, trừ, so sánh và chuyển đổi các đơn vị thời gian.

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
- Hiển thị bài toán thời gian phức tạp (cộng, trừ, so sánh thời gian)
- Ô nhập đáp án (giờ, phút)
- Nút hiển thị gợi ý
- Thông báo đúng/sai
- Bảng điểm

### 2. Các level
- **Level 1**: Cộng thời gian đơn giản
- **Level 2**: Trừ thời gian
- **Level 3**: So sánh thời gian
- **Level 4**: Bài toán thực tế phức tạp hơn
- **Level 5**: Thời gian giới hạn

### 3. Logic game
```php
// Kiểm tra đáp án giờ phút
function checkTime($userHours, $userMinutes, $answer) {
    return $userHours === $answer['hours'] && $userMinutes === $answer['minutes'];
}
```

### 4. Cách chơi
1. Đọc bài toán trên màn hình
2. Nhập đáp án giờ, phút
3. Nhấn kiểm tra để xác nhận
4. Đúng thì cộng điểm, sai thì trừ điểm
5. Chuyển level khi đạt đủ điểm

### 5. Kiểm tra đáp án
```php
$correct = checkTime($userHours, $userMinutes, $answer);
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
// Game thời gian nâng cao
Route::get('/dailuongvadoluong/advanced-time', [MeasurementGameController::class, 'advancedTimeGame']);
Route::post('/dailuongvadoluong/advanced-time/check', [MeasurementGameController::class, 'checkAdvancedTimeAnswer']);
Route::post('/dailuongvadoluong/advanced-time/reset', [MeasurementGameController::class, 'resetAdvancedTimeGame']);
```

### Views
- **File**: `resources/views/games/lop4/dailuongvadoluong/thoi_gian_nang_cao.blade.php`
- **Components**:
  - Bài toán thời gian
  - Input đáp án (giờ, phút)
  - Nút gợi ý
  - Thông báo
  - Bảng điểm

### JavaScript
- Sinh bài toán ngẫu nhiên
- Kiểm tra đáp án
- Quản lý điểm số
- Hiệu ứng thông báo

### Session
- Key: `advanced_time_level`
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