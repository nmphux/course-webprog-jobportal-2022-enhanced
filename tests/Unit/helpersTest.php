<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Tests for helper functions in src/helpers.php
 */
class HelpersTest extends TestCase
{
    public function testEscapeHtml(): void
    {
        $this->assertEquals('&amp;', e('&'));
        $this->assertEquals('<script>', e('<script>'));
        $this->assertEquals('"Hello"', e('"Hello"'));
        $this->assertEquals('', e(null));
    }

    public function testBaseUrl(): void
    {
        // BASE_URL defined in bootstrap
        $this->assertStringStartsWith('/', base_url(''));
        $this->assertStringEndsWith('/jobs', base_url('jobs'));
    }

    public function testAssetUrl(): void
    {
        $url = asset('css/app.css');
        $this->assertStringContainsString('/assets/', $url);
        $this->assertStringEndsWith('css/app.css', $url);
    }

    public function testCsrfFieldReturnsHiddenInput(): void
    {
        $field = csrf_field();
        $this->assertStringContainsString('<input', $field);
        $this->assertStringContainsString('hidden', $field);
        $this->assertStringContainsString('_csrf_token', $field);
    }
}
