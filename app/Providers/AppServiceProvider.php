<?php

namespace App\Providers;

 use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;


class AppServiceProvider extends ServiceProvider
{
   
    public function register(): void
    {
        //
    }
 
    public function boot(): void
    {
        App::setLocale('ar');
        Config::set('app.locale', 'ar');
        Config::set('app.fallback_locale', 'ar');
    }
}
