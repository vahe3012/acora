<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Menu;
use App\Services\HelperService;
use App\Services\MenuService;
use App\Services\Settings\SettingsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        View::composer('front.*', function ($view) {
            $view->with('settings', app(SettingsService::class));
//            $view->with('helper', app(HelperService::class));
//            $view->with('menu', app(MenuService::class));

        });
    }
}
