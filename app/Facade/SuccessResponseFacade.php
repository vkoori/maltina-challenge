<?php

namespace App\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static JsonResponse ok(array|string $message = null, array|JsonResource|Collection $data = [])
 * @method static JsonResponse created(array|string $message = null, array|JsonResource|Collection $data = [])
 *
 * @see \App\Service\Responses\Success::class
 */
class SuccessResponseFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'success';
    }
}
