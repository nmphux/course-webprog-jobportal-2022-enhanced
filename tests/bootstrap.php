<?php
/**
 * Test Bootstrap — sets up autoloading and test database
 */

define('BASE_PATH', dirname(__DIR__));
define('TEST_MODE', true);

// Autoloader (mirrors public/index.php)
spl_autoload_register(function (string $class) {
    $map = [
        'Core\\'      => '/src/Core/',
        'Models\\'    => '/src/Models/',
        'Services\\'  => '/src/Services/',
        'Controllers\\' => '/src/Controllers/',
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
require_once BASE_PATH . '/src/helpers.php';
