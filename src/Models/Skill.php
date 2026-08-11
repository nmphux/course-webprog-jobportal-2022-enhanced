<?php

namespace Models;

use Core\Model;

class Skill extends Model
{
    public function getAll(): array
    {
        return $this->queryAll(
            "SELECT s.id, s.name, sc.name AS category_name, s.category_id
             FROM skills s
             JOIN skill_categories sc ON sc.id = s.category_id
             ORDER BY sc.name, s.name"
        );
    }

    public function getAllGrouped(): array
    {
        $skills = $this->getAll();
        $grouped = [];

        foreach ($skills as $skill) {
            $grouped[$skill['category_name']][] = $skill;
        }

        return $grouped;
    }

    public function findByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        $placeholders = [];
        $params = [];
        foreach ($ids as $i => $id) {
            $key = 'id_' . $i;
            $placeholders[] = ':' . $key;
            $params[$key] = (int) $id;
        }

        return $this->queryAll(
            "SELECT s.id, s.name, sc.name AS category_name
             FROM skills s
             JOIN skill_categories sc ON sc.id = s.category_id
             WHERE s.id IN (" . implode(',', $placeholders) . ")
             ORDER BY s.name",
            $params
        );
    }

    public function suggest(string $term, int $limit = 10): array
    {
        return $this->queryAll(
            "SELECT s.id, s.name, sc.name AS category_name
             FROM skills s
             JOIN skill_categories sc ON sc.id = s.category_id
             WHERE s.name LIKE :term
             ORDER BY s.name
             LIMIT {$limit}",
            ['term' => '%' . $term . '%']
        );
    }

    public function getCategories(): array
    {
        return $this->queryAll("SELECT * FROM skill_categories ORDER BY name");
    }
}
