<?php

namespace App\Providers;

use App\Repositories\V1\Contracts\ItemRepository;
use App\Repositories\V1\Eloquent\ItemRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ItemRepository::class, ItemRepositoryEloquent::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
