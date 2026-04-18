<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Request;
use App\Core\Upload;
use App\Core\Validation;
use App\Middleware\AuthMiddleware;
use App\Models\SliderAd;

class SliderController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::handle();
        $model = new SliderAd();
        $this->view('slider/index', [
            'title' => 'إدارة السلايدر',
            'csrf' => Csrf::token(),
            'slides' => $model->all(),
        ]);
    }

    public function create(): void
    {
        AuthMiddleware::handle();
        $this->view('slider/form', [
            'title' => 'إضافة شريحة جديدة',
            'csrf' => Csrf::token(),
            'slide' => null,
            'formAction' => '/slider/store',
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
        $model = new SliderAd();
        $id = (int) Request::input('id');
        $slide = $model->find($id);

        if (!$slide) {
            flash('error', 'الشريحة المطلوبة غير موجودة.');
            $this->redirect('/slider');
        }

        $this->view('slider/form', [
            'title' => 'تعديل الشريحة',
            'csrf' => Csrf::token(),
            'slide' => $slide,
            'formAction' => '/slider/update?id=' . $id,
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
            $this->redirect('/slider');
        }

        $model = new SliderAd();
        $existing = $id ? $model->find($id) : null;
        $data = [
            'title' => trim((string) Request::input('title')),
            'subtitle' => trim((string) Request::input('subtitle')),
            'button_text' => trim((string) Request::input('button_text')),
            'link_url' => trim((string) Request::input('link_url')),
            'sort_order' => (int) Request::input('sort_order', 0),
            'is_active' => Request::input('is_active') ? 1 : 0,
            'image_path' => $existing['image_path'] ?? null,
        ];

        $errors = Validation::required($data, ['title' => 'عنوان الشريحة']);

        try {
            $uploadedImage = Upload::image('image', 'slider');
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
            $errors['image'] = 'صورة الشريحة مطلوبة.';
        }

        if ($errors) {
            flash('error', reset($errors));
            $_SESSION['_old'] = $data;
            $this->redirect($id ? '/slider/edit?id=' . $id : '/slider/create');
        }

        unset($_SESSION['_old']);

        if ($id) {
            $model->update($id, $data);
            flash('success', 'تم تحديث الشريحة بنجاح.');
        } else {
            $model->create($data);
            flash('success', 'تم إضافة الشريحة بنجاح.');
        }

        $this->redirect('/slider');
    }

    public function delete(): void
    {
        AuthMiddleware::handle();

        if (!Csrf::verify(Request::input('_token'))) {
            flash('error', 'رمز الحماية غير صالح.');
            $this->redirect('/slider');
        }

        $id = (int) Request::input('id');
        $model = new SliderAd();
        $slide = $model->find($id);

        if (!$slide) {
            flash('error', 'الشريحة غير موجودة.');
            $this->redirect('/slider');
        }

        Upload::remove($slide['image_path'] ?? null);
        $model->delete($id);
        flash('success', 'تم حذف الشريحة بنجاح.');
        $this->redirect('/slider');
    }
}
