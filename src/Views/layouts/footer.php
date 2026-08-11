    </main>

    <footer>
      <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <h5><?= __('footer.about') ?></h5>
                <p style="font-size: 0.875rem; line-height: 1.7;">
                    <?= __('footer.about_desc') ?>
                </p>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <h5><?= __('footer.for_candidates') ?></h5>
                <ul style="font-size: 0.875rem;">
                    <li style="margin-bottom: 0.5rem;"><a href="<?= base_url('jobs') ?>"><?= __('nav.find_jobs') ?></a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="<?= base_url('candidate/create-cv') ?>"><?= __('nav.create_cv') ?></a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="<?= base_url('bookmarks') ?>"><?= __('nav.bookmarks') ?></a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5><?= __('footer.for_employers') ?></h5>
                <ul style="font-size: 0.875rem;">
                    <li style="margin-bottom: 0.5rem;"><a href="<?= base_url('employer/create-job') ?>"><?= __('nav.post_job') ?></a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="<?= base_url('employer/manage') ?>"><?= __('nav.manage_posts') ?></a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom text-center" style="font-size: 0.8125rem; color: #64748B; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
            <span><?= __('footer.copyright', [date('Y')]) ?></span>
            <div style="display: flex; gap: 0.375rem;">
                <button type="button" data-theme-toggle="dawn" title="Dawn Theme" style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.6); background: linear-gradient(135deg, #FFEDD5, #F43F5E); cursor: pointer; transition: transform 0.15s;" onmouseenter="this.style.transform='scale(1.2)'" onmouseleave="this.style.transform='scale(1)'"></button>
                <button type="button" data-theme-toggle="noon" title="Noon Theme" style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.6); background: linear-gradient(135deg, #DBEAFE, #2563EB); cursor: pointer; transition: transform 0.15s;" onmouseenter="this.style.transform='scale(1.2)'" onmouseleave="this.style.transform='scale(1)'"></button>
                <button type="button" data-theme-toggle="dusk" title="Dusk Theme" style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.6); background: linear-gradient(135deg, #1A103C, #D97706); cursor: pointer; transition: transform 0.15s;" onmouseenter="this.style.transform='scale(1.2)'" onmouseleave="this.style.transform='scale(1)'"></button>
                <button type="button" data-theme-toggle="night" title="Night Theme" style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.6); background: linear-gradient(135deg, #0B1121, #38BDF8); cursor: pointer; transition: transform 0.15s;" onmouseenter="this.style.transform='scale(1.2)'" onmouseleave="this.style.transform='scale(1)'"></button>
            </div>
        </div>
      </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= asset('js/app.js') ?>"></script>
    <?php if (!empty($extra_js)): ?>
        <?php foreach ((array)$extra_js as $js): ?>
            <script src="<?= asset('js/' . $js) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if (!empty($extra_scripts)): ?>
        <?= $extra_scripts ?>
    <?php endif; ?>
</body>
</html>
