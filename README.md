<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

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

## Sử dụng với Ngrok

Để chạy ứng dụng qua ngrok:

1. Cài đặt ngrok
2. Chạy lệnh:
```bash
ngrok http 8000
```
3. Cấu hình trong `app/Providers/AppServiceProvider.php` đã có sẵn xử lý HTTPS cho ngrok

## Đóng góp

Nếu bạn muốn đóng góp cho dự án, vui lòng:
1. Fork dự án
2. Tạo branch mới (`git checkout -b feature/amazing-feature`)
3. Commit thay đổi (`git commit -m 'Add some amazing feature'`)
4. Push lên branch (`git push origin feature/amazing-feature`)
5. Tạo Pull Request

## License

[MIT License](LICENSE)
