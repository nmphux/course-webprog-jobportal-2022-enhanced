<?php

namespace Controllers;

use Core\Controller;
use Models;
use Services;

class JobController extends Controller
{
    public function index(): void
    {
        $jobModel      = $this->container->get(Models\Job::class);
        $categoryModel = $this->container->get(Models\Category::class);

        $filters = [
            'q'          => trim($_GET['q'] ?? ''),
            'category'   => $_GET['category'] ?? '',
            'city'       => trim($_GET['city'] ?? ''),
            'level'      => $_GET['level'] ?? '',
            'type'       => $_GET['type'] ?? '',
            'experience' => $_GET['experience'] ?? '',
            'sort'       => $_GET['sort'] ?? '',
        ];

        $page    = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = 12;

        $categories = $categoryModel->getAll();
        $result     = $jobModel->search($filters, $page, $perPage);

        $this->view('jobs/index', [
            'jobs'       => $result,
            'filters'    => $filters,
            'categories' => $categories,
        ]);
    }

    public function detail(array $params): void
    {
        $jobModel      = $this->container->get(Models\Job::class);
        $bookmarkModel = $this->container->get(Models\Bookmark::class);
        $appModel      = $this->container->get(Models\Application::class);

        $id  = (int) $params['id'];
        $job = $jobModel->findById($id);

        if (!$job) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $user         = $this->user();
        $isBookmarked = false;
        $hasApplied   = false;

        if ($user) {
            $isBookmarked = $bookmarkModel->exists($user['user_id'], $id);
            $hasApplied   = $appModel->exists($user['user_id'], $id);
        }

        $relatedJobs = $jobModel->getRelated($id, $job['category_id'], 4);

        $this->view('jobs/detail', [
            'job'          => $job,
            'isBookmarked' => $isBookmarked,
            'hasApplied'   => $hasApplied,
            'relatedJobs'  => $relatedJobs,
        ]);
    }

    public function apply(array $params): void
    {
        $appModel         = $this->container->get(Models\Application::class);
        $jobModel         = $this->container->get(Models\Job::class);
        $fileUploadService = $this->container->get(Services\FileUploadService::class);

        $jobId  = (int) $params['id'];
        $user   = $this->user();
        $userId = $user['user_id'];

        $job = $jobModel->findById($jobId);
        if (!$job) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $jobUrl = '/' . ltrim(job_url($job), '/');

        // Prevent duplicate applications
        if ($appModel->exists($userId, $jobId)) {
            $this->flash('error', __('jobs.already_applied'));
            $this->redirect($jobUrl);
            return;
        }

        $filePath = '';

        if (isset($_FILES['cv']) && $_FILES['cv']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = $fileUploadService->upload(
                $_FILES['cv'],
                'cv',
                ['application/pdf'],
                5 * 1024 * 1024
            );

            if (!$uploadResult['success']) {
                $this->flash('error', $uploadResult['error']);
                $this->redirect($jobUrl);
                return;
            }

            $filePath = $uploadResult['path'];
        }

        $appModel->create([
            'job_id'         => $jobId,
            'user_id'        => $userId,
            'applicant_name' => $user['user_name'],
            'file_path'      => $filePath,
        ]);

        $this->flash('success', __('jobs.apply_success'));
        $this->redirect($jobUrl);
    }
}
