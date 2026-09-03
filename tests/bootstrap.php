<?php
/**
 * Test Bootstrap — sets up autoloading and test database
 */

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

if (!defined('TEST_MODE')) {
    define('TEST_MODE', true);
}

// Autoloader (mirrors public/index.php + tests namespace)
spl_autoload_register(function (string $class) {
    $map = [
        'Core\\'        => '/src/Core/',
        'Models\\'      => '/src/Models/',
        'Services\\'    => '/src/Services/',
        'Controllers\\' => '/src/Controllers/',
        'Tests\\'       => '/tests/', // Bổ sung mapping cho namespace Tests
    ];

    foreach ($map as $prefix => $dir) {
        if (strpos($class, $prefix) === 0) {
            $relative = substr($class, strlen($prefix));
            $file = BASE_PATH . $dir . str_replace('\\', '/', $relative) . '.php';
            if (file_exists($file)) {
                require_once $file;
            }
            return;
        }
    }
});

// Load helpers
if (file_exists(BASE_PATH . '/src/helpers.php')) {
    require_once BASE_PATH . '/src/helpers.php';
}