<div class="container" style="margin-top: 120px; text-align: center; padding: 60px 20px;">
    <div style="font-size: 120px; font-weight: 700; color: var(--danger, #dc3545); line-height: 1;">403</div>
    <h2 style="margin: 20px 0 10px; color: var(--text);"><?= __('error.access_denied') ?></h2>
    <p style="color: var(--text-muted); max-width: 500px; margin: 0 auto 30px;">
        <?= e($message ?? __('error.access_denied_desc')) ?>
    </p>
    <a href="<?= base_url('/') ?>" class="btn btn-primary"><?= __('error.back_home') ?></a>
</div>
