<?php

use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerCareController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Middleware\Auth\AdminAuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return to_route("admin.dashboard.index");
});


Route::get('/admin/login', [AdminAuthController::class, "login"])->name("admin.login");
Route::get('/admin/logout', [AdminAuthController::class, "logout"])->name("admin.logout");
Route::post('/admin/authenticate', [AdminAuthController::class, "authenticate"])->name("admin.authenticate");


Route::prefix('admin')->name("admin.")->middleware(AdminAuthMiddleware::class)->group(function () {
    Route::get("/dashboard", [AdminBaseController::class, "index"])->name("dashboard.index");

    Route::resource('categories', CategoryController::class);
    Route::resource('news', NewsController::class);
    Route::resource('about-us', AboutUsController::class)->except(['show']);
    Route::resource('customer-care', CustomerCareController::class)->except(['create', 'store', 'edit', 'update']);
});


Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');

Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');
