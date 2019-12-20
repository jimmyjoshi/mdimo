<?php

namespace App\Providers;

/*
 * Class HasherServiceProvider
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com )
 * @package App\Providers
 */

use App\Services\Hasher\Hasher;
use Illuminate\Support\ServiceProvider;

class HasherServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Package boot method.
     */
    public function boot()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHasher();
    }

    /**
     * Register the application bindings.
     *
     * @return void
     */
    private function registerHasher()
    {
        $this->app->bind('hasher', function ($app) {
            return new Hasher($app);
        });
    }
}
