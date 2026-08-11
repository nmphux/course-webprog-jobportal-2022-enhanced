<?php

namespace Middleware;

class CsrfMiddleware
{
    /**
     * Handle CSRF token generation and validation.
     *
     * - GET/HEAD requests: ensure a CSRF token exists in the session.
     * - POST/PUT/DELETE requests: validate the submitted token against the session token.
     *   On success, regenerate the token for the next request.
     */
    public function handle(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if (in_array($method, ['GET', 'HEAD'], true)) {
            $this->ensureTokenExists();
            return;
        }

        if (in_array($method, ['POST', 'PUT', 'DELETE'], true)) {
            $this->validateToken();
            $this->regenerateToken();
        }
    }

    /**
     * Generate a CSRF token if one does not already exist in the session.
     */
    private function ensureTokenExists(): void
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    /**
     * Validate the submitted CSRF token against the session token.
     * Halts execution with a 403 response on failure.
     */
    private function validateToken(): void
    {
        $sessionToken = $_SESSION['csrf_token'] ?? '';
        $submittedToken = $_POST['_csrf_token'] ?? '';

        if ($sessionToken === '' || $submittedToken === '' || !hash_equals($sessionToken, $submittedToken)) {
            http_response_code(403);
            view('errors/403', [
                'message' => 'Invalid or missing CSRF token. Please refresh the page and try again.',
            ]);
            exit;
        }
    }

    /**
     * Regenerate the CSRF token after a successful validation.
     */
    private function regenerateToken(): void
    {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}
