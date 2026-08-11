<?php

namespace Models;

use Core\Model;

class Company extends Model
{
    public function findById(int $id): ?array
    {
        return $this->queryOne(
            "SELECT * FROM companies WHERE id = :id",
            ['id' => $id]
        );
    }

    public function findOrCreate(array $data): int
    {
        $existing = $this->queryOne(
            "SELECT id FROM companies WHERE name = :name",
            ['name' => $data['name']]
        );

        if ($existing) {
            return (int) $existing['id'];
        }

        return $this->insert('companies', $data);
    }

    public function updateCompany(int $id, array $data): int
    {
        return $this->update('companies', $data, 'id = :id', ['id' => $id]);
    }

    public function getAll(): array
    {
        return $this->queryAll("SELECT * FROM companies ORDER BY name");
    }

    public function getByEmployer(int $userId): array
    {
        return $this->queryAll(
            "SELECT DISTINCT c.*
             FROM companies c
             JOIN job_posts jp ON jp.company_id = c.id
             WHERE jp.user_id = :user_id
             ORDER BY c.name",
            ['user_id' => $userId]
        );
    }

    public function getJobs(int $companyId): array
    {
        return $this->queryAll(
            "SELECT jp.*, cat.name AS category_name
             FROM job_posts jp
             JOIN categories cat ON cat.id = jp.category_id
             WHERE jp.company_id = :company_id AND jp.status = 'published'
             ORDER BY jp.created_at DESC",
            ['company_id' => $companyId]
        );
    }

    public function getFeatured(int $limit = 8): array
    {
        return $this->queryAll(
            "SELECT c.*, COUNT(jp.id) AS job_count
             FROM companies c
             JOIN job_posts jp ON jp.company_id = c.id AND jp.status = 'published'
             GROUP BY c.id
             ORDER BY job_count DESC
             LIMIT {$limit}"
        );
    }
}
