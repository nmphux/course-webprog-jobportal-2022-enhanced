<div class="container" style="padding-top: 1.5rem; padding-bottom: 3rem;">
    <h1 class="fade-in-up" style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">
        <?= __('candidate.my_bookmarks') ?>
    </h1>

    <?php if (!empty($bookmarks)): ?>
        <div class="row">
            <?php foreach ($bookmarks as $bm): ?>
                <?php $job = $bm; ?>
                <div class="col-md-6 col-lg-4" style="margin-bottom: 1rem;">
                    <div class="job-card card card-hover fade-in-up" style="position: relative;">
                        <div class="card-body">
                            <div>
                                <div style="display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 0.75rem;">
                                    <?php if (!empty($bm['company_logo'])): ?>
                                        <img src="<?= upload_url(e($bm['company_logo'])) ?>"
                                            alt="<?= e($bm['company_name'] ?? '') ?>"
                                            style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover; flex-shrink: 0;">
                                    <?php else: ?>
                                        <div class="avatar" style="width: 48px; height: 48px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.25rem; flex-shrink: 0; color: var(--text-light); background: var(--bg-surface); ">
                                            <?= strtoupper(substr($bm['company_name'] ?? '?', 0, 1)) ?>
                                        </div>
                                    <?php endif; ?>
                                    <div style="min-width: 0; flex: 1;">
                                        <h3 style="margin: 0 0 0.25rem; font-size: 1rem; font-weight: 600;">
                                            <a href="<?= base_url('jobs/' . (int)$bm['id']) ?>" style="text-decoration: none; color: inherit;">
                                                <?= e($bm['title'] ?? '') ?>
                                            </a>
                                        </h3>
                                        <p style="margin: 0; font-size: 0.875rem; color: var(--text-muted);">
                                            <?= e($bm['company_name'] ?? '') ?>
                                        </p>
                                    </div>
                                </div>
                                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; font-size: 0.8125rem; color: var(--text-muted); margin-bottom: 0.75rem;">
                                    <?php if (!empty($bm['company_city'])): ?>
                                        <span><i class="fas fa-map-marker-alt fa-fw"></i> <?= e($bm['company_city']) ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($bm['level'])): ?>
                                        <span><i class="fas fa-layer-group fa-fw"></i> <?= e($bm['level']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div>
                            <?php if (!empty($bm['salary'])): ?>
                                <div style="font-size: 0.9375rem; font-weight: 600; color: var(--primary); margin-bottom: 0.75rem;">
                                    <?= e($bm['salary']) ?>
                                </div>
                            <?php endif; ?>
                            <form action="<?= base_url('bookmarks/' . (int)$bm['bookmark_id'] . '/delete') ?>" method="POST" style="margin: 0;">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-danger btn-sm btn-ripple" style="width: 100%;">
                                    <i class="fas fa-trash" style="margin-right: 0.375rem;"></i><?= __('candidate.remove_bookmark') ?>
                                </button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state fade-in-up" style="text-align: center; padding: 4rem 2rem;">
            <i class="far fa-bookmark" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
            <h3><?= __('candidate.no_bookmarks_title') ?></h3>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;"><?= __('candidate.no_bookmarks_desc') ?></p>
            <a href="<?= base_url('jobs') ?>" class="btn btn-primary btn-ripple">
                <i class="fas fa-search" style="margin-right: 0.375rem;"></i><?= __('candidate.browse_jobs') ?>
            </a>
        </div>
    <?php endif; ?>
</div>
