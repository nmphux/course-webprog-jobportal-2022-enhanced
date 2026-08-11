<?php

namespace Middleware;

class AuthMiddleware
{
    /**
     * Verify the user is authenticated and optionally has the required role.
     *
     * @param string|null $role 'employer', 'candidate', or null for any authenticated user
     */
    public function handle(?string $role = null): void
    {
        $isAjax = $this->isAjaxRequest();

        // Check authentication
        if (!isset($_SESSION['user_id'])) {
            if ($isAjax) {
                $this->jsonResponse(401, 'Authentication required. Please log in.');
            }
            redirect('login');
        }

        // Check role-based authorization
        if ($role === null) {
            return;
        }

        $userType = $_SESSION['user_type'] ?? null;
        $authorized = false;

        if ($role === 'employer' && $userType == 1) {
            $authorized = true;
        } elseif ($role === 'candidate' && $userType == 0) {
            $authorized = true;
        }

        if (!$authorized) {
            if ($isAjax) {
                $this->jsonResponse(403, 'You do not have permission to access this resource.');
            }

            http_response_code(403);
            view('errors/403', [
                'message' => 'You do not have permission to access this resource.',
            ]);
            exit;
        }
    }

    /**
     * Detect if the current request is an AJAX/XHR request.
     */
    private function isAjaxRequest(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * Send a JSON error response and halt execution.
     */
    private function jsonResponse(int $status, string $message): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'error'   => true,
            'message' => $message,
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}
