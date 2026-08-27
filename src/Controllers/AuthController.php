<?php

namespace Controllers;

use Core\Controller;
use Models;
use Services;

class AuthController extends Controller
{
    public function loginForm(): void
    {
        if ($this->user()) {
            $this->redirect('/');
            return;
        }

        $this->view('auth/login');
    }

    public function login(): void
    {
        $authService = $this->container->get(Services\AuthService::class);

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $result = $authService->login($email, $password);

        if ($result['success']) {
            $this->flash('success', __('auth.login_success', [$_SESSION['user_name']]));
            $this->redirect('/');
            return;
        }

        $this->storeOldInput();
        $this->flash('error', $result['error']);
        $this->redirect('/login');
    }

    public function registerForm(): void
    {
        if ($this->user()) {
            $this->redirect('/');
            return;
        }

        $this->view('auth/register');
    }

    public function register(): void
    {
        $authService = $this->container->get(Services\AuthService::class);

        $name            = trim($_POST['name'] ?? '');
        $email           = trim($_POST['email'] ?? '');
        $password        = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $userType        = (int) ($_POST['user_type'] ?? 0);

        if ($password !== $confirmPassword) {
            $this->storeOldInput();
            $this->flash('error', __('validation.passwords_match'));
            $this->redirect('/register');
            return;
        }

        $result = $authService->register($name, $email, $password, $userType);

        if ($result['success']) {
            $this->flash('success', __('auth.register_success'));
            $this->redirect('/login');
            return;
        }

        $this->storeOldInput();
        $errors = implode(' ', $result['errors']);
        $this->flash('error', $errors);
        $this->redirect('/register');
    }

    public function logout(): void
    {
        $authService = $this->container->get(Services\AuthService::class);
        $authService->logout();

        session_start();
        $this->flash('success', __('auth.logout_success'));
        $this->redirect('/login');
    }
}
