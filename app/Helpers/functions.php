<?php

if (!function_exists('config')) {
    function config(?string $key = null, mixed $default = null): mixed
    {
        static $config;

        if (!$config) {
            $config = require APP_PATH . '/Config/config.php';
        }

        if ($key === null) {
            return $config;
        }

        $segments = explode('.', $key);
        $value = $config;

        foreach ($segments as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }
}

if (!function_exists('redirect')) {
    function redirect(string $path): never
    {
        header('Location: ' . $path);
        exit;
    }
}

if (!function_exists('old')) {
    function old(string $key, mixed $default = ''): mixed
    {
        return $_SESSION['_old'][$key] ?? $default;
    }
}

if (!function_exists('flash')) {
    function flash(string $key, ?string $message = null): ?string
    {
        if ($message !== null) {
            $_SESSION['_flash'][$key] = $message;
            return null;
        }

        $value = $_SESSION['_flash'][$key] ?? null;
        unset($_SESSION['_flash'][$key]);
        return $value;
    }
}

if (!function_exists('view')) {
    function view(string $template, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        require APP_PATH . '/Views/' . $template . '.php';
    }
}

if (!function_exists('e')) {
    function e(null|string|int|float $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('base_url')) {
    function base_url(): string
    {
        return rtrim((string) config('app.url', ''), '/');
    }
}

if (!function_exists('url')) {
    function url(string $path = ''): string
    {
        $path = '/' . ltrim($path, '/');
        $base = base_url();
        return $base !== '' ? $base . $path : $path;
    }
}

if (!function_exists('asset_url')) {
    function asset_url(string $path = ''): string
    {
        return url($path);
    }
}

if (!function_exists('upload_url')) {
    function upload_url(?string $relativePath = null): string
    {
        $base = trim((string) config('uploads.base_url', '/storage/uploads'), '/');

        if (!$relativePath) {
            return url($base);
        }

        return url($base . '/' . ltrim($relativePath, '/'));
    }
}

if (!function_exists('is_active_path')) {
    function is_active_path(string $path): bool
    {
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        return str_starts_with(rtrim($uri, '/'), rtrim($path, '/'));
    }
}

if (!function_exists('selected')) {
    function selected(mixed $value, mixed $expected): string
    {
        return (string) $value === (string) $expected ? 'selected' : '';
    }
}

if (!function_exists('checked')) {
    function checked(mixed $value): string
    {
        return (int) $value === 1 ? 'checked' : '';
    }
}

if (!function_exists('slugify')) {
    function slugify(string $text): string
    {
        $text = trim($text);
        $text = preg_replace('/\s+/u', '-', $text);
        $text = preg_replace('/[^\p{Arabic}\p{L}\p{N}\-_]+/u', '', $text);
        $text = preg_replace('/-+/u', '-', $text);
        return trim((string) $text, '-');
    }
}
