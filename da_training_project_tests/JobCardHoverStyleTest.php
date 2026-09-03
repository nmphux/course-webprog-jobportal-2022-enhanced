<?php

namespace Tests\DATraining;

use Tests\TestCase;

class JobCardHoverStyleTest extends TestCase
{
    // === ADDED FUNCTION ===
    private function renderJobCard(array $jobOverrides = []): string
    {
        $job = array_merge([
            'id'              => 20,
            'title'           => 'Backend Developer (Go)',
            'company_name'    => 'Acme Corp',
            'company_logo'    => '',
            'company_city'    => 'Ho Chi Minh',
            'level'           => 'Middle',
            'employment_type' => 'Full-time',
            'salary'          => '$1000 - $1500',
            'skills'          => 'Go,PostgreSQL',
            'created_at'      => '2026-01-01 00:00:00',
            'category_name'   => 'IT',
        ], $jobOverrides);

        ob_start();
        include BASE_PATH . '/src/Views/partials/job-card.php';
        return ob_get_clean();
    }
    // === END ADDED FUNCTION ===

    private function getComponentsCss(): string
    {
        return file_get_contents(BASE_PATH . '/public/assets/css/components.css');
    }

    public function testJobCardHoverChangesCardTitleColor(): void
    {
        $css = $this->getComponentsCss();

        // $hasCardHoverTitleRule = (bool) preg_match(
        //     '/\.job-card:hover\s+\.job-title|\.job-card:hover\s[^{]*\.job-title/',
        //     $css
        // );

        // === FIXED ===
        $hasCardHoverTitleRule = (bool) preg_match(
            '/\.job-card:hover[^{]*\.[\w-]*title[\w-]*[^{]*\{[^}]*(?<![a-zA-Z-])color:\s*var\(--primary\)/i',
            $css
        );

        $hasCardHoverTitleInline = (bool) preg_match(
            '/\.job-card:hover\b[^}]*color:\s*var\(--primary\)/',
            $css
        );

        $this->assertTrue(
            $hasCardHoverTitleRule || $hasCardHoverTitleInline,
            'Hovering on .job-card should change the title color to var(--primary) — ' .
            'expected a CSS rule like .job-card:hover .job-title { color: var(--primary) }'
        );
    }

    public function testJobCardTitleColorUsesCustomProperty(): void
    {
        $css = $this->getComponentsCss();

        // $hasPrimaryColorOnHover = (bool) preg_match(
        //     '/\.job-card[^}]*:hover[^}]*var\(--primary\)|\.job-card:hover\s+\.\w+[^}]*var\(--primary\)/',
        //     $css
        // );

        // === FIXED ===
        $hasPrimaryColorOnHover = (bool) preg_match(
            '/\.job-card:hover[^{]*\.[\w-]*title[\w-]*[^{]*\{[^}]*(?<![a-zA-Z-])color:\s*var\(--primary\)/i',
            $css
        );        

        $this->assertTrue(
            $hasPrimaryColorOnHover,
            'The hover color should use var(--primary), not a hardcoded color value'
        );
    }

    // === ADDED FUNCTION ===
    public function testJobCardTitleHasNoInlineColorOverride(): void
    {
        $css = $this->getComponentsCss();

        preg_match(
            '/\.job-card:hover[^{]*\.([\w-]*title[\w-]*)[^{]*\{[^}]*(?<![a-zA-Z-])color:\s*var\(--primary\)/i',
            $css,
            $cssMatch
        );

        $titleClass = $cssMatch[1] ?? null;

        $this->assertNotNull(
            $titleClass,
            'Could not locate the .job-card:hover title-color rule in CSS to verify against — ' .
            'see testJobCardHoverChangesCardTitleColor'
        );

        $html = $this->renderJobCard();

        // Find the actual rendered element carrying that class name.
        $elementPattern = '/<[a-zA-Z0-9]+[^>]*\bclass="[^"]*\b'
            . preg_quote($titleClass, '/')
            . '\b[^"]*"[^>]*>/i';

        preg_match($elementPattern, $html, $elMatch);

        $this->assertNotEmpty(
            $elMatch,
            "Could not find a rendered element with class \"{$titleClass}\" in the job card markup"
        );

        $titleTag = $elMatch[0];

        $hasInlineColor = (bool) preg_match(
            '/style="[^"]*(?<![a-zA-Z-])color\s*:/i',
            $titleTag
        );

        $this->assertFalse(
            $hasInlineColor,
            "The title element (.{$titleClass}) must not set an inline \"color\" style " .
            '(e.g. style="color: inherit") — inline styles always override the ' .
            '.job-card:hover CSS rule regardless of specificity, permanently blocking ' .
            "the hover color change. Found tag: {$titleTag}"
        );
    }
    // === END ADDED FUNTION ===
}
