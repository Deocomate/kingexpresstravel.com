<?php

namespace App\Providers;

use App\Http\View\Composers\HeaderComposer;
use App\Models\Contact;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
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

        View::composer('client.layouts.partials.header', HeaderComposer::class);

        View::composer(['client.layouts.partials.header', 'client.layouts.partials.footer'], function ($view) {
            $contactInfo = Contact::with(['branches' => function ($query) {
                $query->orderBy('is_main', 'desc');
            }])->first();
            $view->with('contactInfo', $contactInfo);
        });
    }
}
