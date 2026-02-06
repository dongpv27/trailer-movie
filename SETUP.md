# TrailerPhim - Laravel Movie Trailer Website

Website trailer phim cho thị trường Việt Nam, sử dụng Laravel + PostgreSQL, kiến trúc SEO-first.

## Cài đặt

### 1. Cấu hình môi trường

```bash
cp .env.example .env
```

Cập nhật `.env`:
- DB_CONNECTION=pgsql
- DB_HOST=127.0.0.1
- DB_PORT=5432
- DB_DATABASE=trailerphim
- DB_USERNAME=postgres
- DB_PASSWORD=mật_khẩu_của_bạn

### 2. Cài đặt dependencies

```bash
composer install
npm install
```

### 3. Chạy migrations và seeders

```bash
php artisan migrate
php artisan db:seed --class=CategorySeeder
```

### 4. Link storage

```bash
php artisan storage:link
```

### 5. Build assets

```bash
npm run build
```

### 6. Tạo admin user

```bash
php artisan tinker
>>> User::create(['name' => 'Admin', 'email' => 'admin@trailerphim.com', 'password' => bcrypt('password')])
```

### 7. Khởi động server

```bash
php artisan serve
```

Truy cập: http://localhost:8000

## Admin Panel

Filament admin panel: http://localhost:8000/admin

## Lệnh hữu ích

```bash
# Generate sitemap
php artisan sitemap:generate

# Generate sitemap và ping Google
php artisan sitemap:generate --ping

# Run scheduler để test
php artisan schedule:run
```

## Cấu trúc dự án

- `app/Models/` - Movie, Trailer, Category, Post
- `app/Http/Controllers/` - Controllers
- `app/Helpers/SeoHelper.php` - SEO Schema.org helpers
- `app/Services/SitemapService.php` - Sitemap generator
- `app/Filament/Resources/` - Admin resources
- `resources/views/` - Blade templates
- `database/migrations/` - Database migrations

## Features

- Trang chủ với slider phim hot
- Trang chi tiết phim với trailer YouTube
- Danh sách phim theo trạng thái (Hot, Sắp chiếu, Đang chiếu)
- Lọc theo thể loại, quốc gia, năm
- Tin điện ảnh
- Sitemap tự động
- SEO-friendly với Schema.org
- Admin panel với Filament

## Verification

- [x] Trang chủ hiển thị đầy đủ sections
- [x] Hero slider hoạt động
- [x] Trang phim /phim/{slug} có đầy đủ Schema.org
- [x] Sitemap.xml accessible
- [x] Admin panel CRUD hoạt động
- [x] Mobile responsive
