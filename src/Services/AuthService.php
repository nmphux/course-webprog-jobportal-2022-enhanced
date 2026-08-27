<?php

namespace Services;

use Models\User;

class AuthService
{
    private User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function register(string $name, string $email, string $password, int $userType): array
    {
        $errors = [];

        $name = trim($name);
        $email = trim($email);

        if ($name === '') {
            $errors[] = __('validation.required');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = __('validation.email');
        }

        $config = require BASE_PATH . '/config/app.php';
        if (strlen($password) < $config['password_min_length']) {
            $errors[] = __('validation.min_length', [$config['password_min_length']]);
        }

        if (!in_array($userType, [0, 1], true)) {
            $errors[] = 'Invalid account type.';
        }

        if (empty($errors) && $this->userModel->findByEmail($email)) {
            $errors[] = __('auth.email_taken');
        }

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $userId = $this->userModel->create([
            'name'      => $name,
            'email'     => $email,
            'password'  => password_hash($password, PASSWORD_BCRYPT),
            'user_type' => $userType,
        ]);

        return ['success' => true, 'user_id' => $userId];
    }

    public function login(string $email, string $password): array
    {
        $user = $this->userModel->findByEmail(trim($email));

        if (!$user) {
            return ['success' => false, 'error' => __('auth.invalid_credentials')];
        }

        $authenticated = false;

        if (password_verify($password, $user['password'])) {
            $authenticated = true;
        } elseif (md5($password) === $user['password']) {
            $authenticated = true;
            $newHash = password_hash($password, PASSWORD_BCRYPT);
            $this->userModel->updatePassword($user['id'], $newHash);
        }

        if (!$authenticated) {
            return ['success' => false, 'error' => __('auth.invalid_credentials')];
        }

        session_regenerate_id(true);

        $_SESSION['user_id']     = $user['id'];
        $_SESSION['user_name']   = $user['name'];
        $_SESSION['user_type']   = $user['user_type'];
        $_SESSION['user_avatar'] = $user['avatar'];

        $locale = $user['language'] ?? 'en';

        if (!in_array($locale, ['en', 'vi'], true)) {
            $locale = 'en';
        }

        $_SESSION['locale'] = $locale;

        setcookie(
            'locale',
            $locale,
            [
                'expires'  => time() + (365 * 24 * 60 * 60),
                'path'     => '/',
                'secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
                'httponly' => false,
                'samesite' => 'Lax',
            ]
        );

        return ['success' => true, 'user' => $user];
    }

    public function logout(): void
    {
        $locale = $_SESSION['locale'] ?? $_COOKIE['locale'] ?? 'en';

        if (!in_array($locale, ['en', 'vi'], true)) {
            $locale = 'en';
        }
        unset(
            $_SESSION['user_id'],
            $_SESSION['user_name'],
            $_SESSION['user_type'],
            $_SESSION['user_avatar']
        );
        session_regenerate_id(true);
        $_SESSION['locale'] = $locale;

        // Keep the language
        setcookie(
            'locale',
            $locale,
            [
                'expires'  => time() + (365 * 24 * 60 * 60),
                'path'     => '/',
                'secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
                'httponly' => false,
                'samesite' => 'Lax',
            ]
        );
    }

    public function changePassword(int $userId, string $currentPassword, string $newPassword, string $confirmPassword): array
    {
        $user = $this->userModel->findById($userId);

        if (!$user) {
            return ['success' => false, 'error' => 'User not found.'];
        }

        $verified = password_verify($currentPassword, $user['password'])
                 || md5($currentPassword) === $user['password'];

        if (!$verified) {
            return ['success' => false, 'field' => 'current', 'error' => __('settings.password_incorrect')];
        }

        $config = require BASE_PATH . '/config/app.php';
        if (strlen($newPassword) < $config['password_min_length']) {
            return ['success' => false, 'field' => 'new', 'error' => __('validation.min_length', [$config['password_min_length']])];
        }

        if (password_verify($newPassword, $user['password'])) {
            return ['success' => false, 'field' => 'new', 'error' => __('settings.password_same')];
        }

        if ($newPassword !== $confirmPassword) {
            return ['success' => false, 'field' => 'confirm', 'error' => __('settings.password_mismatch')];
        }

        $this->userModel->updatePassword($userId, password_hash($newPassword, PASSWORD_BCRYPT));

        return ['success' => true];
    }
}
