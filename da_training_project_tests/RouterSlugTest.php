<?php

namespace Tests\DATraining;

use Tests\TestCase;
use Core\Router;

class RouterSlugTest extends TestCase
{
    public function testRouterSupportsSlugParameter(): void
    {
        $router = new Router([
            'GET /jobs/{slug}-{id}' => ['JobController', 'detail'],
        ]);

        $result = $router->match('GET', '/jobs/my-test-job-123');

        $this->assertNotNull($result);
        $this->assertEquals('JobController', $result['controller']);
        $this->assertEquals('detail', $result['action']);
    }

    public function testRouterExtractsSlugAndIdParams(): void
    {
        $router = new Router([
            'GET /jobs/{slug}-{id}' => ['JobController', 'detail'],
        ]);

        $result = $router->match('GET', '/jobs/backend-developer-42');

        $this->assertNotNull($result);
        $this->assertArrayHasKey('slug', $result['params']);
        $this->assertArrayHasKey('id', $result['params']);
        $this->assertEquals('42', $result['params']['id']);
    }

    public function testRouterDoesNotMatchInvalidSlugUrl(): void
    {
        $router = new Router([
            'GET /jobs/{slug}-{id}' => ['JobController', 'detail'],
        ]);

        $result = $router->match('GET', '/jobs/');

        $this->assertNull($result, 'Empty path after /jobs/ should not match');
    }

    public function testRouterHandlesMultipleHyphensInSlug(): void
    {
        $router = new Router([
            'GET /jobs/{slug}-{id}' => ['JobController', 'detail'],
        ]);

        $result = $router->match('GET', '/jobs/senior-full-stack-engineer-7');

        $this->assertNotNull($result);
        $this->assertEquals('7', $result['params']['id']);
    }

    public function testApplyRouteStillUsesNumericId(): void
    {
        $routes = require BASE_PATH . '/config/routes.php';

        $hasApplyRoute = false;
        foreach ($routes as $routeKey => $handler) {
            if (str_contains($routeKey, 'apply')) {
                $hasApplyRoute = true;
                $this->assertStringContainsString(
                    '{id}',
                    $routeKey,
                    'The apply route should still use {id}'
                );
            }
        }

        $this->assertTrue($hasApplyRoute, 'An apply route should exist');
    }
}
