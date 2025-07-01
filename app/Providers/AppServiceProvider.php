<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
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
        Http::macro('github', function () {
            return Http::withToken(config('app.github_personal_token'))
                ->withHeader('X-GitHub-Api-Version', config('app.github_api_version'))
                ->baseUrl(config('app.github_base_api_url'));
        });
    }
}
