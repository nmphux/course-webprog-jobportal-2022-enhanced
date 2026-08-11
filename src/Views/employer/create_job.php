<div class="container" style="padding-top: 1.5rem; padding-bottom: 3rem; max-width: 800px;">
    <h1 class="fade-in-up" style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">
        <?= __('employer.post_new_job') ?>
    </h1>

    <!-- Wizard Steps -->
    <div class="wizard-steps fade-in-up" style="margin-bottom: 2rem;">
        <div class="wizard-step active" data-step="1">
            <span class="wizard-step-number">1</span>
            <span class="wizard-step-label"><?= __('employer.step_company') ?></span>
        </div>
        <div class="wizard-step" data-step="2">
            <span class="wizard-step-number">2</span>
            <span class="wizard-step-label"><?= __('employer.step_details') ?></span>
        </div>
        <div class="wizard-step" data-step="3">
            <span class="wizard-step-number">3</span>
            <span class="wizard-step-label"><?= __('employer.step_requirements') ?></span>
        </div>
        <div class="wizard-step" data-step="4">
            <span class="wizard-step-number">4</span>
            <span class="wizard-step-label"><?= __('employer.step_preview') ?></span>
        </div>
    </div>

    <form action="<?= base_url('employer/create-job') ?>" method="POST" id="create-job-form">
        <?= csrf_field() ?>

        <!-- Step 1: Company -->
        <div class="wizard-panel card fade-in-up" data-step="1">
            <div class="card-header">
                <h2 style="font-size: 1.125rem; font-weight: 600; margin: 0;"><?= __('employer.company_info') ?></h2>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 1rem;">
                    <label for="company_id" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                        <?= __('employer.select_company') ?>
                    </label>
                    <select name="company_id" id="company_id" class="form-control" data-autosave>
                        <option value=""><?= __('employer.choose_company') ?></option>
                        <?php foreach ($companies ?? [] as $co): ?>
                            <option value="<?= (int)$co['id'] ?>" <?= old('company_id') == $co['id'] ? 'selected' : '' ?>>
                                <?= e($co['name'] ?? '') ?>
                            </option>
                        <?php endforeach; ?>
                        <option value="new"><?= __('employer.create_new_company') ?></option>
                    </select>
                </div>

                <!-- New company fields (hidden by default) -->
                <div id="new-company-fields" style="display: none;">
                    <div style="margin-bottom: 1rem;">
                        <label for="company_name" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                            <?= __('employer.company_name') ?>
                        </label>
                        <input type="text" name="company_name" id="company_name" class="form-control"
                               value="<?= e(old('company_name')) ?>" data-autosave>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="company_slogan" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                            <?= __('employer.company_slogan') ?>
                        </label>
                        <input type="text" name="company_slogan" id="company_slogan" class="form-control"
                               value="<?= e(old('company_slogan')) ?>" data-autosave>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="company_city" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                            <?= __('employer.city') ?>
                        </label>
                        <select name="company_city" id="company_city" class="form-control" data-autosave>
                            <option value=""><?= __('employer.select_city') ?></option>
                            <option value="Ho Chi Minh" <?= old('company_city') === 'Ho Chi Minh' ? 'selected' : '' ?>>Ho Chi Minh</option>
                            <option value="Ha Noi" <?= old('company_city') === 'Ha Noi' ? 'selected' : '' ?>>Ha Noi</option>
                            <option value="Da Nang" <?= old('company_city') === 'Da Nang' ? 'selected' : '' ?>>Da Nang</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="company_address" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                            <?= __('employer.address') ?>
                        </label>
                        <input type="text" name="company_address" id="company_address" class="form-control"
                               value="<?= e(old('company_address')) ?>" data-autosave>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Job Details -->
        <div class="wizard-panel card" data-step="2" style="display: none;">
            <div class="card-header">
                <h2 style="font-size: 1.125rem; font-weight: 600; margin: 0;"><?= __('employer.job_details') ?></h2>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 1rem;">
                    <label for="title" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                        <?= __('employer.job_title') ?> <span style="color: var(--danger);">*</span>
                    </label>
                    <input type="text" name="title" id="title" class="form-control" required
                           value="<?= e(old('title')) ?>" data-autosave>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label for="category_id" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                        <?= __('employer.category') ?> <span style="color: var(--danger);">*</span>
                    </label>
                    <select name="category_id" id="category_id" class="form-control" required data-autosave>
                        <option value=""><?= __('employer.select_category') ?></option>
                        <?php foreach ($categories ?? [] as $cat): ?>
                            <option value="<?= (int)$cat['id'] ?>" <?= old('category_id') == $cat['id'] ? 'selected' : '' ?>>
                                <?= e($cat['name'] ?? '') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label for="description" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                        <?= __('employer.description') ?> <span style="color: var(--danger);">*</span>
                    </label>
                    <textarea name="description" id="description" class="form-control" rows="6" required data-autosave><?= e(old('description')) ?></textarea>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label for="requirements" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                        <?= __('employer.requirements') ?>
                    </label>
                    <textarea name="requirements" id="requirements" class="form-control" rows="6" data-autosave><?= e(old('requirements')) ?></textarea>
                </div>
            </div>
        </div>

        <!-- Step 3: Skills & Requirements -->
        <div class="wizard-panel card" data-step="3" style="display: none;">
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
                                                   <?= in_array($skill['id'], (array)old('skills', [])) ? 'checked' : '' ?>>
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
                        <select name="level" id="level" class="form-control" data-autosave>
                            <option value=""><?= __('employer.select_level') ?></option>
                            <?php foreach (['Fresher', 'Junior', 'Middle', 'Senior'] as $lvl): ?>
                                <option value="<?= $lvl ?>" <?= old('level') === $lvl ? 'selected' : '' ?>><?= $lvl ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6" style="margin-bottom: 1rem;">
                        <label for="experience_years" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                            <?= __('employer.experience_years') ?>
                        </label>
                        <input type="number" name="experience_years" id="experience_years" class="form-control"
                               value="<?= e(old('experience_years', '0')) ?>" min="0" max="30" data-autosave>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6" style="margin-bottom: 1rem;">
                        <label for="employment_type" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                            <?= __('employer.employment_type') ?>
                        </label>
                        <select name="employment_type" id="employment_type" class="form-control" data-autosave>
                            <option value=""><?= __('employer.select_type') ?></option>
                            <?php foreach (['Full-time', 'Part-time', 'Remote'] as $type): ?>
                                <option value="<?= $type ?>" <?= old('employment_type') === $type ? 'selected' : '' ?>><?= $type ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6" style="margin-bottom: 1rem;">
                        <label for="salary" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                            <?= __('employer.salary') ?>
                        </label>
                        <select name="salary" id="salary" class="form-control" data-autosave>
                            <option value=""><?= __('employer.select_salary') ?></option>
                            <option value="Under $300" <?= old('salary') === 'Under $300' ? 'selected' : '' ?>>Under $300</option>
                            <option value="$300 - $500" <?= old('salary') === '$300 - $500' ? 'selected' : '' ?>>$300 - $500</option>
                            <option value="$500 - $700" <?= old('salary') === '$500 - $700' ? 'selected' : '' ?>>$500 - $700</option>
                            <option value="$700 - $1000" <?= old('salary') === '$700 - $1000' ? 'selected' : '' ?>>$700 - $1,000</option>
                            <option value="Over $1000" <?= old('salary') === 'Over $1000' ? 'selected' : '' ?>>Over $1,000</option>
                            <option value="Negotiable" <?= old('salary') === 'Negotiable' ? 'selected' : '' ?>><?= __('employer.negotiable') ?></option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label for="interview_rounds" style="display: block; font-weight: 500; margin-bottom: 0.375rem;">
                        <?= __('employer.interview_rounds') ?>
                    </label>
                    <input type="number" name="interview_rounds" id="interview_rounds" class="form-control"
                           value="<?= e(old('interview_rounds', '1')) ?>" min="1" max="10" data-autosave>
                </div>
            </div>
        </div>

        <!-- Step 4: Preview -->
        <div class="wizard-panel card" data-step="4" style="display: none;">
            <div class="card-header">
                <h2 style="font-size: 1.125rem; font-weight: 600; margin: 0;"><?= __('employer.preview') ?></h2>
            </div>
            <div class="card-body">
                <div id="preview-content" style="line-height: 1.7;">
                    <p style="color: var(--text-muted); font-style: italic;"><?= __('employer.preview_desc') ?></p>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="fade-in-up" style="display: flex; justify-content: space-between; margin-top: 1.5rem;">
            <button type="button" id="wizard-prev" class="btn btn-outline-primary" style="display: none;">
                <i class="fas fa-arrow-left" style="margin-right: 0.375rem;"></i><?= __('employer.previous') ?>
            </button>
            <div style="margin-left: auto; display: flex; gap: 0.75rem;">
                <button type="button" id="wizard-next" class="btn btn-primary btn-ripple">
                    <?= __('employer.next') ?> <i class="fas fa-arrow-right" style="margin-left: 0.375rem;"></i>
                </button>
                <button type="submit" id="wizard-submit" class="btn btn-primary btn-lg btn-ripple" style="display: none;">
                    <i class="fas fa-paper-plane" style="margin-right: 0.375rem;"></i><?= __('employer.publish_job') ?>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
