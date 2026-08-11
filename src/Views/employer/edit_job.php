<?php
$job_skills = is_array($job['skills'] ?? null) ? $job['skills'] : array_filter(array_map('trim', explode(',', $job['skills'] ?? '')));
$job_skill_ids = $job['skill_ids'] ?? [];
?>

<div class="container" style="padding-top: 1.5rem; padding-bottom: 3rem; max-width: 800px;">
    <div class="fade-in-up" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0;">
            <?= __('employer.edit_job') ?>
        </h1>
        <a href="<?= base_url('employer/manage') ?>" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-arrow-left" style="margin-right: 0.25rem;"></i><?= __('employer.back_to_manage') ?>
        </a>
    </div>

    <form action="<?= base_url('employer/edit-job/' . (int)$job['id']) ?>" method="POST" id="edit-job-form">
        <?= csrf_field() ?>

        <!-- Company -->
        <div class="card fade-in-up" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <h2 style="font-size: 1.125rem; font-weight: 600; margin: 0;"><?= __('employer.company_info') ?></h2>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 1rem;">
                    <label for="company_id" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                        <?= __('employer.company') ?>
                    </label>
                    <select name="company_id" id="company_id" class="form-control">
                        <?php foreach ($companies ?? [] as $co): ?>
                            <option value="<?= (int)$co['id'] ?>" <?= ($job['company_id'] ?? '') == $co['id'] ? 'selected' : '' ?>>
                                <?= e($co['name'] ?? '') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Job Details -->
        <div class="card fade-in-up" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <h2 style="font-size: 1.125rem; font-weight: 600; margin: 0;"><?= __('employer.job_details') ?></h2>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 1rem;">
                    <label for="title" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                        <?= __('employer.job_title') ?> <span style="color: var(--danger);">*</span>
                    </label>
                    <input type="text" name="title" id="title" class="form-control" required
                           value="<?= e(old('title', $job['title'] ?? '')) ?>">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label for="category_id" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                        <?= __('employer.category') ?> <span style="color: var(--danger);">*</span>
                    </label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        <option value=""><?= __('employer.select_category') ?></option>
                        <?php foreach ($categories ?? [] as $cat): ?>
                            <option value="<?= (int)$cat['id'] ?>" <?= old('category_id', $job['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                <?= e($cat['name'] ?? '') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label for="description" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                        <?= __('employer.description') ?> <span style="color: var(--danger);">*</span>
                    </label>
                    <textarea name="description" id="description" class="form-control" rows="6" required><?= e(old('description', $job['description'] ?? '')) ?></textarea>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label for="requirements" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                        <?= __('employer.requirements') ?>
                    </label>
                    <textarea name="requirements" id="requirements" class="form-control" rows="6"><?= e(old('requirements', $job['requirements'] ?? '')) ?></textarea>
                </div>
            </div>
        </div>

        <!-- Skills & Specs -->
        <div class="card fade-in-up" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <h2 style="font-size: 1.125rem; font-weight: 600; margin: 0;"><?= __('employer.skills_requirements') ?></h2>
            </div>
            <div class="card-body">
                <!-- Skills Multi-select -->
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                        <?= __('employer.skills') ?>
                    </label>
                    <div style="max-height: 250px; overflow-y: auto; border: 1px solid var(--border-color); border-radius: 0.375rem; padding: 0.75rem;">
                        <?php foreach ($skills ?? [] as $group => $group_skills): ?>
                            <div style="margin-bottom: 0.75rem;">
                                <strong style="font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase;"><?= e($group) ?></strong>
                                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.375rem;">
                                    <?php foreach ($group_skills as $skill): ?>
                                        <label style="display: flex; align-items: center; gap: 0.25rem; font-size: 0.875rem; cursor: pointer;">
                                            <input type="checkbox" name="skills[]" value="<?= (int)$skill['id'] ?>"
                                                   <?= in_array($skill['id'], $job_skill_ids) ? 'checked' : '' ?>>
                                            <?= e($skill['name'] ?? '') ?>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6" style="margin-bottom: 1rem;">
                        <label for="level" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                            <?= __('employer.level') ?>
                        </label>
                        <select name="level" id="level" class="form-control">
                            <option value=""><?= __('employer.select_level') ?></option>
                            <?php foreach (['Fresher', 'Junior', 'Middle', 'Senior'] as $lvl): ?>
                                <option value="<?= $lvl ?>" <?= old('level', $job['level'] ?? '') === $lvl ? 'selected' : '' ?>><?= $lvl ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6" style="margin-bottom: 1rem;">
                        <label for="experience_years" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                            <?= __('employer.experience_years') ?>
                        </label>
                        <input type="number" name="experience_years" id="experience_years" class="form-control"
                               value="<?= e(old('experience_years', $job['experience_years'] ?? '0')) ?>" min="0" max="30">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6" style="margin-bottom: 1rem;">
                        <label for="employment_type" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                            <?= __('employer.employment_type') ?>
                        </label>
                        <select name="employment_type" id="employment_type" class="form-control">
                            <option value=""><?= __('employer.select_type') ?></option>
                            <?php foreach (['Full-time', 'Part-time', 'Remote'] as $type): ?>
                                <option value="<?= $type ?>" <?= old('employment_type', $job['employment_type'] ?? '') === $type ? 'selected' : '' ?>><?= $type ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6" style="margin-bottom: 1rem;">
                        <label for="salary" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                            <?= __('employer.salary') ?>
                        </label>
                        <select name="salary" id="salary" class="form-control">
                            <option value=""><?= __('employer.select_salary') ?></option>
                            <?php
                            $salary_opts = ['Under $300', '$300 - $500', '$500 - $700', '$700 - $1000', 'Over $1000', 'Negotiable'];
                            foreach ($salary_opts as $s):
                            ?>
                                <option value="<?= $s ?>" <?= old('salary', $job['salary'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label for="interview_rounds" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                        <?= __('employer.interview_rounds') ?>
                    </label>
                    <input type="number" name="interview_rounds" id="interview_rounds" class="form-control"
                           value="<?= e(old('interview_rounds', $job['interview_rounds'] ?? '1')) ?>" min="1" max="10">
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="fade-in-up" style="display: flex; gap: 0.75rem;">
            <button type="submit" class="btn btn-primary btn-lg btn-ripple" style="flex: 1;">
                <i class="fas fa-save" style="margin-right: 0.375rem;"></i><?= __('employer.update_job') ?>
            </button>
            <a href="<?= base_url('employer/manage') ?>" class="btn btn-outline-primary btn-lg" style="flex: 0 0 auto;">
                <?= __('employer.cancel') ?>
            </a>
        </div>
    </form>
</div>
