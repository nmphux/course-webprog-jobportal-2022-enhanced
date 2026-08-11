<?php

/**
 * Database Configuration
 * 
 * Supports both Docker environment variables and local XAMPP defaults.
 * 
 * Docker: Uses DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD env vars
 * Local:  Falls back to localhost / root / empty password (XAMPP default)
 */

$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbName = getenv('DB_DATABASE') ?: 'job_portal_db';
$dbUser = getenv('DB_USERNAME') ?: 'root';
$dbPass = getenv('DB_PASSWORD') ?: '';

try {
    $db = new PDO(
        "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    error_log('Database connection failed: ' . $e->getMessage());
    exit('Database connection failed. Please try again later.');
}

return $db;
