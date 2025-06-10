# Game Săn Từ Phân Số 🔍

## Mục tiêu
Giúp học sinh rèn luyện khả năng nhận biết và hiểu về phân số thông qua việc tìm kiếm các từ liên quan đến phân số trong bảng chữ cái, phát triển kỹ năng quan sát và tư duy nhanh.

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
- Bảng chữ cái với các từ ẩn
- Danh sách từ cần tìm
- Đồng hồ đếm ngược
- Thanh tiến trình level
- Điểm số hiện tại

### 2. Các level
- **Level 1**: Tìm từ đơn giản về phân số cơ bản
- **Level 2**: Tìm từ về so sánh phân số
- **Level 3**: Tìm từ về phép tính phân số
- **Level 4**: Tìm từ về ứng dụng phân số
- **Level 5**: Tìm từ phức tạp và thuật ngữ phân số

### 3. Logic game
```php
// Tạo bảng chữ cái và từ ẩn
function generateWordHuntGrid($level) {
    $words = [
        1 => [
            'words' => ['PHANSO', 'TUSO', 'MAUSO', 'CHIA'],
            'grid_size' => 8,
            'time_limit' => 120,
            'hint' => 'Tìm các từ cơ bản về phân số'
        ],
        // Các level tiếp theo
    ];
    
    return generateGrid($words[$level] ?? $words[1]);
}

// Tạo ma trận chữ cái
function generateGrid($config) {
    $grid = [];
    $size = $config['grid_size'];
    
    // Đặt các từ vào vị trí ngẫu nhiên
    foreach ($config['words'] as $word) {
        placeWord($grid, $word);
    }
    
    // Điền các ô trống bằng chữ cái ngẫu nhiên
    fillEmptySpaces($grid);
    
    return [
        'grid' => $grid,
        'words' => $config['words'],
        'time_limit' => $config['time_limit']
    ];
}

// Kiểm tra từ tìm được
function checkFoundWord($word, $words) {
    return in_array(strtoupper($word), array_map('strtoupper', $words));
}
```

### 4. Cách chơi
1. Quan sát bảng chữ cái
2. Tìm và đánh dấu các từ trong danh sách
3. Kéo chuột để chọn từ
4. Hoàn thành trước khi hết thời gian
5. Chuyển level khi tìm đủ từ

### 5. Kiểm tra đáp án
```javascript
// Frontend gửi dữ liệu
const formData = new FormData();
formData.append('found_word', JSON.stringify({
    word: selectedWord,
    start: startPosition,
    end: endPosition
}));

// Backend kiểm tra
$correct = checkFoundWord($foundWord, $levelWords);
```

### 6. Phản hồi
- **Đúng**: 
  - Đánh dấu từ tìm được
  - Animation highlight từ
  - Cộng điểm
- **Sai**: 
  - Rung lắc vùng chọn
  - Cho phép thử lại
  - Không trừ điểm

## Cấu trúc code

### Routes
```php
// Game săn từ phân số
Route::get('/phanso/word-hunt', [GameController::class, 'wordHuntGame']);
Route::post('/phanso/word-hunt/check', [GameController::class, 'checkWordHunt']);
Route::post('/phanso/word-hunt/reset', [GameController::class, 'resetWordHunt']);
```

### Views
- **File**: `resources/views/games/lop4/phanso/word_hunt.blade.php`
- **Components**:
  - Letter grid
  - Word list
  - Timer
  - Score display
  - Progress bar

### JavaScript
- Grid interaction
- Word selection
- Timer management
- Animation effects
- AJAX requests

### Session
- Key: `word_hunt_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- JavaScript thuần cho tương tác
- Canvas API cho grid rendering
- GSAP cho animation
- Laravel cho backend
- Bootstrap cho UI

## Cải tiến có thể thực hiện
1. Thêm chế độ multiplayer
2. Thêm power-ups (thời gian thêm, gợi ý)
3. Thêm bảng xếp hạng theo thời gian
4. Thêm nhiều hướng tìm từ hơn
5. Thêm chế độ tạo bảng từ tùy chỉnh
``` 