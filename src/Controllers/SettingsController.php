<?php

namespace Controllers;

use Core\Controller;
use Models;
use Services;

class SettingsController extends Controller
{
    public function index(): void
    {
        $userModel  = $this->container->get(Models\User::class);
        $skillModel = $this->container->get(Models\Skill::class);

        $userId = $this->user()['user_id'];

        $userData       = $userModel->findById($userId);
        $profile        = $userModel->getProfile($userId);
        $education      = $userModel->getEducation($userId);
        $experience     = $userModel->getExperience($userId);
        $certifications = $userModel->getCertifications($userId);
        $skills         = $skillModel->getAllGrouped();
        $userSkillIds   = $userModel->getSkillIds($userId);
        $activeTab      = $_GET['tab'] ?? 'account';

        $this->view('settings/index', [
            'user'           => $userData,
            'profile'        => $profile,
            'education'      => $education,
            'experience'     => $experience,
            'certifications' => $certifications,
            'all_skills'     => $skills,
            'user_skill_ids' => $userSkillIds,
            'tab'            => $activeTab,
        ]);
    }

    public function handlePost(): void
    {
        $action = $_POST['action'] ?? '';

        switch ($action) {
            case 'update-account':
                $this->updateAccount();
                break;
            case 'upload-avatar':
                $this->uploadAvatar();
                break;
            case 'update-profile':
                $this->updateProfile();
                break;
            case 'change-password':
                $this->changePassword();
                break;
            case 'update-language':
                $this->updateLanguage();
                break;
            case 'add-education':
                $this->addEducation();
                break;
            case 'update-education':
                $this->updateEducation();
                break;
            case 'delete-education':
                $this->deleteEducation();
                break;
            case 'add-experience':
                $this->addExperience();
                break;
            case 'update-experience':
                $this->updateExperience();
                break;
            case 'delete-experience':
                $this->deleteExperience();
                break;
            case 'add-certification':
                $this->addCertification();
                break;
            case 'update-certification':
                $this->updateCertification();
                break;
            case 'delete-certification':
                $this->deleteCertification();
                break;
            default:
                $this->flash('error', 'Invalid action.');
                $this->redirect('/settings');
                break;
        }
    }

    // ─── Account ──────────────────────────────────────────────

    private function updateAccount(): void
    {
        $userModel = $this->container->get(Models\User::class);
        $userId    = $this->user()['user_id'];
        $name      = trim($_POST['name'] ?? '');

        if ($name === '') {
            $this->flash('error', __('settings.name_required'));
            $this->redirect('/settings?tab=account');
            return;
        }

        $userModel->updateUser($userId, ['name' => $name]);
        $_SESSION['user_name'] = $name;

        $this->flash('success', __('settings.account_updated'));
        $this->redirect('/settings?tab=account');
    }

