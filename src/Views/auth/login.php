<div class="auth-split">
    <div class="auth-illustration">
        <div class="text-center px-4">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" style="width: 160px; height: 160px; margin-bottom: 1.5rem; opacity: 0.9;">
                <circle cx="100" cy="100" r="80" fill="rgba(255,255,255,0.1)" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                <rect x="65" y="55" width="70" height="90" rx="8" fill="rgba(255,255,255,0.15)" stroke="rgba(255,255,255,0.3)" stroke-width="2"/>
                <circle cx="100" cy="82" r="15" fill="rgba(255,255,255,0.2)" stroke="rgba(255,255,255,0.4)" stroke-width="2"/>
                <rect x="80" y="105" width="40" height="6" rx="3" fill="rgba(255,255,255,0.3)"/>
                <rect x="75" y="117" width="50" height="4" rx="2" fill="rgba(255,255,255,0.2)"/>
                <rect x="75" y="126" width="50" height="4" rx="2" fill="rgba(255,255,255,0.2)"/>
            </svg>
            <h2 class="h3 fw-bold mb-2" style="font-size: 1.5rem;">
                <?= __('home.hero_title') ?>
            </h2>
            <p style="opacity: 0.85; font-size: 0.9375rem; line-height: 1.6; max-width: 320px; margin: 0 auto;">
                <?= __('home.hero_subtitle') ?>
            </p>
        </div>
    <div class="auth-form">
        <div class="auth-form-inner">
            <h2 style="color: var(--primary); font-weight: 800; font-size: 1.5rem; margin-bottom: 2rem;"><?= __('auth.login_title') ?></h2>
            <p style="color: var(--text-muted); margin-bottom: 2rem;"><?= __('home.hero_subtitle') ?></p>

            <form action="<?= base_url('login') ?>" method="POST">
                <?= csrf_field() ?>
                <div style="margin-bottom: 1.25rem;">
                    <label class="form-label" for="email"><?= __('auth.email') ?></label>
                    <input type="email" name="email" id="email" class="form-control" value="<?= e(old('email')) ?>" placeholder="name@example.com" required>
                </div>
                <div style="margin-bottom: 1.25rem;">
                    <label class="form-label" for="password"><?= __('auth.password') ?></label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="<?= __('auth.password') ?>" required>
                </div>
                <button type="submit" class="btn btn-primary btn-ripple" style="width: 100%; padding: 0.75rem;">
                    <?= __('auth.login_btn') ?>
                </button>
            </form>

            <div style="text-align: center; margin-top: 1.5rem; color: var(--text-muted);">
                <?= __('auth.no_account') ?>
                <a href="<?= base_url('register') ?>" style="margin-left: 0.25rem; font-weight: 600;">
                    <?= __('auth.register_btn') ?>
                </a>
            </div>
    </div>
