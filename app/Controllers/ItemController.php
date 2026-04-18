<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Request;
use App\Core\Upload;
use App\Core\Validation;
use App\Middleware\AuthMiddleware;
use App\Models\Category;
use App\Models\Item;
use App\Models\Setting;

class ItemController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::handle();

        $filters = [
            'category_id' => (int) Request::input('category_id'),
            'search' => trim((string) Request::input('search')),
        ];

        $itemModel = new Item();
        $categoryModel = new Category();

        $this->view('items/index', [
            'title' => 'إدارة الأصناف',
            'csrf' => Csrf::token(),
            'items' => $itemModel->all($filters),
            'categories' => $categoryModel->options(),
            'filters' => $filters,
            'popularCount' => $itemModel->popularCount(),
        ]);
    }

    public function create(): void
    {
        AuthMiddleware::handle();
        $categoryModel = new Category();
        $this->view('items/form', [
            'title' => 'إضافة صنف جديد',
            'csrf' => Csrf::token(),
            'item' => null,
            'categories' => $categoryModel->options(),
            'formAction' => '/items/store',
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

        $itemModel = new Item();
        $categoryModel = new Category();
        $id = (int) Request::input('id');
        $item = $itemModel->find($id);

        if (!$item) {
            flash('error', 'الصنف المطلوب غير موجود.');
            $this->redirect('/items');
        }

        $this->view('items/form', [
            'title' => 'تعديل الصنف',
            'csrf' => Csrf::token(),
            'item' => $item,
            'categories' => $categoryModel->options(),
            'formAction' => '/items/update?id=' . $id,
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
            $this->redirect('/items');
        }

        $itemModel = new Item();
        $categoryModel = new Category();
        $existing = $id ? $itemModel->find($id) : null;

        $data = [
            'category_id' => (int) Request::input('category_id'),
            'name' => trim((string) Request::input('name')),
            'slug' => trim((string) Request::input('slug')),
            'short_description' => trim((string) Request::input('short_description')),
            'description' => trim((string) Request::input('description')),
            'price' => trim((string) Request::input('price')),
            'icon' => trim((string) Request::input('icon')),
            'is_popular' => Request::input('is_popular') ? 1 : 0,
            'is_active' => Request::input('is_active') ? 1 : 0,
            'sort_order' => (int) Request::input('sort_order', 0),
            'image_path' => $existing['image_path'] ?? null,
        ];

        $errors = Validation::required($data, [
            'category_id' => 'القسم',
            'name' => 'اسم الصنف',
            'price' => 'السعر',
        ]);

        if ($data['category_id'] <= 0 || !$categoryModel->find($data['category_id'])) {
            $errors['category_id'] = 'اختر قسمًا صالحًا.';
        }

        if (!is_numeric($data['price'])) {
            $errors['price'] = 'السعر يجب أن يكون رقمًا صالحًا.';
        }

        $data['slug'] = $data['slug'] !== '' ? slugify($data['slug']) : slugify($data['name']);
        if ($data['slug'] === '') {
            $errors['slug'] = 'تعذر إنشاء slug صالح لهذا الصنف.';
        }

        if ($itemModel->slugExists($data['slug'], $id)) {
            $errors['slug'] = 'هذا الرابط المختصر مستخدم بالفعل لصنف آخر.';
        }

        $popularCount = $itemModel->popularCountExcluding($id);
        if ($data['is_popular'] === 1 && $popularCount >= 6) {
            $errors['is_popular'] = 'لا يمكن تحديد أكثر من 6 أصناف كأكثر طلبًا.';
        }

        try {
            $uploadedImage = Upload::image('image', 'items');
            if ($uploadedImage) {
                if (!empty($existing['image_path'])) {
                    Upload::remove($existing['image_path']);
                }
                $data['image_path'] = $uploadedImage;
            }
        } catch (\RuntimeException $e) {
            $errors['image'] = $e->getMessage();
        }

        if ($errors) {
            flash('error', reset($errors));
            $_SESSION['_old'] = $data;
            $this->redirect($id ? '/items/edit?id=' . $id : '/items/create');
        }

        unset($_SESSION['_old']);
        $data['price'] = number_format((float) $data['price'], 2, '.', '');

        if ($id) {
            $itemModel->update($id, $data);
            flash('success', 'تم تحديث الصنف بنجاح.');
        } else {
            $itemModel->create($data);
            flash('success', 'تم إضافة الصنف بنجاح.');
        }

        $this->redirect('/items');
    }

    public function delete(): void
    {
        AuthMiddleware::handle();

        if (!Csrf::verify(Request::input('_token'))) {
            flash('error', 'رمز الحماية غير صالح.');
            $this->redirect('/items');
        }

        $id = (int) Request::input('id');
        $itemModel = new Item();
        $item = $itemModel->find($id);

        if (!$item) {
            flash('error', 'الصنف غير موجود.');
            $this->redirect('/items');
        }

        if (!empty($item['image_path'])) {
            Upload::remove($item['image_path']);
        }

        $settingModel = new Setting();
        $settings = $settingModel->allKeyValue();
        if ((int) ($settings['featured_item_id'] ?? 0) === $id) {
            $settingModel->setValue('featured_item_id', null, 'select', 'featured');
        }

        $itemModel->delete($id);
        flash('success', 'تم حذف الصنف بنجاح.');
        $this->redirect('/items');
    }
}
