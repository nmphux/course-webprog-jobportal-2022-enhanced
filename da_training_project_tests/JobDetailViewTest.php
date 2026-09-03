<?php

namespace Tests\DATraining;

use Tests\TestCase;

class JobDetailViewTest extends TestCase
{
    private function getDetailViewContent(): string
    {
        return file_get_contents(BASE_PATH . '/src/Views/jobs/detail.php');
    }

    public function testDetailPageRendersJobTitle(): void
    {
        $content = $this->getDetailViewContent();

        $this->assertMatchesRegularExpression(
            '/\$job\[.title.\]/',
            $content,
            'Detail page should display the job title'
        );
    }

    public function testDetailPageRendersCompanyName(): void
    {
        $content = $this->getDetailViewContent();

        $this->assertMatchesRegularExpression(
            '/\$job\[.company_name.\]/',
            $content,
            'Detail page should display the company name'
        );
    }

    public function testDetailPageRendersDescription(): void
    {
        $content = $this->getDetailViewContent();

        $this->assertMatchesRegularExpression(
            '/\$job\[.description.\]/',
            $content,
            'Detail page should display the job description'
        );
    }

    public function testDetailPageRendersSkills(): void
    {
        $content = $this->getDetailViewContent();

        $this->assertStringContainsString(
            'skills_list',
            $content,
            'Detail page should display the skills list'
        );
    }

    public function testDetailPageRendersRelatedJobs(): void
    {
        $content = $this->getDetailViewContent();

        $this->assertStringContainsString(
            'related_jobs',
            $content,
            'Detail page should display related jobs'
        );
    }

    public function testDetailPageIncludesJobCardPartialForRelatedJobs(): void
    {
        $content = $this->getDetailViewContent();

        $this->assertStringContainsString(
            'job-card.php',
            $content,
            'Detail page should include the job-card.php partial for related jobs'
        );
    }

    public function testDetailPageRelatedJobsUseSlugUrls(): void
    {
        $content = $this->getDetailViewContent();

        $jobCardContent = file_get_contents(BASE_PATH . '/src/Views/partials/job-card.php');

        $usesNumericOnlyUrl = (bool) preg_match(
            '/base_url\(\s*[\'"]jobs\/[\'"].*\(int\)\s*\$job\[.id.\]\s*\)/',
            $jobCardContent
        );

        $this->assertFalse(
            $usesNumericOnlyUrl,
            'Job card links should use slug-based URLs, not plain numeric IDs'
        );
    }
}
