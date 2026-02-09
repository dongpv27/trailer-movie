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
        Schema::table('movie_streaming', function (Blueprint $table) {
            $table->string('external_url')->nullable()->after('available_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movie_streaming', function (Blueprint $table) {
            $table->dropColumn('external_url');
        });
    }
};
