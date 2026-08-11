<?php

namespace Tests\Integration;

use Tests\TestCase;

/**
 * Integration tests for job applications workflow.
 */
class ApplicationTest extends TestCase
{
    public function testCreateApplication(): void
    {
        $candidate = $this->createUser(['user_type' => 0]);
        $employer = $this->createUser(['user_type' => 1]);
        $job = $this->createJob(['employer_id' => $employer['id']]);

        $app = $this->createApplication([
            'job_id'         => $job['id'],
            'user_id'        => $candidate['id'],
            'applicant_name' => $candidate['name'],
        ]);

        $this->assertArrayHasKey('id', $app);
        $this->assertEquals('pending', $app['status']);
    }

    public function testApplicationStatusChange(): void
    {
        $candidate = $this->createUser(['user_type' => 0]);
        $employer = $this->createUser(['user_type' => 1]);
        $job = $this->createJob(['employer_id' => $employer['id']]);

        $app = $this->createApplication([
            'job_id'  => $job['id'],
            'user_id' => $candidate['id'],
        ]);

        // Update status
        $stmt = self::$db->prepare('UPDATE applications SET status = :status WHERE id = :id');
        $stmt->execute([':status' => 'reviewed', ':id' => $app['id']]);

        $stmt = self::$db->prepare('SELECT status FROM applications WHERE id = :id');
        $stmt->execute([':id' => $app['id']]);
        $updated = $stmt->fetch();

        $this->assertEquals('reviewed', $updated['status']);
    }

    public function testApplicationStatuses(): void
    {
        $statuses = ['pending', 'reviewed', 'shortlisted', 'interview', 'accepted', 'rejected'];

        foreach ($statuses as $status) {
            $candidate = $this->createUser(['user_type' => 0]);
            $employer = $this->createUser(['user_type' => 1]);
            $job = $this->createJob(['employer_id' => $employer['id']]);

            $app = $this->createApplication([
                'job_id'  => $job['id'],
                'user_id' => $candidate['id'],
                'status'  => $status,
            ]);

            $this->assertEquals($status, $app['status']);
        }
    }
}
