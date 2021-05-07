<?php

namespace Idempotency;

use Illuminate\Support\ServiceProvider;

/**
 * Class IdempotencyServiceProvider
 * @package Idempotency
 */
class IdempotencyServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/idempotency.php', 'idempotency');
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/idempotency.php' => config_path('idempotency.php')], 'config');
    }
}