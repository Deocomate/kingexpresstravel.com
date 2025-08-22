<?php

namespace App\Providers;

use App\Http\View\Composers\HeaderComposer; // Dòng này phải ở đây
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View; // Dòng này phải ở đây
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();

        // Đảm bảo bạn đã thêm dòng này vào đúng phương thức boot()
        View::composer('client.layouts.partials.header', HeaderComposer::class);
    }
}
