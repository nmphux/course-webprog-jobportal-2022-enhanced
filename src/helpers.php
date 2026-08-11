<?php

define('BASE_PATH', dirname(__DIR__));

$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
define('BASE_URL', rtrim($scriptName, '/'));

function base_url(string $path = ''): string
{
    return BASE_URL . '/' . ltrim($path, '/');
}

function asset(string $path): string
{
    return BASE_URL . '/assets/' . ltrim($path, '/');
}

function upload_url(string $path): string
{
    return BASE_URL . '/uploads/' . ltrim($path, '/');
}

function redirect(string $path): void
{
    header('Location: ' . base_url($path));
    exit;
}

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function __(string $key, array $replacements = []): string
{
    static $translations = null;
    static $loadedLocale = null;

    $locale = $_SESSION['locale'] ?? 'en';

    if ($translations === null || $loadedLocale !== $locale) {
        $file = BASE_PATH . '/config/lang/' . $locale . '.php';
        $translations = file_exists($file) ? require $file : [];
        $loadedLocale = $locale;
    }

    $text = $translations[$key] ?? $key;

    if (!empty($replacements)) {
        $text = vsprintf($text, $replacements);
    }

    return $text;
}

function csrf_token(): string
{
    return $_SESSION['csrf_token'] ?? '';
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf_token" value="' . e(csrf_token()) . '">';
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function flash_messages(): string
{
    if (empty($_SESSION['flash'])) {
        return '';
    }

    $html = '<div class="toast-container" id="toastContainer">';
    $iconMap = [
        'success' => '<i class="fas fa-check-circle toast-icon"></i>',
        'error'   => '<i class="fas fa-exclamation-circle toast-icon"></i>',
        'warning' => '<i class="fas fa-exclamation-triangle toast-icon"></i>',
        'info'    => '<i class="fas fa-info-circle toast-icon"></i>',
    ];
    foreach ($_SESSION['flash'] as $msg) {
        $type = e($msg['type']);
        $text = e($msg['message']);
        $icon = $iconMap[$type] ?? $iconMap['info'];
        $html .= '<div class="toast toast-' . $type . '" role="alert">'
               . $icon
               . '<span class="toast-content">' . $text . '</span>'
               . '<button type="button" class="toast-close" aria-label="Close">&times;</button>'
               . '</div>';
    }

    $html .= '</div>';
    unset($_SESSION['flash']);
    return $html;
}

function old(string $field, string $default = ''): string
{
    $value = $_SESSION['old_input'][$field] ?? $default;
    unset($_SESSION['old_input'][$field]);
    return $value;
}

function view(string $name, array $data = [], array $options = []): void
{
    $useLayout = $options['layout'] ?? true;

    $data['csrf_token'] = csrf_token();
    $data['current_user'] = isset($_SESSION['user_id']) ? [
        'id'     => $_SESSION['user_id'],
        'name'   => $_SESSION['user_name'] ?? '',
        'type'   => $_SESSION['user_type'] ?? null,
        'avatar' => $_SESSION['user_avatar'] ?? null,
    ] : null;
    $data['locale'] = $_SESSION['locale'] ?? 'en';
    $data['flash_html'] = flash_messages();

    extract($data);

    if ($useLayout) {
        require BASE_PATH . '/src/Views/layouts/header.php';
    }
    require BASE_PATH . '/src/Views/' . $name . '.php';
    if ($useLayout) {
        require BASE_PATH . '/src/Views/layouts/footer.php';
    }
}
