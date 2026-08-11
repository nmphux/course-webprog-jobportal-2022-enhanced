<?php

namespace Middleware;

class LocaleMiddleware
{
    /**
     * Determine and set the active locale.
     *
     * Priority: $_GET['lang'] -> $_SESSION['locale'] -> cookie 'locale' -> 'en'
     *
     * If a lang query parameter is present, it is persisted and the user is
     * redirected to the same URL without the parameter (clean URL).
     */
    public function handle(): void
    {
        $config = require BASE_PATH . '/config/app.php';
        $supported = $config['supported_locales'];
        $default = $config['default_locale'];

        // 1. Explicit lang query parameter — highest priority
        if (isset($_GET['lang'])) {
            $lang = $_GET['lang'];

            if (in_array($lang, $supported, true)) {
                $this->persistLocale($lang);
            }

            // Redirect to the same URL without the lang parameter
            $this->redirectWithoutLang();
            return;
        }

        // 2. Session locale
        if (isset($_SESSION['locale']) && in_array($_SESSION['locale'], $supported, true)) {
            return; // Already set in session, nothing to do
        }

        // 3. Cookie locale
        if (isset($_COOKIE['locale']) && in_array($_COOKIE['locale'], $supported, true)) {
            $_SESSION['locale'] = $_COOKIE['locale'];
            return;
        }

        // 4. Default locale
        $this->persistLocale($default);
    }

    /**
     * Store the locale in both session and cookie.
     */
    private function persistLocale(string $locale): void
    {
        $_SESSION['locale'] = $locale;
        setcookie('locale', $locale, [
            'expires'  => time() + (30 * 24 * 60 * 60), // 30 days
            'path'     => '/',
            'httponly'  => false,
            'samesite' => 'Lax',
        ]);
    }

    /**
     * Redirect to the current URL without the 'lang' query parameter.
     */
    private function redirectWithoutLang(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI']);
        $path = $uri['path'] ?? '/';

        // Rebuild query string without 'lang'
        $query = [];
        if (isset($uri['query'])) {
            parse_str($uri['query'], $query);
        }
        unset($query['lang']);

        $url = $path;
        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        header('Location: ' . $url);
        exit;
    }
}
