<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * TRAILERPHIM - COMPLETE DATABASE SETUP
 *
 * File migration duy nhất chứa toàn bộ cấu trúc database cho TrailerPhim.
 * Chạy 1 lần là hoàn tất setup database.
 *
 * Chạy: php artisan migrate:fresh --seed
 */
return new class extends Migration
{
    public function up(): void
    {
        // ============================================
        // TABLE: USERS (Laravel default)
        // ============================================
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // ============================================
        // TABLE: MOVIES
        // ============================================
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('original_title')->nullable();
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // SEO fields
            $table->text('content')->nullable()->comment('Nội dung phim SEO 120-180 chữ');
            $table->text('notable_points')->nullable()->comment('Phim có gì đáng chú ý 2-3 câu');
            $table->json('faq')->nullable()->comment('Câu hỏi thường gặp JSON');

            $table->string('poster')->nullable();
            $table->string('backdrop')->nullable();
            $table->date('release_date')->nullable();
            // status column removed - using movie_statuses pivot table instead
            $table->string('country')->nullable();
            $table->string('director')->nullable();
            $table->string('cast')->nullable();
            $table->integer('duration')->nullable()->comment('Duration in minutes');
            $table->unsignedBigInteger('view_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index('slug');
            $table->index('release_date');
            $table->index('view_count');
            $table->index('published_at');
        });

        // ============================================
        // TABLE: MOVIE_STATUSES (pivot table for multi-status)
        // ============================================
        Schema::create('movie_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['hot', 'upcoming', 'released']);
            $table->timestamps();

            $table->unique(['movie_id', 'status']);
            $table->index('status');
        });

        // ============================================
        // TABLE: TRAILERS
        // ============================================
        Schema::create('trailers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->string('youtube_id');
            $table->string('thumbnail')->nullable();
            $table->boolean('is_main')->default(false);
            $table->unsignedInteger('sort')->default(0);
            $table->unsignedInteger('play_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index('movie_id');
            $table->index('is_main');
            $table->index('published_at');
            $table->index('play_count');
        });

        // ============================================
        // TABLE: CATEGORIES (genres, countries, years)
        // ============================================
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('type', ['genre', 'country', 'year'])->default('genre');
            $table->text('description')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index('slug');
            $table->index('type');
        });

        // ============================================
        // TABLE: CATEGORY_MOVIE (pivot)
        // ============================================
        Schema::create('category_movie', function (Blueprint $table) {
            $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            // Composite primary key
            $table->primary(['movie_id', 'category_id']);
        });

        // ============================================
        // TABLE: POSTS
        // ============================================
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt')->nullable();
            $table->text('content');
            $table->string('thumbnail')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->unsignedBigInteger('view_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        // ============================================
        // TABLE: STREAMINGS (Netflix, Disney+, etc.)
        // ============================================
        Schema::create('streamings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type'); // 'cinema' or 'streaming'
            $table->string('icon')->nullable(); // SVG icon or Heroicon name
            $table->string('url')->nullable(); // External link to platform
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // ============================================
        // TABLE: MOVIE_STREAMING (pivot)
        // ============================================
        Schema::create('movie_streaming', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $table->foreignId('streaming_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('available'); // 'available' or 'coming_soon'
            $table->timestamp('available_date')->nullable();
            $table->string('external_url')->nullable();
            $table->timestamps();
        });

        // ============================================
        // TABLE: PAGE_VISITS (Analytics)
        // ============================================
        Schema::create('page_visits', function (Blueprint $table) {
            $table->id();
            $table->string('url', 500);
            $table->string('route_name')->nullable();
            $table->nullableMorphs('visitable');
            $table->string('session_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('visited_at')->index();
        });

        // ============================================
        // TABLE: TRAILER_PLAYS (Analytics)
        // ============================================
        Schema::create('trailer_plays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trailer_id')->constrained()->onDelete('cascade');
            $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('played_at')->index();

            $table->index('trailer_id');
            $table->index('movie_id');
        });

        // ============================================
        // FULL-TEXT SEARCH SETUP (PostgreSQL only)
        // ============================================
        if (DB::getDriverName() === 'pgsql') {
            // Add search_text column for full-text search (tsvector type)
            DB::statement("ALTER TABLE movies ADD COLUMN search_text tsvector");

            // Create GIN index for fast full-text search
            DB::statement("CREATE INDEX movies_search_text_idx ON movies USING GIN (search_text)");

            // Create trigger function to update search_text automatically
            DB::statement("
                CREATE OR REPLACE FUNCTION movies_search_text_trigger() RETURNS trigger AS $$
                BEGIN
                    NEW.search_text :=
                        setweight(to_tsvector('simple', coalesce(NEW.title, '')), 'A') ||
                        setweight(to_tsvector('simple', coalesce(NEW.original_title, '')), 'A') ||
                        setweight(to_tsvector('simple', coalesce(NEW.director, '')), 'B') ||
                        setweight(to_tsvector('simple', coalesce(NEW.\"cast\", '')), 'C') ||
                        setweight(to_tsvector('simple', coalesce(NEW.country, '')), 'D') ||
                        setweight(to_tsvector('simple', coalesce(NEW.description, '')), 'D');
                    RETURN NEW;
                END
                $$ LANGUAGE plpgsql
            ");

            // Create trigger to call the function on INSERT or UPDATE
            DB::statement("
                CREATE TRIGGER movies_search_text_update
                BEFORE INSERT OR UPDATE ON movies
                FOR EACH ROW
                EXECUTE FUNCTION movies_search_text_trigger()
            ");
        }

        // ============================================
        // TABLE: CACHE (Laravel default)
        // ============================================
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });

        // ============================================
        // TABLE: JOBS (Laravel default)
        // ============================================
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options');
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        // ============================================
        // TABLE: SESSIONS (Laravel default)
        // ============================================
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        // Drop triggers (PostgreSQL)
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("DROP TRIGGER IF EXISTS movies_search_text_update ON movies");
            DB::statement("DROP FUNCTION IF EXISTS movies_search_text_trigger()");
            DB::statement("DROP INDEX IF EXISTS movies_search_text_idx");
        }

        // Drop all tables in correct order (respecting foreign keys)
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('trailer_plays');
        Schema::dropIfExists('page_visits');
        Schema::dropIfExists('movie_streaming');
        Schema::dropIfExists('streamings');
        Schema::dropIfExists('category_movie');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('movie_statuses');
        Schema::dropIfExists('trailers');
        Schema::dropIfExists('movies');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('users');
    }
};
