<div class="container" style="margin-top: 120px; text-align: center; padding: 60px 20px;">
    <div style="font-size: 120px; font-weight: 700; color: var(--primary); line-height: 1;">404</div>
    <h2 style="margin: 20px 0 10px; color: var(--text);"><?= __('error.page_not_found') ?></h2>
    <p style="color: var(--text-muted); max-width: 500px; margin: 0 auto 30px;">
        <?= e($message ?? __('error.page_not_found_desc')) ?>
    </p>
    <a href="<?= base_url('/') ?>" class="btn btn-primary"><?= __('error.back_home') ?></a>
</div>
