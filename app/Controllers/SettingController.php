<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Request;
use App\Middleware\AuthMiddleware;
use App\Models\Item;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::handle();

        $settingModel = new Setting();
        $itemModel = new Item();

        $this->view('settings/index', [
            'title' => 'الإعدادات العامة',
            'csrf' => Csrf::token(),
            'settings' => $settingModel->allKeyValue(),
            'definitions' => $settingModel->definitions(),
            'featuredItems' => $itemModel->optionsForFeatured(),
        ]);
    }

    public function update(): void
    {
        AuthMiddleware::handle();

        if (!Csrf::verify(Request::input('_token'))) {
            flash('error', 'رمز الحماية غير صالح.');
            $this->redirect('/settings');
        }

        $settingModel = new Setting();
        $itemModel = new Item();
        $featuredItemId = (int) Request::input('featured_item_id', 0);

        if ($featuredItemId > 0 && !$itemModel->isSelectableFeatured($featuredItemId)) {
            flash('error', 'الوجبة المميزة المختارة غير موجودة أو غير نشطة.');
            $this->redirect('/settings');
        }

        $payload = [
            'site_title' => trim((string) Request::input('site_title')),
            'site_description' => trim((string) Request::input('site_description')),
            'order_now_url' => trim((string) Request::input('order_now_url')),
            'whatsapp_url' => trim((string) Request::input('whatsapp_url')),
            'contact_url' => trim((string) Request::input('contact_url')),
            'topbar_text' => trim((string) Request::input('topbar_text')),
            'hero_title' => trim((string) Request::input('hero_title')),
            'hero_description' => trim((string) Request::input('hero_description')),
            'about_text' => trim((string) Request::input('about_text')),
            'featured_item_id' => $featuredItemId > 0 ? (string) $featuredItemId : null,
        ];

        $settingModel->upsertMany($payload);
        flash('success', 'تم تحديث الإعدادات العامة بنجاح.');
        $this->redirect('/settings');
    }
}
