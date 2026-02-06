<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->text('content')->nullable()->after('description')->comment('Nội dung phim SEO 120-180 chữ');
            $table->text('notable_points')->nullable()->after('content')->comment('Phim có gì đáng chú ý 2-3 câu');
            $table->json('faq')->nullable()->after('notable_points')->comment('Câu hỏi thường gặp JSON');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn(['content', 'notable_points', 'faq']);
        });
    }
};
