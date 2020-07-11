<?php

namespace App\Providers;

use App\Core\Interfaces\DownloaderInterface;
use App\Core\News\Services\HttpDownloader;
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
        $this->app->bind(
            DownloaderInterface::class,
            HttpDownloader::class
        );
    }
}
