# TrailerPhim - Hướng dẫn cài đặt

## Cách 1: Cài đặt đầy đủ (Khuyên dùng)

Sử dụng file migration và seeder tổng hợp - **chỉ cần chạy 2 lệnh**:

```bash
# 1. Migration tất cả các bảng
php artisan migrate:fresh

# 2. Seeder dữ liệu ban đầu (categories, streamings, admin user)
php artisan db:seed --class=TRAILERPHIM_INSTALL
```

Hoặc gộp thành 1 lệnh:

```bash
php artisan migrate:fresh --seed
```

## Cách 2: Sử dụng các file riêng lẻ

Nếu muốn chạy từng migration/seeder riêng lẻ (không khuyến khích):

```bash
# Migrations
php artisan migrate

# Seeders
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=StreamingSeeder
php artisan db:seed --class=MovieSeeder
php artisan db:seed --class=PostSeeder
```

---

## File tổng hợp

### 📁 database/migrations/TRAILERPHIM_INSTALL.php

Tổng hợp **tất cả** migrations của project trong 1 file:

- ✅ movies table (với tất cả fields: content, notable_points, faq, director, cast)
- ✅ trailers table (với sort field)
- ✅ categories table (genre, country, year)
- ✅ category_movie pivot table
- ✅ streamings table
- ✅ movie_streaming pivot table (với external_url)
- ✅ posts table

### 📁 database/seeders/TRAILERPHIM_INSTALL.php

Tổng hợp dữ liệu ban đầu trong 1 file:

- ✅ 14 thể loại phim (genres)
- ✅ 14 quốc gia (countries)
- ✅ 5 năm phim (years)
- ✅ 5 rạp chiếu phim Việt Nam (CGV, Lotte, Galaxy, Beta, Cinestar)
- ✅ 5 nền tảng streaming quốc tế (Netflix, Disney+, HBO Go, Prime Video, Apple TV+)
- ✅ Admin user cho Filament

---

## Thông tin đăng nhập Admin

Sau khi chạy seeder, bạn có thể đăng nhập vào admin panel tại `/admin`:

- **Email**: `admin@trailerphim.com`
- **Password**: `password`

⚠️ **QUAN TRỌNG**: Đổi password sau khi đăng nhập lần đầu!

---

## Các bước tiếp theo sau khi cài đặt

```bash
# 1. Tạo symlink cho storage (nếu chưa có)
php artisan storage:link

# 2. Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# 3. Tạo sitemap
php artisan sitemap:generate

# 4. (Tuỳ chọn) Start development server
php artisan serve
# Hoặc dùng full stack
composer dev
```

---

## Danh sách file migrations cũ (đã được tổng hợp)

Các file dưới đây đã được gộp vào `TRAILERPHIM_INSTALL.php` và có thể **xoá** nếu muốn:

- ❌ `2025_02_04_000001_create_movies_table.php`
- ❌ `2025_02_04_000002_create_trailers_table.php`
- ❌ `2025_02_04_000003_create_categories_table.php`
- ❌ `2025_02_04_000004_create_category_movie_table.php`
- ❌ `2025_02_04_000005_create_posts_table.php`
- ❌ `2026_02_06_035710_add_sort_to_trailers_table.php`
- ❌ `2026_02_06_060920_add_seo_fields_to_movies_table.php`
- ❌ `2026_02_07_135032_create_streamings_table.php`
- ❌ `2026_02_07_135034_create_movie_streaming_table.php`
- ❌ `2026_02_07_150051_add_movie_slug_to_movie_streaming_table.php`
- ❌ `2026_02_07_171710_add_cast_and_director_to_movies_table.php`

## Danh sách file seeders cũ (đã được tổng hợp)

Các file dưới đây đã được gộp vào `TRAILERPHIM_INSTALL.php`:

- ❌ `CategorySeeder.php` (dữ liệu đã gộp)
- ❌ `StreamingSeeder.php` (dữ liệu đã gộp)
- ✅ `MovieSeeder.php` (giữ lại nếu muốn thêm dữ liệu mẫu)
- ✅ `Movies2025Seeder.php` (giữ lại nếu muốn thêm dữ liệu mẫu)
- ✅ `Movies2026Seeder.php` (giữ lại nếu muốn thêm dữ liệu mẫu)
- ✅ `PostSeeder.php` (giữ lại nếu muốn thêm dữ liệu mẫu)
- ✅ `MovieStreamingSeeder.php` (giữ lại nếu muốn thêm dữ liệu mẫu)
- ✅ `AddMovieCastSeeder.php` (giữ lại nếu muốn thêm dữ liệu mẫu)

---

## Lưu ý quan trọng

1. **Backup dữ liệu trước khi chạy migrate:fresh** - Lệnh này sẽ XOÁ TOÀN BỘ dữ liệu!
2. File migration tổng hợp có tên bắt đầu bằng `TRAILERPHIM_` để dễ nhận biết và luôn được load đầu tiên
3. Sau khi cài đặt, nên vào admin panel để thêm nội dung thực tế (movies, trailers, posts)
4. Tạo sitemap định kỳ để cập nhật Google: `php artisan sitemap:generate --ping`

---

## Troubleshooting

### Lỗi "Class TRAILERPHIM_INSTALL not found"

```bash
php artisan optimize:clear
composer dump-autoload
```

### Lỗi khi chạy seeder

```bash
php artisan db:seed --class=TRAILERPHIM_INSTALL --force
```

### Muốn reset hoàn toàn

```bash
php artisan migrate:fresh --seed --force
```
