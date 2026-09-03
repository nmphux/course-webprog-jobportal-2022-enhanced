<?php

namespace Core;

class Router
{
    /** @var array<string, array> Compiled routes: pattern => [regex, paramNames, controller, action, middleware] */
    private array $compiled = [];

    /**
     * @param array $routes Format: 'METHOD /path' => ['Controller', 'action'] or ['Controller', 'action', ['middleware1']]
     */
    public function __construct(array $routes)
    {
        foreach ($routes as $routeKey => $handler) {
            [$method, $pattern] = explode(' ', $routeKey, 2);

            $controller = $handler[0];
            $action = $handler[1];
            $middleware = $handler[2] ?? [];

            // Extract parameter names from the pattern
            preg_match_all('#\{(\w+)\}#', $pattern, $paramMatches);
            $paramNames = $paramMatches[1];

            // Build regex: {id} -> (\d+), {slug} -> ([a-z0-9-]+)
            $regex = preg_replace_callback('#\{(\w+)\}#', function ($m) {
                $name = $m[1];
                if ($name === 'slug') {
                    return '([a-z0-9-]+)';
                }
                // Default: {id} and any other numeric parameter
                return '(\d+)';
            }, $pattern);

            $regex = '#^' . $regex . '$#';

            $this->compiled[] = [
                'method'     => $method,
                'regex'      => $regex,
                'paramNames' => $paramNames,
                'controller' => $controller,
                'action'     => $action,
                'middleware'  => $middleware,
            ];
        }
    }

    /**
     * Match a request method and path against registered routes.
     *
     * @return array{controller: string, action: string, params: array, middleware: array}|null
     */
    public function match(string $method, string $path): ?array
    {
        $method = strtoupper($method);

        foreach ($this->compiled as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (preg_match($route['regex'], $path, $matches)) {
                array_shift($matches); // Remove full match

                $params = [];
                foreach ($route['paramNames'] as $i => $name) {
                    $params[$name] = $matches[$i] ?? null;
                }

                return [
                    'controller' => $route['controller'],
                    'action'     => $route['action'],
                    'params'     => $params,
                    'middleware'  => $route['middleware'],
                ];
            }
        }

        return null;
    }
}
