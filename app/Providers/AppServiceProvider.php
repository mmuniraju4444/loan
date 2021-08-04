<?php

namespace App\Providers;

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
        $this->registerObservers();
        $this->registerRepository();
    }

    /**
     * Register the service Observers.
     *
     * @return void
     */
    protected function registerObservers()
    {
        $this->app->register(ObserverServiceProvider::class);
    }

    /**
     * Register the service Repository.
     *
     * @return void
     */
    protected function registerRepository()
    {
        $this->app->register(RepositoryServiceProvider::class);
    }
}
