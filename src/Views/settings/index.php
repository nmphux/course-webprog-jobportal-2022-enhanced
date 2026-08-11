<div class="container" style="padding-top: 2rem; padding-bottom: 3rem;">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="settings-sidebar">
                <div class="user-info">
                    <?php if (!empty($user['avatar'])): ?>
                        <img src="<?= upload_url($user['avatar']) ?>" class="avatar avatar-lg" alt="" style="margin-bottom: 0.75rem;">
                    <?php else: ?>
                        <div class="avatar-placeholder avatar-lg" style="width: 80px; height: 80px; font-size: 2rem; margin-bottom: 0.75rem;">
                            <?= strtoupper(substr($user['name'], 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                    <strong><?= e($user['name']) ?></strong>
                    <small class="text-muted"><?= e($user['email']) ?></small>
                </div>
                <div class="list-group">
                    <a href="#" data-tabs-id="account-settings" class="list-group-item <?= $tab === 'account' ? 'active' : '' ?>">
                        <i class="fas fa-user fa-fw" style="margin-right: 0.5rem;"></i><?= __('settings.account') ?>
                    </a>
                    <a href="#" data-tabs-id="profile-settings" class="list-group-item <?= $tab === 'profile' ? 'active' : '' ?>">
                        <i class="fas fa-id-card fa-fw" style="margin-right: 0.5rem;"></i><?= __('settings.profile') ?>
                    </a>
                    <a href="#" data-tabs-id="password-settings" class="list-group-item <?= $tab === 'password' ? 'active' : '' ?>">
                        <i class="fas fa-lock fa-fw" style="margin-right: 0.5rem;"></i><?= __('settings.password') ?>
                    </a>
                    <a href="#" data-tabs-id="theme-settings" class="list-group-item <?= $tab === 'theme' ? 'active' : '' ?>">
                        <i class="fas fa-palette fa-fw" style="margin-right: 0.5rem;"></i><?= __('settings.theme') ?>
                    </a>
                    <a href="#" data-tabs-id="language-settings" class="list-group-item <?= $tab === 'language' ? 'active' : '' ?>">
                        <i class="fas fa-globe fa-fw" style="margin-right: 0.5rem;"></i><?= __('settings.language') ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="col-lg-9">

            <!-- Account Tab -->
            <div class="boxinfo account-settings <?= $tab === 'account' ? 'active' : '' ?>" style="<?= $tab !== 'account' ? 'display:none;' : '' ?>">
                <div class="card">
                    <div class="card-header"><?= __('settings.account') ?></div>
                    <div class="card-body">
                        <form action="<?= base_url('settings') ?>" method="POST">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="update-account">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label"><?= __('settings.name') ?></label>
                                    <input type="text" class="form-control" name="name" value="<?= e($user['name']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><?= __('settings.email') ?></label>
                                    <input type="email" class="form-control" value="<?= e($user['email']) ?>" disabled>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><?= __('settings.account_type') ?></label>
                                <input type="text" class="form-control" value="<?= $user['user_type'] == 0 ? __('auth.job_seeker') : __('auth.employer') ?>" disabled>
                            </div>
                            <button type="submit" class="btn btn-primary"><?= __('settings.save') ?></button>
                        </form>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header"><?= __('settings.photo') ?></div>
                    <div class="card-body">
                        <form action="<?= base_url('settings') ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="upload-avatar">
                            <div class="d-flex align-items-center mb-3" style="gap: 1.5rem;">
                                <?php if (!empty($user['avatar'])): ?>
                                    <img src="<?= upload_url($user['avatar']) ?>" class="avatar avatar-xl" alt="">
                                <?php else: ?>
                                    <div class="avatar-placeholder avatar-xl" style="width: 120px; height: 120px; font-size: 3rem;">
                                        <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <input type="file" name="avatar" accept="image/*" class="form-control" style="max-width: 300px;">
                                    <small class="form-text"><?= __('validation.file_too_large', ['5MB']) ?></small>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary"><?= __('settings.upload_photo') ?></button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Profile Tab -->
            <div class="boxinfo profile-settings <?= $tab === 'profile' ? 'active' : '' ?>" style="<?= $tab !== 'profile' ? 'display:none;' : '' ?>">
                <div class="card">
                    <div class="card-header"><?= __('settings.profile') ?></div>
                    <div class="card-body">
                        <form action="<?= base_url('settings') ?>" method="POST">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="update-profile">
                            <div class="mb-3">
                                <label class="form-label"><?= __('settings.headline') ?></label>
                                <input type="text" class="form-control" name="headline" value="<?= e($profile['headline'] ?? '') ?>" placeholder="e.g. Senior Frontend Developer">
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label"><?= __('settings.phone') ?></label>
                                    <input type="text" class="form-control" name="phone" value="<?= e($user['phone'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><?= __('settings.address') ?></label>
                                    <input type="text" class="form-control" name="address" value="<?= e($user['address'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><?= __('settings.about_me') ?></label>
                                <textarea class="form-control" name="about_me" rows="4" placeholder="<?= __('settings.about_me') ?>"><?= e($user['about_me'] ?? '') ?></textarea>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label"><?= __('settings.linkedin') ?></label>
                                    <input type="url" class="form-control" name="linkedin_url" value="<?= e($profile['linkedin_url'] ?? '') ?>" placeholder="https://linkedin.com/in/...">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><?= __('settings.github') ?></label>
                                    <input type="url" class="form-control" name="github_url" value="<?= e($profile['github_url'] ?? '') ?>" placeholder="https://github.com/...">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label"><?= __('settings.portfolio') ?></label>
                                    <input type="url" class="form-control" name="portfolio_url" value="<?= e($profile['portfolio_url'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><?= __('settings.website') ?></label>
                                    <input type="url" class="form-control" name="website_url" value="<?= e($profile['website_url'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><?= __('settings.skills') ?></label>
                                <select name="skills[]" multiple class="form-control" style="height: 200px;">
                                    <?php
                                    $current_cat = '';
                                    foreach ($all_skills as $skill):
                                        if ($skill['category_name'] !== $current_cat):
                                            if ($current_cat !== '') echo '</optgroup>';
                                            $current_cat = $skill['category_name'];
                                    ?>
                                        <optgroup label="<?= e($current_cat) ?>">
                                    <?php endif; ?>
                                        <option value="<?= $skill['id'] ?>" <?= in_array((int)$skill['id'], $user_skill_ids) ? 'selected' : '' ?>><?= e($skill['name']) ?></option>
                                    <?php endforeach; ?>
                                    <?php if ($current_cat !== '') echo '</optgroup>'; ?>
                                </select>
                                <small class="form-text">Hold Ctrl (Cmd on Mac) to select multiple</small>
                            </div>
                            <button type="submit" class="btn btn-primary"><?= __('settings.save') ?></button>
                        </form>
                    </div>
                </div>

                <!-- Education -->
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <?= __('settings.education') ?>
                        <button class="btn btn-sm btn-outline-primary" onclick="document.getElementById('add-education-form').style.display = document.getElementById('add-education-form').style.display === 'none' ? 'block' : 'none'">
                            <i class="fas fa-plus"></i> <?= __('settings.add') ?>
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="add-education-form" style="display: none; margin-bottom: 1.5rem; padding: 1rem; background: var(--bg-surface); border-radius: var(--radius-sm);">
                            <form action="<?= base_url('settings') ?>" method="POST">
                                <?= csrf_field() ?>
                                <input type="hidden" name="action" value="add-education">
                                <div class="row mb-2">
                                    <div class="col-md-6"><input type="text" class="form-control" name="school_name" placeholder="School Name" required></div>
                                    <div class="col-md-6"><input type="text" class="form-control" name="degree" placeholder="Degree"></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4"><input type="text" class="form-control" name="field_of_study" placeholder="Field of Study"></div>
                                    <div class="col-md-4"><input type="date" class="form-control" name="start_date"></div>
                                    <div class="col-md-4"><input type="date" class="form-control" name="end_date"></div>
                                </div>
                                <textarea class="form-control mb-2" name="description" rows="2" placeholder="Description"></textarea>
                                <button type="submit" class="btn btn-primary btn-sm"><?= __('settings.save') ?></button>
                            </form>
                        </div>
                        <?php if (empty($education)): ?>
                            <p class="text-muted"><?= __('common.no_results') ?></p>
                        <?php else: ?>
                            <?php foreach ($education as $edu): ?>
                                <div style="border-bottom: 1px solid var(--border); padding: 0.75rem 0; display: flex; justify-content: space-between; align-items: start;">
                                    <div>
                                        <strong><?= e($edu['school_name']) ?></strong>
                                        <?php if (!empty($edu['degree'])): ?><span class="text-muted"> — <?= e($edu['degree']) ?></span><?php endif; ?>
                                        <?php if (!empty($edu['field_of_study'])): ?><br><small class="text-muted"><?= e($edu['field_of_study']) ?></small><?php endif; ?>
                                        <?php if (!empty($edu['start_date'])): ?>
                                            <br><small class="text-muted"><?= e($edu['start_date']) ?> — <?= e($edu['end_date'] ?? 'Present') ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <form action="<?= base_url('settings') ?>" method="POST" style="display:inline;">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="action" value="delete-education">
                                        <input type="hidden" name="id" value="<?= $edu['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-secondary" data-confirm="<?= __('common.confirm') ?>"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Experience -->
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <?= __('settings.experience') ?>
                        <button class="btn btn-sm btn-outline-primary" onclick="document.getElementById('add-experience-form').style.display = document.getElementById('add-experience-form').style.display === 'none' ? 'block' : 'none'">
                            <i class="fas fa-plus"></i> <?= __('settings.add') ?>
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="add-experience-form" style="display: none; margin-bottom: 1.5rem; padding: 1rem; background: var(--bg-surface); border-radius: var(--radius-sm);">
                            <form action="<?= base_url('settings') ?>" method="POST">
                                <?= csrf_field() ?>
                                <input type="hidden" name="action" value="add-experience">
                                <div class="row mb-2">
                                    <div class="col-md-6"><input type="text" class="form-control" name="job_title" placeholder="Job Title" required></div>
                                    <div class="col-md-6"><input type="text" class="form-control" name="company_name" placeholder="Company Name" required></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4"><input type="date" class="form-control" name="start_date"></div>
                                    <div class="col-md-4"><input type="date" class="form-control" name="end_date"></div>
                                    <div class="col-md-4"><label style="padding-top: 0.5rem;"><input type="checkbox" name="is_current" value="1"> Currently working here</label></div>
                                </div>
                                <textarea class="form-control mb-2" name="description" rows="2" placeholder="Description"></textarea>
                                <button type="submit" class="btn btn-primary btn-sm"><?= __('settings.save') ?></button>
                            </form>
                        </div>
                        <?php if (empty($experience)): ?>
                            <p class="text-muted"><?= __('common.no_results') ?></p>
                        <?php else: ?>
                            <?php foreach ($experience as $exp): ?>
                                <div style="border-bottom: 1px solid var(--border); padding: 0.75rem 0; display: flex; justify-content: space-between; align-items: start;">
                                    <div>
                                        <strong><?= e($exp['job_title']) ?></strong> <span class="text-muted">at <?= e($exp['company_name']) ?></span>
                                        <?php if (!empty($exp['start_date'])): ?>
                                            <br><small class="text-muted"><?= e($exp['start_date']) ?> — <?= $exp['is_current'] ? 'Present' : e($exp['end_date'] ?? '') ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <form action="<?= base_url('settings') ?>" method="POST" style="display:inline;">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="action" value="delete-experience">
                                        <input type="hidden" name="id" value="<?= $exp['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-secondary" data-confirm="<?= __('common.confirm') ?>"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Certifications -->
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <?= __('settings.certifications') ?>
                        <button class="btn btn-sm btn-outline-primary" onclick="document.getElementById('add-cert-form').style.display = document.getElementById('add-cert-form').style.display === 'none' ? 'block' : 'none'">
                            <i class="fas fa-plus"></i> <?= __('settings.add') ?>
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="add-cert-form" style="display: none; margin-bottom: 1.5rem; padding: 1rem; background: var(--bg-surface); border-radius: var(--radius-sm);">
                            <form action="<?= base_url('settings') ?>" method="POST">
                                <?= csrf_field() ?>
                                <input type="hidden" name="action" value="add-certification">
                                <div class="row mb-2">
                                    <div class="col-md-6"><input type="text" class="form-control" name="name" placeholder="Certification Name" required></div>
                                    <div class="col-md-6"><input type="text" class="form-control" name="issuing_org" placeholder="Issuing Organization"></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4"><input type="date" class="form-control" name="issue_date"></div>
                                    <div class="col-md-4"><input type="date" class="form-control" name="expiry_date"></div>
                                    <div class="col-md-4"><input type="url" class="form-control" name="credential_url" placeholder="Credential URL"></div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm"><?= __('settings.save') ?></button>
                            </form>
                        </div>
                        <?php if (empty($certifications)): ?>
                            <p class="text-muted"><?= __('common.no_results') ?></p>
                        <?php else: ?>
                            <?php foreach ($certifications as $cert): ?>
                                <div style="border-bottom: 1px solid var(--border); padding: 0.75rem 0; display: flex; justify-content: space-between; align-items: start;">
                                    <div>
                                        <strong><?= e($cert['name']) ?></strong>
                                        <?php if (!empty($cert['issuing_org'])): ?><span class="text-muted"> — <?= e($cert['issuing_org']) ?></span><?php endif; ?>
                                        <?php if (!empty($cert['issue_date'])): ?>
                                            <br><small class="text-muted"><?= e($cert['issue_date']) ?><?php if (!empty($cert['expiry_date'])): ?> — <?= e($cert['expiry_date']) ?><?php endif; ?></small>
                                        <?php endif; ?>
                                        <?php if (!empty($cert['credential_url'])): ?>
                                            <br><small><a href="<?= e($cert['credential_url']) ?>" target="_blank">View Credential</a></small>
                                        <?php endif; ?>
                                    </div>
                                    <form action="<?= base_url('settings') ?>" method="POST" style="display:inline;">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="action" value="delete-certification">
                                        <input type="hidden" name="id" value="<?= $cert['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-secondary" data-confirm="<?= __('common.confirm') ?>"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Password Tab -->
            <div class="boxinfo password-settings <?= $tab === 'password' ? 'active' : '' ?>" style="<?= $tab !== 'password' ? 'display:none;' : '' ?>">
                <div class="card">
                    <div class="card-header"><?= __('settings.change_password') ?></div>
                    <div class="card-body">
                        <form action="<?= base_url('settings') ?>" method="POST" style="max-width: 480px;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="change-password">
                            <div class="mb-3">
                                <label class="form-label"><?= __('settings.current_password') ?></label>
                                <input type="password" class="form-control" name="oldpassword" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><?= __('settings.new_password') ?></label>
                                <input type="password" class="form-control" name="newpassword" required>
                                <small class="form-text"><?= __('validation.min_length', [6]) ?></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><?= __('settings.confirm_password') ?></label>
                                <input type="password" class="form-control" name="confpassword" required>
                            </div>
                            <button type="submit" class="btn btn-primary"><?= __('settings.change_password') ?></button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Theme Tab -->
            <div class="boxinfo theme-settings <?= $tab === 'theme' ? 'active' : '' ?>" style="<?= $tab !== 'theme' ? 'display:none;' : '' ?>">
                <div class="card">
                    <div class="card-header"><?= __('settings.theme') ?></div>
                    <div class="card-body">
                        <p class="text-muted" style="margin-bottom: 1.5rem;"><?= __('settings.theme_desc') ?></p>
                        <div class="row">
                            <div class="col-6 col-md-3 mb-3">
                                <div class="theme-card card-hover" data-theme-name="dawn" onclick="selectTheme('dawn')" style="cursor:pointer; border-radius: var(--radius-md); overflow:hidden; border:2px solid var(--border); transition: all 0.2s;">
                                    <div style="height:60px; background:#FFF7ED; display:flex; align-items:center; justify-content:center; gap:8px;">
                                        <span style="width:20px;height:20px;border-radius:50%;background:#EA580C;display:inline-block;"></span>
                                        <span style="width:20px;height:20px;border-radius:50%;background:#F43F5E;display:inline-block;"></span>
                                    </div>
                                    <div style="padding:10px; text-align:center; background:var(--bg-surface);">
                                        <strong style="font-size: 0.875rem;">Dawn</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mb-3">
                                <div class="theme-card card-hover" data-theme-name="noon" onclick="selectTheme('noon')" style="cursor:pointer; border-radius: var(--radius-md); overflow:hidden; border:2px solid var(--border); transition: all 0.2s;">
                                    <div style="height:60px; background:#F8FAFC; display:flex; align-items:center; justify-content:center; gap:8px;">
                                        <span style="width:20px;height:20px;border-radius:50%;background:#2563EB;display:inline-block;"></span>
                                        <span style="width:20px;height:20px;border-radius:50%;background:#3B82F6;display:inline-block;"></span>
                                    </div>
                                    <div style="padding:10px; text-align:center; background:var(--bg-surface);">
                                        <strong style="font-size: 0.875rem;">Noon</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mb-3">
                                <div class="theme-card card-hover" data-theme-name="dusk" onclick="selectTheme('dusk')" style="cursor:pointer; border-radius: var(--radius-md); overflow:hidden; border:2px solid var(--border); transition: all 0.2s;">
                                    <div style="height:60px; background:#1E1B4B; display:flex; align-items:center; justify-content:center; gap:8px;">
                                        <span style="width:20px;height:20px;border-radius:50%;background:#D97706;display:inline-block;"></span>
                                        <span style="width:20px;height:20px;border-radius:50%;background:#9333EA;display:inline-block;"></span>
                                    </div>
                                    <div style="padding:10px; text-align:center; background:var(--bg-surface);">
                                        <strong style="font-size: 0.875rem;">Dusk</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mb-3">
                                <div class="theme-card card-hover" data-theme-name="night" onclick="selectTheme('night')" style="cursor:pointer; border-radius: var(--radius-md); overflow:hidden; border:2px solid var(--border); transition: all 0.2s;">
                                    <div style="height:60px; background:#0F172A; display:flex; align-items:center; justify-content:center; gap:8px;">
                                        <span style="width:20px;height:20px;border-radius:50%;background:#38BDF8;display:inline-block;"></span>
                                        <span style="width:20px;height:20px;border-radius:50%;background:#818CF8;display:inline-block;"></span>
                                    </div>
                                    <div style="padding:10px; text-align:center; background:var(--bg-surface);">
                                        <strong style="font-size: 0.875rem;">Night</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Language Tab -->
            <div class="boxinfo language-settings <?= $tab === 'language' ? 'active' : '' ?>" style="<?= $tab !== 'language' ? 'display:none;' : '' ?>">
                <div class="card">
                    <div class="card-header"><?= __('settings.language') ?></div>
                    <div class="card-body">
                        <p class="text-muted" style="margin-bottom: 1.5rem;"><?= __('settings.language_desc') ?></p>
                        <form action="<?= base_url('settings') ?>" method="POST">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="update-language">
                            <?php
                            $langs = [
                                'en' => ['flag' => '🇺🇸', 'name' => 'English'],
                                'vi' => ['flag' => '🇻🇳', 'name' => 'Tiếng Việt'],
                            ];
                            foreach ($langs as $code => $lang): ?>
                                <label style="display:flex; align-items:center; gap:12px; cursor:pointer; padding:12px; border:2px solid <?= ($user['language'] ?? 'en') === $code ? 'var(--primary)' : 'var(--border)' ?>; border-radius: var(--radius-md); margin-bottom:12px; transition: border-color 0.2s;">
                                    <input type="radio" name="language" value="<?= $code ?>" <?= ($user['language'] ?? 'en') === $code ? 'checked' : '' ?>
                                           onchange="this.closest('form').querySelectorAll('label').forEach(l=>l.style.borderColor='var(--border)');this.closest('label').style.borderColor='var(--primary)';">
                                    <span style="font-size:24px;"><?= $lang['flag'] ?></span>
                                    <strong><?= $lang['name'] ?></strong>
                                </label>
                            <?php endforeach; ?>
                            <button type="submit" class="btn btn-primary" style="margin-top: 0.5rem;"><?= __('settings.save_language') ?></button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function selectTheme(name) {
    setTheme(name);
    highlightActiveTheme();
}
function highlightActiveTheme() {
    var current = localStorage.getItem('theme') || 'noon';
    document.querySelectorAll('.theme-card').forEach(function(card) {
        if (card.getAttribute('data-theme-name') === current) {
            card.style.borderColor = 'var(--primary)';
            card.style.boxShadow = '0 0 0 2px var(--primary-focus-shadow)';
        } else {
            card.style.borderColor = 'var(--border)';
            card.style.boxShadow = 'none';
        }
    });
}
highlightActiveTheme();
</script>
