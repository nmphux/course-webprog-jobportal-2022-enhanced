<?php

namespace Tests\Integration;

use Tests\TestCase;

/**
 * Integration tests for authentication flows.
 */
class AuthTest extends TestCase
{
    public function testLegacyMd5UserCanLoginAndIsUpgradedToBcrypt(): void
    {
        // Session handling (session_regenerate_id/setcookie) inside
        // AuthService::login() cannot run under the PHPUnit CLI runner
        // (no real HTTP headers), so we suppress the resulting PHP
        // notices here; the authentication + hash-upgrade behaviour
        // under test is unaffected.
        $userModel = new \Models\User(self::$db);
        $authService = new \Services\AuthService($userModel);

        $plainPassword = 'legacyPass123';
        $user = $this->createUser([
            'email'    => 'legacy_' . uniqid() . '@example.com',
            'password' => md5($plainPassword),
        ]);

        $result = @$authService->login($user['email'], $plainPassword);
        $this->assertTrue($result['success'], 'Legacy MD5 user should be able to log in');

        $refreshed = $userModel->findByEmail($user['email']);
        $this->assertNotSame(md5($plainPassword), $refreshed['password'], 'Password should no longer be stored as raw MD5');
        $this->assertTrue(
            str_starts_with($refreshed['password'], '$2y$') || str_starts_with($refreshed['password'], '$2a$') || str_starts_with($refreshed['password'], '$2b$'),
            'Password should be upgraded to a bcrypt hash'
        );
        $this->assertTrue(password_verify($plainPassword, $refreshed['password']), 'New bcrypt hash should verify against the original password');

        // Login again — should now go through the bcrypt path directly.
        $secondLogin = @$authService->login($user['email'], $plainPassword);
        $this->assertTrue($secondLogin['success'], 'User should still be able to log in after being upgraded to bcrypt');
    }

    public function testLegacyMd5UserWithWrongPasswordFailsLogin(): void
    {
        $userModel = new \Models\User(self::$db);
        $authService = new \Services\AuthService($userModel);

        $user = $this->createUser([
            'email'    => 'legacy_wrong_' . uniqid() . '@example.com',
            'password' => md5('correctPassword'),
        ]);

        $result = $authService->login($user['email'], 'incorrectPassword');
        $this->assertFalse($result['success'], 'Wrong password should not authenticate a legacy MD5 user');

        $refreshed = $userModel->findByEmail($user['email']);
        $this->assertSame(md5('correctPassword'), $refreshed['password'], 'Password hash should remain untouched after a failed attempt');
    }

    public function testBcryptUserLoginStillWorks(): void
    {
        $userModel = new \Models\User(self::$db);
        $authService = new \Services\AuthService($userModel);

        $plainPassword = 'modernPass123';
        $user = $this->createUser([
            'email'    => 'modern_' . uniqid() . '@example.com',
            'password' => password_hash($plainPassword, PASSWORD_BCRYPT),
        ]);

        $result = @$authService->login($user['email'], $plainPassword);
        $this->assertTrue($result['success'], 'Existing bcrypt users should continue to log in normally');
    }

    public function testUserRegistration(): void
    {
        $user = $this->createUser([
            'name'      => 'John Doe',
            'email'     => 'john@example.com',
            'user_type' => 0,
        ]);

        $this->assertArrayHasKey('id', $user);
        $this->assertEquals('John Doe', $user['name']);
        $this->assertEquals('john@example.com', $user['email']);
        $this->assertEquals(0, $user['user_type']);
    }

    public function testEmployerRegistration(): void
    {
        $user = $this->createUser([
            'name'      => 'Acme Corp',
            'email'     => 'hr@acme.com',
            'user_type' => 1,
        ]);

        $this->assertEquals(1, $user['user_type']);
    }

    public function testPasswordHashing(): void
    {
        $password = 'securePass123!';
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->assertTrue(password_verify($password, $hash));
        $this->assertFalse(password_verify('wrongPassword', $hash));
    }

    public function testDuplicateEmailPreventsRegistration(): void
    {
        $this->createUser(['email' => 'duplicate@example.com']);

        $this->expectException(\PDOException::class);
        $this->expectExceptionMessageMatches('/UNIQUE|unique|duplicate/i');

        $this->createUser(['email' => 'duplicate@example.com']);
    }

    public function testUserCanBeCreatedWithAllFields(): void
    {
        $user = $this->createUser([
            'name'      => 'Full Profile User',
            'email'     => 'full@example.com',
            'user_type' => 0,
            'phone'     => '+84123456789',
            'address'   => '123 Main St, HCMC',
            'about_me'  => 'A passionate developer.',
        ]);

        $this->assertEquals('Full Profile User', $user['name']);
    }
}
