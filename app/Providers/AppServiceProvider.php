<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('frontend.*', function ($view) {
            $view->with('placeholder', asset('images/placeholder.png'));
            });

        if (App::environment('local'))
        { 
           View::composer('*', function ($view) {
            $view->with('novalidate', 'novalidate');
            });
        }
        else
        {
            View::composer('*', function ($view) {
            $view->with('novalidate', null);
            });
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    
    public function register()
    {
        $this->app->bind(\App\Enjoythetrip\Interfaces\FrontendRepositoryInterface::class,function()
        {            
            return new \App\Enjoythetrip\Repositories\FrontendRepository;
        });
        
        
        $this->app->bind(\App\Enjoythetrip\Interfaces\BackendRepositoryInterface::class,function()
        {            
            return new \App\Enjoythetrip\Repositories\BackendRepository;
        });
    }
}

