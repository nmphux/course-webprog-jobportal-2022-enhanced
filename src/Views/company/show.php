<div class="container" style="padding-top: 1.5rem; padding-bottom: 3rem;">
    <!-- Company Header -->
    <div class="card fade-in-up" style="margin-bottom: 2rem;">
        <div class="card-body" style="padding: 2rem;">
            <div style="display: flex; align-items: flex-start; gap: 1.5rem; flex-wrap: wrap;">
                <?php if (!empty($company['logo'])): ?>
                    <img src="<?= upload_url(e($company['logo'])) ?>"
                         alt="<?= e($company['name'] ?? '') ?>"
                         style="width: 96px; height: 96px; border-radius: 16px; object-fit: cover; flex-shrink: 0;">
                <?php else: ?>
                    <div class="avatar" style="width: 96px; height: 96px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 700; flex-shrink: 0;">
                        <?= strtoupper(substr($company['name'] ?? '?', 0, 1)) ?>
                    </div>
                <?php endif; ?>

                <div style="flex: 1; min-width: 200px;">
                    <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0 0 0.25rem;">
                        <?= e($company['name'] ?? '') ?>
                    </h1>
                    <?php if (!empty($company['slogan'])): ?>
                        <p style="font-size: 1rem; color: var(--text-muted); margin: 0 0 0.75rem; font-style: italic;">
                            <?= e($company['slogan']) ?>
                        </p>
                    <?php endif; ?>

                    <div style="display: flex; flex-wrap: wrap; gap: 1.25rem; font-size: 0.875rem; color: var(--text-muted);">
                        <?php if (!empty($company['city'])): ?>
                            <span><i class="fas fa-map-marker-alt fa-fw" style="margin-right: 0.25rem;"></i><?= e($company['city']) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($company['company_size'])): ?>
                            <span><i class="fas fa-users fa-fw" style="margin-right: 0.25rem;"></i><?= e($company['company_size']) ?> <?= __('company.employees') ?></span>
                        <?php endif; ?>
                        <?php if (!empty($company['founded_year'])): ?>
                            <span><i class="fas fa-calendar fa-fw" style="margin-right: 0.25rem;"></i><?= __('company.founded') ?> <?= e($company['founded_year']) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($company['website'])): ?>
                            <a href="<?= e($company['website']) ?>" target="_blank" rel="noopener noreferrer" style="text-decoration: none;">
                                <i class="fas fa-globe fa-fw" style="margin-right: 0.25rem;"></i><?= __('company.website') ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About -->
    <?php if (!empty($company['about'])): ?>
    <div class="card fade-in-up" style="margin-bottom: 2rem;">
        <div class="card-header">
            <h2 style="font-size: 1.125rem; font-weight: 600; margin: 0;"><?= __('company.about') ?></h2>
        </div>
        <div class="card-body">
            <div style="line-height: 1.7; font-size: 0.9375rem;">
                <?= $company['about'] ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Published Jobs -->
    <section class="fade-in-up">
        <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem;">
            <?= __('company.open_positions') ?>
            <?php if (!empty($jobs)): ?>
                <span class="badge-info" style="font-size: 0.8125rem; vertical-align: middle;"><?= count($jobs) ?></span>
            <?php endif; ?>
        </h2>

        <?php if (!empty($jobs)): ?>
            <div class="row">
                <?php foreach ($jobs as $job): ?>
                    <div class="col-md-6" style="margin-bottom: 1rem;">
                        <?php include __DIR__ . '/../partials/job-card.php'; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state" style="text-align: center; padding: 3rem;">
                <i class="fas fa-briefcase" style="font-size: 2rem; color: var(--text-muted); margin-bottom: 0.75rem;"></i>
                <p style="color: var(--text-muted);"><?= __('company.no_open_positions') ?></p>
            </div>
        <?php endif; ?>
    </section>
</div>
