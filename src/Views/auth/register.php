<div class="auth-split">
    <div class="auth-illustration" style="border-top-right-radius: 0;">
        <div style="max-width: 400px; text-align: center;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" style="width: 200px; height: 200px; margin-bottom: 2rem; opacity: 0.9;">
                <circle cx="100" cy="100" r="80" fill="rgba(255,255,255,0.1)" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                <circle cx="80" cy="75" r="18" fill="rgba(255,255,255,0.15)" stroke="rgba(255,255,255,0.3)" stroke-width="2"/>
                <circle cx="120" cy="75" r="18" fill="rgba(255,255,255,0.15)" stroke="rgba(255,255,255,0.3)" stroke-width="2"/>
                <path d="M60 125 Q60 105 80 105 Q100 105 100 125" fill="rgba(255,255,255,0.15)" stroke="rgba(255,255,255,0.3)" stroke-width="2"/>
                <path d="M100 125 Q100 105 120 105 Q140 105 140 125" fill="rgba(255,255,255,0.15)" stroke="rgba(255,255,255,0.3)" stroke-width="2"/>
                <line x1="150" y1="60" x2="150" y2="90" stroke="rgba(255,255,255,0.5)" stroke-width="3" stroke-linecap="round"/>
                <line x1="135" y1="75" x2="165" y2="75" stroke="rgba(255,255,255,0.5)" stroke-width="3" stroke-linecap="round"/>
            </svg>
            <h2 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.75rem;">
                <?= __('home.cta_candidate') ?>
            </h2>
            <p style="opacity: 0.85; font-size: 1rem; line-height: 1.6;">
                <?= __('home.cta_candidate_desc') ?>
            </p>
        </div>
    </div>
    <div class="auth-form">
        <div class="auth-form-inner">
            <div style="margin-bottom: 2rem;">
                <a href="<?= base_url('/') ?>" style="color: var(--primary); font-weight: 800; font-size: 1.5rem; text-decoration: none;">
                    <svg width="24" height="24" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 4px; vertical-align: -3px;">
                        <rect x="3" y="7" width="22" height="18" rx="3" stroke="currentColor" stroke-width="2" fill="none"/>
                        <path d="M9 7V5C9 3.34 10.34 2 12 2H16C17.66 2 19 3.34 19 5V7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="14" cy="16" r="3" fill="currentColor" opacity="0.3"/>
                        <rect x="8" y="18" width="12" height="2" rx="1" fill="currentColor" opacity="0.2"/>
                    </svg>
                    JobHub
                </a>
            </div>
            <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;"><?= __('auth.register_title') ?></h2>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;"><?= __('home.cta_candidate_desc') ?></p>

            <form action="<?= base_url('register') ?>" method="POST">
                <?= csrf_field() ?>
                <div style="margin-bottom: 1rem;">
                    <label class="form-label" for="name"><?= __('auth.name') ?></label>
                    <input type="text" name="name" id="name" class="form-control" value="<?= e(old('name')) ?>" required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label class="form-label" for="email"><?= __('auth.email') ?></label>
                    <input type="email" name="email" id="email" class="form-control" value="<?= e(old('email')) ?>" required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label class="form-label" for="password"><?= __('auth.password') ?></label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <small class="form-text"><?= __('validation.min_length', [6]) ?></small>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label class="form-label" for="confirm_password"><?= __('auth.confirm_password') ?></label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label class="form-label" for="user_type"><?= __('auth.account_type') ?></label>
                    <select name="user_type" id="user_type" class="form-control">
                        <option value="0"><?= __('auth.job_seeker') ?></option>
                        <option value="1"><?= __('auth.employer') ?></option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-ripple" style="width: 100%; padding: 0.75rem;">
                    <?= __('auth.register_btn') ?>
                </button>
            </form>

            <div style="text-align: center; margin-top: 1.5rem; color: var(--text-muted);">
                <?= __('auth.have_account') ?>
                <a href="<?= base_url('login') ?>" style="margin-left: 0.25rem; font-weight: 600;">
                    <?= __('auth.login_btn') ?>
                </a>
            </div>
        </div>
    </div>
</div>
