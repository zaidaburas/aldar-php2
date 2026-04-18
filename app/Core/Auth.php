<?php

namespace App\Core;

class Auth
{
    public static function login(array $admin): void
    {
        Session::put(config('security.session_key'), [
            'id' => $admin['id'],
            'username' => $admin['username'],
            'name' => $admin['full_name'] ?? $admin['username'],
        ]);
    }

    public static function user(): ?array
    {
        return Session::get(config('security.session_key'));
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function logout(): void
    {
        Session::forget(config('security.session_key'));
    }
}
