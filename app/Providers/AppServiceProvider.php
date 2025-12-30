<?php

namespace App\Providers;

use Illuminate\Http\Request;
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
        /** @var Request $request */
        $request = $this->app->make(Request::class);

        $appUrl = config('app.url');

        if (empty($appUrl) || str_contains($appUrl, 'localhost')) {
            $appUrl = $request->getSchemeAndHttpHost();
        }

        $normalizedRoot = preg_replace('#/api$#', '', rtrim($appUrl ?? '', '/'));

        if (! empty($normalizedRoot)) {
            config(['app.url' => $normalizedRoot]);
        }

        if ($this->app->environment('production')) {
            URL::forceRootUrl(config('app.url'));
            URL::forceScheme('https');
        }
    }
}
