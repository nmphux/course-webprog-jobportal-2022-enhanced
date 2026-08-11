<?php

namespace Tests;

use PDO;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * Base Test Case for JobHub tests.
 * Sets up an SQLite in-memory database and the schema.
 */
abstract class TestCase extends PHPUnitTestCase
{
    protected static ?PDO $db = null;

    /**
     * Set up the in-memory database before the first test.
     */
    public static function setUpBeforeClass(): void
    {
        if (self::$db === null) {
            self::$db = new PDO('sqlite::memory:', null, null, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            // Create schema
            self::createSchema();
        }
    }

    /**
     * Create tables matching the production schema (simplified).
     */
    protected static function createSchema(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                user_type INTEGER NOT NULL DEFAULT 0,
                phone VARCHAR(20) DEFAULT NULL,
                address VARCHAR(255) DEFAULT NULL,
                about_me TEXT DEFAULT NULL,
                avatar VARCHAR(255) DEFAULT NULL,
                language VARCHAR(10) NOT NULL DEFAULT 'en',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS job_posts (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                employer_id INTEGER NOT NULL,
                company_id INTEGER DEFAULT NULL,
                company_name VARCHAR(100) DEFAULT NULL,
                company_logo VARCHAR(255) DEFAULT NULL,
                company_city VARCHAR(100) DEFAULT NULL,
                title VARCHAR(200) NOT NULL,
                category_id INTEGER DEFAULT NULL,
                category_name VARCHAR(100) DEFAULT NULL,
                description TEXT DEFAULT NULL,
                requirements TEXT DEFAULT NULL,
                level VARCHAR(50) DEFAULT NULL,
                employment_type VARCHAR(50) DEFAULT NULL,
                salary VARCHAR(100) DEFAULT NULL,
                experience_years INTEGER DEFAULT 0,
                interview_rounds INTEGER DEFAULT 1,
                skills TEXT DEFAULT NULL,
                status VARCHAR(20) NOT NULL DEFAULT 'published',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (employer_id) REFERENCES users(id)
            );

            CREATE TABLE IF NOT EXISTS applications (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                job_id INTEGER NOT NULL,
                user_id INTEGER NOT NULL,
                applicant_name VARCHAR(100) DEFAULT NULL,
                file_path VARCHAR(255) DEFAULT NULL,
                status VARCHAR(20) NOT NULL DEFAULT 'pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (job_id) REFERENCES job_posts(id),
                FOREIGN KEY (user_id) REFERENCES users(id)
            );

            CREATE TABLE IF NOT EXISTS bookmarks (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                job_id INTEGER NOT NULL,
                user_id INTEGER NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (job_id) REFERENCES job_posts(id),
                FOREIGN KEY (user_id) REFERENCES users(id)
            );

            CREATE TABLE IF NOT EXISTS companies (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name VARCHAR(100) NOT NULL,
                logo VARCHAR(255) DEFAULT NULL,
                city VARCHAR(100) DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS categories (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name VARCHAR(100) NOT NULL
            );

            CREATE TABLE IF NOT EXISTS skills (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name VARCHAR(100) NOT NULL,
                category_id INTEGER DEFAULT NULL
            );

            CREATE TABLE IF NOT EXISTS user_skills (
                user_id INTEGER NOT NULL,
                skill_id INTEGER NOT NULL,
                PRIMARY KEY (user_id, skill_id)
            );
        ";

        foreach (explode(';', $sql) as $statement) {
            $statement = trim($statement);
            if (!empty($statement)) {
                self::$db->exec($statement);
            }
        }
    }

    /**
     * Create a test user and return the user's data.
     */
    protected function createUser(array $overrides = []): array
    {
        $defaults = [
            'name'      => 'Test User',
            'email'     => 'test_' . uniqid() . '@example.com',
            'password'  => password_hash('password123', PASSWORD_DEFAULT),
            'user_type' => 0,
        ];

        $data = array_merge($defaults, $overrides);

        $stmt = self::$db->prepare(
            'INSERT INTO users (name, email, password, user_type) VALUES (:name, :email, :password, :user_type)'
        );
        $stmt->execute([
            ':name'      => $data['name'],
            ':email'     => $data['email'],
            ':password'  => $data['password'],
            ':user_type' => $data['user_type'],
        ]);

        $data['id'] = (int) self::$db->lastInsertId();
        return $data;
    }

    /**
     * Create a test job post and return its data.
     */
    protected function createJob(array $overrides = []): array
    {
        $defaults = [
            'employer_id'    => 1,
            'title'          => 'Test Job Position',
            'description'    => 'This is a test job description.',
            'company_name'   => 'Test Company',
            'company_city'   => 'Ho Chi Minh',
            'level'          => 'Junior',
            'employment_type'=> 'Full-time',
            'salary'         => '$500 - $700',
            'status'         => 'published',
        ];

        $data = array_merge($defaults, $overrides);

        $stmt = self::$db->prepare(
            'INSERT INTO job_posts (employer_id, title, description, company_name, company_city, level, employment_type, salary, status)
             VALUES (:employer_id, :title, :description, :company_name, :company_city, :level, :employment_type, :salary, :status)'
        );
        $stmt->execute([
            ':employer_id'     => $data['employer_id'],
            ':title'           => $data['title'],
            ':description'     => $data['description'],
            ':company_name'    => $data['company_name'],
            ':company_city'    => $data['company_city'],
            ':level'           => $data['level'],
            ':employment_type' => $data['employment_type'],
            ':salary'          => $data['salary'],
            ':status'          => $data['status'],
        ]);

        $data['id'] = (int) self::$db->lastInsertId();
        $data['created_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    /**
     * Create a test application.
     */
    protected function createApplication(array $overrides = []): array
    {
        $defaults = [
            'job_id'         => 1,
            'user_id'        => 1,
            'applicant_name' => 'Test Applicant',
            'status'         => 'pending',
        ];

        $data = array_merge($defaults, $overrides);

        $stmt = self::$db->prepare(
            'INSERT INTO applications (job_id, user_id, applicant_name, status)
             VALUES (:job_id, :user_id, :applicant_name, :status)'
        );
        $stmt->execute([
            ':job_id'         => $data['job_id'],
            ':user_id'        => $data['user_id'],
            ':applicant_name' => $data['applicant_name'],
            ':status'         => $data['status'],
        ]);

        $data['id'] = (int) self::$db->lastInsertId();
        return $data;
    }

    /**
     * Tear down tables after each test.
     */
    protected function tearDown(): void
    {
        if (self::$db) {
            self::$db->exec('DELETE FROM bookmarks');
            self::$db->exec('DELETE FROM applications');
            self::$db->exec('DELETE FROM job_posts');
            self::$db->exec('DELETE FROM users');
        }
    }
}
