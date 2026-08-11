<?php

namespace Tests\Integration;

use Tests\TestCase;

/**
 * Integration tests for authentication flows.
 */
class AuthTest extends TestCase
{
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
