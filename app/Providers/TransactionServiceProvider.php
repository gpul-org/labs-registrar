<?php
/**
 * Created by PhpStorm.
 * User: ssaavedra
 * Date: 12/23/15
 * Time: 8:34 PM
 */

namespace Registration\Providers;


use Illuminate\Support\ServiceProvider;
use Registration\Repositories\TransactionRepository;

class TransactionServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the service provider.
     *
     * @return mixed
     */
    public function register()
    {
        $this->app->bind('Transaction', function($app) {
            $app = $this->app;

            return new TransactionRepository();
        });
    }
}