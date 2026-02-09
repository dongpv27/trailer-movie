# TRAILERPHIM - Database Setup Guide

## 📁 Tổng quan

Đã đơn giản hóa database structure, giờ chỉ cần **2 files**:

```
database/
├── migrations/
│   └── TRAILERPHIM_ALL_TABLES.php    ← 1 file MIGRATION duy nhất
└── seeders/
    ├── DatabaseSeeder.php            ← File gọi seeder
    └── TRAILERPHIM_ALL_DATA.php       ← 1 file SEEDER duy nhất
```

## 🚀 Cách sử dụng

### 1. MIGRATE - Tạo tất cả bảng

Chạy **1 lệnh duy nhất** để tạo toàn bộ database:

```bash
php artisan migrate --path=database/migrations/TRAILERPHIM_ALL_TABLES.php
```

Hoặc nếu muốn xóa data cũ và tạo lại từ đầu:

```bash
php artisan migrate:fresh --path=database/migrations/TRAILERPHIM_ALL_TABLES.php
```

**Các bảng sẽ được tạo:**
- ✅ `users` - User accounts
- ✅ `movies` - Phim (với full-text search)
- ✅ `trailers` - Trailers YouTube
- ✅ `categories` - Thể loại, Quốc gia, Năm
- ✅ `category_movie` - Quan hệ phim - thể loại
- ✅ `posts` - Bài viết tin tức
- ✅ `streamings` - Rạp chiếu & Platform streaming
- ✅ `movie_streaming` - Quan hệ phim - streaming
- ✅ `cache`, `jobs`, `failed_jobs` - Laravel system tables

### 2. SEED - Thêm data vào database

#### Bước 1: Thêm TMDB API Key

Lấy API key miễn phí tại: https://www.themoviedb.org/settings/api

Thêm vào file `.env`:

```bash
TMDB_API_KEY=your_api_key_here
```

#### Bước 2: Chạy seeder

```bash
# Chạy seeder tổng hợp (khuyên dùng)
php artisan db:seed --class=TRAILERPHIM_ALL_DATA

# Hoặc chạy tất cả seeders
php artisan db:seed
```

**Data sẽ được thêm:**
- ✅ **48 Categories**: 14 genres, 14 countries, 12 years (2015-2026)
- ✅ **10 Streamings**: 5 cinemas (CGV, Lotte...) + 5 platforms (Netflix, Disney+...)
- ✅ **3 Sample Posts**: Tin tức mẫu
- ✅ **53+ Movies**: Phim nổi tiếng từ 2020-2025 (từ TMDB)
  - Tự động tạo: trailers, genres, countries, SEO content

## 🔄 Reset & Reinstall

### Xóa toàn bộ data và tạo lại

```bash
# Bước 1: Xóa tất cả tables
php artisan migrate:fresh --path=database/migrations/TRAILERPHIM_ALL_TABLES.php

# Bước 2: Seed lại data
php artisan db:seed --class=TRAILERPHIM_ALL_DATA
```

### Chỉ muốn xóa movies (giữ nguyên categories/streamings)

```bash
# Xóa trong database
php artisan tinker --execute="App\Models\Movie::truncate(); App\Models\Trailer::truncate();"

# Seed lại movies
php artisan db:seed --class=TRAILERPHIM_ALL_DATA
```

## 📊 Tóm tắt

### Trước khi tổng hợp:
- ❌ 17+ migration files
- ❌ 12+ seeder files
- ❌ Phức tạp, khó quản lý

### Sau khi tổng hợp:
- ✅ 1 migration file (`TRAILERPHIM_ALL_TABLES.php`)
- ✅ 1 seeder file (`TRAILERPHIM_ALL_DATA.php`)
- ✅ Đơn giản, dễ maintain

## 🔧 Testing

### Test kết nối TMDB

```bash
php artisan tmdb:test
```

### Test tìm kiếm phim trên TMDB

```bash
php artisan tmdb:test --movie="Oppenheimer"
```

## 📝 File Reference

### TRAILERPHIM_ALL_TABLES.php
- **Chức năng**: Tạo toàn bộ database schema
- **Bảng được tạo**: 11 tables
- **Tính năng đặc biệt**: PostgreSQL full-text search
- **Rollback**: Hỗ trợ đầy đủ

### TRAILERPHIM_ALL_DATA.php
- **Chức năng**: Seed toàn bộ data cần thiết
- **Data được tạo**:
  - 48 categories (genres, countries, years)
  - 10 streamings (cinemas, platforms)
  - 3 sample posts
  - 53+ movies from TMDB (2020-2025)
- **Yêu cầu**: TMDB_API_KEY trong .env
- **Tính năng**: Auto-generate SEO content, auto-fetch trailers

## ⚠️ Lưu ý

1. **TMDB API Key**: BẮT BUỘC để seed movies (lấy miễn phí)
2. **PostgreSQL**: Full-text search chỉ hoạt động với PostgreSQL
3. **Rate Limiting**: Seeder tự động delay 0.25s giữa các request để tránh bị TMDB limit
4. **Unique Slugs**: Tự động tạo slug duy nhất, tránh trùng lặp

## 🐛 Troubleshooting

### Lỗi: TMDB_API_KEY not found
```bash
# Solution: Thêm vào .env
TMDB_API_KEY=your_key_here
```

### Lỗi: Table doesn't exist
```bash
# Solution: Chạy migration trước
php artisan migrate --path=database/migrations/TRAILERPHIM_ALL_TABLES.php
```

### Lỗi: Class not found
```bash
# Solution: Clear cache
php artisan clear-compiled
composer dump-autoload
```

## 📞 Support

- TMDB API: https://developers.themoviedb.org/
- Laravel Docs: https://laravel.com/docs/migrations
- Project Issues: https://github.com/dongpv27/trailer-movie/issues
