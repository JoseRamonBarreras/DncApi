<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UploadServiceInterface;
use App\Services\UploadService;

class UploadServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UploadServiceInterface::class, UploadService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
