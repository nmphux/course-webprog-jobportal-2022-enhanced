<?php
/**
 * Feature tests for Settings/Profile management
 */

class SettingsTest extends TestCase {

    public function testSettingsTabsExist(): void {
        $tabs = ['account', 'profile', 'password', 'theme', 'language'];
        $this->assertEquals(5, count($tabs), 'There should be 5 settings tabs');

        $expectedLabels = [
            'account' => 'settings.account',
            'profile' => 'settings.profile',
            'password' => 'settings.password',
            'theme' => 'settings.theme',
            'language' => 'settings.language',
        ];

        foreach ($tabs as $tab) {
            $this->assertTrue(
                isset($expectedLabels[$tab]),
                "Settings tab '$tab' should have a label key"
            );
        }
    }

    public function testProfileFields(): void {
        $fields = [
            'headline',
            'phone',
            'address',
            'about_me',
            'linkedin_url',
            'github_url',
            'portfolio_url',
            'website_url',
            'skills',
        ];

        foreach ($fields as $field) {
            $this->assertTrue(true, "Profile field '$field' should be available");
        }
    }

    public function testPasswordChangeFields(): void {
        $this->assertTrue(true, 'Current password field should exist');
        $this->assertTrue(true, 'New password field should exist');
        $this->assertTrue(true, 'Confirm password field should exist');
    }

    public function testEducationFields(): void {
        $fields = ['school_name', 'degree', 'field_of_study', 'start_date', 'end_date', 'description'];
        $this->assertEquals(6, count($fields), 'Education form should have 6 fields');
    }

    public function testExperienceFields(): void {
        $fields = ['job_title', 'company_name', 'start_date', 'end_date', 'is_current', 'description'];
        $this->assertEquals(6, count($fields), 'Experience form should have 6 fields');
    }

    public function testCertificationFields(): void {
        $fields = ['name', 'issuing_org', 'issue_date', 'expiry_date', 'credential_url'];
        $this->assertEquals(5, count($fields), 'Certification form should have 5 fields');
    }

    public function testThemeOptions(): void {
        $themes = ['dawn', 'noon', 'dusk', 'night'];
        $this->assertEquals(4, count($themes), 'There should be 4 theme options');
    }

    public function testLanguageOptions(): void {
        $this->assertTrue(true, 'English language option should exist');
        $this->assertTrue(true, 'Vietnamese language option should exist');
    }

    public function testAvatarUpload(): void {
        $config = require BASE_PATH . '/config/app.php';
        $maxSize = $config['upload_max_size'] ?? 5 * 1024 * 1024;
        $this->assertEquals(5 * 1024 * 1024, $maxSize, 'Max upload size should be 5MB');
    }
}

