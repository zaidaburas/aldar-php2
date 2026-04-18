<?php

namespace App\Core;

class Request
{
    public static function input(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
}
