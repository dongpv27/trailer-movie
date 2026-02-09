# Quick Start - Thêm phim từ TMDB

Hướng dẫn nhanh để thêm data phim từ năm 2020-2025 vào TrailerPhim.

## Bước 1: Lấy TMDB API Key

1. Truy cập: https://www.themoviedb.org/settings/api
2. Đăng nhập hoặc đăng ký tài khoản (miễn phí)
3. Click "Apply" để tạo API key
4. Copy API key (dạng: `eyJhbGciOiJIUzI1NiJ9...`)

## Bước 2: Thêm API Key vào .env

Mở file `.env` và thêm dòng sau:

```bash
TMDB_API_KEY=eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJ...
```

**Lưu ý:** Thay `eyJhbGciOiJIUzI1NiJ9...` bằng API key của bạn.

## Bước 3: Test kết nối

```bash
php artisan tmdb:test
```

Nếu thấy output như sau là thành công:
```
=== TMDB API Connection Test ===
✅ TMDB_API_KEY đã được cấu hình
Đang test kết nối tới TMDB API...
✅ Kết nối thành công!
=== Tất cả tests passed! ===
```

## Bước 4: Chạy Seeder

```bash
php artisan db:seed --class=MoviesFrom2020Seeder
```

## Các lệnh hữu ích

### Test tìm kiếm một phim cụ thể
```bash
php artisan tmdb:test --movie="Oppenheimer"
```

### Xem danh sách phim sẽ được import
Mở file `database/seeders/MoviesFrom2020Seeder.php`, xem array `$moviesToSeed`

### Import lại từ đầu (xóa data cũ)
```bash
# Cảnh báo: Sẽ XÓA TẤT CẢ data!
php artisan migrate:fresh

# Cài đặt lại
php artisan db:seed --class=TRAILERPHIM_INSTALL

# Import phim
php artisan db:seed --class=MoviesFrom2020Seeder
```

### Thêm phim mới vào danh sách
Mở file `database/seeders/MoviesFrom2020Seeder.php`, thêm vào `$moviesToSeed`:

```php
$moviesToSeed = [
    // ... phim cũ ...
    ['title' => 'Ten Phim Moi', 'year' => 2025],
];
```

## Troubleshooting

### Lỗi: TMDB_API_KEY not found
```
Solution: Thêm TMDB_API_KEY=xxx vào file .env
```

### Lỗi: API key invalid
```
Solution: Kiểm tra lại API key, đảm bảo copy đúng toàn bộ string
```

### Lỗi: Connection timeout
```
Solution: Kiểm tra kết nối internet, thử lại sau
```

## Danh sách phim sẽ được import (~53 phim)

### 2025
- Captain America: Brave New World
- Mission: Impossible 8
- Avatar 3
- Thunderbolts
- The SpongeBob Movie

### 2024
- Deadpool & Wolverine
- Dune: Part Two
- Inside Out 2
- Gladiator 2
- Wicked
- Joker: Folie à Deux
- Kingdom of the Planet of the Apes
- ...

### 2023
- Oppenheimer
- Barbie
- Spider-Man: Across the Spider-Verse
- Guardians of the Galaxy Vol. 3
- John Wick: Chapter 4
- ...

### 2022
- Top Gun: Maverick
- Avatar: The Way of Water
- The Batman
- ...

### 2021
- Spider-Man: No Way Home
- Dune
- Shang-Chi
- ...

### 2020
- Tenet
- Wonder Woman 1984
- Soul
- ...

## Dữ liệu được tự động tạo

Mỗi phim sẽ có:
- ✅ Title, Original Title, Slug
- ✅ Description (overview)
- ✅ Content SEO (120-180 chữ)
- ✅ Notable Points (2-3 câu)
- ✅ FAQ (3-4 câu hỏi)
- ✅ Poster + Backdrop URLs
- ✅ Release Date, Status, Duration
- ✅ Director, Cast
- ✅ Trailers (YouTube)
- ✅ Genres + Countries (categories)

## Thời gian chạy

- ~50 phim: khoảng 15-20 giây
- Rate limiting: 0.25s/request (tránh bị TMDB limit)

## Support

Xem hướng dẫn chi tiết: `SEEDER_GUIDE.md`
TMDB API docs: https://developers.themoviedb.org/
