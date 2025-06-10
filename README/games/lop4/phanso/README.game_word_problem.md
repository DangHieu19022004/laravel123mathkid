# Game Bài Toán Có Lời Văn 📝

## Mục tiêu
Giúp học sinh rèn luyện kỹ năng giải toán có lời văn liên quan đến phân số, phát triển tư duy logic và khả năng áp dụng kiến thức vào thực tế.

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
- Khu vực hiển thị đề bài
- Hình ảnh minh họa bài toán
- Các ô nhập đáp án
- Thanh tiến trình level
- Nút kiểm tra và làm lại

### 2. Các level
- **Level 1**: Bài toán về chia bánh đơn giản
- **Level 2**: Bài toán về tìm phần còn lại
- **Level 3**: Bài toán về so sánh phân số
- **Level 4**: Bài toán về tính toán phân số
- **Level 5**: Bài toán tổng hợp nhiều phép tính

### 3. Logic game
```php
// Tạo câu hỏi theo level
function generateWordProblem($level) {
    $problems = [
        1 => [
            'text' => 'Lan có 1 cái bánh. Lan chia bánh thành 4 phần bằng nhau và cho em 1 phần. Hỏi em Lan được mấy phần bánh?',
            'image' => 'cake_division.svg',
            'answer' => ['numerator' => 1, 'denominator' => 4],
            'hint' => 'Bánh được chia thành mấy phần? Em được cho mấy phần?'
        ],
        // Các level tiếp theo
    ];
    return $problems[$level] ?? $problems[1];
}

// Kiểm tra đáp án
function checkWordProblemAnswer($answer, $problem) {
    return $answer['numerator'] === $problem['answer']['numerator'] &&
           $answer['denominator'] === $problem['answer']['denominator'];
}
```

### 4. Cách chơi
1. Đọc kỹ đề bài toán
2. Quan sát hình ảnh minh họa
3. Phân tích thông tin và yêu cầu
4. Nhập đáp án vào ô tương ứng
5. Nhấn "Kiểm tra" để xác nhận đáp án

### 5. Kiểm tra đáp án
```javascript
// Frontend gửi dữ liệu
const formData = new FormData();
formData.append('answer', JSON.stringify({
    numerator: numeratorValue,
    denominator: denominatorValue
}));

// Backend kiểm tra
$correct = checkWordProblemAnswer($answer, $problem);
```

### 6. Phản hồi
- **Đúng**: 
  - Hiển thị thông báo chúc mừng
  - Animation minh họa lời giải
  - Tự động chuyển level mới
- **Sai**: 
  - Rung lắc nhẹ ô nhập
  - Cho phép thử lại
  - Hiển thị gợi ý phân tích bài toán

## Cấu trúc code

### Routes
```php
// Game bài toán có lời văn
Route::get('/phanso/word-problem', [GameController::class, 'wordProblemGame']);
Route::post('/phanso/word-problem/check', [GameController::class, 'checkWordProblemAnswer']);
Route::post('/phanso/word-problem/reset', [GameController::class, 'resetWordProblemGame']);
```

### Views
- **File**: `resources/views/games/lop4/phanso/word_problem.blade.php`
- **Components**:
  - Problem display
  - Illustration
  - Input form
  - Progress bar
  - Hint system
  - Solution explanation

### JavaScript
- Xử lý nhập liệu
- Kiểm tra định dạng phân số
- Animation minh họa
- Gửi AJAX request

### Session
- Key: `word_problem_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho tương tác
- GSAP cho animation
- Laravel cho backend
- Bootstrap cho UI
- SVG cho minh họa bài toán

## Cải tiến có thể thực hiện
1. Thêm công cụ vẽ sơ đồ bài toán
2. Thêm chế độ thi đấu 2 người
3. Thêm bảng xếp hạng
4. Thêm tính năng ghi chú và nháp
5. Thêm video hướng dẫn giải từng dạng bài
``` 