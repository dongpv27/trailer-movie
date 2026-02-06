<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trailers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->string('youtube_id');
            $table->string('thumbnail')->nullable();
            $table->boolean('is_main')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index('movie_id');
            $table->index('is_main');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trailers');
    }
};
