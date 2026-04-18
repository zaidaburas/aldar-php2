<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Request;
use App\Core\Validation;
use App\Middleware\AuthMiddleware;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::handle();

        $model = new Category();
        $this->view('categories/index', [
            'title' => 'إدارة الأقسام',
            'csrf' => Csrf::token(),
            'categories' => $model->all(),
        ]);
    }

    public function create(): void
    {
        AuthMiddleware::handle();
        $this->view('categories/form', [
            'title' => 'إضافة قسم جديد',
            'csrf' => Csrf::token(),
            'category' => null,
            'formAction' => '/categories/store',
        ]);
    }

    public function store(): void
    {
        AuthMiddleware::handle();
        $this->save();
    }

    public function edit(): void
    {
        AuthMiddleware::handle();
        $model = new Category();
        $id = (int) Request::input('id');
        $category = $model->find($id);

        if (!$category) {
            flash('error', 'القسم المطلوب غير موجود.');
            $this->redirect('/categories');
        }

        $this->view('categories/form', [
            'title' => 'تعديل القسم',
            'csrf' => Csrf::token(),
            'category' => $category,
            'formAction' => '/categories/update?id=' . $id,
        ]);
    }

    public function update(): void
    {
        AuthMiddleware::handle();
        $this->save((int) Request::input('id'));
    }

    private function save(?int $id = null): void
    {
        if (!Csrf::verify(Request::input('_token'))) {
            flash('error', 'رمز الحماية غير صالح.');
            $this->redirect('/categories');
        }

        $data = [
            'name' => trim((string) Request::input('name')),
            'slug' => trim((string) Request::input('slug')),
            'icon' => trim((string) Request::input('icon')),
            'description' => trim((string) Request::input('description')),
            'sort_order' => (int) Request::input('sort_order', 0),
            'is_active' => Request::input('is_active') ? 1 : 0,
        ];

        $errors = Validation::required($data, ['name' => 'اسم القسم']);
        $data['slug'] = $data['slug'] !== '' ? slugify($data['slug']) : slugify($data['name']);

        if ($data['slug'] === '') {
            $errors['slug'] = 'تعذر إنشاء slug صالح لهذا القسم.';
        }

        $model = new Category();
        if ($model->slugExists($data['slug'], $id)) {
            $errors['slug'] = 'هذا الرابط المختصر مستخدم بالفعل لقسم آخر.';
        }

        if ($errors) {
            flash('error', reset($errors));
            $_SESSION['_old'] = $data;
            $this->redirect($id ? '/categories/edit?id=' . $id : '/categories/create');
        }

        unset($_SESSION['_old']);

        if ($id) {
            $model->update($id, $data);
            flash('success', 'تم تحديث القسم بنجاح.');
        } else {
            $model->create($data);
            flash('success', 'تم إضافة القسم بنجاح.');
        }

        $this->redirect('/categories');
    }

    public function delete(): void
    {
        AuthMiddleware::handle();

        if (!Csrf::verify(Request::input('_token'))) {
            flash('error', 'رمز الحماية غير صالح.');
            $this->redirect('/categories');
        }

        $id = (int) Request::input('id');
        $model = new Category();
        $category = $model->find($id);

        if (!$category) {
            flash('error', 'القسم غير موجود.');
            $this->redirect('/categories');
        }

        if ($model->hasItems($id)) {
            flash('error', 'لا يمكن حذف قسم يحتوي على أصناف. انقل الأصناف أو احذفها أولاً.');
            $this->redirect('/categories');
        }

        $model->delete($id);
        flash('success', 'تم حذف القسم بنجاح.');
        $this->redirect('/categories');
    }
}
