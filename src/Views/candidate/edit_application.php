<div class="container" style="padding-top: 1.5rem; padding-bottom: 3rem; max-width: 600px;">
    <h1 class="fade-in-up" style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">
        <?= __('candidate.edit_application') ?>
    </h1>

    <div class="card fade-in-up">
        <div class="card-body">
            <div style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color);">
                <p style="margin: 0 0 0.5rem;">
                    <span style="color: var(--text-muted);"><?= __('candidate.job_title') ?>:</span>
                    <strong><?= e($application['job_title'] ?? '') ?></strong>
                </p>
                <?php if (!empty($application['company_name'])): ?>
                <p style="margin: 0 0 0.5rem;">
                    <span style="color: var(--text-muted);"><?= __('candidate.company') ?>:</span>
                    <span><?= e($application['company_name']) ?></span>
                </p>
                <?php endif; ?>
                <p style="margin: 0;">
                    <span style="color: var(--text-muted);"><?= __('candidate.status') ?>:</span>
                    <?php
                    $status = strtolower($application['status'] ?? 'pending');
                    $status_class = 'status-pending';
                    if ($status === 'reviewed') $status_class = 'status-reviewed';
                    elseif (in_array($status, ['shortlisted', 'interview'])) $status_class = 'status-interview';
                    elseif ($status === 'accepted') $status_class = 'status-accepted';
                    elseif ($status === 'rejected') $status_class = 'status-rejected';
                    ?>
                    <span class="status-badge <?= $status_class ?>">
                        <?= e($application['status'] ?? 'PENDING') ?>
                    </span>
                </p>
            </div>

            <form action="<?= base_url('candidate/edit-application/' . (int)$application['id']) ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div style="margin-bottom: 1.25rem;">
                    <label for="applicant_name" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                        <?= __('candidate.applicant_name') ?>
                    </label>
                    <input type="text" name="applicant_name" id="applicant_name" class="form-control"
                           value="<?= e($application['applicant_name'] ?? '') ?>" required>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <label for="cover_letter" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                        <?= __('candidate.cover_letter') ?>
                    </label>
                    <textarea name="cover_letter" id="cover_letter" class="form-control" rows="5"><?= e($application['cover_letter'] ?? '') ?></textarea>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="cv" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                        <?= __('candidate.upload_new_cv') ?>
                    </label>
                    <?php if (!empty($application['file_path'])): ?>
                        <div style="margin-bottom: 0.5rem; font-size: 0.875rem; color: var(--text-muted);">
                            <?= __('candidate.current_cv') ?>:
                            <a href="<?= upload_url(e($application['file_path'])) ?>" target="_blank"><?= e(basename($application['file_path'])) ?></a>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="cv" id="cv" class="form-control" accept="application/pdf">
                </div>

                <div style="display: flex; gap: 0.75rem;">
                    <button type="submit" class="btn btn-primary btn-ripple" style="flex: 1;">
                        <i class="fas fa-save" style="margin-right: 0.375rem;"></i><?= __('candidate.update_application') ?>
                    </button>
                    <a href="<?= base_url('candidate/profile') ?>" class="btn btn-outline-primary" style="flex: 1; text-align: center;">
                        <?= __('common.cancel') ?>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>