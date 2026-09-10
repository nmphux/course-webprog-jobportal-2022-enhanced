<?php

namespace Tests\Feature;

use Tests\TestCase;
use Core\Router;
use Core\ServiceContainer;
use Controllers\CandidateController;
use Models\Application;
use Models\Job;
use Models\User;

class CandidateApplicationTest extends TestCase
{
    public function testCandidateApplicationRoutesRegistered(): void
    {
        $routes = require BASE_PATH . '/config/routes.php';
        $router = new Router($routes);

        // Check routes match correctly
        $viewMatch = $router->match('GET', '/candidate/applications/5');
        $this->assertNotNull($viewMatch);
        $this->assertEquals('CandidateController', $viewMatch['controller']);
        $this->assertEquals('viewApplication', $viewMatch['action']);
        $this->assertEquals('5', $viewMatch['params']['id']);
        $this->assertContains('auth:candidate', $viewMatch['middleware']);

        $editMatch = $router->match('GET', '/candidate/edit-application/5');
        $this->assertNotNull($editMatch);
        $this->assertEquals('CandidateController', $editMatch['controller']);
        $this->assertEquals('editApplicationForm', $editMatch['action']);
        $this->assertEquals('5', $editMatch['params']['id']);
        $this->assertContains('auth:candidate', $editMatch['middleware']);

        $editPostMatch = $router->match('POST', '/candidate/edit-application/5');
        $this->assertNotNull($editPostMatch);
        $this->assertEquals('CandidateController', $editPostMatch['controller']);
        $this->assertEquals('editApplication', $editPostMatch['action']);
        $this->assertEquals('5', $editPostMatch['params']['id']);
        $this->assertContains('auth:candidate', $editPostMatch['middleware']);

        $deleteMatch = $router->match('GET', '/candidate/delete-application/5');
        $this->assertNotNull($deleteMatch);
        $this->assertEquals('CandidateController', $deleteMatch['controller']);
        $this->assertEquals('deleteApplication', $deleteMatch['action']);
        $this->assertEquals('5', $deleteMatch['params']['id']);
        $this->assertContains('auth:candidate', $deleteMatch['middleware']);

        $appsMatch = $router->match('GET', '/candidate/applications');
        $this->assertNotNull($appsMatch);
        $this->assertEquals('CandidateController', $appsMatch['controller']);
        $this->assertContains('auth:candidate', $appsMatch['middleware']);
    }

    public function testLanguageKeysExistInEnAndVi(): void
    {
        $en = require BASE_PATH . '/config/lang/en.php';
        $vi = require BASE_PATH . '/config/lang/vi.php';

        $requiredKeys = [
            'candidate.application_updated',
            'candidate.application_deleted',
            'candidate.application_detail',
            'candidate.edit_application',
            'candidate.delete_application',
            'candidate.confirm_delete_app',
            'candidate.upload_new_cv',
            'candidate.current_cv',
            'candidate.applicant_name',
            'candidate.update_application',
        ];

        foreach ($requiredKeys as $key) {
            $this->assertArrayHasKey($key, $en, "Missing English translation key: $key");
            $this->assertArrayHasKey($key, $vi, "Missing Vietnamese translation key: $key");
            $this->assertNotEmpty($en[$key], "Empty English translation for: $key");
            $this->assertNotEmpty($vi[$key], "Empty Vietnamese translation for: $key");
        }
    }

    public function testJobDetailXssEscaping(): void
    {
        $job = [
            'id'               => 1,
            'title'            => 'Test Job',
            'description'      => '<script>alert("xss-desc")</script>Description test',
            'requirements'     => '<img src=x onerror=alert("xss-req")>Requirements test',
            'company_name'     => 'Test Corp',
            'company_logo'     => '',
            'company_city'     => 'Hanoi',
            'category_name'    => 'IT',
            'created_at'       => '2025-01-01',
            'salary'           => '$1000',
            'level'            => 'Middle',
            'employment_type'  => 'Full-time',
            'skills'           => '',
            'company_id'       => 1,
        ];

        // Capture view output
        ob_start();
        $isBookmarked = false;
        $hasApplied = false;
        $relatedJobs = [];
        $current_user = null;
        include BASE_PATH . '/src/Views/jobs/detail.php';
        $output = ob_get_clean();

        // Ensure script tags and onerror are escaped
        $this->assertStringNotContainsString('<script>alert("xss-desc")</script>', $output);
        $this->assertStringContainsString('&lt;script&gt;alert(&quot;xss-desc&quot;)&lt;/script&gt;', $output);
        $this->assertStringNotContainsString('<img src=x onerror=alert("xss-req")>', $output);
        $this->assertStringContainsString('&lt;img src=x onerror=alert(&quot;xss-req&quot;)&gt;', $output);
    }
+}