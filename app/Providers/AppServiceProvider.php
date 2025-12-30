<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        $appUrl = config('app.url');

        if (! empty($appUrl)) {
            // Normalize APP_URL so it never ends with a duplicated /api segment.
            $normalizedRoot = preg_replace('#/api$#', '', rtrim($appUrl, '/'));

            if (! empty($normalizedRoot) && $normalizedRoot !== $appUrl) {
                config(['app.url' => $normalizedRoot]);
            }

            if ($this->app->environment('production')) {
                URL::forceRootUrl(config('app.url'));
            }
        }
    }
}
