<div class="container" style="padding-top: 1.5rem; padding-bottom: 3rem; max-width: 600px;">
    <h1 class="fade-in-up" style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">
        <?= __('employer.update_application_status') ?>
    </h1>

    <div class="card fade-in-up">
        <div class="card-body">
            <!-- Application Info -->
            <div style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color);">
                <p style="margin: 0 0 0.5rem;">
                    <span style="color: var(--text-muted);"><?= __('employer.job_title') ?>:</span>
                    <strong><?= e($application['job_title'] ?? '') ?></strong>
                </p>
                <p style="margin: 0;">
                    <span style="color: var(--text-muted);"><?= __('employer.current_status') ?>:</span>
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

            <!-- Status Update Form -->
            <form action="<?= base_url('employer/status/' . (int)$application['id']) ?>" method="POST">
                <?= csrf_field() ?>

                <div style="margin-bottom: 1.25rem;">
                    <label for="status" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                        <?= __('employer.new_status') ?>
                    </label>
                    <select name="status" id="status" class="form-control" required>
                        <option value=""><?= __('employer.select_status') ?></option>
                        <?php
                        $statuses = ['PENDING', 'REVIEWED', 'SHORTLISTED', 'INTERVIEW', 'ACCEPTED', 'REJECTED'];
                        foreach ($statuses as $s):
                        ?>
                            <option value="<?= $s ?>" <?= strtoupper($application['status'] ?? '') === $s ? 'selected' : '' ?>>
                                <?= e($s) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="display: flex; gap: 0.75rem;">
                    <button type="submit" class="btn btn-primary btn-ripple" style="flex: 1;">
                        <i class="fas fa-save" style="margin-right: 0.375rem;"></i><?= __('employer.save_status') ?>
                    </button>
                    <a href="<?= base_url('employer/view-cv') ?>" class="btn btn-outline-primary" style="flex: 1; text-align: center;">
                        <?= __('employer.cancel') ?>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
