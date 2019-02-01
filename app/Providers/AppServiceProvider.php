<?php

namespace App\Providers;

use App\Verification\FileVerifier;
use Illuminate\Support\ServiceProvider;
use App\Verification\VirusTotalVerifier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        FileVerifier::class => VirusTotalVerifier::class,
    ];

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
        //
    }
}
