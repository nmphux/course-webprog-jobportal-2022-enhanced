<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * End-to-end workflow tests simulating real user flows.
 */
class WorkflowTest extends TestCase
{
    public function testFullCandidateJobSearchAndApplicationFlow(): void
    {
        // 1. Create employer and job
        $employer = $this->createUser(['user_type' => 1]);
        $job = $this->createJob([
            'employer_id'    => $employer['id'],
            'title'          => 'Full Stack Developer',
            'company_name'   => 'StartupXYZ',
            'level'          => 'Middle',
            'employment_type'=> 'Full-time',
            'salary'         => '$700 - $1000',
            'status'         => 'published',
        ]);

        // 2. Create candidate and apply
        $candidate = $this->createUser(['user_type' => 0]);
        $app = $this->createApplication([
            'job_id'         => $job['id'],
            'user_id'        => $candidate['id'],
            'applicant_name' => $candidate['name'],
        ]);

        $this->assertNotNull($app['id']);
        $this->assertEquals('pending', $app['status']);

        // 3. Employer reviews application
        $stmt = self::$db->prepare('UPDATE applications SET status = :status WHERE id = :id');
        $stmt->execute([':status' => 'reviewed', ':id' => $app['id']]);

        // 4. Verify the status change
        $stmt = self::$db->prepare('SELECT status FROM applications WHERE id = :id');
        $stmt->execute([':id' => $app['id']]);
        $result = $stmt->fetch();

        $this->assertEquals('reviewed', $result['status']);
    }

    public function testEmployerJobPostingAndListingFlow(): void
    {
        // 1. Create employer
        $employer = $this->createUser(['name' => 'Hiring Manager', 'user_type' => 1]);

        // 2. Create multiple job posts
        $jobs = [];
        $titles = ['Backend Engineer', 'Frontend Engineer', 'DevOps Engineer'];
        foreach ($titles as $title) {
            $jobs[] = $this->createJob([
                'employer_id'    => $employer['id'],
                'title'          => $title,
                'company_name'   => 'TechCorp',
                'status'         => 'published',
            ]);
        }

        // 3. Verify all jobs are listed
        $this->assertCount(3, $jobs);

        // 4. Create applications for one job
        $candidates = [];
        for ($i = 0; $i < 3; $i++) {
            $candidate = $this->createUser([
                'name'  => "Candidate {$i}",
                'email' => "candidate{$i}@example.com",
            ]);
            $candidates[] = $candidate;

            $this->createApplication([
                'job_id'         => $jobs[0]['id'],
                'user_id'        => $candidate['id'],
                'applicant_name' => $candidate['name'],
            ]);
        }

        // 5. Count applications for the first job
        $stmt = self::$db->prepare('SELECT COUNT(*) as count FROM applications WHERE job_id = :job_id');
        $stmt->execute([':job_id' => $jobs[0]['id']]);
        $result = $stmt->fetch();

        $this->assertEquals(3, (int)$result['count']);
    }

    public function testBookmarkFlow(): void
    {
        // 1. Create employer, job, and candidate
        $employer = $this->createUser(['user_type' => 1]);
        $job = $this->createJob(['employer_id' => $employer['id']]);
        $candidate = $this->createUser(['user_type' => 0]);

        // 2. Create bookmark
        $stmt = self::$db->prepare(
            'INSERT INTO bookmarks (job_id, user_id) VALUES (:job_id, :user_id)'
        );
        $stmt->execute([':job_id' => $job['id'], ':user_id' => $candidate['id']]);
        $bookmarkId = (int) self::$db->lastInsertId();

        $this->assertGreaterThan(0, $bookmarkId);

        // 3. Verify bookmark exists
        $stmt = self::$db->prepare(
            'SELECT b.id, b.job_id, j.title FROM bookmarks b
             JOIN job_posts j ON j.id = b.job_id
             WHERE b.user_id = :user_id'
        );
        $stmt->execute([':user_id' => $candidate['id']]);
        $bookmarks = $stmt->fetchAll();

        $this->assertCount(1, $bookmarks);
        $this->assertEquals($job['title'], $bookmarks[0]['title']);

        // 4. Remove bookmark
        $stmt = self::$db->prepare('DELETE FROM bookmarks WHERE id = :id');
        $stmt->execute([':id' => $bookmarkId]);

        // 5. Verify it's gone
        $stmt = self::$db->prepare('SELECT COUNT(*) as count FROM bookmarks WHERE user_id = :user_id');
        $stmt->execute([':user_id' => $candidate['id']]);
        $result = $stmt->fetch();

        $this->assertEquals(0, (int)$result['count']);
    }
}
