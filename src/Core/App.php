<?php

namespace Core;

use Middleware\CsrfMiddleware;
use Middleware\AuthMiddleware;
use Middleware\LocaleMiddleware;

class App
{
    private ServiceContainer $container;

    public function __construct(ServiceContainer $container)
    {
        $this->container = $container;
    }

    /**
     * Bootstrap and run the application.
     */
    public function run(): void
    {
        try {
            // Load application config and set timezone
            $config = require BASE_PATH . '/config/app.php';
            date_default_timezone_set($config['timezone']);

            // Store config in the container for access by middleware and controllers
            if (!$this->container->has('config')) {
                $this->container->singleton('config', fn() => $config);
            }

            // Determine request method and path
            $method = $_SERVER['REQUEST_METHOD'];
            $requestUri = $_SERVER['REQUEST_URI'];
            $basePath = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
            $path = parse_url($requestUri, PHP_URL_PATH);
            $path = substr($path, strlen($basePath));
            $path = '/' . trim($path, '/');

            // Run global middleware pipeline
            (new LocaleMiddleware())->handle();
            (new CsrfMiddleware())->handle();

            // Load routes and match
            $routes = require BASE_PATH . '/config/routes.php';
            $router = new Router($routes);
            $matched = $router->match($method, $path);

            if ($matched === null) {
                http_response_code(404);
                view('errors/404', [
                    'message' => 'The page you are looking for could not be found.',
                ]);
                return;
            }

            // Run route-specific middleware
            $this->runRouteMiddleware($matched['middleware']);

            // Resolve and instantiate the controller
            $controllerClass = 'Controllers\\' . $matched['controller'];
            $controller = new $controllerClass($this->container);

            // Call the action with route parameters
            $controller->{$matched['action']}($matched['params']);

        } catch (\Exception $e) {
            error_log('Application error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());

            http_response_code(500);
            view('errors/500', [
                'message' => 'An unexpected error occurred. Please try again later.',
            ]);
        }
    }

    /**
     * Execute route-specific middleware.
     *
     * Supported middleware strings:
     *   'csrf'           -> CsrfMiddleware::handle()
     *   'auth'           -> AuthMiddleware::handle()
     *   'auth:employer'  -> AuthMiddleware::handle('employer')
     *   'auth:candidate' -> AuthMiddleware::handle('candidate')
     *
     * @param array $middlewareList List of middleware identifiers
     */
    private function runRouteMiddleware(array $middlewareList): void
    {
        foreach ($middlewareList as $middleware) {
            if ($middleware === 'csrf') {
                (new CsrfMiddleware())->handle();
                continue;
            }

            if ($middleware === 'auth') {
                (new AuthMiddleware())->handle();
                continue;
            }

            if (str_starts_with($middleware, 'auth:')) {
                $role = substr($middleware, 5); // Extract role after 'auth:'
                (new AuthMiddleware())->handle($role);
                continue;
            }
        }
    }
}
