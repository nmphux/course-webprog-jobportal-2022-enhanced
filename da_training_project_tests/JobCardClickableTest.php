<?php

namespace Tests\DATraining;

use Tests\TestCase;

class JobCardClickableTest extends TestCase
{
    private function renderJobCard(array $jobOverrides = []): string
    {
        $job = array_merge([
            'id'              => 42,
            'title'           => 'Backend Developer',
            'company_name'    => 'TestCo',
            'company_logo'    => '',
            'company_city'    => 'Ho Chi Minh',
            'level'           => 'Senior',
            'employment_type' => 'Full-time',
            'salary'          => '$1500',
            'skills'          => 'Go,Rust',
            'created_at'      => '2026-01-01 00:00:00',
            'category_name'   => 'IT',
        ], $jobOverrides);

        ob_start();
        include BASE_PATH . '/src/Views/partials/job-card.php';
        return ob_get_clean();
    }

    public function testEntireCardIsWrappedInAnchorOrHasClickHandler(): void
    {
        $html = $this->renderJobCard(['id' => 99]);

        $isWrappedInAnchor = (bool) preg_match('/<a[^>]*class="[^"]*\bjob-card\b/', $html);
        $hasOnclick = (bool) preg_match('/<div[^>]*class="[^"]*\bjob-card\b[^"]*"[^>]*onclick/i', $html);
        $hasDataHref = (bool) preg_match('/<div[^>]*class="[^"]*\bjob-card\b[^"]*"[^>]*data-href/i', $html);
        $hasRoleLink = (bool) preg_match('/<div[^>]*class="[^"]*\bjob-card\b[^"]*"[^>]*role="link"/i', $html);
        $hasJsClickSetup = (bool) preg_match('/window\.location|addEventListener.*click/i', $html);
        $hasCardLink = (bool) preg_match('/<a[^>]*class="[^"]*\bcard-link\b/', $html);
        $hasStretchedLink = (bool) preg_match('/stretched-link/', $html);

        $isClickable = $isWrappedInAnchor || $hasOnclick || $hasDataHref || $hasRoleLink
                        || $hasJsClickSetup || $hasCardLink || $hasStretchedLink;

        $this->assertTrue(
            $isClickable,
            'Clicking anywhere on the .job-card should navigate to the job detail page — ' .
            'the card must use an anchor wrapper, onclick, data-href, stretched-link, or similar mechanism'
        );
    }

    public function testCardLinkPointsToJobDetailPage(): void
    {
        $html = $this->renderJobCard(['id' => 55, 'title' => 'Test Job']);

        $hasLinkToDetail = (bool) preg_match('/jobs\/.*55/', $html);

        $this->assertTrue(
            $hasLinkToDetail,
            'The job card must contain a link/reference to the job detail page containing the job ID'
        );
    }

    public function testCardCursorStyleIsPointer(): void
    {
        $html = $this->renderJobCard();

        $hasCursorPointer = (bool) preg_match('/cursor:\s*pointer/', $html);
        
        // === ADDED BLOCK ===
        $css = file_get_contents(BASE_PATH . '/public/assets/css/components.css');
        $hasCursorPointerInCss = (bool) preg_match(
            '/\.job-card(?:\s*,|\s|:hover)?[^{]*\{[^}]*cursor:\s*pointer/',
            $css
        );
        // === END ADDED BLOCK ===

        $cardIsPureAnchor = (bool) preg_match('/<a[^>]*class="[^"]*\bjob-card\b/', $html);

        // $this->assertTrue(
        //     $hasCursorPointer || $cardIsPureAnchor,
        //     'The job card should show a pointer cursor (either via inline style or by being an anchor element)'
        // );

        // === FIXED ===
        $this->assertTrue(
            $hasCursorPointer || $hasCursorPointerInCss || $cardIsPureAnchor,
            'The job card should show a pointer cursor, via inline style, a .job-card CSS rule ' .
            'in components.css, or by being a native anchor element'
        );
    }
}
