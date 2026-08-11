<?php

namespace Controllers;

use Core\Controller;
use Models;
use Services;

class EmployerController extends Controller
{
    public function createJobForm(): void
    {
        $companyModel  = $this->container->get(Models\Company::class);
        $categoryModel = $this->container->get(Models\Category::class);
        $skillModel    = $this->container->get(Models\Skill::class);

        $userId    = $this->user()['user_id'];
        $companies = $companyModel->getByEmployer($userId);
        $categories = $categoryModel->getAll();
        $skills    = $skillModel->getAllGrouped();

        $this->view('employer/create_job', [
            'companies'  => $companies,
            'categories' => $categories,
            'skills'     => $skills,
        ]);
    }

    public function createJob(): void
    {
        $jobModel     = $this->container->get(Models\Job::class);
        $companyModel = $this->container->get(Models\Company::class);

        $userId = $this->user()['user_id'];

        $companyData = [
            'name'    => trim($_POST['company_name'] ?? ''),
            'slogan'  => trim($_POST['slogan'] ?? ''),
            'logo'    => trim($_POST['logo'] ?? ''),
            'city'    => trim($_POST['city'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'email'   => trim($_POST['company_email'] ?? ''),
        ];

        $companyId = $companyModel->findOrCreate($companyData);

        $jobId = $jobModel->createJob([
            'user_id'          => $userId,
            'company_id'       => $companyId,
            'category_id'      => (int) ($_POST['category_id'] ?? 0),
            'title'            => trim($_POST['title'] ?? ''),
            'description'      => trim($_POST['description'] ?? ''),
            'requirements'     => trim($_POST['requirements'] ?? ''),
            'level'            => trim($_POST['level'] ?? ''),
            'experience_years' => trim($_POST['experience_years'] ?? ''),
            'employment_type'  => trim($_POST['employment_type'] ?? ''),
            'salary'           => trim($_POST['salary'] ?? ''),
            'interview_rounds' => trim($_POST['interview_rounds'] ?? ''),
        ]);

        $skillIds = array_map('intval', $_POST['skills'] ?? []);
        if (!empty($skillIds)) {
            $jobModel->syncSkills($jobId, $skillIds);
        }

        $this->flash('success', __('employer.job_created'));
        $this->redirect('/employer/manage');
    }

    public function editJobForm(array $params): void
    {
        $jobModel      = $this->container->get(Models\Job::class);
        $companyModel  = $this->container->get(Models\Company::class);
        $categoryModel = $this->container->get(Models\Category::class);
        $skillModel    = $this->container->get(Models\Skill::class);

        $id  = (int) $params['id'];
        $job = $jobModel->findById($id);

        if (!$job) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $this->requireOwnership($job['user_id'] === $this->user()['user_id']);

        $userId     = $this->user()['user_id'];
        $categories = $categoryModel->getAll();
        $skills     = $skillModel->getAllGrouped();
        $companies  = $companyModel->getByEmployer($userId);
        $jobSkillIds = array_column($jobModel->getSkills($id), 'id');

        $job['skill_ids'] = $jobSkillIds;

        $this->view('employer/edit_job', [
            'job'        => $job,
            'categories' => $categories,
            'skills'     => $skills,
            'companies'  => $companies,
        ]);
    }

    public function editJob(array $params): void
    {
        $jobModel = $this->container->get(Models\Job::class);

        $id  = (int) $params['id'];
        $job = $jobModel->findById($id);

        if (!$job) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $this->requireOwnership($job['user_id'] === $this->user()['user_id']);

        $jobModel->updateJob($id, [
            'category_id'      => (int) ($_POST['category_id'] ?? $job['category_id']),
            'title'            => trim($_POST['title'] ?? ''),
            'description'      => trim($_POST['description'] ?? ''),
            'requirements'     => trim($_POST['requirements'] ?? ''),
            'level'            => trim($_POST['level'] ?? ''),
            'experience_years' => trim($_POST['experience_years'] ?? ''),
            'employment_type'  => trim($_POST['employment_type'] ?? ''),
            'salary'           => trim($_POST['salary'] ?? ''),
            'interview_rounds' => trim($_POST['interview_rounds'] ?? ''),
        ]);

        $skillIds = array_map('intval', $_POST['skills'] ?? []);
        $jobModel->syncSkills($id, $skillIds);

        $this->flash('success', __('employer.job_updated'));
        $this->redirect('/employer/manage');
    }

    public function deleteJob(array $params): void
    {
        $jobModel = $this->container->get(Models\Job::class);

        $id     = (int) $params['id'];
        $userId = $this->user()['user_id'];

        $this->requireOwnership($jobModel->isOwnedBy($id, $userId));

        $jobModel->deleteJob($id, $userId);

        $this->flash('success', __('employer.job_deleted'));
        $this->redirect('/employer/manage');
    }

    public function manage(): void
    {
        $jobModel = $this->container->get(Models\Job::class);
        $userId   = $this->user()['user_id'];

        $jobs = $jobModel->getByEmployer($userId);

        $this->view('employer/manage_jobs', [
            'jobs' => $jobs,
        ]);
    }

    /**
     * SECURITY FIX: Only show applications for jobs owned by this employer.
     * The old code fetched ALL applications regardless of ownership.
     */
    public function viewCv(): void
    {
        $appModel = $this->container->get(Models\Application::class);
        $userId   = $this->user()['user_id'];

        $applications = $appModel->findByEmployerJobs($userId);

        $this->view('employer/view_cv', [
            'applications' => $applications,
        ]);
    }

    public function statusForm(array $params): void
    {
        $appModel = $this->container->get(Models\Application::class);

        $id          = (int) $params['id'];
        $application = $appModel->findById($id);

        if (!$application) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $this->requireOwnership(
            $appModel->isOwnedByEmployer($id, $this->user()['user_id'])
        );

        $this->view('employer/application_status', [
            'application' => $application,
        ]);
    }

    public function updateStatus(array $params): void
    {
        $appModel = $this->container->get(Models\Application::class);

        $id = (int) $params['id'];

        $this->requireOwnership(
            $appModel->isOwnedByEmployer($id, $this->user()['user_id'])
        );

        $status = trim($_POST['status'] ?? '');

        if ($status !== '') {
            $appModel->updateStatus($id, $status);
            $this->flash('success', __('employer.job_updated'));
        }

        $this->redirect('/employer/view-cv');
    }
}
