<?php

use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\CustomerCareController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\TourController as AdminTourController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\ClientAboutController;
use App\Http\Controllers\Client\ClientAuthController;
use App\Http\Controllers\Client\ClientBaseController;
use App\Http\Controllers\Client\ClientCheckoutController;
use App\Http\Controllers\Client\ClientContactController;
use App\Http\Controllers\Client\ClientNewsController;
use App\Http\Controllers\Client\ClientProfileController;
use App\Http\Controllers\Client\ClientTourController;
use App\Http\Middleware\Auth\AdminAuthMiddleware;
use Illuminate\Support\Facades\Route;

// Client Routes
Route::get('/', [ClientBaseController::class, 'index'])->name('client.home');
Route::get('/du-lich', [ClientTourController::class, 'index'])->name('client.tours');
Route::get('/du-lich/{tour:slug}', [ClientTourController::class, 'show'])->name('client.tour.show');
Route::get('/tin-tuc', [ClientNewsController::class, 'index'])->name('client.news');
Route::get('/tin-tuc/{news:slug}', [ClientNewsController::class, 'show'])->name('client.news.show');
Route::get('/gioi-thieu', [ClientAboutController::class, 'index'])->name('client.about');
Route::get('/lien-he', [ClientContactController::class, 'index'])->name('client.contact');
Route::post('/lien-he', [ClientContactController::class, 'store'])->name('client.contact.submit');


// Client Authentication POST Routes
Route::post('/login', [ClientAuthController::class, 'handleLogin'])->name('client.login.submit');
Route::post('/register', [ClientAuthController::class, 'handleRegistration'])->name('client.register.submit');
Route::post('/forgot-password', [ClientAuthController::class, 'handleForgotPassword'])->name('client.forgot-password.submit');
Route::post('/logout', [ClientAuthController::class, 'logout'])->name('client.logout');

// Checkout Routes (for both guests and authenticated users)
Route::get('/dat-tour/{tour:slug}', [ClientCheckoutController::class, 'index'])->name('client.checkout');
Route::post('/dat-tour/{tour:slug}', [ClientCheckoutController::class, 'store'])
    ->middleware('throttle:2,1')
    ->name('client.checkout.store');


// Client Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/tai-khoan', [ClientProfileController::class, 'index'])->name('client.profile');
    Route::put('/tai-khoan', [ClientProfileController::class, 'update'])->name('client.profile.update');
    Route::get('/tai-khoan/lich-su-dat-tour', [ClientProfileController::class, 'bookingHistory'])->name('client.profile.history');
});


// Admin Routes
Route::get('/admin', function () {
    return to_route('admin.dashboard.index');
});

Route::get('/admin/login', [AdminAuthController::class, "login"])->name("admin.login");
Route::get('/admin/logout', [AdminAuthController::class, "logout"])->name("admin.logout");
Route::post('/admin/authenticate', [AdminAuthController::class, "authenticate"])->name("admin.authenticate");


Route::prefix('admin')->name("admin.")->middleware(AdminAuthMiddleware::class)->group(function () {
    Route::get("/dashboard", [AdminBaseController::class, "index"])->name("dashboard.index");
    Route::get('/dashboard/chart-data', [AdminBaseController::class, 'getChartData'])->name('dashboard.chartData');

    Route::post('categories/update-order', [CategoryController::class, 'updateOrder'])->name('categories.updateOrder');
    Route::resource('categories', CategoryController::class);
    Route::resource('news', AdminNewsController::class);
    Route::resource('tours', AdminTourController::class);
    Route::resource('destinations', DestinationController::class);
    Route::resource('customer-care', CustomerCareController::class)->except(['create', 'store', 'edit', 'update']);

    // About Us Routes
    Route::get('about-us', [AboutUsController::class, 'edit'])->name('about-us.edit');
    Route::put('about-us', [AboutUsController::class, 'update'])->name('about-us.update');

    Route::get('contacts', [AdminContactController::class, 'edit'])->name('contacts.edit');
    Route::put('contacts', [AdminContactController::class, 'update'])->name('contacts.update');

    Route::resource('users', UserController::class);
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::resource('orders', OrderController::class)->except(['create', 'store', 'edit', 'update']);
});


Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');

Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');
