<?php
// Router script for PHP built-in server
$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);

// Serve static files directly
$file = __DIR__ . $path;
if ($path !== '/' && file_exists($file) && is_file($file)) {
    return false;
}

// Route everything else through index.php
require __DIR__ . '/index.php';
