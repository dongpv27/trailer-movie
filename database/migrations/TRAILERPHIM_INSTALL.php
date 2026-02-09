<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * TRAILERPHIM ALL-IN-ONE MIGRATION
 *
 * File migration này tổng hợp tất cả các bảng cần thiết cho project TrailerPhim.
 * Chạy migration này khi cài đặt mới hoặc reset database.
 *
 * Cách sử dụng:
 * php artisan migrate:fresh --seed
 *
 * Hoặc nếu database đã có dữ liệu:
 * php artisan migrate
 */
return new class extends Migration
{
    public function up(): void
    {
        // ==================== MOVIES TABLE ====================
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('original_title')->nullable();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('content')->nullable()->comment('Nội dung phim SEO 120-180 chữ');
            $table->text('notable_points')->nullable()->comment('Phim có gì đáng chú ý 2-3 câu');
            $table->json('faq')->nullable()->comment('Câu hỏi thường gặp JSON');
            $table->string('poster')->nullable();
            $table->string('backdrop')->nullable();
            $table->date('release_date')->nullable();
            $table->enum('status', ['hot', 'upcoming', 'released'])->default('released');
            $table->string('country')->nullable();
            $table->string('director')->nullable();
            $table->string('cast')->nullable();
            $table->integer('duration')->nullable()->comment('Duration in minutes');
            $table->unsignedBigInteger('view_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index('slug');
            $table->index('status');
            $table->index('release_date');
            $table->index('view_count');
            $table->index('published_at');
            $table->index('country');
        });

        // ==================== TRAILERS TABLE ====================
        Schema::create('trailers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->string('youtube_id');
            $table->string('thumbnail')->nullable();
            $table->boolean('is_main')->default(false);
            $table->unsignedInteger('sort')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index('movie_id');
            $table->index('is_main');
            $table->index('sort');
            $table->index('published_at');
        });

        // ==================== CATEGORIES TABLE ====================
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

        // ==================== CATEGORY_MOVIE PIVOT TABLE ====================
        Schema::create('category_movie', function (Blueprint $table) {
            $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            // Composite primary key
            $table->primary(['movie_id', 'category_id']);
        });

        // ==================== STREAMINGS TABLE ====================
        Schema::create('streamings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type')->comment('cinema or streaming');
            $table->string('icon')->nullable()->comment('SVG icon or Heroicon name');
            $table->string('url')->nullable()->comment('External link to platform');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('slug');
            $table->index('type');
            $table->index('is_active');
            $table->index('sort_order');
        });

        // ==================== MOVIE_STREAMING PIVOT TABLE ====================
        Schema::create('movie_streaming', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $table->foreignId('streaming_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('available')->comment('available or coming_soon');
            $table->timestamp('available_date')->nullable();
            $table->string('external_url')->nullable()->comment('Link đến phim trên rạp/nền tảng');
            $table->timestamps();

            $table->index('movie_id');
            $table->index('streaming_id');
            $table->index('status');
        });

        // ==================== POSTS TABLE ====================
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

            $table->index('slug');
            $table->index('status');
            $table->index('published_at');
            $table->index('view_count');
        });
    }

    public function down(): void
    {
        // Drop in reverse order due to foreign keys
        Schema::dropIfExists('posts');
        Schema::dropIfExists('movie_streaming');
        Schema::dropIfExists('streamings');
        Schema::dropIfExists('category_movie');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('trailers');
        Schema::dropIfExists('movies');
    }
};
