<!DOCTYPE html>
<html lang="<?= $locale ?? 'en' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= e($csrf_token ?? '') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('css/theme.css') ?>">
    <script>var BASE_URL = '<?= rtrim(base_url(''), '/') ?>';</script>
    <script src="<?= asset('js/theme.js') ?>"></script>
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/components.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/animations.css') ?>">
    <?php if (!empty($extra_css)): ?>
        <?php foreach ((array)$extra_css as $css): ?>
            <link rel="stylesheet" href="<?= asset('css/' . $css) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <title><?= e($page_title ?? 'JobHub') ?></title>
    <?php if (!empty($extra_head)): echo $extra_head; endif; ?>
</head>
<body>
    <!-- Toast Container (fixed top-right) -->
    <?php if (!empty($flash_html)): ?>
        <?= $flash_html ?>
    <?php endif; ?>

    <!-- Back to Top Button -->
    <button id="backToTop" class="back-to-top" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <nav class="navbar navbar-expand-lg fixed-top">
      <div class="container">
        <a class="navbar-brand" href="<?= base_url('/') ?>">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 6px; vertical-align: -4px;">
                <rect x="3" y="7" width="22" height="18" rx="3" stroke="currentColor" stroke-width="2" fill="none"/>
                <path d="M9 7V5C9 3.34 10.34 2 12 2H16C17.66 2 19 3.34 19 5V7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <circle cx="14" cy="16" r="3" fill="currentColor" opacity="0.3"/>
                <rect x="8" y="18" width="12" height="2" rx="1" fill="currentColor" opacity="0.2"/>
            </svg>
            JobHub
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-spabet" id="navbarMain">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link<?= ($active_nav ?? '') === 'home' ? ' active' : '' ?>" href="<?= base_url('/') ?>"><?= __('nav.home') ?></a>
                </li>
                <?php if (!$current_user || $current_user['type'] == 0): ?>
                    <li class="nav-item">
                        <a class="nav-link<?= ($active_nav ?? '') === 'jobs' ? ' active' : '' ?>" href="<?= base_url('jobs') ?>"><?= __('nav.find_jobs') ?></a>
                    </li>
                <?php endif; ?>
                <?php if (!$current_user || $current_user['type'] == 1): ?>
                    <li class="nav-item">
                        <a class="nav-link<?= ($active_nav ?? '') === 'create-job' ? ' active' : '' ?>" href="<?= base_url('employer/create-job') ?>"><?= __('nav.post_job') ?></a>
                    </li>
                <?php endif; ?>
                <?php if (!$current_user || $current_user['type'] == 0): ?>
                    <li class="nav-item">
                        <a class="nav-link<?= ($active_nav ?? '') === 'create-cv' ? ' active' : '' ?>" href="<?= base_url('candidate/create-cv') ?>"><?= __('nav.create_cv') ?></a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if (!$current_user): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('login') ?>">
                            <span class="btn btn-primary btn-sm"><?= __('nav.login') ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('register') ?>">
                            <span class="btn btn-outline-primary btn-sm"><?= __('nav.register') ?></span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="display: flex; align-items: center; gap: 0.5rem;">
                            <?php if (!empty($current_user['avatar'])): ?>
                                <img src="<?= upload_url($current_user['avatar']) ?>" class="user-avatar" alt="">
                            <?php else: ?>
                                <div class="avatar-placeholder avatar-sm" style="font-size: 0.75rem;">
                                    <?= strtoupper(substr($current_user['name'], 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                            <?= e($current_user['name']) ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <?php if ($current_user['type'] == 0): ?>
                                <div class="dropdown-header" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-light);">Candidate Tools</div>
                                <a class="dropdown-item" href="<?= base_url('candidate/profile') ?>">
                                    <i class="fas fa-file-alt fa-fw" style="margin-right: 0.5rem; color: var(--text-muted);"></i><?= __('nav.my_applications') ?>
                                </a>
                                <a class="dropdown-item" href="<?= base_url('bookmarks') ?>">
                                    <i class="fas fa-bookmark fa-fw" style="margin-right: 0.5rem; color: var(--text-muted);"></i><?= __('nav.bookmarks') ?>
                                </a>
                            <?php else: ?>
                                <div class="dropdown-header" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-light);">Employer Tools</div>
                                <a class="dropdown-item" href="<?= base_url('employer/manage') ?>">
                                    <i class="fas fa-chart-bar fa-fw" style="margin-right: 0.5rem; color: var(--text-muted);"></i><?= __('nav.manage_posts') ?>
                                </a>
                                <a class="dropdown-item" href="<?= base_url('employer/view-cv') ?>">
                                    <i class="fas fa-users fa-fw" style="margin-right: 0.5rem; color: var(--text-muted);"></i><?= __('nav.applications') ?>
                                </a>
                            <?php endif; ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('settings') ?>">
                                <i class="fas fa-cog fa-fw" style="margin-right: 0.5rem; color: var(--text-muted);"></i><?= __('nav.settings') ?>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('logout') ?>">
                                <i class="fas fa-sign-out-alt fa-fw" style="margin-right: 0.5rem; color: var(--danger);"></i><?= __('nav.logout') ?>
                            </a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <main class="mt-navbar page-enter">
