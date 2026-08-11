<!-- Hero Section -->
<section class="hero" style="text-align: center; background: var(--gradient-hero); position: relative;">
    <div style="position: absolute; inset: 0; background: var(--gradient-glow); pointer-events: none;"></div>
    <div class="container" style="position: relative; z-index: 1;">
        <h1 class="fade-in-up" style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.75rem;">
            <?= __('home.hero_title') ?>
        </h1>
        <p class="fade-in-up" style="font-size: 1.125rem; color: var(--text-muted); margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
            <?= __('home.hero_subtitle') ?>
        </p>

        <form action="<?= base_url('jobs') ?>" method="GET" class="search-bar fade-in-up" style="max-width: 640px; margin: 0 auto 2.5rem;">
            <div>
                <input type="text" name="q" class="form-control" placeholder="<?= __('home.search_placeholder') ?>" style="min-width: 100px; border-radius: var(--radius-lg) 0 0 var(--radius-lg); border-right: none;">
            </div>
            <button type="submit" class="btn btn-primary btn-ripple" style="border-radius: 0 var(--radius-lg) var(--radius-lg) 0; padding-left: 1.5rem; padding-right: 1.5rem;">
                <i class="fas fa-search" style="margin-right: 0.375rem;"></i>
                <span class="d-none d-sm-inline fade-in-up" style="transition-delay: 0.1s;">
                    <?= __('home.search_button') ?>
                </span>
            </button>
        </form>

        <?php if (!empty($stats)): ?>
            <div class="fade-in-up" style="display: flex; justify-content: center; gap: 3rem; flex-wrap: wrap;">
                <div>
                    <div style="font-size: 2rem; font-weight: 700; color: var(--primary);"><?= number_format($stats['total_jobs'] ?? 0) ?></div>
                    <div style="font-size: 0.875rem; color: var(--text-muted);"><?= __('home.stat_jobs') ?></div>
                </div>
                <div>
                    <div style="font-size: 2rem; font-weight: 700; color: var(--primary);"><?= number_format($stats['total_companies'] ?? 0) ?></div>
                    <div style="font-size: 0.875rem; color: var(--text-muted);"><?= __('home.stat_companies') ?></div>
                </div>
                <div>
                    <div style="font-size: 2rem; font-weight: 700; color: var(--primary);"><?= number_format($stats['total_candidates'] ?? 0) ?></div>
                    <div style="font-size: 0.875rem; color: var(--text-muted);"><?= __('home.stat_candidates') ?></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Browse by Category -->
<?php if (!empty($categories)): ?>
<section class="fade-in-up" style="padding: 3rem 0;">
    <div class="container">
        <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;"><?= __('home.browse_categories') ?></h2>
        <div class="row">
            <?php foreach (array_slice($categories, 0, 14) as $cat): ?>
                <div class="col-6 col-md-4 col-lg-3" style="margin-bottom: 1rem;">
                    <a href="<?= base_url('jobs?category=' . (int)$cat['id']) ?>" style="text-decoration: none;">
                        <div class="category-card card card-hover">
                            <div class="card-body" style="text-align: center; padding: 1.25rem;">
                                <h3 style="font-size: 0.9375rem; font-weight: 600; margin: 0 0 0.25rem; color: inherit;">
                                    <?= e($cat['name'] ?? '') ?>
                                </h3>
                                <span style="font-size: 0.8125rem; color: var(--text-muted);">
                                    <?= __('home.job_count', [(int)($cat['job_count'] ?? 0)]) ?>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Featured Jobs -->
<?php if (!empty($recent_jobs)): ?>
<section class="fade-in-up" style="padding: 3rem 0; background: var(--bg-surface-alt);">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0;"><?= __('home.featured_jobs') ?></h2>
            <a href="<?= base_url('jobs') ?>" class="btn btn-outline-primary btn-sm">
                <?= __('home.view_all_jobs') ?> <i class="fas fa-arrow-right" style="margin-left: 0.25rem;"></i>
            </a>
        </div>
        <div class="row">
            <?php foreach (array_slice($recent_jobs, 0, 6) as $job): ?>
                <div class="col-md-6" style="margin-bottom: 1rem;">
                    <?php include __DIR__ . '/../partials/job-card.php'; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Featured Employers -->
<?php if (!empty($featured_companies)): ?>
<section class="fade-in-up" style="padding: 3rem 0;">
    <div class="container">
        <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;"><?= __('home.featured_employers') ?></h2>
        <div class="row">
            <?php foreach ($featured_companies as $company): ?>
                <div class="col-6 col-md-4 col-lg-3" style="margin-bottom: 1rem;">
                    <div class="company-card card card-hover">
                        <div class="card-body" style="text-align: center; padding: 1.5rem;">
                            <?php if (!empty($company['logo'])): ?>
                                <img src="<?= upload_url(e($company['logo'])) ?>"
                                     alt="<?= e($company['name'] ?? '') ?>"
                                     style="width: 64px; height: 64px; border-radius: 12px; object-fit: cover; margin-bottom: 0.75rem;">
                            <?php else: ?>
                                <div class="avatar" style="width: 64px; height: 64px; border-radius: 12px; margin: 0 auto 0.75rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 700;">
                                    <?= strtoupper(substr($company['name'] ?? '?', 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                            <h3 style="font-size: 0.9375rem; font-weight: 600; margin: 0 0 0.25rem;">
                                <?= e($company['name'] ?? '') ?>
                            </h3>
                            <?php if (!empty($company['city'])): ?>
                                <p style="font-size: 0.8125rem; color: var(--text-muted); margin: 0 0 0.25rem;">
                                    <i class="fas fa-map-marker-alt"></i> <?= e($company['city']) ?>
                                </p>
                            <?php endif; ?>
                            <span style="font-size: 0.8125rem; color: var(--text-muted);">
                                <?= __('home.job_count', [(int)($company['job_count'] ?? 0)]) ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA Section -->
<section class="fade-in-up" style="padding: 3rem 0; background: var(--bg-surface-alt);">
    <div class="container">
        <div class="row">
            <div class="col-md-6" style="margin-bottom: 1rem;">
                <div class="card card-hover">
                    <div class="card-body" style="padding: 2rem; text-align: center;">
                        <i class="fas fa-building" style="font-size: 2rem; color: var(--primary); margin-bottom: 1rem;"></i>
                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;"><?= __('home.cta_employer_title') ?></h3>
                        <p style="color: var(--text-muted); margin-bottom: 1.25rem;"><?= __('home.cta_employer_desc') ?></p>
                        <a href="<?= base_url('employer/create-job') ?>" class="btn btn-primary btn-ripple"><?= __('home.cta_employer_button') ?></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6" style="margin-bottom: 1rem;">
                <div class="card card-hover">
                    <div class="card-body" style="padding: 2rem; text-align: center;">
                        <i class="fas fa-user-tie" style="font-size: 2rem; color: var(--primary); margin-bottom: 1rem;"></i>
                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;"><?= __('home.cta_candidate_title') ?></h3>
                        <p style="color: var(--text-muted); margin-bottom: 1.25rem;"><?= __('home.cta_candidate_desc') ?></p>
                        <a href="<?= base_url('candidate/create-cv') ?>" class="btn btn-outline-primary btn-ripple"><?= __('home.cta_candidate_button') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
