<?php

namespace App\Providers;

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
    // App\Providers\AppServiceProvider.php
    public function boot()
    {
      view()->composer('*', function ($view) {
        if(request()->route('project')){
            $view->with('project', request()->route('project'));
        }
    });
}

}
