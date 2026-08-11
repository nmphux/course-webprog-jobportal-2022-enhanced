<?php
$skills_list = is_array($job['skills'] ?? null) ? $job['skills'] : array_filter(array_map('trim', explode(',', $job['skills'] ?? '')));
?>

<div class="container" style="padding-top: 1.5rem; padding-bottom: 3rem;">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8" style="margin-bottom: 2rem;">
            <!-- Company Header -->
            <div class="card fade-in-up" style="margin-bottom: 1.5rem;">
                <div class="card-body" style="display: flex; align-items: center; gap: 1rem;">
                    <?php if (!empty($job['company_logo'])): ?>
                        <img src="<?= upload_url(e($job['company_logo'])) ?>"
                             alt="<?= e($job['company_name'] ?? '') ?>"
                             style="width: 64px; height: 64px; border-radius: 12px; object-fit: cover; flex-shrink: 0;">
                    <?php else: ?>
                        <div class="avatar" style="width: 64px; height: 64px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 700; flex-shrink: 0;">
                            <?= strtoupper(substr($job['company_name'] ?? '?', 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                    <div>
                        <h2 style="margin: 0 0 0.25rem; font-size: 1rem; color: var(--text-muted);">
                            <?= e($job['company_name'] ?? '') ?>
                        </h2>
                        <?php if (!empty($job['company_city'])): ?>
                            <span style="font-size: 0.8125rem; color: var(--text-muted);">
                                <i class="fas fa-map-marker-alt"></i> <?= e($job['company_city']) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Job Title & Meta -->
            <div class="card fade-in-up" style="margin-bottom: 1.5rem;">
                <div class="card-body">
                    <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0 0 0.5rem;">
                        <?= e($job['title'] ?? '') ?>
                    </h1>
                    <?php if (!empty($job['category_name'])): ?>
                        <span class="badge-info" style="margin-bottom: 0.5rem; display: inline-block;">
                            <?= e($job['category_name']) ?>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($job['created_at'])): ?>
                        <p style="font-size: 0.8125rem; color: var(--text-muted); margin: 0.5rem 0 0;">
                            <i class="far fa-clock"></i> <?= __('jobs.posted') ?> <?= e($job['created_at']) ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Description -->
            <div class="card fade-in-up" style="margin-bottom: 1.5rem;">
                <div class="card-body">
                    <h2 style="font-size: 1.125rem; font-weight: 600; margin: 0 0 1rem;"><?= __('jobs.description') ?></h2>
                    <div style="line-height: 1.7; font-size: 0.9375rem;">
                        <?= $job['description'] ?? '' ?>
                    </div>
                </div>
            </div>

            <!-- Requirements -->
            <?php if (!empty($job['requirements'])): ?>
            <div class="card fade-in-up" style="margin-bottom: 1.5rem;">
                <div class="card-body">
                    <h2 style="font-size: 1.125rem; font-weight: 600; margin: 0 0 1rem;"><?= __('jobs.requirements') ?></h2>
                    <div style="line-height: 1.7; font-size: 0.9375rem;">
                        <?= $job['requirements'] ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Skills -->
            <?php if (!empty($skills_list)): ?>
            <div class="card fade-in-up" style="margin-bottom: 1.5rem;">
                <div class="card-body">
                    <h2 style="font-size: 1.125rem; font-weight: 600; margin: 0 0 1rem;"><?= __('jobs.skills_required') ?></h2>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        <?php foreach ($skills_list as $skill): ?>
                            <span class="badge-skill"><?= e($skill) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div style="position: sticky; top: 5rem;">
                <!-- Quick Info -->
                <div class="card fade-in-up" style="margin-bottom: 1rem;">
                    <div class="card-header">
                        <h3 style="font-size: 1rem; font-weight: 600; margin: 0;"><?= __('jobs.quick_info') ?></h3>
                    </div>
                    <div class="card-body" style="padding: 0;">
                        <table style="width: 100%; font-size: 0.875rem;">
                            <?php if (!empty($job['salary'])): ?>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 0.75rem 1rem; color: var(--text-muted); white-space: nowrap;">
                                    <i class="fas fa-money-bill-wave fa-fw" style="margin-right: 0.375rem;"></i><?= __('jobs.salary') ?>
                                </td>
                                <td style="padding: 0.75rem 1rem; font-weight: 600; text-align: right;"><?= e($job['salary']) ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if (!empty($job['level'])): ?>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 0.75rem 1rem; color: var(--text-muted); white-space: nowrap;">
                                    <i class="fas fa-layer-group fa-fw" style="margin-right: 0.375rem;"></i><?= __('jobs.level') ?>
                                </td>
                                <td style="padding: 0.75rem 1rem; text-align: right;"><?= e($job['level']) ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if (!empty($job['employment_type'])): ?>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 0.75rem 1rem; color: var(--text-muted); white-space: nowrap;">
                                    <i class="fas fa-briefcase fa-fw" style="margin-right: 0.375rem;"></i><?= __('jobs.type') ?>
                                </td>
                                <td style="padding: 0.75rem 1rem; text-align: right;"><?= e($job['employment_type']) ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if (isset($job['experience_years'])): ?>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 0.75rem 1rem; color: var(--text-muted); white-space: nowrap;">
                                    <i class="fas fa-star fa-fw" style="margin-right: 0.375rem;"></i><?= __('jobs.experience') ?>
                                </td>
                                <td style="padding: 0.75rem 1rem; text-align: right;">
                                    <?= __('jobs.years', [(int)$job['experience_years']]) ?>
                                </td>
                            </tr>
                            <?php endif; ?>
                            <?php if (!empty($job['interview_rounds'])): ?>
                            <tr>
                                <td style="padding: 0.75rem 1rem; color: var(--text-muted); white-space: nowrap;">
                                    <i class="fas fa-comments fa-fw" style="margin-right: 0.375rem;"></i><?= __('jobs.interviews') ?>
                                </td>
                                <td style="padding: 0.75rem 1rem; text-align: right;">
                                    <?= __('jobs.rounds', [(int)$job['interview_rounds']]) ?>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card fade-in-up" style="margin-bottom: 1rem;">
                    <div class="card-body">
                        <?php if (!empty($has_applied)): ?>
                            <button class="btn btn-secondary btn-lg btn-ripple" style="width: 100%; margin-bottom: 0.75rem;" disabled>
                                <i class="fas fa-check" style="margin-right: 0.375rem;"></i><?= __('jobs.already_applied') ?>
                            </button>
                        <?php elseif ($current_user && $current_user['type'] == 0): ?>
                            <a href="<?= base_url('jobs/' . (int)$job['id'] . '/apply') ?>" class="btn btn-primary btn-lg btn-ripple" style="width: 100%; margin-bottom: 0.75rem;">
                                <i class="fas fa-paper-plane" style="margin-right: 0.375rem;"></i><?= __('jobs.apply_now') ?>
                            </a>
                        <?php elseif (!$current_user): ?>
                            <a href="<?= base_url('login') ?>" class="btn btn-primary btn-lg btn-ripple" style="width: 100%; margin-bottom: 0.75rem;">
                                <i class="fas fa-sign-in-alt" style="margin-right: 0.375rem;"></i><?= __('jobs.login_to_apply') ?>
                            </a>
                        <?php endif; ?>

                        <?php if ($current_user && $current_user['type'] == 0): ?>
                            <form action="<?= base_url('jobs/' . (int)$job['id'] . '/bookmark') ?>" method="POST" style="margin: 0;">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn <?= !empty($is_bookmarked) ? 'btn-primary' : 'btn-outline-primary' ?> btn-ripple" style="width: 100%;">
                                    <i class="<?= !empty($is_bookmarked) ? 'fas' : 'far' ?> fa-bookmark" style="margin-right: 0.375rem;"></i>
                                    <?= !empty($is_bookmarked) ? __('jobs.bookmarked') : __('jobs.bookmark') ?>
                                </button>
                            </form>
                        <?php endif; ?>

                        <?php if (!empty($job['company_id'])): ?>
                            <a href="<?= base_url('companies/' . (int)$job['company_id']) ?>" class="btn btn-outline-primary btn-ripple" style="width: 100%; margin-top: 0.75rem;">
                                <i class="fas fa-building" style="margin-right: 0.375rem;"></i><?= __('jobs.view_company') ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Jobs -->
    <?php if (!empty($related_jobs)): ?>
    <section class="fade-in-up" style="margin-top: 2rem;">
        <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem;"><?= __('jobs.related_jobs') ?></h2>
        <div class="row">
            <?php foreach (array_slice($related_jobs, 0, 4) as $job): ?>
                <div class="col-md-6 col-lg-3" style="margin-bottom: 1rem;">
                    <?php include __DIR__ . '/../partials/job-card.php'; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</div>
