<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\Responses\Success;
use App\Service\Responses\Error;

class ResponseProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(abstract: 'success', concrete: Success::class);
        $this->app->singleton(abstract: 'error', concrete: Error::class);
    }
}
