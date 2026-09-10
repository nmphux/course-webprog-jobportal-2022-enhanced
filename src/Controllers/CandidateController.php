<?php

namespace Controllers;

use Core\Controller;
use Models;
use Services;

class CandidateController extends Controller
{
    public function profile(): void
    {
        $appModel  = $this->container->get(Models\Application::class);
        $userModel = $this->container->get(Models\User::class);

        $userId = $this->user()['user_id'];

        $applications = $appModel->findByUser($userId);
        $userData     = $userModel->findById($userId);

        $this->view('candidate/profile', [
            'userData'     => $userData,
            'applications' => $applications,
        ]);
    }

    public function applications(): void
    {
        $this->profile();
    }

    public function viewApplication(array $params): void
    {
        $appModel = $this->container->get(Models\Application::class);

        $id = (int) ($params['id'] ?? 0);
        $application = $appModel->findById($id);

        if (!$application) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $applicantId = (int) ($application['applicant_id'] ?? $application['user_id'] ?? 0);
        $this->requireOwnership($applicantId === (int) $this->user()['user_id']);

        $this->view('candidate/view_application', [
            'application' => $application,
        ]);
    }

    public function editApplicationForm(array $params): void
    {
        $appModel = $this->container->get(Models\Application::class);

        $id = (int) ($params['id'] ?? 0);
        $application = $appModel->findById($id);

        if (!$application) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $applicantId = (int) ($application['applicant_id'] ?? $application['user_id'] ?? 0);
        $this->requireOwnership($applicantId === (int) $this->user()['user_id']);

        $this->view('candidate/edit_application', [
            'application' => $application,
        ]);
    }

    public function editApplication(array $params): void
    {
        $appModel          = $this->container->get(Models\Application::class);
        $fileUploadService = $this->container->get(Services\FileUploadService::class);

        $id = (int) ($params['id'] ?? 0);
        $application = $appModel->findById($id);

        if (!$application) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $applicantId = (int) ($application['applicant_id'] ?? $application['user_id'] ?? 0);
        $this->requireOwnership($applicantId === (int) $this->user()['user_id']);

        $data = [];

        if (isset($_POST['applicant_name'])) {
            $data['applicant_name'] = trim($_POST['applicant_name']);
        }

        if (isset($_POST['cover_letter'])) {
            $data['cover_letter'] = trim($_POST['cover_letter']);
        }

        if (isset($_FILES['cv']) && $_FILES['cv']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = $fileUploadService->upload(
                $_FILES['cv'],
                'cv',
                ['application/pdf'],
                5 * 1024 * 1024
            );

            if (!$uploadResult['success']) {
                $this->flash('error', $uploadResult['error']);
                $this->redirect('/candidate/edit-application/' . $id);
                return;
            }

            $data['file_path'] = $uploadResult['path'];
        }

        if (!empty($data)) {
            $appModel->updateApplication($id, $data);
        }

        $this->flash('success', __('candidate.application_updated'));
        $this->redirect('/candidate/profile');
    }

    public function updateApplication(array $params): void
    {
        $this->editApplication($params);
    }

    public function deleteApplication(array $params): void
    {
        $appModel = $this->container->get(Models\Application::class);

        $id = (int) ($params['id'] ?? 0);
        $application = $appModel->findById($id);

        if (!$application) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $applicantId = (int) ($application['applicant_id'] ?? $application['user_id'] ?? 0);
        $this->requireOwnership($applicantId === (int) $this->user()['user_id']);

        $userId = (int) $this->user()['user_id'];
        $appModel->deleteApplication($id, $userId);

        $this->flash('success', __('candidate.application_deleted'));
        $this->redirect('/candidate/profile');
    }

    public function createCvForm(): void
    {
        $userModel  = $this->container->get(Models\User::class);
        $skillModel = $this->container->get(Models\Skill::class);

        $userId = $this->user()['user_id'];

        $userData       = $userModel->findById($userId);
        $profile        = $userModel->getProfile($userId);
        $education      = $userModel->getEducation($userId);
        $experience     = $userModel->getExperience($userId);
        $certifications = $userModel->getCertifications($userId);
        $userSkills     = $userModel->getSkills($userId);

        $this->view('candidate/create_cv', [
            'user'           => $userData,
            'profile'        => $profile,
            'education'      => $education,
            'experience'     => $experience,
            'certifications' => $certifications,
            'skills'         => $userSkills,
        ]);
    }

    public function createCv(): void
    {
        $fileUploadService = $this->container->get(Services\FileUploadService::class);

        $targetFile = '';

        // Handle optional avatar/photo upload for CV
        if (isset($_FILES['fileUpload']) && $_FILES['fileUpload']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = $fileUploadService->upload(
                $_FILES['fileUpload'],
                'avatars',
                ['image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/webp'],
                5 * 1024 * 1024
            );

            if ($uploadResult['success']) {
                $targetFile = $uploadResult['path'];
            }
        }

        // Gather CV data from POST (client-side html2pdf.js handles PDF generation)
        $cvData = [
            'name'         => $_POST['name'] ?? '',
            'date'         => $_POST['date'] ?? '',
            'gender'       => $_POST['gender'] ?? '',
            'email'        => $_POST['email'] ?? '',
            'phone'        => $_POST['phone'] ?? '',
            'address'      => $_POST['address'] ?? '',
            'description'  => $_POST['description'] ?? '',
            'exp'          => $_POST['exp'] ?? '',
            'exp_number'   => $_POST['exp_number'] ?? '',
            'job'          => $_POST['job'] ?? '',
            'skills'       => $_POST['skills'] ?? '',
            'salary'       => $_POST['salary'] ?? '',
            'name_school'  => $_POST['name_school'] ?? '',
            'level'        => $_POST['level'] ?? '',
            'from_month'   => $_POST['from_month'] ?? '',
            'to_month'     => $_POST['to_month'] ?? '',
            'major_school' => $_POST['major_school'] ?? '',
        ];

        $this->view('candidate/create_cv', [
            'submitted'  => true,
            'cvData'     => $cvData,
            'targetFile' => $targetFile,
        ]);
    }
}
