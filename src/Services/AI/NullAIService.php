<?php

namespace Services\AI;

class NullAIService implements AIServiceInterface
{
    public function parseResume(string $filePath): array
    {
        return [
            'name'       => '',
            'email'      => '',
            'phone'      => '',
            'skills'     => [],
            'education'  => [],
            'experience' => [],
            'summary'    => '',
        ];
    }

    public function matchCandidates(array $jobRequirements, array $candidates): array
    {
        return [];
    }

    public function suggestSkills(string $description): array
    {
        return [];
    }

    public function rankApplications(int $jobId): array
    {
        return [];
    }

    public function generateJobDescription(array $params): string
    {
        return '';
    }
}
