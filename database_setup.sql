-- PostgreSQL Database Setup Script
-- Run this in psql or pgAdmin

-- Create database
CREATE DATABASE membership_db;

-- Create user (if needed)
-- CREATE USER membership_user WITH PASSWORD 'your_secure_password';

-- Grant privileges
-- GRANT ALL PRIVILEGES ON DATABASE membership_db TO membership_user;

-- Connect to the database
\c membership_db

-- Note: The migrations will create all tables automatically

