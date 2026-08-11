<div class="container" style="padding-top: 1.5rem; padding-bottom: 3rem;">
    <h1 class="fade-in-up" style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">
        <?= __('employer.received_applications') ?>
    </h1>

    <?php if (!empty($applications)): ?>
        <div class="card fade-in-up">
            <div class="table-responsive">
                <table class="table" style="margin: 0;">
                    <thead>
                        <tr>
                            <th><?= __('employer.applicant') ?></th>
                            <th><?= __('employer.job_title') ?></th>
                            <th><?= __('employer.status') ?></th>
                            <th><?= __('employer.applied_date') ?></th>
                            <th><?= __('employer.actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $app): ?>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.625rem;">
                                        <?php if (!empty($app['user_avatar'])): ?>
                                            <img src="<?= upload_url(e($app['user_avatar'])) ?>" alt=""
                                                 style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="avatar" style="width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.875rem; font-weight: 600;">
                                                <?= strtoupper(substr($app['user_name'] ?? '?', 0, 1)) ?>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <div style="font-weight: 500;"><?= e($app['user_name'] ?? '') ?></div>
                                            <div style="font-size: 0.8125rem; color: var(--text-muted);"><?= e($app['user_email'] ?? '') ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 500;"><?= e($app['job_title'] ?? '') ?></div>
                                    <?php if (!empty($app['company_name'])): ?>
                                        <div style="font-size: 0.8125rem; color: var(--text-muted);"><?= e($app['company_name']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    $status = strtolower($app['status'] ?? 'pending');
                                    $status_class = 'status-pending';
                                    if ($status === 'reviewed') $status_class = 'status-reviewed';
                                    elseif (in_array($status, ['shortlisted', 'interview'])) $status_class = 'status-interview';
                                    elseif ($status === 'accepted') $status_class = 'status-accepted';
                                    elseif ($status === 'rejected') $status_class = 'status-rejected';
                                    ?>
                                    <span class="status-badge <?= $status_class ?>">
                                        <?= e($app['status'] ?? __('employer.status_pending')) ?>
                                    </span>
                                </td>
                                <td style="color: var(--text-muted); font-size: 0.875rem;">
                                    <?= e($app['created_at'] ?? '') ?>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                        <?php if (!empty($app['file_path'])): ?>
                                            <a href="<?= upload_url(e($app['file_path'])) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-file-pdf" style="margin-right: 0.25rem;"></i><?= __('employer.view_cv') ?>
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?= base_url('employer/status/' . (int)$app['id']) ?>" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-edit" style="margin-right: 0.25rem;"></i><?= __('employer.update_status') ?>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="empty-state fade-in-up" style="text-align: center; padding: 4rem 2rem;">
            <i class="fas fa-inbox" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
            <h3><?= __('employer.no_applications_title') ?></h3>
            <p style="color: var(--text-muted);"><?= __('employer.no_applications_desc') ?></p>
        </div>
    <?php endif; ?>
</div>
