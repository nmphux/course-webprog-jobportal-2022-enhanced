<?php

namespace Models;

use Core\Model;

class Application extends Model
{
    public function create(array $data): int
    {
        return $this->insert('applications', $data);
    }

    public function findByJob(int $jobId): array
    {
        return $this->queryAll(
            "SELECT a.*, u.name AS user_name, u.email AS user_email, u.avatar AS user_avatar
             FROM applications a
             JOIN users u ON u.id = a.user_id
             WHERE a.job_id = :job_id
             ORDER BY a.created_at DESC",
            ['job_id' => $jobId]
        );
    }

    public function findByUser(int $userId): array
    {
        return $this->queryAll(
            "SELECT a.*, jp.title AS job_title, c.name AS company_name, c.logo AS company_logo
             FROM applications a
             JOIN job_posts jp ON jp.id = a.job_id
             JOIN companies c ON c.id = jp.company_id
             WHERE a.user_id = :user_id
             ORDER BY a.created_at DESC",
            ['user_id' => $userId]
        );
    }

    public function findByEmployerJobs(int $employerId): array
    {
        return $this->queryAll(
            "SELECT a.*, u.name AS user_name, u.email AS user_email, u.avatar AS user_avatar,
                    jp.title AS job_title, c.name AS company_name
             FROM applications a
             JOIN job_posts jp ON jp.id = a.job_id
             JOIN companies c ON c.id = jp.company_id
             JOIN users u ON u.id = a.user_id
             WHERE jp.user_id = :employer_id
             ORDER BY a.created_at DESC",
            ['employer_id' => $employerId]
        );
    }

    public function updateStatus(int $id, string $status): int
    {
        return $this->update('applications', ['status' => $status], 'id = :id', ['id' => $id]);
    }

    public function exists(int $userId, int $jobId): bool
    {
        $count = $this->count(
            "SELECT COUNT(*) FROM applications WHERE user_id = :user_id AND job_id = :job_id",
            ['user_id' => $userId, 'job_id' => $jobId]
        );
        return $count > 0;
    }

    public function findById(int $id): ?array
    {
        return $this->queryOne(
            "SELECT a.*, jp.user_id AS employer_id, jp.title AS job_title
             FROM applications a
             JOIN job_posts jp ON jp.id = a.job_id
             WHERE a.id = :id",
            ['id' => $id]
        );
    }

    public function isOwnedByEmployer(int $applicationId, int $employerId): bool
    {
        $count = $this->count(
            "SELECT COUNT(*) FROM applications a
             JOIN job_posts jp ON jp.id = a.job_id
             WHERE a.id = :app_id AND jp.user_id = :employer_id",
            ['app_id' => $applicationId, 'employer_id' => $employerId]
        );
        return $count > 0;
    }
}
