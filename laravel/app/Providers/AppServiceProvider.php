<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\ServiceCategory;
use App\Models\Service;

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
        View::composer('*', function ($view) {
            try {
                $nav_categories = ServiceCategory::with('services')->orderBy('sort_order')->get();
                $search_services = Service::select('title', 'slug', 'tagline')->orderBy('title')->get();
            } catch (\Exception $e) {
                $nav_categories = collect();
                $search_services = collect();
            }

            $view->with([
                'nav_categories' => $nav_categories,
                'search_services' => $search_services,
            ]);
        });
    }
}
