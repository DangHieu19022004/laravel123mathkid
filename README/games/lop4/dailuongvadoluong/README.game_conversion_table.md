# Game Bảng Quy Đổi 📝

## Mục tiêu
Giúp học sinh luyện tập hoàn thành bảng quy đổi giữa các đơn vị đo lường (độ dài, khối lượng, dung tích), phát triển kỹ năng chuyển đổi và ghi nhớ các hệ số quy đổi.

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
- Hiển thị bảng quy đổi với các ô trống cần điền
- Danh sách số kéo thả vào bảng
- Thông báo đúng/sai
- Bảng điểm

### 2. Các level
- **Level 1**: Bảng quy đổi đơn vị mét, số nhỏ
- **Level 2**: Bảng quy đổi số lớn hơn
- **Level 3**: Đơn vị hỗn hợp (km, m, cm, mm)
- **Level 4**: Bảng quy đổi khối lượng, dung tích
- **Level 5**: Thời gian giới hạn

### 3. Logic game
```javascript
// Cấu trúc level
const levels = [
    {
        headers: ['Mét (m)', 'Decimét (dm)', 'Centimét (cm)', 'Milimét (mm)'],
        rows: [
            { m: 1, dm: 10, cm: 100, mm: 1000 }
        ],
        draggables: [10, 100, 1000, 20, 200, 2000]
    },
    // ...
];

// Kiểm tra đáp án
function checkTable(userAnswers, correctAnswers) {
    return userAnswers.every((ans, i) => Math.abs(ans - correctAnswers[i]) < 0.01);
}
```

### 4. Cách chơi
1. Quan sát bảng quy đổi trên màn hình
2. Kéo thả số vào các ô trống phù hợp
3. Nhấn kiểm tra để xác nhận
4. Đúng thì cộng điểm, sai thì trừ điểm
5. Chuyển level khi đạt đủ điểm

### 5. Kiểm tra đáp án
```javascript
const isCorrect = checkTable(userAnswers, correctAnswers);
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
// Game bảng quy đổi
Route::get('/dailuongvadoluong/conversion-table', [MeasurementGameController::class, 'conversionTableGame']);
Route::post('/dailuongvadoluong/conversion-table/check', [MeasurementGameController::class, 'checkConversionTableAnswer']);
Route::post('/dailuongvadoluong/conversion-table/reset', [MeasurementGameController::class, 'resetConversionTableGame']);
```

### Views
- **File**: `resources/views/games/lop4/dailuongvadoluong/conversion_table.blade.php`
- **Components**:
  - Bảng quy đổi
  - Danh sách số kéo thả
  - Thông báo
  - Bảng điểm

### JavaScript
- Sinh bảng quy đổi ngẫu nhiên
- Kéo thả số
- Kiểm tra đáp án
- Hiệu ứng thông báo

### Session
- Key: `conversion_table_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho logic
- HTML5 cho giao diện
- Laravel cho backend
- Bootstrap/Tailwind cho UI

## Cải tiến có thể thực hiện
1. Thêm nhiều loại bảng quy đổi hơn
2. Thêm chế độ thi đấu thời gian
3. Thêm bảng xếp hạng
4. Thêm giải thích đáp án 