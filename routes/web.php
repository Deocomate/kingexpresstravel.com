<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\CustomerCareController;

use App\Http\Middleware\Auth\AdminAuthMiddleware;

Route::get("/", function () {
    return to_route("admin.dashboard.index");
});


// --- Admin Authentication Routes ---
Route::get('/admin/login', [AdminAuthController::class, "login"])->name("admin.login");
Route::get('/admin/logout', [AdminAuthController::class, "logout"])->name("admin.logout");
Route::post('/admin/authenticate', [AdminAuthController::class, "authenticate"])->name("admin.authenticate");


Route::prefix('admin')->name("admin.")->middleware(AdminAuthMiddleware::class)->group(function () {
    // Dashboard & Homepage Management
    Route::get("/dashboard", [AdminBaseController::class, "index"])->name("dashboard.index");

    // Modules
    Route::resource('categories', CategoryController::class);
    Route::resource('about-us', AboutUsController::class)->except(['show']);
    Route::resource('customer-care', CustomerCareController::class)->except(['create', 'store', 'edit', 'update']);
});


Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');

Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');
