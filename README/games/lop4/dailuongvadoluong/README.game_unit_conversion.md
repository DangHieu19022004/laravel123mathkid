# Game Chuyển Đổi Đơn Vị Thần Tốc 🔄

## Mục tiêu
Giúp học sinh luyện tập chuyển đổi giữa các đơn vị đo lường (khối lượng, độ dài, dung tích) một cách nhanh chóng, phát triển kỹ năng tính toán và nhận biết đơn vị.

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
- Hiển thị một phép chuyển đổi đơn vị (ví dụ: 1500g = ? kg)
- Ô nhập đáp án
- Bảng điểm
- Thông báo đúng/sai
- Bàn phím ảo hỗ trợ nhập số

### 2. Các level
- **Level 1**: Chuyển đổi đơn vị cơ bản (g <-> kg, m <-> km)
- **Level 2**: Thêm các đơn vị nhỏ hơn (cm, mm)
- **Level 3**: Kết hợp nhiều loại đơn vị
- **Level 4**: Số lớn, nhiều phép chuyển đổi liên tiếp
- **Level 5**: Thời gian giới hạn

### 3. Logic game
```javascript
// Định nghĩa các bộ chuyển đổi đơn vị
const conversions = [
    { from: 'g', to: 'kg', factor: 0.001 },
    { from: 'kg', to: 'g', factor: 1000 },
    { from: 'm', to: 'km', factor: 0.001 },
    { from: 'km', to: 'm', factor: 1000 },
    { from: 'cm', to: 'm', factor: 0.01 },
    { from: 'm', to: 'cm', factor: 100 },
    { from: 'mm', to: 'cm', factor: 0.1 },
    { from: 'cm', to: 'mm', factor: 10 }
];

function generateQuestion() {
    // Chọn ngẫu nhiên một bộ chuyển đổi
    const conversion = conversions[Math.floor(Math.random() * conversions.length)];
    // ...
}

function checkAnswer(userAnswer, correctAnswer) {
    return Math.abs(userAnswer - correctAnswer) < 0.001;
}
```

### 4. Cách chơi
1. Đọc phép chuyển đổi trên màn hình
2. Nhập đáp án vào ô trống
3. Nhấn kiểm tra để xác nhận
4. Đúng thì cộng điểm, sai thì trừ điểm
5. Chuyển level khi đạt đủ điểm

### 5. Kiểm tra đáp án
```javascript
const isCorrect = checkAnswer(userInput, correctAnswer);
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
// Game chuyển đổi đơn vị
Route::get('/dailuongvadoluong/unit-conversion', [MeasurementGameController::class, 'unitConversionGame']);
Route::post('/dailuongvadoluong/unit-conversion/check', [MeasurementGameController::class, 'checkUnitConversionAnswer']);
Route::post('/dailuongvadoluong/unit-conversion/reset', [MeasurementGameController::class, 'resetUnitConversionGame']);
```

### Views
- **File**: `resources/views/games/lop4/dailuongvadoluong/chuyen_doi_don_vi.blade.php`
- **Components**:
  - Input đáp án
  - Bảng điểm
  - Thông báo
  - Bàn phím ảo

### JavaScript
- Sinh câu hỏi ngẫu nhiên
- Kiểm tra đáp án
- Quản lý điểm số
- Hiệu ứng thông báo

### Session
- Key: `unit_conversion_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho logic
- HTML5 cho giao diện
- Laravel cho backend
- Bootstrap/Tailwind cho UI

## Cải tiến có thể thực hiện
1. Thêm nhiều loại đơn vị hơn
2. Thêm chế độ thi đấu thời gian
3. Thêm bảng xếp hạng
4. Thêm giải thích đáp án 