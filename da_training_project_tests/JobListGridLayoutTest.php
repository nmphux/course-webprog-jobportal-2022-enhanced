<?php

namespace Tests\DATraining;

use Tests\TestCase;

class JobListGridLayoutTest extends TestCase
{
    private function getJobsIndexContent(): string
    {
        return file_get_contents(BASE_PATH . '/src/Views/jobs/index.php');
    }

    private function getComponentsCss(): string
    {
        return file_get_contents(BASE_PATH . '/public/assets/css/components.css');
    }

    public function testJobGridCssClassExistsInStylesheet(): void
    {
        $css = $this->getComponentsCss();

        $this->assertMatchesRegularExpression(
            '/\.job-grid\s*\{/',
            $css,
            'The .job-grid CSS class should be defined in components.css'
        );
    }

    public function testJobGridUsesGridDisplay(): void
    {
        $css = $this->getComponentsCss();

        preg_match('/\.job-grid\s*\{([^}]+)\}/', $css, $matches);
        $gridRules = $matches[1] ?? '';

        $this->assertMatchesRegularExpression(
            '/display:\s*grid/',
            $gridRules,
            'The .job-grid class should use display: grid'
        );
    }

    // === ADDED FUNCTION BLOCK ===
    public function testJobGridIsResponsive(): void
    {
        $css = $this->getComponentsCss();

        // Base rule must define flexible columns (auto-fit/auto-fill + minmax,
        // or repeat with a fixed column function) rather than a fixed column count.
        preg_match('/\.job-grid\s*\{([^}]+)\}/', $css, $matches);
        $gridRules = $matches[1] ?? '';

        $hasFlexibleColumns = (bool) preg_match(
            '/grid-template-columns:\s*repeat\(\s*auto-(fit|fill)\s*,\s*minmax\(/',
            $gridRules
        );

        // Or the layout adapts via a media query targeting .job-grid.
        $hasResponsiveMediaQuery = (bool) preg_match(
            '/@media[^{]*\{[^}]*\.job-grid\s*\{[^}]*grid-template-columns/s',
            $css
        );

        $this->assertTrue(
            $hasFlexibleColumns || $hasResponsiveMediaQuery,
            '.job-grid should adapt column count across screen sizes — either via ' .
            'auto-fit/auto-fill + minmax(), or via a media query overriding grid-template-columns'
        );
    }
    // === END ADDED BLOCK ===

    public function testJobListContainerUsesJobGridClass(): void
    {
        $content = $this->getJobsIndexContent();

        $this->assertStringContainsString(
            'job-grid',
            $content,
            'The job listing container in jobs/index.php should use the "job-grid" class for responsive grid layout'
        );
    }

    public function testJobListDoesNotUseBootstrapRowColForJobCards(): void
    {
        $content = $this->getJobsIndexContent();

        // preg_match_all('/foreach.*\$jobs_data.*?endforeach/s', $content, $matches);
        preg_match_all('/foreach[^(]*\(\s*\$jobs_data.*?endforeach/s', $content, $matches);
        $loopBlock = $matches[0][0] ?? '';

        $usesColClass = (bool) preg_match('/class="col-/', $loopBlock);

        $this->assertFalse(
            $usesColClass,
            'When using the job-grid CSS class, the job card loop should not wrap each card in a Bootstrap col-* div'
        );
    }
}
