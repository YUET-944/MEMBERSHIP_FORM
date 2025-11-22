<?php

/**
 * Interactive PostgreSQL Database Setup
 * Run: php setup_database.php
 */

echo "=== PostgreSQL Database Setup ===\n\n";

// Read .env file manually
$envFile = __DIR__ . '/.env';
$envVars = [];

if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $envVars[trim($key)] = trim($value);
        }
    }
}

$host = $envVars['DB_HOST'] ?? '127.0.0.1';
$port = $envVars['DB_PORT'] ?? '5432';
$username = $envVars['DB_USERNAME'] ?? 'postgres';
$password = $envVars['DB_PASSWORD'] ?? '';
$database = $envVars['DB_DATABASE'] ?? 'membership_db';

echo "Current configuration:\n";
echo "Host: $host\n";
echo "Port: $port\n";
echo "User: $username\n";
echo "Database: $database\n";
echo "Password: " . (empty($password) ? '(not set)' : str_repeat('*', strlen($password))) . "\n\n";

// Prompt for password if not set or wrong
if (empty($password)) {
    echo "Password not found in .env file.\n";
    echo "Enter PostgreSQL password for user '$username': ";
    $password = trim(fgets(STDIN));
    echo "\n";
}

// Try to connect
echo "Attempting to connect to PostgreSQL...\n";

try {
    $pdo = new PDO(
        "pgsql:host=$host;port=$port",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "✅ Connected successfully!\n\n";
    
    // Check if database exists
    $stmt = $pdo->query("SELECT 1 FROM pg_database WHERE datname = '$database'");
    $exists = $stmt->fetch();
    
    if ($exists) {
        echo "⚠️  Database '$database' already exists.\n";
        echo "Do you want to drop and recreate it? (y/n): ";
        $response = trim(fgets(STDIN));
        
        if (strtolower($response) === 'y') {
            // Terminate connections
            $pdo->exec("SELECT pg_terminate_backend(pid) FROM pg_stat_activity WHERE datname = '$database' AND pid <> pg_backend_pid()");
            $pdo->exec("DROP DATABASE IF EXISTS $database");
            echo "✅ Dropped existing database\n";
        } else {
            echo "Using existing database.\n";
            echo "\n✅ Database ready! Run: php artisan migrate\n";
            exit(0);
        }
    }
    
    // Create database
    $pdo->exec("CREATE DATABASE $database");
    echo "✅ Database '$database' created successfully!\n\n";
    
    // Update .env if password was entered manually
    if (!empty($password) && $password !== ($envVars['DB_PASSWORD'] ?? '')) {
        echo "Updating .env file with password...\n";
        $content = file_get_contents($envFile);
        $content = preg_replace('/^DB_PASSWORD=.*/m', "DB_PASSWORD=$password", $content);
        file_put_contents($envFile, $content);
        echo "✅ .env file updated\n\n";
    }
    
    echo "=== Setup Complete ===\n";
    echo "Next steps:\n";
    echo "1. Run: php artisan migrate\n";
    echo "2. Test: php artisan migrate:status\n";
    echo "3. Start server: php artisan serve\n";
    
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "\n\n";
    echo "Troubleshooting:\n";
    echo "1. Verify PostgreSQL is running\n";
    echo "2. Check if password is correct\n";
    echo "3. Try connecting with pgAdmin to verify credentials\n";
    echo "4. Check PostgreSQL service: Get-Service postgresql*\n\n";
    
    echo "To reset PostgreSQL password:\n";
    echo "1. Open pgAdmin\n";
    echo "2. Right-click on 'postgres' server → Properties\n";
    echo "3. Change password in Connection tab\n";
    echo "4. Update DB_PASSWORD in .env file\n";
    
    exit(1);
}

