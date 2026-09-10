<div class="container" style="padding-top: 1.5rem; padding-bottom: 3rem; max-width: 700px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h1 class="fade-in-up" style="font-size: 1.5rem; font-weight: 700; margin: 0;">
            <?= __('candidate.application_detail') ?>
        </h1>
        <a href="<?= base_url('candidate/profile') ?>" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-arrow-left" style="margin-right: 0.25rem;"></i><?= __('common.back') ?>
        </a>
    </div>

    <div class="card fade-in-up">
        <div class="card-body">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color);">
                <?php if (!empty($application['company_logo'])): ?>
                    <img src="<?= upload_url(e($application['company_logo'])) ?>" alt=""
                         style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover;">
                <?php endif; ?>
                <div>
                    <h3 style="font-size: 1.125rem; font-weight: 600; margin: 0 0 0.25rem;"><?= e($application['job_title'] ?? '') ?></h3>
                    <div style="color: var(--text-muted); font-size: 0.875rem;"><?= e($application['company_name'] ?? '') ?></div>
                </div>
            </div>

            <table class="table" style="margin-bottom: 1.5rem;">
                <tr>
                    <td style="font-weight: 600; width: 35%; color: var(--text-muted);"><?= __('candidate.status') ?></td>
                    <td>
                        <?php
                        $status = strtolower($application['status'] ?? 'pending');
                        $status_class = 'status-pending';
                        if (in_array($status, ['reviewed'])) $status_class = 'status-reviewed';
                        elseif (in_array($status, ['shortlisted', 'interview'])) $status_class = 'status-interview';
                        elseif ($status === 'accepted') $status_class = 'status-accepted';
                        elseif ($status === 'rejected') $status_class = 'status-rejected';
                        ?>
                        <span class="status-badge <?= $status_class ?>">
                            <?= e($application['status'] ?? 'PENDING') ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: 600; color: var(--text-muted);"><?= __('candidate.applicant_name') ?></td>
                    <td><?= e($application['applicant_name'] ?? '') ?></td>
                </tr>
                <tr>
                    <td style="font-weight: 600; color: var(--text-muted);"><?= __('candidate.applied_date') ?></td>
                    <td><?= e($application['created_at'] ?? '') ?></td>
                </tr>
                <tr>
                    <td style="font-weight: 600; color: var(--text-muted);"><?= __('candidate.cv') ?></td>
                    <td>
                        <?php if (!empty($application['file_path'])): ?>
                            <a href="<?= upload_url(e($application['file_path'])) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-file-pdf" style="margin-right: 0.25rem;"></i><?= __('candidate.view_cv') ?>
                            </a>
                        <?php else: ?>
                            <span style="color: var(--text-muted);"><?= __('candidate.no_cv') ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php if (!empty($application['cover_letter'])): ?>
                <tr>
                    <td style="font-weight: 600; color: var(--text-muted);"><?= __('candidate.cover_letter') ?></td>
                    <td style="white-space: pre-line;"><?= e($application['cover_letter']) ?></td>
                </tr>
                <?php endif; ?>
            </table>

            <div style="display: flex; gap: 0.75rem;">
                <a href="<?= base_url('candidate/edit-application/' . (int)$application['id']) ?>" class="btn btn-primary btn-ripple" style="flex: 1; text-align: center;">
                    <i class="fas fa-edit" style="margin-right: 0.375rem;"></i><?= __('candidate.edit_application') ?>
                </a>
                <a href="<?= base_url('candidate/delete-application/' . (int)$application['id']) ?>" class="btn btn-outline-danger btn-ripple" style="flex: 1; text-align: center;" onclick="return confirm('<?= __('candidate.confirm_delete_app') ?>')">
                    <i class="fas fa-trash" style="margin-right: 0.375rem;"></i><?= __('candidate.delete_application') ?>
                </a>
            </div>
        </div>
    </div>
</div>