(function() {
    var currentStep = 1;
    var totalSteps = 4;
    var form = document.getElementById('create-job-form');
    var storageKey = 'jobportal_create_job';

    function showStep(step) {
        currentStep = step;
        document.querySelectorAll('.wizard-panel').forEach(function(p) {
            p.style.display = p.dataset.step == step ? '' : 'none';
        });
        document.querySelectorAll('.wizard-step').forEach(function(s) {
            var n = parseInt(s.dataset.step);
            s.classList.toggle('active', n === step);
            s.classList.toggle('completed', n < step);
        });
        document.getElementById('wizard-prev').style.display = step > 1 ? '' : 'none';
        document.getElementById('wizard-next').style.display = step < totalSteps ? '' : 'none';
        document.getElementById('wizard-submit').style.display = step === totalSteps ? '' : 'none';

        if (step === totalSteps) buildPreview();
    }

    document.getElementById('wizard-next').addEventListener('click', function() {
        if (currentStep < totalSteps) showStep(currentStep + 1);
    });
    document.getElementById('wizard-prev').addEventListener('click', function() {
        if (currentStep > 1) showStep(currentStep - 1);
    });

    // Toggle new company fields
    var companySelect = document.getElementById('company_id');
    if (companySelect) {
        companySelect.addEventListener('change', function() {
            document.getElementById('new-company-fields').style.display =
                this.value === 'new' ? '' : 'none';
        });
    }

    // Preview builder
    function buildPreview() {
        var el = document.getElementById('preview-content');
        var val = function(n) { var f = form.querySelector('[name="'+n+'"]'); return f ? f.value : ''; };
        var selText = function(n) {
            var f = form.querySelector('[name="'+n+'"]');
            return f && f.selectedIndex >= 0 ? f.options[f.selectedIndex].text : '';
        };
        var skills = [];
        form.querySelectorAll('[name="skills[]"]:checked').forEach(function(cb) {
            skills.push(cb.parentElement.textContent.trim());
        });

        el.innerHTML = '<h3>' + (val('title') || '—') + '</h3>' +
            '<p><strong><?= __("employer.category") ?>:</strong> ' + (selText('category_id') || '—') + '</p>' +
            '<p><strong><?= __("employer.level") ?>:</strong> ' + (val('level') || '—') + '</p>' +
            '<p><strong><?= __("employer.employment_type") ?>:</strong> ' + (val('employment_type') || '—') + '</p>' +
            '<p><strong><?= __("employer.salary") ?>:</strong> ' + (selText('salary') || '—') + '</p>' +
            '<p><strong><?= __("employer.experience_years") ?>:</strong> ' + (val('experience_years') || '0') + '</p>' +
            '<p><strong><?= __("employer.interview_rounds") ?>:</strong> ' + (val('interview_rounds') || '1') + '</p>' +
            (skills.length ? '<p><strong><?= __("employer.skills") ?>:</strong> ' + skills.join(', ') + '</p>' : '') +
            '<hr><p><strong><?= __("employer.description") ?>:</strong></p><div>' + (val('description') || '—').replace(/\n/g, '<br>') + '</div>' +
            (val('requirements') ? '<p><strong><?= __("employer.requirements") ?>:</strong></p><div>' + val('requirements').replace(/\n/g, '<br>') + '</div>' : '');
    }

    // Auto-save to localStorage
    function saveForm() {
        var data = {};
        form.querySelectorAll('[data-autosave]').forEach(function(el) {
            data[el.name] = el.value;
        });
        try { localStorage.setItem(storageKey, JSON.stringify(data)); } catch(e) {}
    }

    function restoreForm() {
        try {
            var saved = JSON.parse(localStorage.getItem(storageKey));
            if (!saved) return;
            Object.keys(saved).forEach(function(name) {
                var el = form.querySelector('[name="'+name+'"]');
                if (el && !el.value) {
                    el.value = saved[name];
                    if (el.name === 'company_id' && el.value === 'new') {
                        document.getElementById('new-company-fields').style.display = '';
                    }
                }
            });
        } catch(e) {}
    }

    form.addEventListener('input', saveForm);
    form.addEventListener('change', saveForm);
    form.addEventListener('submit', function() {
        try { localStorage.removeItem(storageKey); } catch(e) {}
    });

    restoreForm();
    showStep(1);
})();
</script>
