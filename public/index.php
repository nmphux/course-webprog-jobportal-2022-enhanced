<?php

session_start([
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax',
    'use_strict_mode' => true,
]);

require_once __DIR__ . '/../src/helpers.php';

spl_autoload_register(function (string $class) {
    $map = [
        'Core\\'        => '/src/Core/',
        'Middleware\\'   => '/src/Middleware/',
        'Models\\'       => '/src/Models/',
        'Services\\'     => '/src/Services/',
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

$container = new Core\ServiceContainer();

$container->singleton('db', function () {
    return require BASE_PATH . '/config/database.php';
});

$container->singleton('config', function () {
    return require BASE_PATH . '/config/app.php';
});

$container->singleton(Models\User::class, function ($c) {
    return new Models\User($c->get('db'));
});

$container->singleton(Models\Job::class, function ($c) {
    return new Models\Job($c->get('db'));
});

$container->singleton(Models\Company::class, function ($c) {
    return new Models\Company($c->get('db'));
});

$container->singleton(Models\Application::class, function ($c) {
    return new Models\Application($c->get('db'));
});

$container->singleton(Models\Bookmark::class, function ($c) {
    return new Models\Bookmark($c->get('db'));
});

$container->singleton(Models\Skill::class, function ($c) {
    return new Models\Skill($c->get('db'));
});

$container->singleton(Models\Category::class, function ($c) {
    return new Models\Category($c->get('db'));
});

$container->singleton(Services\AuthService::class, function ($c) {
    return new Services\AuthService($c->get(Models\User::class));
});

$container->singleton(Services\FileUploadService::class, function () {
    return new Services\FileUploadService();
});

$container->singleton(Services\AI\AIServiceInterface::class, function () {
    return new Services\AI\NullAIService();
});

$app = new Core\App($container);
$app->run();
