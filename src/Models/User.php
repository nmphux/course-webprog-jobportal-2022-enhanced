<?php

namespace Models;

use Core\Model;

class User extends Model
{
    public function findById(int $id): ?array
    {
        return $this->queryOne(
            "SELECT u.*, up.headline, up.portfolio_url, up.linkedin_url, up.github_url, up.website_url
             FROM users u
             LEFT JOIN user_profiles up ON up.user_id = u.id
             WHERE u.id = :id",
            ['id' => $id]
        );
    }

    public function findByEmail(string $email): ?array
    {
        return $this->queryOne(
            "SELECT * FROM users WHERE email = :email",
            ['email' => $email]
        );
    }

    public function create(array $data): int
    {
        return $this->insert('users', $data);
    }

    public function updateUser(int $id, array $data): int
    {
        return $this->update('users', $data, 'id = :id', ['id' => $id]);
    }

    public function updatePassword(int $id, string $hashedPassword): int
    {
        return $this->update('users', ['password' => $hashedPassword], 'id = :id', ['id' => $id]);
    }

    public function getSkills(int $userId): array
    {
        return $this->queryAll(
            "SELECT s.id, s.name, sc.name AS category_name
             FROM user_skills us
             JOIN skills s ON s.id = us.skill_id
             JOIN skill_categories sc ON sc.id = s.category_id
             WHERE us.user_id = :user_id
             ORDER BY sc.name, s.name",
            ['user_id' => $userId]
        );
    }

    public function getSkillIds(int $userId): array
    {
        $rows = $this->queryAll(
            "SELECT skill_id FROM user_skills WHERE user_id = :user_id",
            ['user_id' => $userId]
        );
        return array_column($rows, 'skill_id');
    }

    public function syncSkills(int $userId, array $skillIds): void
    {
        $this->delete('user_skills', 'user_id = :user_id', ['user_id' => $userId]);

        foreach ($skillIds as $skillId) {
            $this->insert('user_skills', [
                'user_id'  => $userId,
                'skill_id' => (int) $skillId,
            ]);
        }
    }

    public function getProfile(int $userId): ?array
    {
        return $this->queryOne(
            "SELECT * FROM user_profiles WHERE user_id = :user_id",
            ['user_id' => $userId]
        );
    }

    public function upsertProfile(int $userId, array $data): void
    {
        $existing = $this->getProfile($userId);

        if ($existing) {
            $this->update('user_profiles', $data, 'user_id = :user_id', ['user_id' => $userId]);
        } else {
            $data['user_id'] = $userId;
            $this->insert('user_profiles', $data);
        }
    }

    public function getEducation(int $userId): array
    {
        return $this->queryAll(
            "SELECT * FROM user_education WHERE user_id = :user_id ORDER BY start_date DESC",
            ['user_id' => $userId]
        );
    }

    public function addEducation(int $userId, array $data): int
    {
        $data['user_id'] = $userId;
        return $this->insert('user_education', $data);
    }

    public function updateEducation(int $id, int $userId, array $data): int
    {
        return $this->update('user_education', $data, 'id = :id AND user_id = :user_id', ['id' => $id, 'user_id' => $userId]);
    }

    public function deleteEducation(int $id, int $userId): int
    {
        return $this->delete('user_education', 'id = :id AND user_id = :user_id', ['id' => $id, 'user_id' => $userId]);
    }

    public function getExperience(int $userId): array
    {
        return $this->queryAll(
            "SELECT * FROM user_experience WHERE user_id = :user_id ORDER BY is_current DESC, start_date DESC",
            ['user_id' => $userId]
        );
    }

    public function addExperience(int $userId, array $data): int
    {
        $data['user_id'] = $userId;
        return $this->insert('user_experience', $data);
    }

    public function updateExperience(int $id, int $userId, array $data): int
    {
        return $this->update('user_experience', $data, 'id = :id AND user_id = :user_id', ['id' => $id, 'user_id' => $userId]);
    }

    public function deleteExperience(int $id, int $userId): int
    {
        return $this->delete('user_experience', 'id = :id AND user_id = :user_id', ['id' => $id, 'user_id' => $userId]);
    }

    public function getCertifications(int $userId): array
    {
        return $this->queryAll(
            "SELECT * FROM user_certifications WHERE user_id = :user_id ORDER BY issue_date DESC",
            ['user_id' => $userId]
        );
    }

    public function addCertification(int $userId, array $data): int
    {
        $data['user_id'] = $userId;
        return $this->insert('user_certifications', $data);
    }

    public function updateCertification(int $id, int $userId, array $data): int
    {
        return $this->update('user_certifications', $data, 'id = :id AND user_id = :user_id', ['id' => $id, 'user_id' => $userId]);
    }

    public function deleteCertification(int $id, int $userId): int
    {
        return $this->delete('user_certifications', 'id = :id AND user_id = :user_id', ['id' => $id, 'user_id' => $userId]);
    }
}
