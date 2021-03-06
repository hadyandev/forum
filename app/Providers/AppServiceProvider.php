<?php

namespace App\Providers;

use App\Channel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        // \View::share('channels', Channel::all());
        \View::composer('*', function ($view) {
            $view->with('channels', Channel::all());
        });
    }
}
