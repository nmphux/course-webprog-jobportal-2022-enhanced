<?php

namespace Models;

use Core\Model;

class Category extends Model
{
    public function getAll(): array
    {
        return $this->queryAll("SELECT * FROM categories ORDER BY name");
    }

    public function findById(int $id): ?array
    {
        return $this->queryOne(
            "SELECT * FROM categories WHERE id = :id",
            ['id' => $id]
        );
    }

    public function getWithJobCounts(): array
    {
        return $this->queryAll(
            "SELECT c.*, COUNT(jp.id) AS job_count
             FROM categories c
             LEFT JOIN job_posts jp ON jp.category_id = c.id AND jp.status = 'published'
             GROUP BY c.id
             ORDER BY c.name"
        );
    }
}
