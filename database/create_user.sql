-- Create user for TrailerPhim application
CREATE USER trailerphim_user WITH PASSWORD 'trailerphim_secure_password_2024';

-- Create database if not exists (skip if exists)
-- Note: This might fail if database already exists, which is fine

-- Grant all privileges on database
GRANT ALL PRIVILEGES ON DATABASE trailerphim TO trailerphim_user;

-- Connect to database to grant schema privileges
\c trailerphim

-- Grant all on schema public
GRANT ALL ON SCHEMA public TO trailerphim_user;

-- Allow creating objects in schema
ALTER DEFAULT PRIVILEGES IN SCHEMA public
    GRANT ALL ON TABLES TO trailerphim_user;

ALTER DEFAULT PRIVILEGES IN SCHEMA public
    GRANT ALL ON SEQUENCES TO trailerphim_user;
