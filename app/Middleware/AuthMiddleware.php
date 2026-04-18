<?php

namespace App\Middleware;

use App\Core\Auth;

class AuthMiddleware
{
    public static function handle(): void
    {
        if (!Auth::check()) {
            flash('error', 'يجب تسجيل الدخول أولاً.');
            redirect('/login');
        }
    }
}
