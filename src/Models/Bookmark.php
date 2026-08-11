<?php

namespace Models;

use Core\Model;

class Bookmark extends Model
{
    public function add(int $userId, int $jobId): int
    {
        if ($this->exists($userId, $jobId)) {
            return 0;
        }

        return $this->insert('bookmarks', [
            'user_id' => $userId,
            'job_id'  => $jobId,
        ]);
    }

    public function remove(int $id, int $userId): int
    {
        return $this->delete('bookmarks', 'id = :id AND user_id = :user_id', [
            'id'      => $id,
            'user_id' => $userId,
        ]);
    }

    public function removeByJobAndUser(int $jobId, int $userId): int
    {
        return $this->delete('bookmarks', 'job_id = :job_id AND user_id = :user_id', [
            'job_id'  => $jobId,
            'user_id' => $userId,
        ]);
    }

    public function getByUser(int $userId): array
    {
        return $this->queryAll(
            "SELECT b.id AS bookmark_id, b.created_at AS bookmarked_at,
                    jp.*, c.name AS company_name, c.logo AS company_logo, c.city AS company_city,
                    cat.name AS category_name
             FROM bookmarks b
             JOIN job_posts jp ON jp.id = b.job_id
             JOIN companies c ON c.id = jp.company_id
             JOIN categories cat ON cat.id = jp.category_id
             WHERE b.user_id = :user_id
             ORDER BY b.created_at DESC",
            ['user_id' => $userId]
        );
    }

    public function exists(int $userId, int $jobId): bool
    {
        $count = $this->count(
            "SELECT COUNT(*) FROM bookmarks WHERE user_id = :user_id AND job_id = :job_id",
            ['user_id' => $userId, 'job_id' => $jobId]
        );
        return $count > 0;
    }
}
