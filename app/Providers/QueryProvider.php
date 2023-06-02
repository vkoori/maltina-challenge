<?php

namespace App\Providers;

use App\Repositories\ProductRepository;
use App\Repositories\TypeRepository;
use Illuminate\Support\ServiceProvider;

class QueryProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(abstract: 'type-queries', concrete: TypeRepository::class);
        $this->app->singleton(abstract: 'product-queries', concrete: ProductRepository::class);
    }
}
