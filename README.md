# Game Toán Lớp 4

Dự án game học toán dành cho học sinh lớp 4, tập trung vào các chủ đề về phân số và phép tính.

## Yêu cầu hệ thống

- PHP >= 8.0
- Composer
- Node.js & NPM
- Laravel 9.x

## Cài đặt

1. Clone dự án:
```bash
git clone <repository-url>
cd game-toan-lop4
```

2. Cài đặt dependencies:
```bash
composer install
npm install
```

3. Tạo file .env và cấu hình:
```bash
cp .env.example .env
php artisan key:generate
```

4. Chạy ứng dụng:
```bash
php artisan serve
npm run dev
```

## Các game hiện có

### 1. Game Chia Bánh (Phân số)
- **Route**: `/games/lop4/phanso/cake`
- **Mô tả**: Học sinh sẽ học về phân số thông qua việc chia bánh sinh nhật
- **Cách chơi**: 
  - Bánh được chia thành nhiều phần bằng nhau
  - Click vào từng phần để chọn/bỏ chọn
  - Chọn đúng số phần theo yêu cầu
- **Logic**: 
  - Level 1: Chia 2 phần
  - Level 2: Chia 4 phần
  - Level 3: Chia 6 phần
  - Level 4: Chia 8 phần
  - Level 5: Chia 10 phần

### 2. Game Chia Táo
- **Route**: `/games/lop4/phanso/apple`
- **Mô tả**: Học sinh học về phép chia qua việc chia táo vào các nhóm
- **Cách chơi**:
  - Kéo và thả táo vào các nhóm
  - Mỗi nhóm phải có số táo bằng nhau
- **Logic**:
  - Level 1: 4-8 táo chia 2 nhóm
  - Level 2: 6-12 táo chia 2 nhóm
  - Level 3: 9-15 táo chia 3 nhóm
  - Level 4: 12-20 táo chia 3 nhóm
  - Level 5: 16-24 táo chia 4 nhóm

### 3. Game Biểu Thức Ngoặc
- **Route**: `/games/lop4/phanso/bracket`
- **Mô tả**: Học sinh học cách tính biểu thức có dấu ngoặc
- **Cách chơi**:
  - Đặt dấu ngoặc vào biểu thức để có kết quả theo yêu cầu
  - Click vào số để đặt/bỏ dấu ngoặc
- **Logic**:
  - Thứ tự tính: Trong ngoặc → Nhân chia → Cộng trừ
  - Độ khó tăng dần theo level

## Cấu trúc thư mục

```
resources/views/games/lop4/
├── phanso.blade.php     # Trang chủ games
├── cake.blade.php       # Game chia bánh
├── apple.blade.php      # Game chia táo
└── bracket.blade.php    # Game biểu thức ngoặc
```

## Phát triển

### Routes
Tất cả routes được định nghĩa trong `routes/web.php`:
```php
Route::prefix('games/lop4')->name('games.lop4.')->group(function () {
    Route::get('/phanso', [GameController::class, 'gameHub']);
    
    // Game chia bánh
    Route::get('/phanso/cake', [GameController::class, 'cakeGame']);
    Route::post('/phanso/cake/check', [GameController::class, 'checkCakeAnswer']);
    Route::post('/phanso/cake/reset', [GameController::class, 'resetCakeGame']);
    
    // Game chia táo
    Route::get('/phanso/apple', [GameController::class, 'appleGame']);
    Route::post('/phanso/apple/check', [GameController::class, 'checkChiataoAnswer']);
    Route::post('/phanso/apple/reset', [GameController::class, 'resetAppleGame']);
    
    // Game biểu thức ngoặc
    Route::get('/phanso/bracket', [GameController::class, 'bracketGame']);
    Route::post('/phanso/bracket/check', [GameController::class, 'checkBieuthucAnswer']);
    Route::post('/phanso/bracket/reset', [GameController::class, 'resetBracketGame']);
});
```

### Controllers
Logic xử lý game được định nghĩa trong `app/Http/Controllers/GameController.php`

### Session
- Mỗi game sử dụng session để lưu level hiện tại
- Keys: `cake_level`, `apple_level`, `bracket_level`
