<?php

namespace App\Providers;

use App\Core\Interfaces\DownloaderInterface;
use App\Core\Interfaces\NewsBuilderInterface;
use App\Core\News\Services\ActualNewsDownloader;
use App\Core\News\Services\NewsBuilder;
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
        $this->app->bind(DownloaderInterface::class, ActualNewsDownloader::class);
        $this->app->bind(NewsBuilderInterface::class, NewsBuilder::class);
    }
}
