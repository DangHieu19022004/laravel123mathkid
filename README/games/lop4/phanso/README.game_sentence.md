# Game Ghép Câu Phân Số 📝

## Mục tiêu
Giúp học sinh rèn luyện khả năng đọc và hiểu phân số thông qua việc ghép các từ để tạo thành câu có ý nghĩa về phân số, phát triển kỹ năng ngôn ngữ và tư duy logic.

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
- Khu vực hiển thị các từ rời rạc
- Khu vực ghép câu
- Thanh tiến trình level
- Nút kiểm tra và làm lại
- Khu vực hiển thị gợi ý

### 2. Các level
- **Level 1**: Ghép câu đơn giản về phân số cơ bản
- **Level 2**: Ghép câu về so sánh phân số
- **Level 3**: Ghép câu về phép cộng phân số
- **Level 4**: Ghép câu về phép trừ phân số
- **Level 5**: Ghép câu phức tạp về các phép tính phân số

### 3. Logic game
```php
// Tạo câu hỏi theo level
function generateSentenceQuestion($level) {
    $questions = [
        1 => [
            'words' => ['Một', 'phần', 'tư', 'là', 'phân số', 'bằng', '1/4'],
            'correct_sentence' => 'Một phần tư là phân số bằng 1/4',
            'hint' => 'Hãy bắt đầu với từ "Một"'
        ],
        // Các level tiếp theo
    ];
    return $questions[$level] ?? $questions[1];
}

// Kiểm tra câu trả lời
function checkSentenceAnswer($answer, $question) {
    // Loại bỏ khoảng trắng thừa và chuyển về chữ thường
    $normalizedAnswer = trim(strtolower($answer));
    $normalizedCorrect = trim(strtolower($question['correct_sentence']));
    
    return $normalizedAnswer === $normalizedCorrect;
}
```

### 4. Cách chơi
1. Quan sát các từ được cung cấp
2. Kéo và thả các từ vào khu vực ghép câu
3. Sắp xếp các từ theo thứ tự hợp lý
4. Nhấn "Kiểm tra" để xác nhận
5. Chuyển level khi ghép đúng câu

### 5. Kiểm tra đáp án
```javascript
// Frontend gửi dữ liệu
const formData = new FormData();
formData.append('sentence', JSON.stringify({
    words: arrangedWords,
    order: wordOrder
}));

// Backend kiểm tra
$correct = checkSentenceAnswer($sentence, $question);
```

### 6. Phản hồi
- **Đúng**: 
  - Hiển thị thông báo chúc mừng
  - Animation từ sáng lên
  - Tự động chuyển level mới
- **Sai**: 
  - Rung lắc nhẹ các từ sai vị trí
  - Cho phép thử lại
  - Hiển thị gợi ý về từ đầu tiên

## Cấu trúc code

### Routes
```php
// Game ghép câu phân số
Route::get('/phanso/sentence', [GameController::class, 'sentenceGame']);
Route::post('/phanso/sentence/check', [GameController::class, 'checkSentenceAnswer']);
Route::post('/phanso/sentence/reset', [GameController::class, 'resetSentenceGame']);
```

### Views
- **File**: `resources/views/games/lop4/phanso/sentence.blade.php`
- **Components**:
  - Word bank
  - Sentence construction area
  - Progress bar
  - Message display
  - Hint system

### JavaScript
- Drag and drop functionality
- Word order management
- Animation effects
- AJAX requests

### Session
- Key: `sentence_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho tương tác
- HTML5 Drag and Drop API
- GSAP cho animation
- Laravel cho backend
- Bootstrap cho UI

## Cải tiến có thể thực hiện
1. Thêm chế độ đếm thời gian
2. Thêm chế độ thi đấu 2 người
3. Thêm nhiều dạng câu hơn
4. Thêm bảng xếp hạng
5. Thêm công cụ gợi ý thông minh
``` 