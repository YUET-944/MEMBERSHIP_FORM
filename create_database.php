<?php

/**
 * Create PostgreSQL Database Script
 * Run: php create_database.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

// Get database config
$host = env('DB_HOST', '127.0.0.1');
$port = env('DB_PORT', '5432');
$username = env('DB_USERNAME', 'postgres');
$password = env('DB_PASSWORD', '');
$database = env('DB_DATABASE', 'membership_db');

echo "Creating PostgreSQL database...\n";
echo "Host: $host\n";
echo "Port: $port\n";
echo "User: $username\n";
echo "Database: $database\n\n";

try {
    // Connect to PostgreSQL server (not specific database)
    $pdo = new PDO(
        "pgsql:host=$host;port=$port",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "✅ Connected to PostgreSQL server\n";
    
    // Check if database exists
    $stmt = $pdo->query("SELECT 1 FROM pg_database WHERE datname = '$database'");
    $exists = $stmt->fetch();
    
    if ($exists) {
        echo "⚠️  Database '$database' already exists\n";
        echo "Do you want to drop and recreate it? (y/n): ";
        $handle = fopen("php://stdin", "r");
        $line = trim(fgets($handle));
        fclose($handle);
        
        if (strtolower($line) === 'y') {
            // Terminate existing connections
            $pdo->exec("SELECT pg_terminate_backend(pid) FROM pg_stat_activity WHERE datname = '$database' AND pid <> pg_backend_pid()");
            $pdo->exec("DROP DATABASE IF EXISTS $database");
            echo "✅ Dropped existing database\n";
        } else {
            echo "Using existing database\n";
            exit(0);
        }
    }
    
    // Create database
    $pdo->exec("CREATE DATABASE $database");
    echo "✅ Database '$database' created successfully!\n\n";
    
    echo "Next steps:\n";
    echo "1. Run: php artisan migrate\n";
    echo "2. Test: php artisan migrate:status\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
    echo "Possible issues:\n";
    echo "1. Wrong password in .env file\n";
    echo "2. PostgreSQL service not running\n";
    echo "3. User 'postgres' doesn't exist\n\n";
    echo "Solutions:\n";
    echo "- Check your PostgreSQL password\n";
    echo "- Update DB_PASSWORD in .env file\n";
    echo "- Or reset PostgreSQL password using pgAdmin\n";
    exit(1);
}

