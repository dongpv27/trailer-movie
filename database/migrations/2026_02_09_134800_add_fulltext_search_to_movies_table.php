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

        // Populate search_text for existing records
        DB::statement("
            UPDATE movies
            SET search_text =
                setweight(to_tsvector('simple', coalesce(title, '')), 'A') ||
                setweight(to_tsvector('simple', coalesce(original_title, '')), 'A') ||
                setweight(to_tsvector('simple', coalesce(director, '')), 'B') ||
                setweight(to_tsvector('simple', coalesce(\"cast\", '')), 'C') ||
                setweight(to_tsvector('simple', coalesce(country, '')), 'D') ||
                setweight(to_tsvector('simple', coalesce(description, '')), 'D')
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop trigger
        DB::statement("DROP TRIGGER IF EXISTS movies_search_text_update ON movies");

        // Drop trigger function
        DB::statement("DROP FUNCTION IF EXISTS movies_search_text_trigger()");

        // Drop index
        DB::statement("DROP INDEX IF EXISTS movies_search_text_idx");

        // Drop column
        DB::statement("ALTER TABLE movies DROP COLUMN IF EXISTS search_text");
    }
};
