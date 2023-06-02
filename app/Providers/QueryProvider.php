<?php

namespace App\Providers;

use App\Repositories\OrderRepository;
use App\Repositories\PriceRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TypeRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class QueryProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(abstract: 'type-queries', concrete: TypeRepository::class);
        $this->app->singleton(abstract: 'product-queries', concrete: ProductRepository::class);
        $this->app->singleton(abstract: 'price-queries', concrete: PriceRepository::class);
        $this->app->singleton(abstract: 'order-queries', concrete: OrderRepository::class);
        $this->app->singleton(abstract: 'user-queries', concrete: UserRepository::class);
    }
}
