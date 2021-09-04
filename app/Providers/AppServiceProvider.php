<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// Used to mess with URLs
use Illuminate\Routing\UrlGenerator;

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
    public function boot(UrlGenerator $url)
    {
        // If we are on a production environment, generate a secure URL!
        if (env('APP_ENV') !== 'local') {
            $url->forceScheme('https');
        }
    }
}
