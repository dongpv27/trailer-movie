# TrailerPhim - Setup Instructions

## Current Status
- [x] Laravel project installed
- [x] All migrations created
- [x] All models created
- [x] All controllers created
- [x] Routes configured
- [x] SEO Helper created
- [x] Blade views & components created
- [x] Filament admin resources created
- [x] Sitemap service & command created
- [x] Category seeder created
- [x] Frontend assets built (npm run build)

## Database Setup Required

PostgreSQL is running but requires authentication. Choose one option:

### Option 1: Use PostgreSQL with password

Update `.env` with your PostgreSQL credentials:
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=trailerphim
DB_USERNAME=postgres
DB_PASSWORD=your_password_here
```

Then create the database:
```bash
psql -U postgres -c "CREATE DATABASE trailerphim;"
```

### Option 2: Configure PostgreSQL for trust authentication (dev only)

Edit `postgresql.conf` and `pg_hba.conf` to allow trust authentication, then restart PostgreSQL.

### Option 3: Use Docker PostgreSQL

```bash
docker run -d --name postgres-trailer -e POSTGRES_PASSWORD=postgres -e POSTGRES_DB=trailerphim -p 5432:5432 postgres:16
```

Then update `.env`:
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=trailerphim
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

## Complete Setup (after database is configured)

```bash
# 1. Run migrations
php artisan migrate

# 2. Seed categories
php artisan db:seed --class=CategorySeeder

# 3. Create admin user
php artisan tinker
>>> \App\Models\User::create(['name' => 'Admin', 'email' => 'admin@trailerphim.com', 'password' => bcrypt('admin123')])

# 4. Start server
php artisan serve
```

## Access URLs

- Website: http://localhost:8000
- Admin Panel: http://localhost:8000/admin
- Sitemap: http://localhost:8000/sitemap.xml

Admin login:
- Email: admin@trailerphim.com
- Password: admin123

## Required Image Placeholders

Create these placeholder images in `public/images/`:
- `og-default.jpg` - 1200x630 for OpenGraph
- `logo.png` - 200x200 for logo
- `no-poster.png` - 300x450 for missing movie posters
- `no-backdrop.png` - 1920x1080 for missing backdrops
- `no-post.png` - 1200x630 for missing post thumbnails

Or update the code to use external placeholder services like `placehold.co`.

## Scheduled Tasks

The sitemap is scheduled to generate daily at 02:00. To verify:
```bash
php artisan schedule:list
```

To run manually:
```bash
php artisan sitemap:generate --ping
```
