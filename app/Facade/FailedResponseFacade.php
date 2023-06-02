<?php

namespace App\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static JsonResponse badRequest(array|string $message = null, array|string $errors = [])
 * @method static JsonResponse notFound(array|string $message = null, array|string $errors = [])
 * @method static JsonResponse unauthorized(array|string $message = null, array|string $errors = [])
 * @method static JsonResponse unprocessableEntity(array|string $message = null, array|string $errors = [])
 * @method static JsonResponse serverError(array|string $message = null, array|string $errors = [])
 * @method static JsonResponse customError(int $statusCode, array|string $message = null, array|string $errors = [])
 *
 * @see \App\Service\Responses\Error::class
 */
class FailedResponseFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'error';
    }
}
