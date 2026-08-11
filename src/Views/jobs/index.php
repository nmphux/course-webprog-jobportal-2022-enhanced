<?php
$f = $filters ?? [];
$jobs_data = $jobs['data'] ?? [];
$total = $jobs['total'] ?? 0;
$current_page = $jobs['page'] ?? 1;
$total_pages = $jobs['total_pages'] ?? 1;
?>

<div class="container" style="padding-top: 1.5rem; padding-bottom: 3rem;">
    <!-- Search Bar -->
    <form action="<?= base_url('jobs') ?>" method="GET" class="search-bar fade-in-up" style="margin-bottom: 2rem;">
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <input type="text" name="q" class="form-control"
                   value="<?= e($f['q'] ?? '') ?>"
                   placeholder="<?= __('jobs.search_placeholder') ?>"
                   style="flex: 1; min-width: 200px;">
            <button type="submit" class="btn btn-primary btn-ripple">
                <i class="fas fa-search" style="margin-right: 0.375rem;"></i><?= __('jobs.search') ?>
            </button>
        </div>
    </form>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3" style="margin-bottom: 1.5rem;">
            <form action="<?= base_url('jobs') ?>" method="GET" class="filter-panel card fade-in-up">
                <div class="card-body">
                    <!-- Preserve keyword -->
                    <?php if (!empty($f['q'])): ?>
                        <input type="hidden" name="q" value="<?= e($f['q']) ?>">
                    <?php endif; ?>

                    <!-- Category -->
                    <h4 style="font-size: 0.875rem; font-weight: 600; margin-bottom: 0.75rem;"><?= __('jobs.category') ?></h4>
                    <div style="max-height: 200px; overflow-y: auto; margin-bottom: 1.25rem;">
                        <?php foreach ($categories ?? [] as $cat): ?>
                            <div class="form-check" style="margin-bottom: 0.25rem;">
                                <input class="form-check-input" type="checkbox" name="category[]"
                                       value="<?= (int)$cat['id'] ?>"
                                       id="cat-<?= (int)$cat['id'] ?>"
                                       <?= in_array($cat['id'], (array)($f['category'] ?? [])) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="cat-<?= (int)$cat['id'] ?>" style="font-size: 0.8125rem;">
                                    <?= e($cat['name'] ?? '') ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- City -->
                    <h4 style="font-size: 0.875rem; font-weight: 600; margin-bottom: 0.75rem;"><?= __('jobs.location') ?></h4>
                    <select name="city" class="form-control form-control-sm" style="margin-bottom: 1.25rem;">
                        <option value=""><?= __('jobs.all_cities') ?></option>
                        <option value="Ho Chi Minh" <?= ($f['city'] ?? '') === 'Ho Chi Minh' ? 'selected' : '' ?>><?= __('jobs.city_hcm') ?></option>
                        <option value="Ha Noi" <?= ($f['city'] ?? '') === 'Ha Noi' ? 'selected' : '' ?>><?= __('jobs.city_hn') ?></option>
                        <option value="Da Nang" <?= ($f['city'] ?? '') === 'Da Nang' ? 'selected' : '' ?>><?= __('jobs.city_dn') ?></option>
                    </select>

                    <!-- Level -->
                    <h4 style="font-size: 0.875rem; font-weight: 600; margin-bottom: 0.75rem;"><?= __('jobs.filter_level') ?></h4>
                    <select name="level" class="form-control form-control-sm" style="margin-bottom: 1.25rem;">
                        <option value=""><?= __('jobs.all_levels') ?></option>
                        <?php foreach (['Fresher', 'Junior', 'Middle', 'Senior'] as $lvl): ?>
                            <option value="<?= $lvl ?>" <?= ($f['level'] ?? '') === $lvl ? 'selected' : '' ?>><?= $lvl ?></option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Employment Type -->
                    <h4 style="font-size: 0.875rem; font-weight: 600; margin-bottom: 0.75rem;"><?= __('jobs.filter_type') ?></h4>
                    <select name="type" class="form-control form-control-sm" style="margin-bottom: 1.25rem;">
                        <option value=""><?= __('jobs.all_types') ?></option>
                        <?php foreach (['Full-time', 'Part-time', 'Remote'] as $type): ?>
                            <option value="<?= $type ?>" <?= ($f['type'] ?? '') === $type ? 'selected' : '' ?>><?= $type ?></option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" class="btn btn-primary btn-sm btn-ripple" style="width: 100%;">
                        <?= __('jobs.apply_filters') ?>
                    </button>
                </div>
            </form>
        </div>

        <!-- Job Listings -->
        <div class="col-lg-9">
            <!-- Results header -->
            <div class="fade-in-up" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
                <p style="margin: 0; font-size: 0.875rem; color: var(--text-muted);">
                    <?= __('jobs.result_count', [(int)$total]) ?>
                </p>
                <form action="<?= base_url('jobs') ?>" method="GET" style="display: flex; align-items: center; gap: 0.5rem;">
                    <!-- Carry filters forward -->
                    <?php if (!empty($f['q'])): ?><input type="hidden" name="q" value="<?= e($f['q']) ?>"><?php endif; ?>
                    <?php if (!empty($f['city'])): ?><input type="hidden" name="city" value="<?= e($f['city']) ?>"><?php endif; ?>
                    <?php if (!empty($f['level'])): ?><input type="hidden" name="level" value="<?= e($f['level']) ?>"><?php endif; ?>
                    <?php if (!empty($f['type'])): ?><input type="hidden" name="type" value="<?= e($f['type']) ?>"><?php endif; ?>
                    <?php foreach ((array)($f['category'] ?? []) as $cid): ?>
                        <input type="hidden" name="category[]" value="<?= (int)$cid ?>">
                    <?php endforeach; ?>

                    <label for="sort" style="font-size: 0.8125rem; white-space: nowrap; margin: 0;"><?= __('jobs.sort_by') ?></label>
                    <select name="sort" id="sort" class="form-control form-control-sm" style="width: auto;" onchange="this.form.submit()">
                        <option value="newest" <?= ($f['sort'] ?? '') === 'newest' ? 'selected' : '' ?>><?= __('jobs.newest') ?></option>
                        <option value="salary_desc" <?= ($f['sort'] ?? '') === 'salary_desc' ? 'selected' : '' ?>><?= __('jobs.salary') ?></option>
                    </select>
                </form>
            </div>

            <?php if (!empty($jobs_data)): ?>
                <div class="row">
                    <?php foreach ($jobs_data as $job): ?>
                        <div class="col-md-6" style="margin-bottom: 1rem;">
                            <?php include __DIR__ . '/../partials/job-card.php'; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php
                $pagination = [
                    'page' => $current_page,
                    'total_pages' => $total_pages,
                    'base_url' => base_url('jobs'),
                ];
                include __DIR__ . '/../partials/pagination.php';
                ?>
            <?php else: ?>
                <div class="empty-state fade-in-up" style="text-align: center; padding: 3rem;">
                    <i class="fas fa-search" style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
                    <h3><?= __('jobs.no_results_title') ?></h3>
                    <p style="color: var(--text-muted);"><?= __('jobs.no_results_desc') ?></p>
                    <a href="<?= base_url('jobs') ?>" class="btn btn-outline-primary"><?= __('jobs.clear_filters') ?></a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
