<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Middleware\AuthMiddleware;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Item;
use App\Models\SliderAd;

class DashboardController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::handle();

        $categoryModel = new Category();
        $itemModel = new Item();
        $sliderModel = new SliderAd();
        $galleryModel = new Gallery();

        $this->view('dashboard/index', [
            'title' => 'لوحة التحكم',
            'csrf' => Csrf::token(),
            'stats' => [
                'categories' => $categoryModel->count(),
                'items' => $itemModel->count(),
                'popular_items' => $itemModel->popularCount(),
                'active_items' => $itemModel->activeCount(),
                'slider_ads' => $sliderModel->countActive(),
                'gallery' => $galleryModel->countActive(),
            ],
        ]);
    }
}
