<?php

namespace App\Providers;

use App\Models\Plugin;
use App\Models\PluginFile;
use App\Policies\PluginPolicy;
use App\Policies\PluginFilePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Plugin::class => PluginPolicy::class,
        PluginFile::class => PluginFilePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
