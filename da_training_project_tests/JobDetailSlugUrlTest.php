<?php

namespace Tests\DATraining;

use Tests\TestCase;

class JobDetailSlugUrlTest extends TestCase
{
    public function testRouteDefinitionAcceptsSlugAndId(): void
    {
        $routes = require BASE_PATH . '/config/routes.php';

        $hasSlugRoute = false;
        foreach ($routes as $routeKey => $handler) {
            if (
                str_starts_with($routeKey, 'GET /jobs/')
                && str_contains($routeKey, '{slug}')
                && str_contains($routeKey, '{id}')
                && !str_contains($routeKey, 'apply')
                && !str_contains($routeKey, 'bookmark')
            ) {
                $hasSlugRoute = true;
                break;
            }
        }

        $this->assertTrue(
            $hasSlugRoute,
            'There should be a GET route for job detail that includes both {slug} and {id} parameters, e.g. /jobs/{slug}-{id}'
        );
    }

    public function testRouteDefinitionMapsToJobControllerDetail(): void
    {
        $routes = require BASE_PATH . '/config/routes.php';

        foreach ($routes as $routeKey => $handler) {
            if (
                str_starts_with($routeKey, 'GET /jobs/')
                && str_contains($routeKey, '{slug}')
            ) {
                $this->assertEquals(
                    'JobController',
                    $handler[0],
                    'The slug-based job detail route should map to JobController'
                );
                $this->assertEquals(
                    'detail',
                    $handler[1],
                    'The slug-based job detail route should map to the detail action'
                );
                return;
            }
        }

        $this->fail('No slug-based route found to test controller mapping');
    }

    public function testRouterMatchesSlugIdPattern(): void
    {
        $routes = require BASE_PATH . '/config/routes.php';
        $router = new \Core\Router($routes);

        $result = $router->match('GET', '/jobs/software-engineer-42');

        $this->assertNotNull(
            $result,
            'Router should match a URL like /jobs/software-engineer-42'
        );
        $this->assertEquals('detail', $result['action']);
    }

    public function testRouterExtractsIdFromSlugUrl(): void
    {
        $routes = require BASE_PATH . '/config/routes.php';
        $router = new \Core\Router($routes);

        $result = $router->match('GET', '/jobs/senior-backend-developer-99');

        $this->assertNotNull($result);
        $this->assertArrayHasKey('id', $result['params']);
        $this->assertEquals('99', $result['params']['id']);
    }

    public function testJobCardLinksUseSlugFormat(): void
    {
        $job = [
            'id'              => 7,
            'title'           => 'Full Stack Developer',
            'company_name'    => 'Acme',
            'company_logo'    => '',
            'company_city'    => 'Ha Noi',
            'level'           => 'Middle',
            'employment_type' => 'Full-time',
            'salary'          => '$800',
            'skills'          => 'PHP',
            'created_at'      => '2026-01-01',
            'category_name'   => 'IT',
        ];

        ob_start();
        include BASE_PATH . '/src/Views/partials/job-card.php';
        $html = ob_get_clean();

        $hasSlugUrl = (bool) preg_match('/jobs\/full-stack-developer-7\b/', $html);

        $this->assertTrue(
            $hasSlugUrl,
            'Job card links should use SEO-friendly slug format: /jobs/{title-slug}-{id}'
        );
    }

    public function testSlugFormatIsLowercaseHyphenated(): void
    {
        $job = [
            'id'              => 15,
            'title'           => 'Senior PHP Developer',
            'company_name'    => 'Corp',
            'company_logo'    => '',
            'company_city'    => 'Ho Chi Minh',
            'level'           => 'Senior',
            'employment_type' => 'Full-time',
            'salary'          => '$2000',
            'skills'          => '',
            'created_at'      => '2026-01-01',
            'category_name'   => 'IT',
        ];

        ob_start();
        include BASE_PATH . '/src/Views/partials/job-card.php';
        $html = ob_get_clean();

        $hasProperSlug = (bool) preg_match('/jobs\/senior-php-developer-15\b/', $html);

        $this->assertTrue(
            $hasProperSlug,
            'Slug should be lowercase and hyphen-separated: senior-php-developer-15'
        );
    }

    public function testOldNumericOnlyRouteNoLongerMatchesDetail(): void
    {
        $routes = require BASE_PATH . '/config/routes.php';

        $hasNumericOnlyRoute = false;
        foreach ($routes as $routeKey => $handler) {
            if (preg_match('#^GET /jobs/\{id\}$#', $routeKey)) {
                $hasNumericOnlyRoute = true;
                break;
            }
        }

        $this->assertFalse(
            $hasNumericOnlyRoute,
            'The old numeric-only route GET /jobs/{id} should be replaced by the slug-based route'
        );
    }
}
