<?php

namespace App\Core;

class Csrf
{
    public static function token(): string
    {
        $key = config('security.csrf_key');

        if (empty($_SESSION[$key])) {
            $_SESSION[$key] = bin2hex(random_bytes(32));
        }

        return $_SESSION[$key];
    }

    public static function verify(?string $token): bool
    {
        $key = config('security.csrf_key');
        return isset($_SESSION[$key]) && is_string($token) && hash_equals($_SESSION[$key], $token);
    }
}
