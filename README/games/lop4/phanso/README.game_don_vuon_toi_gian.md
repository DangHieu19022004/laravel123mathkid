# Game Đơn Vườn Táo - Tối Giản Phân Số 🍎

## Mục tiêu
Giúp học sinh học về tối giản phân số thông qua việc thu hoạch táo trong vườn và tính toán phân số tối giản.

## Cấu trúc game

### 1. Giao diện
- Vườn táo với nhiều cây táo
- Mỗi cây có số táo khác nhau
- Giao diện chia làm 2 phần:
  - Phần vườn táo (hiển thị các cây)
  - Phần nhập đáp án (phân số tối giản)

### 2. Các level
- **Level 1**: Phân số đơn giản (2-4 táo)
- **Level 2**: Phân số trung bình (4-8 táo)
- **Level 3**: Phân số phức tạp (8-12 táo)
- **Level 4**: Phân số rất phức tạp (12-16 táo)
- **Level 5**: Phân số siêu phức tạp (16-20 táo)

### 3. Logic game
```php
// Tạo số táo dựa vào level
$maxApples = 4 + ($level - 1) * 4;
$totalApples = rand($maxApples/2, $maxApples);

// Tạo số táo được chọn (luôn nhỏ hơn tổng số táo)
$selectedApples = rand(1, $totalApples - 1);

// Tối giản phân số
function simplifyFraction($numerator, $denominator) {
    $gcd = gcd($numerator, $denominator);
    return [
        'numerator' => $numerator / $gcd,
        'denominator' => $denominator / $gcd
    ];
}
```

### 4. Cách chơi
1. Học sinh quan sát vườn táo
2. Click vào các quả táo để thu hoạch
3. Hệ thống hiển thị phân số thu hoạch/tổng số
4. Học sinh tính toán phân số tối giản
5. Nhập đáp án vào ô phân số
6. Nhấn "Kiểm tra" để xác nhận

### 5. Kiểm tra đáp án
```php
// Backend kiểm tra
$userAnswer = [
    'numerator' => $request->input('numerator'),
    'denominator' => $request->input('denominator')
];

$correctAnswer = simplifyFraction($selectedApples, $totalApples);

$isCorrect = ($userAnswer['numerator'] == $correctAnswer['numerator'] &&
             $userAnswer['denominator'] == $correctAnswer['denominator']);
```

### 6. Phản hồi
- **Đúng**: 
  - Hiển thị thông báo chúc mừng
  - Animation táo rơi vào giỏ
  - Tự động chuyển level mới
- **Sai**: 
  - Hiển thị gợi ý về UCLN
  - Cho phép thử lại

## Cấu trúc code

### Routes
```php
// Game vườn táo
Route::get('/phanso/apple', [GameController::class, 'appleGame']);
Route::post('/phanso/apple/check', [GameController::class, 'checkAppleAnswer']);
Route::post('/phanso/apple/reset', [GameController::class, 'resetAppleGame']);
```

### Views
- **File**: `resources/views/games/lop4/apple.blade.php`
- **Components**:
  - Apple tree SVG
  - Apple objects
  - Fraction input form
  - Message display

### JavaScript
- Xử lý click chọn táo
- Tính toán và hiển thị phân số
- Gửi AJAX request kiểm tra đáp án
- Animation táo rơi

### Session
- Key: `apple_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- SVG cho vẽ cây và táo
- JavaScript thuần cho tương tác
- GSAP cho animation
- Laravel cho backend
- Bootstrap cho UI

## Cải tiến có thể thực hiện
1. Thêm nhiều loại cây ăn quả khác nhau
2. Thêm công cụ hỗ trợ tìm UCLN
3. Thêm chế độ thi đấu 2 người
4. Thêm hiệu ứng âm thanh
5. Thêm chế độ gợi ý từng bước 