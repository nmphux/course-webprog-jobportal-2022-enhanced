<?php

namespace Core;

use PDO;

class Controller
{
    protected ServiceContainer $container;
    protected PDO $db;

    public function __construct(ServiceContainer $container)
    {
        $this->container = $container;
        $this->db = $container->get('db');
    }

    /**
     * Render a view with merged global data.
     *
     * @param string $name View file path relative to Views/ (without .php)
     * @param array  $data Variables to pass to the view
     */
    protected function view(string $name, array $data = []): void
    {
        view($name, $data);
    }

    /**
     * Redirect to a path within the application.
     */
    protected function redirect(string $path): void
    {
        redirect($path);
    }

    /**
     * Send a JSON response.
     *
     * @param mixed $data   Data to encode as JSON
     * @param int   $status HTTP status code
     */
    protected function json(mixed $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Add a flash message to the session.
     *
     * @param string $type    Message type (e.g., 'success', 'error', 'warning', 'info')
     * @param string $message The message text
     */
    protected function flash(string $type, string $message): void
    {
        $_SESSION['flash'][] = [
            'type'    => $type,
            'message' => $message,
        ];
    }

    /**
     * Get the currently authenticated user's session data, or null if not logged in.
     *
     * @return array{user_id: int, user_name: string, user_type: int, user_avatar: string|null}|null
     */
    protected function user(): ?array
    {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        return [
            'user_id'     => $_SESSION['user_id'],
            'user_name'   => $_SESSION['user_name'] ?? '',
            'user_type'   => $_SESSION['user_type'] ?? 0,
            'user_avatar' => $_SESSION['user_avatar'] ?? null,
        ];
    }

    /**
     * Require that an ownership condition is met. If not, respond with 403.
     *
     * @param bool $condition True if the current user owns the resource
     */
    protected function requireOwnership(bool $condition): void
    {
        if (!$condition) {
            http_response_code(403);
            view('errors/403', [
                'message' => 'You do not have permission to access this resource.',
            ]);
            exit;
        }
    }

    /**
     * Store the current POST data in session for repopulating forms after redirect.
     */
    protected function storeOldInput(): void
    {
        $_SESSION['old_input'] = $_POST;
    }

}
