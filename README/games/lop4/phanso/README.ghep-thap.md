# Game Ghép Thập Phân 🔢

## Mục tiêu
Giúp học sinh học về mối quan hệ giữa phân số và số thập phân thông qua trò chơi ghép cặp tương ứng.

## Cấu trúc game

### 1. Giao diện
- Màn hình chia làm 2 cột:
  - Cột trái: Danh sách phân số
  - Cột phải: Danh sách số thập phân
- Các số được hiển thị trong các ô có thể kéo thả
- Thanh tiến trình hiển thị số cặp đã ghép đúng

### 2. Các level
- **Level 1**: Số thập phân một chữ số (1/2 → 0.5)
- **Level 2**: Số thập phân hai chữ số (1/4 → 0.25)
- **Level 3**: Số thập phân ba chữ số (1/8 → 0.125)
- **Level 4**: Phân số phức tạp (3/4 → 0.75)
- **Level 5**: Hỗn hợp các dạng số

### 3. Logic game
```php
// Tạo danh sách cặp số dựa vào level
function generatePairs($level) {
    $pairs = [];
    switch($level) {
        case 1:
            $pairs = [
                ['fraction' => '1/2', 'decimal' => '0.5'],
                ['fraction' => '1/5', 'decimal' => '0.2'],
                // ...
            ];
            break;
        case 2:
            // Tương tự cho các level khác
    }
    return shuffle($pairs);
}

// Kiểm tra cặp ghép
function checkPair($fraction, $decimal) {
    return eval("return $fraction;") == $decimal;
}
```

### 4. Cách chơi
1. Học sinh quan sát các số ở hai cột
2. Kéo thả để ghép cặp phân số - số thập phân
3. Cặp ghép đúng sẽ được khóa và đổi màu
4. Hoàn thành khi ghép đúng tất cả các cặp
5. Chuyển level khi hoàn thành

### 5. Kiểm tra đáp án
```javascript
// Frontend kiểm tra ghép cặp
function checkMatch(fractionElement, decimalElement) {
    const pair = {
        fraction: fractionElement.dataset.value,
        decimal: decimalElement.dataset.value
    };
    
    // Gửi AJAX request kiểm tra
    fetch('/phanso/bracket/check', {
        method: 'POST',
        body: JSON.stringify(pair)
    })
    .then(response => response.json())
    .then(data => {
        if (data.correct) {
            lockPair(fractionElement, decimalElement);
        }
    });
}
```

### 6. Phản hồi
- **Ghép đúng**: 
  - Cặp số được khóa
  - Đổi màu xanh
  - Cập nhật thanh tiến trình
- **Ghép sai**: 
  - Rung lắc nhẹ
  - Trả về vị trí cũ
  - Hiển thị gợi ý (tùy level)

## Cấu trúc code

### Routes
```php
// Game ghép thập phân
Route::get('/phanso/bracket', [GameController::class, 'bracketGame']);
Route::post('/phanso/bracket/check', [GameController::class, 'checkBracketMatch']);
Route::post('/phanso/bracket/reset', [GameController::class, 'resetBracketGame']);
```

### Views
- **File**: `resources/views/games/lop4/bracket.blade.php`
- **Components**:
  - Draggable number cards
  - Progress bar
  - Message display
  - Level indicator

### JavaScript
- Xử lý kéo thả (Drag & Drop API)
- Kiểm tra ghép cặp
- Animation phản hồi
- Cập nhật tiến trình

### Session
- Key: `bracket_level`
- Giá trị: 1-5
- Reset về 1 khi hoàn thành level 5

## Công nghệ sử dụng
- HTML5 Drag & Drop API
- JavaScript thuần cho tương tác
- GSAP cho animation
- Laravel cho backend
- Bootstrap cho UI

## Cải tiến có thể thực hiện
1. Thêm chế độ tính giờ
2. Thêm hiệu ứng âm thanh
3. Thêm chế độ nhiều người chơi
4. Thêm bảng xếp hạng
5. Thêm công cụ chuyển đổi số 