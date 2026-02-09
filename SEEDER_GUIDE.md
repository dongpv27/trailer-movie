# Hướng dẫn sử dụng MoviesFrom2020Seeder

Seeder này giúp bạn tự động import dữ liệu phim từ năm 2020-2025 từ TMDB (The Movie Database) vào website TrailerPhim.

## Yêu cầu

### 1. TMDB API Key

Bạn cần có API key từ TMDB (miễn phí):

1. Truy cập: https://www.themoviedb.org/settings/api
2. Đăng nhập hoặc đăng ký tài khoản
3. Tạo API key (chọn "Developer")
4. Copy API key

### 2. Cấu hình .env

Thêm TMDB API key vào file `.env`:

```bash
TMDB_API_KEY=your_api_key_here
```

Ví dụ:
```bash
TMDB_API_KEY=eyJhbGciOiJIUzI1NiJ9.eyJ...
```

## Cách sử dụng

### Phương pháp 1: Chạy trực tiếp seeder (Khuyên dùng)

```bash
php artisan db:seed --class=MoviesFrom2020Seeder
```

### Phương pháp 2: Gọi từ DatabaseSeeder

Bỏ comment dòng trong `database/seeders/DatabaseSeeder.php`:

```php
$this->call([
    MoviesFrom2020Seeder::class,
]);
```

Sau đó chạy:

```bash
php artisan db:seed
```

## Danh sách phim được import

Seeder sẽ import ~50+ phim nổi bật từ 2020-2025:

### 2025
- Captain America: Brave New World
- Mission: Impossible 8
- Avatar 3
- Thunderbolts
- ...

### 2024
- Deadpool & Wolverine
- Dune: Part Two
- Inside Out 2
- Gladiator 2
- Wicked
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
- Shang-Chi and the Legend of the Ten Rings
- ...

### 2020
- Tenet
- Wonder Woman 1984
- Soul
- ...

## Dữ liệu được import

### Movie Model
- ✅ Title (tiêu đề)
- ✅ Original Title (tiêu đề gốc)
- ✅ Slug (URL-friendly)
- ✅ Description (mô tả ngắn)
- ✅ Content (nội dung SEO 120-180 chữ)
- ✅ Notable Points (điểm nổi bật 2-3 câu)
- ✅ FAQ (3-4 câu hỏi thường gặp)
- ✅ Poster (ảnh poster từ TMDB)
- ✅ Backdrop (ảnh nền từ TMDB)
- ✅ Release Date (ngày phát hành)
- ✅ Status (trạng thái: released/upcoming)
- ✅ Duration (thời lượng)
- ✅ Director (đạo diễn)
- ✅ Cast (diễn viên)
- ✅ View Count (lượt xem - mặc định 0)
- ✅ Published At (ngày xuất bản)

### Trailer Model
- ✅ YouTube ID
- ✅ Title (tiêu đề trailer)
- ✅ Is Main (trailer chính)

### Categories
- ✅ Genres (thể loại) - mapped từ TMDB genres
- ✅ Countries (quốc gia) - detected từ production countries

## Nội dung SEO tự động

Seeder tự động tạo nội dung SEO theo template:

### Content (120-180 chữ)
- Mô tả bối cảnh phim
- Giới thiệu nhân vật chính
- Nêu xung đột chính (KHÔNG spoil kết thúc)
- Nhấn mạnh giá trị sản xuất

### Notable Points (2-3 câu)
- Lý do phim được quan tâm
- Điểm đặc biệt về thể loại
- Thông tin về công chiếu

### FAQ (3-4 câu)
- Khi nào phim công chiếu?
- Trailer đã ra chưa?
- Phim thuộc thể loại gì?
- Ai là đạo diễn?

## Tính năng

### ✅ Tự động trùng lọc
- Kiểm tra trùng slug
- Bỏ qua phim đã tồn tại
- Tạo slug duy nhất

### ✅ Rate Limiting
- Delay 0.25s giữa các request
- Tránh bị TMDB limit
- An toàn cho API key

### ✅ Error Handling
- Tiếp tục nếu 1 phim lỗi
- Log chi tiết lỗi
- Báo cáo tổng kết

### ✅ Smart Mapping
- Map TMDB genres → Local categories
- Detect quốc gia từ production countries
- Tự động set movie country

## Output example

```
=== Seeding Movies from 2020-2025 ===
Processing [0/53]: Captain America: Brave New World (2025)
  - Created: Captain America: Brave New World
Processing [1/53]: Mission: Impossible 8 (2025)
  - Not found on TMDB
Processing [2/53]: Avatar 3 (2025)
  - Created: Avatar 3
...

=== Seeding Complete ===
Total processed: 53
Successfully created: 45
Skipped (already exists): 5
Failed: 3
```

## Troubleshooting

### Lỗi: TMDB_API_KEY not found
```
Solution: Thêm TMDB_API_KEY=xxx vào file .env
```

### Lỗi: Not found on TMDB
```
Solution: Phim chưa có trên TMDB hoặc tên không khớp.
Kiểm tra lại tên phim tại: https://www.themoviedb.org/
```

### Lỗi: Failed to fetch details
```
Solution: Có thể do rate limit hoặc network issue.
Thử lại sau vài giây hoặc kiểm tra kết nối internet.
```

### Làm mới hoàn toàn
```bash
# Xóa tất cả movies và trailers
php artisan migrate:fresh

# Chạy lại seeder cài đặt
php artisan db:seed --class=TRAILERPHIM_INSTALL

# Chạy seeder import phim
php artisan db:seed --class=MoviesFrom2020Seeder
```

## Customization

### Thêm phim mới
Sửa file `database/seeders/MoviesFrom2020Seeder.php`, thêm vào array `$moviesToSeed`:

```php
$moviesToSeed = [
    // ... existing movies ...
    ['title' => 'Ten Phim Moi', 'year' => 2025],
];
```

### Thay đổi ngôn ngữ
Thay đổi parameter `language` trong các method API:

```php
'language' => 'vi-VN', // Tiếng Việt
// hoặc
'language' => 'en-US', // Tiếng Anh
```

### Điều chỉnh số trailer
Thay đổi trong method `createTrailers()`:

```php
foreach ($trailers->take(3) as $index => $video) {
    // Change 'take(3)' to 'take(5)' for more trailers
}
```

## Notes

- Seeder sử dụng TMDB API v3
- Giới hạn rate: 40 requests / 10 seconds (TMDB free tier)
- Thời gian chạy: ~13-15 giây cho 50 phim
- Poster/backdrop URLs từ TMDB image server
- Không cần download ảnh về local (sử dụng URL trực tiếp)

## Support

Nếu gặp vấn đề:
1. Kiểm tra TMDB API key có hợp lệ không
2. Kiểm tra kết nối internet
3. Xem log lỗi chi tiết trong terminal
4. Test API key tại: https://developers.themoviedb.org/3/getting-started/introduction
