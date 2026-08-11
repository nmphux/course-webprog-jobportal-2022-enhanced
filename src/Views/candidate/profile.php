<div class="container" style="padding-top: 1.5rem; padding-bottom: 3rem;">
    <h1 class="fade-in-up" style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">
        <?= __('candidate.my_applications') ?>
    </h1>

    <!-- Analytics Dashboard -->
    <?php if (!empty($applications)): ?>
    <div class="stats-grid fade-in-up" style="margin-bottom: 1.5rem;">
        <div class="stat-card stat-card-primary">
            <div class="stat-icon"><i class="fas fa-paper-plane"></i></div>
            <div class="stat-value"><?= count($applications) ?></div>
            <div class="stat-label"><?= __('candidate.total_applied') ?></div>
        <?php
        $pending = $reviewed = $interview = $accepted = $rejected = 0;
        foreach ($applications as $app) {
            $s = strtolower($app['status'] ?? 'pending');
            if ($s === 'pending') $pending++;
            elseif (in_array($s, ['reviewed'])) $reviewed++;
            elseif (in_array($s, ['shortlisted', 'interview'])) $interview++;
            elseif ($s === 'accepted') $accepted++;
            elseif ($s === 'rejected') $rejected++;
        }
        ?>
        <div class="stat-card stat-card-warning">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-value"><?= $pending ?></div>
            <div class="stat-label"><?= __('candidate.status_pending') ?></div>
        <div class="stat-card stat-card-success">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-value"><?= $accepted ?></div>
            <div class="stat-label"><?= __('candidate.accepted') ?></div>
        <div class="stat-card" style="background:var(--info-bg);">
            <div class="stat-icon" style="background:var(--info-bg);color:var(--info);"><i class="fas fa-chart-line"></i></div>
            <div class="stat-value" style="color:var(--info);"><?= $interview + $reviewed ?></div>
            <div class="stat-label" style="color:var(--info);"><?= __('candidate.in_progress') ?></div>
            <?php if ($interview > 0): ?>
                <div class="stat-trend up"><i class="fas fa-arrow-up"></i> <?= $interview ?> interviewing</div>
            <?php endif; ?>
        </div>

    <!-- Pipeline -->
    <?php if (count($applications) > 0): ?>
    <div class="pipeline fade-in-up" style="margin-bottom: 1.5rem;">
        <div class="step <?= $pending > 0 ? 'active' : 'done' ?>">
            <span class="step-count"><?= $pending ?></span>
            <span class="step-label"><?= __('candidate.status_pending') ?></span>
        </div>
        <div class="step <?= $reviewed > 0 ? 'active' : ($reviewed + $interview + $accepted > 0 ? 'done' : '') ?>">
            <span class="step-count"><?= $reviewed ?></span>
            <span class="step-label"><?= __('candidate.reviewed') ?></span>
        </div>
        <div class="step <?= $interview > 0 ? 'active' : ($interview + $accepted > 0 ? 'done' : '') ?>">
            <span class="step-count"><?= $interview ?></span>
            <span class="step-label"><?= __('candidate.interview') ?></span>
        </div>
        <div class="step <?= $accepted > 0 ? 'active' : '' ?>">
            <span class="step-count"><?= $accepted ?></span>
            <span class="step-label"><?= __('candidate.accepted') ?></span>
        </div>
    <?php endif; ?>
    <?php endif; ?>

    <!-- AI Match Score Suggestion -->
    <div class="ai-slot fade-in-up">
        <div class="ai-icon"><i class="fas fa-robot"></i></div>
        <div class="ai-label"><?= __('candidate.ai_match_title') ?></div>
        <div class="ai-desc"><?= __('candidate.ai_match_desc') ?></div>
        <span class="ai-coming-soon"><?= __('candidate.coming_soon') ?></span>
    </div>

    <?php if (!empty($applications)): ?>
        <div class="card fade-in-up">
            <div class="table-responsive">
                <table class="table" style="margin: 0;">
                    <thead>
                        <tr>
                            <th><?= __('candidate.job_title') ?></th>
                            <th><?= __('candidate.company') ?></th>
                            <th><?= __('candidate.status') ?></th>
                            <th><?= __('candidate.applied_date') ?></th>
                            <th><?= __('candidate.cv') ?></th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.875rem">
                        <?php foreach ($applications as $app): ?>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <?php if (!empty($app['company_logo'])): ?>
                                            <img src="<?= upload_url(e($app['company_logo'])) ?>" alt=""
                                                 style="width: 32px; height: 32px; border-radius: 6px; object-fit: cover;">
                                        <?php endif; ?>
                                        <span style="font-weight: 500;"><?= e($app['job_title'] ?? '') ?></span>
                                    </div>
                                </td>
                                <td style="color: var(--text-muted);">
                                    <?= e($app['company_name'] ?? '') ?>
                                </td>
                                <td>
                                    <?php
                                    $status = strtolower($app['status'] ?? 'pending');
                                    $status_class = 'status-pending';
                                    if (in_array($status, ['reviewed'])) $status_class = 'status-reviewed';
                                    elseif (in_array($status, ['shortlisted', 'interview'])) $status_class = 'status-interview';
                                    elseif ($status === 'accepted') $status_class = 'status-accepted';
                                    elseif ($status === 'rejected') $status_class = 'status-rejected';
                                    ?>
                                    <span class="status-badge <?= $status_class ?>">
                                        <?= e($app['status'] ?? __('candidate.status_pending')) ?>
                                    </span>
                                </td>
                                <td style="color: var(--text-muted); font-size: 0.875rem;">
                                    <?= e($app['created_at'] ?? '') ?>
                                </td>
                                <td>
                                    <?php if (!empty($app['file_path'])): ?>
                                        <a href="<?= upload_url(e($app['file_path'])) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-file-pdf" style="margin-right: 0.25rem;"></i><?= __('candidate.view_cv') ?>
                                        </a>
                                    <?php else: ?>
                                        <span style="color: var(--text-muted); font-size: 0.8125rem;"><?= __('candidate.no_cv') ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
    <?php else: ?>
        <div class="empty-state fade-in-up" style="text-align: center; padding: 4rem 2rem;">
            <i class="fas fa-file-alt" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
            <h3><?= __('candidate.no_applications_title') ?></h3>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;"><?= __('candidate.no_applications_desc') ?></p>
            <a href="<?= base_url('jobs') ?>" class="btn btn-primary btn-ripple">
                <i class="fas fa-search" style="margin-right: 0.375rem;"></i><?= __('candidate.browse_jobs') ?>
            </a>
        </div>
    <?php endif; ?>
</div>
