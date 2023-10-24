<?php

namespace Ariefadjie\Laravai;

use Illuminate\Support\ServiceProvider;

class LaravaiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('ariefadjie.laravai.lingkaran', \Ariefadjie\Laravai\Services\Lingkaran::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }
}