    private function uploadAvatar(): void
    {
        $userModel         = $this->container->get(Models\User::class);
        $fileUploadService = $this->container->get(Services\FileUploadService::class);
        $userId            = $this->user()['user_id'];

        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] === UPLOAD_ERR_NO_FILE) {
            $this->flash('error', __('validation.required'));
            $this->redirect('/settings?tab=account');
            return;
        }

        $result = $fileUploadService->upload(
            $_FILES['avatar'],
            'avatars',
            ['image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/webp'],
            5 * 1024 * 1024
        );

        if (!$result['success']) {
            $this->flash('error', $result['error']);
            $this->redirect('/settings?tab=account');
            return;
        }

        $userModel->updateUser($userId, ['avatar' => $result['path']]);
        $_SESSION['user_avatar'] = $result['path'];

        $this->flash('success', __('settings.photo_updated'));
        $this->redirect('/settings?tab=account');
    }

    // ─── Profile ──────────────────────────────────────────────

    private function updateProfile(): void
    {
        $userModel = $this->container->get(Models\User::class);
        $userId    = $this->user()['user_id'];

        // Update basic user fields
        $userModel->updateUser($userId, [
            'phone'   => trim($_POST['phone'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'about_me' => trim($_POST['about_me'] ?? ''),
        ]);

        // Upsert extended profile
        $userModel->upsertProfile($userId, [
            'headline'      => trim($_POST['headline'] ?? ''),
            'linkedin_url'  => trim($_POST['linkedin_url'] ?? ''),
            'github_url'    => trim($_POST['github_url'] ?? ''),
            'portfolio_url' => trim($_POST['portfolio_url'] ?? ''),
            'website_url'   => trim($_POST['website_url'] ?? ''),
        ]);

        // Sync skills
        $skillIds = array_map('intval', $_POST['skills'] ?? []);
        $userModel->syncSkills($userId, $skillIds);

        $this->flash('success', __('settings.profile_updated'));
        $this->redirect('/settings?tab=profile');
    }

    // ─── Password ─────────────────────────────────────────────

    private function changePassword(): void
    {
        $authService = $this->container->get(Services\AuthService::class);
        $userId      = $this->user()['user_id'];

        $current = $_POST['oldpassword'] ?? '';
        $new     = $_POST['newpassword'] ?? '';
        $confirm = $_POST['confpassword'] ?? '';

        $result = $authService->changePassword($userId, $current, $new, $confirm);

        if ($result['success']) {
            $authService->logout();
            session_start();
            $this->flash('success', __('settings.password_changed'));
            $this->redirect('/login');
            return;
        }

        $this->flash('error', $result['error']);
        $this->redirect('/settings?tab=password');
    }

    // ─── Language ─────────────────────────────────────────────

    private function updateLanguage(): void
    {
        $userModel       = $this->container->get(Models\User::class);
        $userId          = $this->user()['user_id'];
        $lang            = $_POST['language'] ?? 'en';
        $supportedLocales = ['en', 'vi'];

        if (!in_array($lang, $supportedLocales, true)) {
            $lang = 'en';
        }

        $userModel->updateUser($userId, ['language' => $lang]);
        $_SESSION['locale'] = $lang;
        setcookie('locale', $lang, time() + (365 * 24 * 60 * 60), '/');

        $this->flash('success', __('settings.language_saved'));
        $this->redirect('/settings?tab=language');
    }

    // ─── Education ────────────────────────────────────────────

    private function addEducation(): void
    {
        $userModel = $this->container->get(Models\User::class);
        $userId    = $this->user()['user_id'];

        $userModel->addEducation($userId, [
            'school_name'    => trim($_POST['school_name'] ?? ''),
            'degree'         => trim($_POST['degree'] ?? ''),
            'field_of_study' => trim($_POST['field_of_study'] ?? ''),
            'start_date'     => $_POST['start_date'] ?? null,
            'end_date'       => $_POST['end_date'] ?? null,
            'description'    => trim($_POST['description'] ?? ''),
        ]);

        $this->flash('success', __('settings.profile_updated'));
        $this->redirect('/settings?tab=profile');
    }

    private function updateEducation(): void
    {
        $userModel = $this->container->get(Models\User::class);
        $userId    = $this->user()['user_id'];
        $id        = (int) ($_POST['id'] ?? 0);

        $userModel->updateEducation($id, $userId, [
            'school_name'    => trim($_POST['school_name'] ?? ''),
            'degree'         => trim($_POST['degree'] ?? ''),
            'field_of_study' => trim($_POST['field_of_study'] ?? ''),
            'start_date'     => $_POST['start_date'] ?? null,
            'end_date'       => $_POST['end_date'] ?? null,
            'description'    => trim($_POST['description'] ?? ''),
        ]);

        $this->flash('success', __('settings.profile_updated'));
        $this->redirect('/settings?tab=profile');
    }

    private function deleteEducation(): void
    {
        $userModel = $this->container->get(Models\User::class);
        $userId    = $this->user()['user_id'];
        $id        = (int) ($_POST['id'] ?? 0);

        $userModel->deleteEducation($id, $userId);

        $this->flash('success', __('settings.profile_updated'));
        $this->redirect('/settings?tab=profile');
    }

    // ─── Experience ───────────────────────────────────────────

    private function addExperience(): void
    {
        $userModel = $this->container->get(Models\User::class);
        $userId    = $this->user()['user_id'];

        $userModel->addExperience($userId, [
            'company_name' => trim($_POST['company_name'] ?? ''),
            'job_title'    => trim($_POST['job_title'] ?? ''),
            'start_date'   => $_POST['start_date'] ?? null,
            'end_date'     => $_POST['end_date'] ?? null,
            'is_current'   => isset($_POST['is_current']) ? 1 : 0,
            'description'  => trim($_POST['description'] ?? ''),
        ]);

        $this->flash('success', __('settings.profile_updated'));
        $this->redirect('/settings?tab=profile');
    }

    private function updateExperience(): void
    {
        $userModel = $this->container->get(Models\User::class);
        $userId    = $this->user()['user_id'];
        $id        = (int) ($_POST['id'] ?? 0);

        $userModel->updateExperience($id, $userId, [
            'company_name' => trim($_POST['company_name'] ?? ''),
            'job_title'    => trim($_POST['job_title'] ?? ''),
            'start_date'   => $_POST['start_date'] ?? null,
            'end_date'     => $_POST['end_date'] ?? null,
            'is_current'   => isset($_POST['is_current']) ? 1 : 0,
            'description'  => trim($_POST['description'] ?? ''),
        ]);

        $this->flash('success', __('settings.profile_updated'));
        $this->redirect('/settings?tab=profile');
    }

    private function deleteExperience(): void
    {
        $userModel = $this->container->get(Models\User::class);
        $userId    = $this->user()['user_id'];
        $id        = (int) ($_POST['id'] ?? 0);

        $userModel->deleteExperience($id, $userId);

        $this->flash('success', __('settings.profile_updated'));
        $this->redirect('/settings?tab=profile');
    }

    // ─── Certifications ──────────────────────────────────────

    private function addCertification(): void
    {
        $userModel = $this->container->get(Models\User::class);
        $userId    = $this->user()['user_id'];

        $userModel->addCertification($userId, [
            'name'           => trim($_POST['name'] ?? ''),
            'issuing_org'    => trim($_POST['issuing_org'] ?? ''),
            'issue_date'     => $_POST['issue_date'] ?? null,
            'expiry_date'    => $_POST['expiry_date'] ?? null,
            'credential_url' => trim($_POST['credential_url'] ?? ''),
        ]);

        $this->flash('success', __('settings.profile_updated'));
        $this->redirect('/settings?tab=profile');
    }

    private function updateCertification(): void
    {
        $userModel = $this->container->get(Models\User::class);
        $userId    = $this->user()['user_id'];
        $id        = (int) ($_POST['id'] ?? 0);

        $userModel->updateCertification($id, $userId, [
            'name'           => trim($_POST['name'] ?? ''),
            'issuing_org'    => trim($_POST['issuing_org'] ?? ''),
            'issue_date'     => $_POST['issue_date'] ?? null,
            'expiry_date'    => $_POST['expiry_date'] ?? null,
            'credential_url' => trim($_POST['credential_url'] ?? ''),
        ]);

        $this->flash('success', __('settings.profile_updated'));
        $this->redirect('/settings?tab=profile');
    }

    private function deleteCertification(): void
    {
        $userModel = $this->container->get(Models\User::class);
        $userId    = $this->user()['user_id'];
        $id        = (int) ($_POST['id'] ?? 0);

        $userModel->deleteCertification($id, $userId);

        $this->flash('success', __('settings.profile_updated'));
        $this->redirect('/settings?tab=profile');
    }
}
