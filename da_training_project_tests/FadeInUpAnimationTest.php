<?php

namespace Tests\DATraining;

use Tests\TestCase;

class FadeInUpAnimationTest extends TestCase
{
    private function getAnimationsCss(): string
    {
        return file_get_contents(BASE_PATH . '/public/assets/css/animations.css');
    }

    private function getAppJs(): string
    {
        return file_get_contents(BASE_PATH . '/public/assets/js/app.js');
    }

    private function getDetailViewContent(): string
    {
        return file_get_contents(BASE_PATH . '/src/Views/jobs/detail.php');
    }

    public function testFadeInUpStartsWithZeroOpacity(): void
    {
        $css = $this->getAnimationsCss();

        $this->assertMatchesRegularExpression(
            '/\.fade-in-up\s*\{[^}]*opacity:\s*0/',
            $css,
            'The .fade-in-up class should start with opacity: 0'
        );
    }

    public function testFadeInUpVisibleClassSetsFullOpacity(): void
    {
        $css = $this->getAnimationsCss();

        $this->assertMatchesRegularExpression(
            '/\.fade-in-up\.visible\s*\{[^}]*opacity:\s*1/',
            $css,
            'The .fade-in-up.visible class should set opacity: 1'
        );
    }

    public function testDetailPageHasFadeInUpElements(): void
    {
        $content = $this->getDetailViewContent();

        $this->assertStringContainsString(
            'fade-in-up',
            $content,
            'The job detail page should use fade-in-up animations'
        );
    }

    public function testAnimationObserverMakesElementsVisible(): void
    {
        $js = $this->getAppJs();

        $this->assertStringContainsString(
            'visible',
            $js,
            'The app.js should add the "visible" class to elements'
        );

        $this->assertStringContainsString(
            'fade-in-up',
            $js,
            'The app.js should target .fade-in-up elements'
        );
    }

    public function testFadeInUpElementsBecomeVisibleOnDetailPage(): void
    {
        $css = $this->getAnimationsCss();
        $js = $this->getAppJs();

        $hasDirectVisibility = (bool) preg_match(
            '/\.fade-in-up\s*\{[^}]*opacity:\s*1/',
            $css
        );

        $hasAnimationTrigger = (bool) preg_match(
            '/\.fade-in-up\.visible\s*\{[^}]*opacity:\s*1/',
            $css
        );

        $observerAddsVisible = (bool) preg_match(
            '/classList\.add\(\s*["\']visible["\']\s*\)/',
            $js
        );

        $hasFallbackVisibility = (bool) preg_match(
            '/else\s*\{[^}]*\.fade-in-up[^}]*visible/',
            $js
        );

        $this->assertTrue(
            ($hasAnimationTrigger && $observerAddsVisible) || $hasDirectVisibility || $hasFallbackVisibility,
            'fade-in-up elements must become visible after page load — either through IntersectionObserver adding "visible" class, ' .
            'or through a CSS/JS fallback that ensures opacity transitions to 1'
        );
    }

    public function testFadeInUpElementsDoNotRemainInvisible(): void
    {
        $js = $this->getAppJs();

        $observerExists = str_contains($js, 'IntersectionObserver');
        $addsVisibleClass = (bool) preg_match('/classList\.add\(\s*["\']visible/', $js);

        $this->assertTrue(
            $observerExists && $addsVisibleClass,
            'The IntersectionObserver must exist and add the "visible" class so elements do not stay at opacity: 0'
        );

        $hasRootMarginBug = (bool) preg_match(
            '/rootMargin:\s*["\']0px\s+0px\s+-40px\s+0px["\']/',
            $js
        );

        if ($hasRootMarginBug) {
            $hasFallback = (bool) preg_match(
                '/requestAnimationFrame|setTimeout.*visible|\.forEach.*visible/',
                $js
            );

            $this->assertTrue(
                $hasFallback || !$hasRootMarginBug,
                'If rootMargin creates a negative offset, a fallback mechanism should ensure already-visible elements get the "visible" class'
            );
        }
    }

    // === ADDED FUNCTIONS BLOCK ===
    public function testDetailPageFadeInUpElementsHaveNoInlineOpacityOverride(): void
    {
        $content = $this->getDetailViewContent();

        // Find every tag that carries the fade-in-up class.
        preg_match_all(
            '/<[a-zA-Z0-9]+[^>]*\bclass="[^"]*\bfade-in-up\b[^"]*"[^>]*>/i',
            $content,
            $matches
        );

        $this->assertNotEmpty(
            $matches[0],
            'Expected to find at least one .fade-in-up element on the detail page'
        );

        foreach ($matches[0] as $tag) {
            $hasInlineOpacity = (bool) preg_match(
                '/style="[^"]*opacity\s*:\s*0\b[^"]*"/i',
                $tag
            );

            $this->assertFalse(
                $hasInlineOpacity,
                'A .fade-in-up element must not hardcode "opacity: 0" as an inline style — ' .
                'inline styles override the CSS .visible class and permanently hide the content: ' . $tag
            );
        }
    }

    public function testDetailPageLoadsAnimationScript(): void
    {
        $content = $this->getDetailViewContent();

        $loadsAppJs = (bool) preg_match('/app\.js/', $content);

        $this->assertTrue(
            $loadsAppJs,
            'The detail page must load app.js (directly or via its layout) so the ' .
            'IntersectionObserver that reveals .fade-in-up elements actually runs on this page'
        );
    }
    // === END ADDED BLOCK ===
}
