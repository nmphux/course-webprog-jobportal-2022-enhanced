<?php

/**
 * Database Configuration (Singleton / Cached PDO Connection)
 */

// Hàm lấy biến môi trường đa tầng tránh lỗi rỗng trong Apache mod_php
function get_db_env(string $key, string $default = ''): string {
    if (!empty($_ENV[$key])) {
        return $_ENV[$key];
    }
    if (!empty($_SERVER[$key])) {
        return $_SERVER[$key];
    }
    $val = getenv($key);
    return ($val !== false && $val !== '') ? $val : $default;
}

// Lưu trữ PDO instance để không tạo mới nhiều lần trong 1 request
static $dbInstance = null;

if ($dbInstance instanceof PDO) {
    return $dbInstance;
}

// Dùng '127.0.0.1' thay vì 'localhost' để tránh bẫy Unix socket
$dbHost = get_db_env('DB_HOST', '127.0.0.1');
$dbPort = get_db_env('DB_PORT', '3306');
$dbName = get_db_env('DB_DATABASE', 'job_portal_db');
$dbUser = get_db_env('DB_USERNAME', 'root');
$dbPass = get_db_env('DB_PASSWORD', '');

$dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4";

try {
    $dbInstance = new PDO(
        $dsn,
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_TIMEOUT            => 5,
        ]
    );
} catch (PDOException $e) {
    error_log(sprintf('[DB Connection Error] DSN: %s | User: %s | Error: %s', $dsn, $dbUser, $e->getMessage()));
    http_response_code(500);
    
    // Hiển thị chi tiết lỗi khi đang ở môi trường dev để dễ debug
    if (get_db_env('APP_ENV', 'development') === 'development') {
        exit('Database connection failed: ' . htmlspecialchars($e->getMessage()) . '<br>DSN: ' . htmlspecialchars($dsn));
    }
    exit('Database connection failed. Please try again later.');
}

return $dbInstance;