<?php
/**
 * Job Card Partial
 * Data: $job (single job array with company_name, company_logo, company_city,
 *       title, level, employment_type, salary, skills, id, created_at, category_name)
 *
 * $job['skills'] can be either:
 *   - A comma-separated string (legacy format)
 *   - An array of arrays with ['name'] key (from getSkills() query)
 */
$raw_skills = $job['skills'] ?? [];

if (is_array($raw_skills)) {
    // Extract skill names from array of skill objects
    $skills_list = array_map(function($s) {
        return is_array($s) ? ($s['name'] ?? '') : (string)$s;
    }, $raw_skills);
    $skills_list = array_filter($skills_list, function($v) { return $v !== ''; });
} else {
    // Comma-separated string
    $skills_list = array_filter(array_map('trim', explode(',', (string)$raw_skills)));
}

$max_skills = 4;
$extra_count = max(0, count($skills_list) - $max_skills);
?>
<div class="job-card card card-hover fade-in-up">
    <div class="card-body">
        <div style="display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 0.75rem;">
            <?php if (!empty($job['company_logo'])): ?>
                <img src="<?= upload_url(e($job['company_logo'])) ?>"
                     alt="<?= e($job['company_name'] ?? '') ?>"
                     style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover; flex-shrink: 0;">
            <?php else: ?>
                <div class="avatar" style="width: 48px; height: 48px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.25rem; flex-shrink: 0;">
                    <?= strtoupper(substr($job['company_name'] ?? '?', 0, 1)) ?>
                </div>
            <?php endif; ?>
            <div style="min-width: 0; flex: 1;">
                <h3 style="margin: 0 0 0.25rem; font-size: 1rem; font-weight: 600; line-height: 1.3;">
                    <a href="<?= base_url('jobs/' . (int)$job['id']) ?>" style="text-decoration: none; color: inherit;">
                        <?= e($job['title'] ?? '') ?>
                    </a>
                </h3>
                <p style="margin: 0; font-size: 0.875rem; color: var(--text-muted);">
                    <?= e($job['company_name'] ?? '') ?>
                </p>
            </div>

        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; font-size: 0.8125rem; color: var(--text-muted); margin-bottom: 0.75rem;">
            <?php if (!empty($job['company_city'])): ?>
                <span><i class="fas fa-map-marker-alt fa-fw"></i> <?= e($job['company_city']) ?></span>
            <?php endif; ?>
            <?php if (!empty($job['level'])): ?>
                <span><i class="fas fa-layer-group fa-fw"></i> <?= e($job['level']) ?></span>
            <?php endif; ?>
            <?php if (!empty($job['employment_type'])): ?>
                <span><i class="fas fa-clock fa-fw"></i> <?= e($job['employment_type']) ?></span>
            <?php endif; ?>
        </div>

        <?php if (!empty($job['salary'])): ?>
            <div style="font-size: 0.9375rem; font-weight: 600; color: var(--primary); margin-bottom: 0.75rem;">
                <?= e($job['salary']) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($skills_list)): ?>
            <div style="display: flex; flex-wrap: wrap; gap: 0.375rem;">
                <?php foreach (array_slice(array_values($skills_list), 0, $max_skills) as $skill): ?>
                    <span class="badge-skill"><?= e($skill) ?></span>
                <?php endforeach; ?>
                <?php if ($extra_count > 0): ?>
                    <span class="badge-skill" style="opacity: 0.7;">+<?= $extra_count ?> <?= __('jobs.more') ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
