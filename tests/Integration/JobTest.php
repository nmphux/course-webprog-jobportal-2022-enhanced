<?php

namespace Tests\Integration;

use Tests\TestCase;

/**
 * Integration tests for Job CRUD operations.
 */
class JobTest extends TestCase
{
    public function testCreateJob(): void
    {
        $employer = $this->createUser(['user_type' => 1]);
        $job = $this->createJob([
            'employer_id'    => $employer['id'],
            'title'          => 'Senior PHP Developer',
            'company_name'   => 'Tech Corp',
            'company_city'   => 'Ho Chi Minh',
            'level'          => 'Senior',
            'employment_type'=> 'Full-time',
            'salary'         => 'Over $1000',
        ]);

        $this->assertArrayHasKey('id', $job);
        $this->assertEquals('Senior PHP Developer', $job['title']);
        $this->assertEquals('Tech Corp', $job['company_name']);
    }

    public function testCreateMultipleJobs(): void
    {
        $employer = $this->createUser(['user_type' => 1]);

        $job1 = $this->createJob(['employer_id' => $employer['id'], 'title' => 'Job One']);
        $job2 = $this->createJob(['employer_id' => $employer['id'], 'title' => 'Job Two']);
        $job3 = $this->createJob(['employer_id' => $employer['id'], 'title' => 'Job Three']);

        $this->assertNotEquals($job1['id'], $job2['id']);
        $this->assertNotEquals($job2['id'], $job3['id']);
    }

    public function testJobRequiresEmployer(): void
    {
        $this->expectException(\PDOException::class);
        $this->expectExceptionMessageMatches('/FOREIGN KEY|constraint|NOT NULL/i');

        // This should fail because employer_id=999 doesn't exist
        $this->createJob(['employer_id' => 999]);
    }

    public function testJobWithDraftStatus(): void
    {
        $employer = $this->createUser(['user_type' => 1]);
        $job = $this->createJob([
            'employer_id' => $employer['id'],
            'status'      => 'draft',
        ]);

        $this->assertEquals('draft', $job['status']);
    }

    public function testJobStatusTransition(): void
    {
        $employer = $this->createUser(['user_type' => 1]);
        $job = $this->createJob([
            'employer_id' => $employer['id'],
            'status'      => 'draft',
        ]);

        // Update from draft to published
        $stmt = self::$db->prepare('UPDATE job_posts SET status = :status WHERE id = :id');
        $stmt->execute([':status' => 'published', ':id' => $job['id']]);

        $stmt = self::$db->prepare('SELECT status FROM job_posts WHERE id = :id');
        $stmt->execute([':id' => $job['id']]);
        $updated = $stmt->fetch();

        $this->assertEquals('published', $updated['status']);
    }
}
