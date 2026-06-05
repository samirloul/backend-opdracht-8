<?php

namespace App\Providers;

use App\Contracts\Feature2RepositoryInterface;
use App\Services\PdoFeature2Repository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Feature2RepositoryInterface::class, PdoFeature2Repository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
