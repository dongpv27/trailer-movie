-- Check data counts
SELECT 'movies' as table_name, COUNT(*) as count FROM movies
UNION ALL
SELECT 'trailers', COUNT(*) FROM trailers
UNION ALL
SELECT 'categories', COUNT(*) FROM categories
UNION ALL
SELECT 'posts', COUNT(*) FROM posts
UNION ALL
SELECT 'category_movie', COUNT(*) FROM category_movie;
