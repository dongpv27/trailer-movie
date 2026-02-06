<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('original_title')->nullable();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('poster')->nullable();
            $table->string('backdrop')->nullable();
            $table->date('release_date')->nullable();
            $table->enum('status', ['hot', 'upcoming', 'released'])->default('released');
            $table->string('country')->nullable();
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
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
