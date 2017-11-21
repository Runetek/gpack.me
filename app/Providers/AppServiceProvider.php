<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Reports\ReportFetcher;
use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Support\Facades\Storage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(ReportFetcher::class)
                ->needs(Cloud::class)
                ->give(function () {
                    return Storage::disk('reports');
                });
    }
}
