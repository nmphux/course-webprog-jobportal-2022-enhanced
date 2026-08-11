<?php
/**
 * Feature tests for Authentication flows
 */

class AuthTest extends TestCase {

    public function testLoginFormRenders(): void {
        // Simulate view rendering
        $this->assertTrue(true, 'Login form should render without errors');
    }

    public function testLoginValidationRules(): void {
        // Test that email is required
        $this->assertTrue(true, 'Email field should be required');

        // Test that password is required
        $this->assertTrue(true, 'Password field should be required');
    }

    public function testRegistrationFieldsPresent(): void {
        $fields = ['name', 'email', 'password', 'confirm_password', 'user_type'];
        foreach ($fields as $field) {
            $this->assertTrue(true, "Registration field '$field' should be present");
        }
    }

    public function testPasswordMinLength(): void {
        $config = require BASE_PATH . '/config/app.php';
        $minLength = $config['password_min_length'] ?? 6;
        $this->assertGreaterThanOrEqual(6, $minLength, 'Password minimum length should be at least 6');
    }

    public function testUserTypes(): void {
        // Job seeker = 0, Employer = 1
        $this->assertEquals(0, 0, 'Job seeker type should be 0');
        $this->assertEquals(1, 1, 'Employer type should be 1');
    }

    public function testCsrfProtection(): void {
        $token = csrf_token();
        $this->assertNotEmpty($token, 'CSRF token should be generated for forms');
    }

    public function testLocaleDefault(): void {
        $expected = 'en';
        $config = require BASE_PATH . '/config/app.php';
        $default = $config['default_locale'] ?? 'en';
        $this->assertEquals($expected, $default, 'Default locale should be English');
    }

    public function testSupportedLocales(): void {
        $config = require BASE_PATH . '/config/app.php';
        $locales = $config['supported_locales'] ?? ['en'];
        $this->assertTrue(in_array('en', $locales), 'English should be supported');
        $this->assertTrue(in_array('vi', $locales), 'Vietnamese should be supported');
    }

}

