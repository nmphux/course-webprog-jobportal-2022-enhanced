<div class="container" style="padding-top: 2rem; padding-bottom: 3rem;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><?= __('nav.create_cv') ?></h2>
        <button class="btn btn-primary" onclick="generateCV()"><i class="fas fa-download"></i> <?= __('candidate.download_cv') ?></button>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div id="cv-preview" class="card" style="padding: 2.5rem; background: #fff; color: #1a1a1a;">
                <div style="display: flex; gap: 1.5rem; margin-bottom: 2rem; align-items: center;">
                    <?php if (!empty($user['avatar'])): ?>
                        <img src="<?= upload_url($user['avatar']) ?>" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                    <?php endif; ?>
                    <div>
                        <h1 style="font-size: 1.75rem; font-weight: 700; margin: 0; color: #1a1a1a;"><?= e($user['name']) ?></h1>
                        <?php if (!empty($profile['headline'])): ?>
                            <p style="font-size: 1.1rem; color: #4a5568; margin: 0.25rem 0 0;"><?= e($profile['headline']) ?></p>
                        <?php endif; ?>
                        <div style="margin-top: 0.5rem; font-size: 0.875rem; color: #718096;">
                            <?php if (!empty($user['email'])): ?><span><i class="fas fa-envelope" style="width: 16px;"></i> <?= e($user['email']) ?></span><?php endif; ?>
                            <?php if (!empty($user['phone'])): ?><span style="margin-left: 1rem;"><i class="fas fa-phone" style="width: 16px;"></i> <?= e($user['phone']) ?></span><?php endif; ?>
                            <?php if (!empty($user['address'])): ?><span style="margin-left: 1rem;"><i class="fas fa-map-marker-alt" style="width: 16px;"></i> <?= e($user['address']) ?></span><?php endif; ?>
                        </div>
                        <div style="margin-top: 0.25rem; font-size: 0.875rem; color: #718096;">
                            <?php if (!empty($profile['linkedin_url'])): ?><a href="<?= e($profile['linkedin_url']) ?>" style="color: #2563EB; margin-right: 1rem;"><i class="fab fa-linkedin"></i> LinkedIn</a><?php endif; ?>
                            <?php if (!empty($profile['github_url'])): ?><a href="<?= e($profile['github_url']) ?>" style="color: #2563EB; margin-right: 1rem;"><i class="fab fa-github"></i> GitHub</a><?php endif; ?>
                            <?php if (!empty($profile['portfolio_url'])): ?><a href="<?= e($profile['portfolio_url']) ?>" style="color: #2563EB;"><i class="fas fa-globe"></i> Portfolio</a><?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php if (!empty($user['about_me'])): ?>
                <div style="margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #2563EB; border-bottom: 2px solid #2563EB; padding-bottom: 0.25rem; margin-bottom: 0.75rem;"><?= __('settings.about_me') ?></h3>
                    <p style="color: #4a5568; line-height: 1.6; margin: 0;"><?= e($user['about_me']) ?></p>
                </div>
                <?php endif; ?>

                <?php if (!empty($skills)): ?>
                <div style="margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #2563EB; border-bottom: 2px solid #2563EB; padding-bottom: 0.25rem; margin-bottom: 0.75rem;"><?= __('settings.skills') ?></h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        <?php foreach ($skills as $skill): ?>
                            <span style="background: #EBF5FF; color: #2563EB; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.8125rem; font-weight: 500;"><?= e($skill['name']) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($experience)): ?>
                <div style="margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #2563EB; border-bottom: 2px solid #2563EB; padding-bottom: 0.25rem; margin-bottom: 0.75rem;"><?= __('settings.experience') ?></h3>
                    <?php foreach ($experience as $exp): ?>
                        <div style="margin-bottom: 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: baseline;">
                                <strong style="color: #1a1a1a;"><?= e($exp['job_title']) ?></strong>
                                <small style="color: #718096; white-space: nowrap;"><?= e($exp['start_date'] ?? '') ?> — <?= $exp['is_current'] ? 'Present' : e($exp['end_date'] ?? '') ?></small>
                            </div>
                            <div style="color: #4a5568; font-size: 0.9375rem;"><?= e($exp['company_name']) ?></div>
                            <?php if (!empty($exp['description'])): ?>
                                <p style="color: #4a5568; font-size: 0.875rem; margin: 0.25rem 0 0; line-height: 1.5;"><?= e($exp['description']) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($education)): ?>
                <div style="margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #2563EB; border-bottom: 2px solid #2563EB; padding-bottom: 0.25rem; margin-bottom: 0.75rem;"><?= __('settings.education') ?></h3>
                    <?php foreach ($education as $edu): ?>
                        <div style="margin-bottom: 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: baseline;">
                                <strong style="color: #1a1a1a;"><?= e($edu['school_name']) ?></strong>
                                <small style="color: #718096; white-space: nowrap;"><?= e($edu['start_date'] ?? '') ?> — <?= e($edu['end_date'] ?? 'Present') ?></small>
                            </div>
                            <?php if (!empty($edu['degree']) || !empty($edu['field_of_study'])): ?>
                                <div style="color: #4a5568; font-size: 0.9375rem;"><?= e(implode(' — ', array_filter([$edu['degree'] ?? '', $edu['field_of_study'] ?? '']))) ?></div>
                            <?php endif; ?>
                            <?php if (!empty($edu['description'])): ?>
                                <p style="color: #4a5568; font-size: 0.875rem; margin: 0.25rem 0 0; line-height: 1.5;"><?= e($edu['description']) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($certifications)): ?>
                <div style="margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #2563EB; border-bottom: 2px solid #2563EB; padding-bottom: 0.25rem; margin-bottom: 0.75rem;"><?= __('settings.certifications') ?></h3>
                    <?php foreach ($certifications as $cert): ?>
                        <div style="margin-bottom: 0.75rem;">
                            <strong style="color: #1a1a1a;"><?= e($cert['name']) ?></strong>
                            <?php if (!empty($cert['issuing_org'])): ?><span style="color: #4a5568;"> — <?= e($cert['issuing_org']) ?></span><?php endif; ?>
                            <?php if (!empty($cert['issue_date'])): ?><br><small style="color: #718096;"><?= e($cert['issue_date']) ?><?php if (!empty($cert['expiry_date'])): ?> — <?= e($cert['expiry_date']) ?><?php endif; ?></small><?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card" style="padding: 1.5rem; position: sticky; top: 5rem;">
                <h5 style="margin-bottom: 1rem;"><?= __('candidate.cv_tips') ?></h5>
                <ul style="font-size: 0.875rem; color: var(--text-muted); padding-left: 1.25rem; margin: 0;">
                    <li style="margin-bottom: 0.5rem;"><?= __('candidate.tip_complete') ?></li>
                    <li style="margin-bottom: 0.5rem;"><?= __('candidate.tip_skills') ?></li>
                    <li style="margin-bottom: 0.5rem;"><?= __('candidate.tip_experience') ?></li>
                    <li><?= __('candidate.tip_education') ?></li>
                </ul>
                <hr>
                <a href="<?= base_url('settings?tab=profile') ?>" class="btn btn-outline-primary" style="width: 100%;"><i class="fas fa-edit"></i> <?= __('candidate.edit_profile') ?></a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
function generateCV() {
    var el = document.getElementById('cv-preview');
    var opt = {
        margin: 10,
        filename: '<?= e($user['name']) ?>_CV.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };
    html2pdf().set(opt).from(el).save();
}
</script>
