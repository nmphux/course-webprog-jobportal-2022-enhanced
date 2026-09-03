<?php

namespace Tests\DATraining;

use Tests\TestCase;

class JobCardHtmlTest extends TestCase
{
    private function renderJobCard(array $jobOverrides = []): string
    {
        $job = array_merge([
            'id'              => 1,
            'title'           => 'Software Engineer',
            'company_name'    => 'Acme Corp',
            'company_logo'    => '',
            'company_city'    => 'Ho Chi Minh',
            'level'           => 'Junior',
            'employment_type' => 'Full-time',
            'salary'          => '$500 - $700',
            'skills'          => 'PHP,JavaScript,MySQL',
            'created_at'      => '2026-01-01 00:00:00',
            'category_name'   => 'IT',
        ], $jobOverrides);

        ob_start();
        include BASE_PATH . '/src/Views/partials/job-card.php';
        return ob_get_clean();
    }

    public function testJobCardHasClosedDivTags(): void
    {
        $html = $this->renderJobCard();

        $openDivs = preg_match_all('/<div[\s>]/i', $html);
        $closeDivs = preg_match_all('/<\/div>/i', $html);

        $this->assertEquals(
            $openDivs,
            $closeDivs,
            'All <div> tags in job-card.php must be properly closed to prevent DOM nesting corruption'
        );
    }

    public function testJobCardDoesNotNestInsidePreviousCard(): void
    {
        $html1 = $this->renderJobCard(['id' => 1, 'title' => 'Job A']);
        $html2 = $this->renderJobCard(['id' => 2, 'title' => 'Job B']);
        $combined = $html1 . $html2;

        $openDivs = preg_match_all('/<div[\s>]/i', $combined);
        $closeDivs = preg_match_all('/<\/div>/i', $combined);

        $this->assertEquals(
            $openDivs,
            $closeDivs,
            'Rendering multiple job cards sequentially must not cause nesting — all divs must be balanced'
        );
    }

    public function testJobCardRootElementHasJobCardClass(): void
    {
        $html = $this->renderJobCard();

        // $this->assertMatchesRegularExpression(
        //     '/<div[^>]*class="[^"]*\bjob-card\b[^"]*"/',
        //     $html,
        //     'The root element of the job card should have the "job-card" class'
        // );

        // === FIXED ===
        $this->assertMatchesRegularExpression(
            '/<(?:div|a)[^>]*class="[^"]*\bjob-card\b[^"]*"/',
            $html,
            'The root element of the job card (a <div> or an <a>) should have the "job-card" class'
        );
    }

    public function testJobCardRendersTitle(): void
    {
        $html = $this->renderJobCard(['title' => 'DevOps Engineer']);

        $this->assertStringContainsString(
            'DevOps Engineer',
            $html,
            'Job card should display the job title'
        );
    }

    public function testJobCardRendersCompanyName(): void
    {
        $html = $this->renderJobCard(['company_name' => 'TechCorp']);

        $this->assertStringContainsString(
            'TechCorp',
            $html,
            'Job card should display the company name'
        );
    }

    public function testJobCardRendersLocation(): void
    {
        $html = $this->renderJobCard(['company_city' => 'Da Nang']);

        $this->assertStringContainsString('Da Nang', $html);
    }

    public function testJobCardRendersSalary(): void
    {
        $html = $this->renderJobCard(['salary' => '$1000 - $2000']);

        $this->assertStringContainsString('$1000 - $2000', $html);
    }

    public function testJobCardRendersSkillBadges(): void
    {
        $html = $this->renderJobCard(['skills' => 'PHP,Laravel,Vue.js']);

        $this->assertStringContainsString('PHP', $html);
        $this->assertStringContainsString('Laravel', $html);
        $this->assertStringContainsString('Vue.js', $html);
    }

    public function testJobCardLimitsDisplayedSkillsToFour(): void
    {
        $html = $this->renderJobCard([
            'skills' => 'PHP,Laravel,Vue.js,MySQL,Redis,Docker',
        ]);

        $this->assertStringContainsString('PHP', $html);
        $this->assertStringContainsString('Laravel', $html);
        $this->assertStringContainsString('Vue.js', $html);
        $this->assertStringContainsString('MySQL', $html);
        $this->assertStringNotContainsString('Redis', $html);
        $this->assertStringNotContainsString('Docker', $html);
        $this->assertMatchesRegularExpression('/\+2/', $html, 'Should show "+2" for extra skills');
    }

    public function testJobCardEscapesHtmlInTitle(): void
    {
        $html = $this->renderJobCard(['title' => '<script>alert("xss")</script>']);

        $this->assertStringNotContainsString('<script>', $html, 'Title should be HTML-escaped');
        $this->assertStringContainsString('&lt;script&gt;', $html);
    }
}
