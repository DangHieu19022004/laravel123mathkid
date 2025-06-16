# Game So Sánh Thời Gian 🕒

## Mục tiêu
Giúp học sinh luyện tập so sánh các khoảng thời gian khác nhau, phát triển kỹ năng chuyển đổi và nhận biết đơn vị thời gian.

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
- Hiển thị hai khoảng thời gian với đơn vị khác nhau (giờ, phút, giây, ngày...)
- Nút chọn khoảng thời gian lớn hơn
- Thông báo đúng/sai
- Bảng điểm
- Bảng quy đổi thời gian tham khảo

### 2. Các level
- **Level 1**: So sánh các khoảng thời gian đơn giản (giờ, phút)
- **Level 2**: Thêm đơn vị ngày, tuần
- **Level 3**: Kết hợp nhiều đơn vị hỗn hợp
- **Level 4**: Số lượng câu hỏi nhiều hơn
- **Level 5**: Thời gian giới hạn

### 3. Logic game
```javascript
// Chuyển đổi thời gian về giây để so sánh
function convertToSeconds(time) {
    switch(time.unit) {
        case 'giây': return time.value;
        case 'phút': return time.value * 60;
        case 'giờ': return time.value * 3600;
        case 'ngày': return time.value * 86400;
        case 'tuần': return time.value * 604800;
        default: return 0;
    }
}

// So sánh hai khoảng thời gian
function checkAnswer(selected, other) {
    return convertToSeconds(selected) > convertToSeconds(other);
}
```

### 4. Cách chơi
1. Quan sát hai khoảng thời gian trên màn hình
2. Chọn khoảng thời gian lớn hơn
3. Nhấn kiểm tra để xác nhận
4. Đúng thì cộng điểm, sai thì trừ điểm
5. Chuyển level khi đạt đủ điểm

### 5. Kiểm tra đáp án
```javascript
const isCorrect = checkAnswer(selected, other);
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
// Game so sánh thời gian
Route::get('/dailuongvadoluong/time-comparison', [MeasurementGameController::class, 'timeComparisonGame']);
Route::post('/dailuongvadoluong/time-comparison/check', [MeasurementGameController::class, 'checkTimeComparisonAnswer']);
Route::post('/dailuongvadoluong/time-comparison/reset', [MeasurementGameController::class, 'resetTimeComparisonGame']);
```

### Views
- **File**: `resources/views/games/lop4/dailuongvadoluong/so_sanh_thoi_gian.blade.php`
- **Components**:
  - Hai khoảng thời gian
  - Nút chọn
  - Thông báo
  - Bảng điểm
  - Bảng quy đổi thời gian

### JavaScript
- Chuyển đổi đơn vị thời gian
- So sánh thời gian
- Kiểm tra đáp án
- Hiệu ứng thông báo

### Session
- Key: `time_comparison_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho logic
- HTML5 cho giao diện
- Laravel cho backend
- Bootstrap/Tailwind cho UI

## Cải tiến có thể thực hiện
1. Thêm nhiều loại câu hỏi hơn
2. Thêm chế độ thi đấu thời gian
3. Thêm bảng xếp hạng
4. Thêm giải thích đáp án 