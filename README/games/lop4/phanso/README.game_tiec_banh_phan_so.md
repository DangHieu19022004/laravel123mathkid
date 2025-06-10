# Game Chia Bánh Sinh Nhật 🎂

## Mục tiêu
Giúp học sinh học về phân số thông qua việc chia bánh sinh nhật thành các phần bằng nhau và chọn số phần theo yêu cầu.

## Yêu cầu hệ thống
- PHP >= 7.4
- Laravel >= 8.0
- Node.js >= 14.0
- MySQL >= 5.7

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
- Bánh sinh nhật hình tròn được vẽ bằng SVG
- Bánh được chia thành các phần bằng nhau (số phần tùy theo level)
- Mỗi phần có thể click để chọn/bỏ chọn
- Phần được chọn sẽ chuyển sang màu vàng (#ffc107)

### 2. Các level
- **Level 1**: Bánh chia 2 phần
- **Level 2**: Bánh chia 4 phần
- **Level 3**: Bánh chia 6 phần
- **Level 4**: Bánh chia 8 phần
- **Level 5**: Bánh chia 10 phần

### 3. Logic game
```php
// Tính số phần bánh dựa vào level
$pieces = 2 + ($level - 1) * 2;

// Random số phần cần chọn (luôn nhỏ hơn tổng số phần)
$numerator = rand(1, $pieces - 1);

// Tạo câu hỏi
$question = [
    'level' => $level,
    'pieces' => $pieces,
    'numerator' => $numerator,
    'denominator' => $pieces
];
```

### 4. Cách chơi
1. Học sinh xem yêu cầu phân số cần chọn (VD: 3/8)
2. Click vào các phần bánh để chọn
3. Phần được chọn sẽ chuyển màu vàng
4. Click lần nữa để bỏ chọn
5. Nhấn "Kiểm tra" khi đã chọn xong

### 5. Kiểm tra đáp án
```javascript
// Frontend gửi dữ liệu
const formData = new FormData();
formData.append('selected_pieces', JSON.stringify(Array.from(selectedPieces)));
formData.append('numerator', numerator);

// Backend kiểm tra
$isCorrect = count($selectedPieces) === (int)$numerator;
```

### 6. Phản hồi
- **Đúng**: 
  - Hiển thị thông báo chúc mừng
  - Hiệu ứng confetti
  - Tự động chuyển level mới sau 2 giây
- **Sai**: 
  - Hiển thị thông báo gợi ý
  - Cho phép thử lại

## Cấu trúc code

### Routes
```php
// Game chia bánh
Route::get('/phanso/cake', [GameController::class, 'cakeGame']);
Route::post('/phanso/cake/check', [GameController::class, 'checkCakeAnswer']);
Route::post('/phanso/cake/reset', [GameController::class, 'resetCakeGame']);
```

### Views
- **File**: `resources/views/games/lop4/cake.blade.php`
- **Components**:
  - SVG cake drawing
  - Game controls
  - Message display
  - Confetti effect

### JavaScript
- Vẽ bánh bằng SVG
- Xử lý click chọn phần bánh
- Gửi AJAX request kiểm tra đáp án
- Hiển thị phản hồi và hiệu ứng

### Session
- Key: `cake_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- SVG cho vẽ bánh
- JavaScript thuần cho tương tác
- Canvas Confetti cho hiệu ứng
- Laravel cho backend
- Bootstrap cho UI

## Cải tiến có thể thực hiện
1. Thêm animation khi chọn/bỏ chọn phần bánh
2. Thêm âm thanh phản hồi
3. Thêm chế độ chơi tính giờ
4. Thêm bảng xếp hạng
5. Thêm các dạng bánh khác nhau 