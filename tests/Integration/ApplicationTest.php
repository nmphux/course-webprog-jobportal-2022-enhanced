<?php

namespace Tests\Integration;

use Tests\TestCase;
use Models\Application;

/**
 * Integration tests for job applications workflow.
 */
class ApplicationTest extends TestCase
{
    public function testCreateApplication(): void
    {
        $candidate = $this->createUser(['user_type' => 0]);
        $employer = $this->createUser(['user_type' => 1]);
        $job = $this->createJob(['user_id' => $employer['id']]);

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
        $job = $this->createJob(['user_id' => $employer['id']]);

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
            $job = $this->createJob(['user_id' => $employer['id']]);

            $app = $this->createApplication([
                'job_id'  => $job['id'],
                'user_id' => $candidate['id'],
                'status'  => $status,
            ]);

            $this->assertEquals($status, $app['status']);
        }
    }

    public function testApplicationOwnership(): void
    {
        $candidate1 = $this->createUser(['user_type' => 0]);
        $candidate2 = $this->createUser(['user_type' => 0]);
        $employer = $this->createUser(['user_type' => 1]);
        $job = $this->createJob(['user_id' => $employer['id']]);

        $app = $this->createApplication([
            'job_id'  => $job['id'],
            'user_id' => $candidate1['id'],
        ]);

        $appModel = new Application(self::$db);

        $this->assertTrue($appModel->isOwnedBy($app['id'], $candidate1['id']));
        $this->assertTrue($appModel->isOwnedByCandidate($app['id'], $candidate1['id']));
        $this->assertFalse($appModel->isOwnedBy($app['id'], $candidate2['id']));
        $this->assertFalse($appModel->isOwnedByCandidate($app['id'], $candidate2['id']));
    }

    public function testFindByIdIncludesApplicantId(): void
    {
        $candidate = $this->createUser(['user_type' => 0]);
        $employer = $this->createUser(['user_type' => 1]);
        $job = $this->createJob(['user_id' => $employer['id']]);

        $app = $this->createApplication([
            'job_id'         => $job['id'],
            'user_id'        => $candidate['id'],
            'applicant_name' => 'Jane Candidate',
        ]);

        $appModel = new Application(self::$db);
        $found = $appModel->findById($app['id']);

        $this->assertNotNull($found);
        $this->assertEquals($candidate['id'], $found['user_id']);
        $this->assertEquals($candidate['id'], $found['applicant_id']);
        $this->assertEquals('Jane Candidate', $found['applicant_name']);
    }

    public function testCandidateCanUpdateApplication(): void
    {
        $candidate = $this->createUser(['user_type' => 0]);
        $employer = $this->createUser(['user_type' => 1]);
        $job = $this->createJob(['user_id' => $employer['id']]);

        $app = $this->createApplication([
            'job_id'         => $job['id'],
            'user_id'        => $candidate['id'],
            'applicant_name' => 'Old Name',
        ]);

        $appModel = new Application(self::$db);
        $updatedRows = $appModel->updateApplication($app['id'], [
            'applicant_name' => 'Updated Name',
            'file_path'      => 'cv/updated.pdf',
        ]);

        $this->assertEquals(1, $updatedRows);

        $found = $appModel->findById($app['id']);
        $this->assertEquals('Updated Name', $found['applicant_name']);
        $this->assertEquals('cv/updated.pdf', $found['file_path']);
    }

    public function testCandidateCanDeleteApplication(): void
    {
        $candidate = $this->createUser(['user_type' => 0]);
        $employer = $this->createUser(['user_type' => 1]);
        $job = $this->createJob(['user_id' => $employer['id']]);

        $app = $this->createApplication([
            'job_id'  => $job['id'],
            'user_id' => $candidate['id'],
        ]);

        $appModel = new Application(self::$db);

        // Another candidate cannot delete
        $deleted = $appModel->deleteApplication($app['id'], $candidate['id'] + 999);
        $this->assertEquals(0, $deleted);
        $this->assertNotNull($appModel->findById($app['id']));

        // Owner can delete
        $deleted = $appModel->deleteApplication($app['id'], $candidate['id']);
        $this->assertEquals(1, $deleted);
        $this->assertNull($appModel->findById($app['id']));
    }
}
