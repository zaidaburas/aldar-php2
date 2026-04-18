<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Request;
use App\Core\Validation;
use App\Models\Admin;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        if (Auth::check()) {
            $this->redirect('/dashboard');
        }

        $this->view('auth/login', [
            'title' => 'تسجيل الدخول',
            'csrf' => Csrf::token(),
        ]);
    }

    public function login(): void
    {
        if (!Csrf::verify(Request::input('_token'))) {
            flash('error', 'رمز الحماية غير صالح.');
            $this->redirect('/login');
        }

        $data = [
            'username' => trim((string) Request::input('username')),
            'password' => (string) Request::input('password'),
        ];

        $_SESSION['_old'] = ['username' => $data['username']];

        $errors = Validation::required($data, [
            'username' => 'اسم المستخدم',
            'password' => 'كلمة المرور',
        ]);

        if ($errors) {
            flash('error', reset($errors));
            $this->redirect('/login');
        }

        $model = new Admin();
        $admin = $model->findByUsername($data['username']);

        if (!$admin || !password_verify($data['password'], $admin['password_hash'])) {
            flash('error', 'بيانات الدخول غير صحيحة.');
            $this->redirect('/login');
        }

        unset($_SESSION['_old']);
        $model->updateLastLogin((int) $admin['id']);
        Auth::login($admin);
        flash('success', 'تم تسجيل الدخول بنجاح.');
        $this->redirect('/dashboard');
    }

    public function logout(): void
    {
        if (Csrf::verify(Request::input('_token'))) {
            Auth::logout();
            flash('success', 'تم تسجيل الخروج بنجاح.');
        }

        $this->redirect('/login');
    }
}
