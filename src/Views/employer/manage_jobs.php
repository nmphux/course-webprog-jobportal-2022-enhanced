<div class="container" style="padding-top: 1.5rem; padding-bottom: 3rem;">
    <div class="fade-in-up" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.75rem;">
        <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0;">
            <?= __('employer.manage_jobs') ?>
        </h1>
        <a href="<?= base_url('employer/create-job') ?>" class="btn btn-primary btn-ripple">
            <i class="fas fa-plus" style="margin-right: 0.375rem;"></i><?= __('employer.post_job') ?>
        </a>
    </div>

    <?php if (!empty($jobs)): ?>
        <div class="card fade-in-up">
            <div class="table-responsive">
                <table class="table" style="margin: 0;">
                    <thead>
                        <tr>
                            <th><?= __('employer.job_title') ?></th>
                            <th><?= __('employer.company') ?></th>
                            <th><?= __('employer.category') ?></th>
                            <th><?= __('employer.status') ?></th>
                            <th><?= __('employer.applications') ?></th>
                            <th><?= __('employer.actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jobs as $job): ?>
                            <tr>
                                <td>
                                    <a href="<?= base_url('jobs/' . (int)$job['id']) ?>" style="font-weight: 500; text-decoration: none;">
                                        <?= e($job['title'] ?? '') ?>
                                    </a>
                                </td>
                                <td style="color: var(--text-muted);">
                                    <?= e($job['company_name'] ?? '') ?>
                                </td>
                                <td style="color: var(--text-muted);">
                                    <?= e($job['category_name'] ?? '') ?>
                                </td>
                                <td>
                                    <?php
                                    $status = strtolower($job['status'] ?? 'published');
                                    $badge_class = 'badge-success';
                                    if ($status === 'draft') $badge_class = 'badge-warning';
                                    elseif ($status === 'closed') $badge_class = 'badge-danger';
                                    ?>
                                    <span class="status-badge <?= $badge_class ?>">
                                        <?= e(ucfirst($job['status'] ?? 'Published')) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-info"><?= (int)($job['application_count'] ?? 0) ?></span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <a href="<?= base_url('employer/edit-job/' . (int)$job['id']) ?>" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-edit"></i> <?= __('employer.edit') ?>
                                        </a>
                                        <form action="<?= base_url('employer/delete-job/' . (int)$job['id']) ?>" method="POST"
                                              onsubmit="return confirm('<?= __('employer.confirm_delete') ?>');"
                                              style="margin: 0;">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> <?= __('employer.delete') ?>
                                            </button>
                                        </form>
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
            <i class="fas fa-briefcase" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
            <h3><?= __('employer.no_jobs_title') ?></h3>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;"><?= __('employer.no_jobs_desc') ?></p>
            <a href="<?= base_url('employer/create-job') ?>" class="btn btn-primary btn-ripple">
                <i class="fas fa-plus" style="margin-right: 0.375rem;"></i><?= __('employer.post_job') ?>
            </a>
        </div>
    <?php endif; ?>
</div>
