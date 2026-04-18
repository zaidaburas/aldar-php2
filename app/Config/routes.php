<?php

return [
    ['GET', '/', 'AuthController@showLogin'],
    ['GET', '/login', 'AuthController@showLogin'],
    ['POST', '/login', 'AuthController@login'],
    ['POST', '/logout', 'AuthController@logout'],

    ['GET', '/dashboard', 'DashboardController@index'],

    ['GET', '/categories', 'CategoryController@index'],
    ['GET', '/categories/create', 'CategoryController@create'],
    ['POST', '/categories/store', 'CategoryController@store'],
    ['GET', '/categories/edit', 'CategoryController@edit'],
    ['POST', '/categories/update', 'CategoryController@update'],
    ['POST', '/categories/delete', 'CategoryController@delete'],

    ['GET', '/items', 'ItemController@index'],
    ['GET', '/items/create', 'ItemController@create'],
    ['POST', '/items/store', 'ItemController@store'],
    ['GET', '/items/edit', 'ItemController@edit'],
    ['POST', '/items/update', 'ItemController@update'],
    ['POST', '/items/delete', 'ItemController@delete'],

    ['GET', '/slider', 'SliderController@index'],
    ['GET', '/slider/create', 'SliderController@create'],
    ['POST', '/slider/store', 'SliderController@store'],
    ['GET', '/slider/edit', 'SliderController@edit'],
    ['POST', '/slider/update', 'SliderController@update'],
    ['POST', '/slider/delete', 'SliderController@delete'],

    ['GET', '/gallery', 'GalleryController@index'],
    ['GET', '/gallery/create', 'GalleryController@create'],
    ['POST', '/gallery/store', 'GalleryController@store'],
    ['GET', '/gallery/edit', 'GalleryController@edit'],
    ['POST', '/gallery/update', 'GalleryController@update'],
    ['POST', '/gallery/delete', 'GalleryController@delete'],

    ['GET', '/settings', 'SettingController@index'],
    ['POST', '/settings/update', 'SettingController@update'],
];
