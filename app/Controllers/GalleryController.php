<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Request;
use App\Core\Upload;
use App\Core\Validation;
use App\Middleware\AuthMiddleware;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::handle();
        $model = new Gallery();
        $this->view('gallery/index', [
            'title' => 'إدارة معرض الصور',
            'csrf' => Csrf::token(),
            'images' => $model->all(),
        ]);
    }

    public function create(): void
    {
        AuthMiddleware::handle();
        $this->view('gallery/form', [
            'title' => 'إضافة صورة للمعرض',
            'csrf' => Csrf::token(),
            'image' => null,
            'formAction' => '/gallery/store',
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
        $model = new Gallery();
        $id = (int) Request::input('id');
        $image = $model->find($id);

        if (!$image) {
            flash('error', 'الصورة المطلوبة غير موجودة.');
            $this->redirect('/gallery');
        }

        $this->view('gallery/form', [
            'title' => 'تعديل صورة المعرض',
            'csrf' => Csrf::token(),
            'image' => $image,
            'formAction' => '/gallery/update?id=' . $id,
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
            $this->redirect('/gallery');
        }

        $model = new Gallery();
        $existing = $id ? $model->find($id) : null;
        $data = [
            'title' => trim((string) Request::input('title')),
            'sort_order' => (int) Request::input('sort_order', 0),
            'is_active' => Request::input('is_active') ? 1 : 0,
            'image_path' => $existing['image_path'] ?? null,
        ];

        $errors = Validation::required($data, ['title' => 'عنوان الصورة']);

        try {
            $uploadedImage = Upload::image('image', 'gallery');
            if ($uploadedImage) {
                if (!empty($existing['image_path'])) {
                    Upload::remove($existing['image_path']);
                }
                $data['image_path'] = $uploadedImage;
            }
        } catch (\RuntimeException $e) {
            $errors['image'] = $e->getMessage();
        }

        if (!$data['image_path']) {
            $errors['image'] = 'صورة المعرض مطلوبة.';
        }

        if ($errors) {
            flash('error', reset($errors));
            $_SESSION['_old'] = $data;
            $this->redirect($id ? '/gallery/edit?id=' . $id : '/gallery/create');
        }

        unset($_SESSION['_old']);

        if ($id) {
            $model->update($id, $data);
            flash('success', 'تم تحديث صورة المعرض بنجاح.');
        } else {
            $model->create($data);
            flash('success', 'تمت إضافة صورة المعرض بنجاح.');
        }

        $this->redirect('/gallery');
    }

    public function delete(): void
    {
        AuthMiddleware::handle();

        if (!Csrf::verify(Request::input('_token'))) {
            flash('error', 'رمز الحماية غير صالح.');
            $this->redirect('/gallery');
        }

        $id = (int) Request::input('id');
        $model = new Gallery();
        $image = $model->find($id);

        if (!$image) {
            flash('error', 'الصورة غير موجودة.');
            $this->redirect('/gallery');
        }

        Upload::remove($image['image_path'] ?? null);
        $model->delete($id);
        flash('success', 'تم حذف الصورة بنجاح.');
        $this->redirect('/gallery');
    }
}
