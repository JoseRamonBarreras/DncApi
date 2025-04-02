<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ImprimirRequisicion;
use App\Services\ImprimirRequisicionService;

use App\Interfaces\ReporteMatriz;
use App\Services\ReporteMatrizService;

class ReporteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ImprimirRequisicion::class, ImprimirRequisicionService::class);
        $this->app->bind(ReporteMatriz::class, ReporteMatrizService::class);
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
