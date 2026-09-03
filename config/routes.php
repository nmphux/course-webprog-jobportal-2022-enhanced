<?php

return [
    // Public routes
    'GET /'                        => ['HomeController', 'index'],

    // Auth
    'GET /login'                   => ['AuthController', 'loginForm'],
    'POST /login'                  => ['AuthController', 'login'],
    'GET /register'                => ['AuthController', 'registerForm'],
    'POST /register'               => ['AuthController', 'register'],
    'GET /logout'                  => ['AuthController', 'logout'],

    // Jobs (public browsing)
    'GET /jobs'                    => ['JobController', 'index'],
    'GET /jobs/{slug}-{id}'        => ['JobController', 'detail'],
    'GET /jobs/{id}'               => ['JobController', 'detail'],
    'POST /jobs/{id}/apply'        => ['JobController', 'apply', ['auth:candidate']],

    // Search API (AJAX)
    'GET /api/search/suggest'      => ['SearchController', 'suggest'],

    // Bookmarks
    'GET /bookmarks'               => ['BookmarkController', 'index', ['auth:candidate']],
    'POST /jobs/{id}/bookmark'     => ['BookmarkController', 'toggle', ['auth']],
    'GET /jobs/{id}/bookmark'      => ['BookmarkController', 'toggle', ['auth']],
    'GET /bookmarks/{id}/delete'   => ['BookmarkController', 'delete', ['auth']],

    // Employer
    'GET /employer/create-job'     => ['EmployerController', 'createJobForm', ['auth:employer']],
    'POST /employer/create-job'    => ['EmployerController', 'createJob', ['auth:employer']],
    'GET /employer/edit-job/{id}'  => ['EmployerController', 'editJobForm', ['auth:employer']],
    'POST /employer/edit-job/{id}' => ['EmployerController', 'editJob', ['auth:employer']],
    'GET /employer/delete-job/{id}'=> ['EmployerController', 'deleteJob', ['auth:employer']],
    'GET /employer/manage'         => ['EmployerController', 'manage', ['auth:employer']],
    'GET /employer/view-cv'        => ['EmployerController', 'viewCv', ['auth:employer']],
    'GET /employer/status/{id}'    => ['EmployerController', 'statusForm', ['auth:employer']],
    'POST /employer/status/{id}'   => ['EmployerController', 'updateStatus', ['auth:employer']],

    // Candidate
    'GET /candidate/profile'       => ['CandidateController', 'profile', ['auth:candidate']],
    'GET /candidate/create-cv'     => ['CandidateController', 'createCvForm', ['auth:candidate']],
    'POST /candidate/create-cv'    => ['CandidateController', 'createCv', ['auth:candidate']],

    // Settings
    'GET /settings'                => ['SettingsController', 'index', ['auth']],
    'POST /settings'               => ['SettingsController', 'handlePost', ['auth']],

    // Company profiles
    'GET /companies/{id}'          => ['CompanyController', 'show'],
];
