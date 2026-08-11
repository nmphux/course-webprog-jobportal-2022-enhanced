<?php

namespace Services\AI;

interface AIServiceInterface
{
    public function parseResume(string $filePath): array;

    public function matchCandidates(array $jobRequirements, array $candidates): array;

    public function suggestSkills(string $description): array;

    public function rankApplications(int $jobId): array;

    public function generateJobDescription(array $params): string;
}
