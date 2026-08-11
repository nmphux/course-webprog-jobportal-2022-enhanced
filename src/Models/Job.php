<?php

namespace Models;

use Core\Model;

class Job extends Model
{
    public function findById(int $id): ?array
    {
        $job = $this->queryOne(
            "SELECT jp.*, c.name AS company_name, c.logo AS company_logo, c.city AS company_city,
                    c.slogan AS company_slogan, c.website AS company_website, c.company_size,
                    cat.name AS category_name, cat.slug AS category_slug
             FROM job_posts jp
             JOIN companies c ON c.id = jp.company_id
             JOIN categories cat ON cat.id = jp.category_id
             WHERE jp.id = :id",
            ['id' => $id]
        );

        if ($job) {
            $job['skills'] = $this->getSkills($id);
        }

        return $job;
    }

    public function getSkills(int $jobId): array
    {
        return $this->queryAll(
            "SELECT s.id, s.name, sc.name AS category_name
             FROM job_skills js
             JOIN skills s ON s.id = js.skill_id
             JOIN skill_categories sc ON sc.id = s.category_id
             WHERE js.job_id = :job_id
             ORDER BY s.name",
            ['job_id' => $jobId]
        );
    }

    public function search(array $filters, int $page = 1, int $perPage = 12): array
    {
        $where = ['jp.status = :status'];
        $params = ['status' => 'published'];
        $joins = '';

        if (!empty($filters['q'])) {
            $where[] = '(jp.title LIKE :q OR jp.description LIKE :q2 OR c.name LIKE :q3)';
            $params['q'] = '%' . $filters['q'] . '%';
            $params['q2'] = '%' . $filters['q'] . '%';
            $params['q3'] = '%' . $filters['q'] . '%';
        }

        if (!empty($filters['category'])) {
            $where[] = 'jp.category_id = :category_id';
            $params['category_id'] = (int) $filters['category'];
        }

        if (!empty($filters['city'])) {
            $where[] = 'c.city LIKE :city';
            $params['city'] = '%' . $filters['city'] . '%';
        }

        if (!empty($filters['level'])) {
            $where[] = 'jp.level = :level';
            $params['level'] = $filters['level'];
        }

        if (!empty($filters['type'])) {
            $where[] = 'jp.employment_type = :type';
            $params['type'] = $filters['type'];
        }

        if (!empty($filters['experience'])) {
            $where[] = 'jp.experience_years <= :exp';
            $params['exp'] = (int) $filters['experience'];
        }

        if (!empty($filters['skill_ids'])) {
            $joins .= ' JOIN job_skills js_filter ON js_filter.job_id = jp.id';
            $skillPlaceholders = [];
            foreach ($filters['skill_ids'] as $i => $sid) {
                $key = 'skill_' . $i;
                $skillPlaceholders[] = ':' . $key;
                $params[$key] = (int) $sid;
            }
            $where[] = 'js_filter.skill_id IN (' . implode(',', $skillPlaceholders) . ')';
        }

        $whereStr = implode(' AND ', $where);

        $orderBy = 'jp.created_at DESC';
        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'salary':
                    $orderBy = 'jp.salary DESC';
                    break;
                case 'oldest':
                    $orderBy = 'jp.created_at ASC';
                    break;
            }
        }

        $countSql = "SELECT COUNT(DISTINCT jp.id) FROM job_posts jp
                     JOIN companies c ON c.id = jp.company_id
                     {$joins}
                     WHERE {$whereStr}";
        $total = $this->count($countSql, $params);

        $offset = ($page - 1) * $perPage;
        $dataSql = "SELECT DISTINCT jp.*, c.name AS company_name, c.logo AS company_logo, c.city AS company_city,
                           cat.name AS category_name
                    FROM job_posts jp
                    JOIN companies c ON c.id = jp.company_id
                    JOIN categories cat ON cat.id = jp.category_id
                    {$joins}
                    WHERE {$whereStr}
                    ORDER BY {$orderBy}
                    LIMIT {$perPage} OFFSET {$offset}";
        $jobs = $this->queryAll($dataSql, $params);

        foreach ($jobs as &$job) {
            $job['skills'] = $this->getSkills($job['id']);
        }

        return [
            'data'       => $jobs,
            'total'      => $total,
            'page'       => $page,
            'per_page'   => $perPage,
            'total_pages'=> (int) ceil($total / $perPage),
        ];
    }

    public function getByEmployer(int $userId): array
    {
        $jobs = $this->queryAll(
            "SELECT jp.*, c.name AS company_name, c.logo AS company_logo,
                    cat.name AS category_name,
                    (SELECT COUNT(*) FROM applications a WHERE a.job_id = jp.id) AS application_count
             FROM job_posts jp
             JOIN companies c ON c.id = jp.company_id
             JOIN categories cat ON cat.id = jp.category_id
             WHERE jp.user_id = :user_id
             ORDER BY jp.created_at DESC",
            ['user_id' => $userId]
        );

        return $jobs;
    }

    public function createJob(array $data): int
    {
        return $this->insert('job_posts', $data);
    }

    public function updateJob(int $id, array $data): int
    {
        return $this->update('job_posts', $data, 'id = :id', ['id' => $id]);
    }

    public function deleteJob(int $id, int $userId): int
    {
        return $this->delete('job_posts', 'id = :id AND user_id = :user_id', ['id' => $id, 'user_id' => $userId]);
    }

    public function syncSkills(int $jobId, array $skillIds): void
    {
        $this->delete('job_skills', 'job_id = :job_id', ['job_id' => $jobId]);

        foreach ($skillIds as $skillId) {
            $this->insert('job_skills', [
                'job_id'   => $jobId,
                'skill_id' => (int) $skillId,
            ]);
        }
    }

    public function getRecent(int $limit = 6): array
    {
        $jobs = $this->queryAll(
            "SELECT jp.*, c.name AS company_name, c.logo AS company_logo, c.city AS company_city,
                    cat.name AS category_name
             FROM job_posts jp
             JOIN companies c ON c.id = jp.company_id
             JOIN categories cat ON cat.id = jp.category_id
             WHERE jp.status = 'published'
             ORDER BY jp.created_at DESC
             LIMIT {$limit}"
        );

        foreach ($jobs as &$job) {
            $job['skills'] = $this->getSkills($job['id']);
        }

        return $jobs;
    }

    public function getRelated(int $jobId, int $categoryId, int $limit = 4): array
    {
        return $this->queryAll(
            "SELECT jp.*, c.name AS company_name, c.logo AS company_logo, c.city AS company_city,
                    cat.name AS category_name
             FROM job_posts jp
             JOIN companies c ON c.id = jp.company_id
             JOIN categories cat ON cat.id = jp.category_id
             WHERE jp.category_id = :cat_id AND jp.id != :job_id AND jp.status = 'published'
             ORDER BY jp.created_at DESC
             LIMIT {$limit}",
            ['cat_id' => $categoryId, 'job_id' => $jobId]
        );
    }

    public function isOwnedBy(int $jobId, int $userId): bool
    {
        $count = $this->count(
            "SELECT COUNT(*) FROM job_posts WHERE id = :id AND user_id = :user_id",
            ['id' => $jobId, 'user_id' => $userId]
        );
        return $count > 0;
    }
}
