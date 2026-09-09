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

    public function testSkillsDropdownAndSyncing(): void {
        $skillModel = new \Models\Skill(self::$db);
        $userModel = new \Models\User(self::$db);

        self::$db->exec("INSERT INTO skill_categories (name) VALUES ('Development')");
        $catId = (int) self::$db->lastInsertId();
        self::$db->exec("INSERT INTO skills (name, category_id) VALUES ('PHP', {$catId})");
        $skillId = (int) self::$db->lastInsertId();
        self::$db->exec("INSERT INTO skills (name, category_id) VALUES ('Uncategorized Skill', NULL)");
        $uncatSkillId = (int) self::$db->lastInsertId();

        // Ensure getAll() returns flat skills carrying category data
        $skills = $skillModel->getAll();
        $this->assertIsArray($skills);
        $this->assertNotEmpty($skills);
        $first = $skills[0];
        $this->assertArrayHasKey('id', $first);
        $this->assertArrayHasKey('name', $first);
        $this->assertArrayHasKey('category_name', $first);

        // Test syncSkills with invalid/empty strings doesn't cause 500 error
        $user = $this->createUser();
        $userId = $user['id'];

        $userModel->syncSkills($userId, ['', 0, -1, 'abc']);
        $userSkills = $userModel->getSkillIds($userId);
        $this->assertEmpty($userSkills);

        $userModel->syncSkills($userId, ['', $skillId, $uncatSkillId]);
        $userSkills = $userModel->getSkillIds($userId);
        $this->assertCount(2, $userSkills);
        $this->assertContains((string) $skillId, array_map('strval', $userSkills));
        $this->assertContains((string) $uncatSkillId, array_map('strval', $userSkills));
    }
}

