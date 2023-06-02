<?php

namespace App\Service\Responses\Constraint;

use Illuminate\Http\JsonResponse;

interface Error
{
    public function badRequest(array|string $message = null, array|string $errors = []): JsonResponse;
    public function notFound(array|string $message = null, array|string $errors = []): JsonResponse;
    public function unauthorized(array|string $message = null, array|string $errors = []): JsonResponse;
    public function unprocessableEntity(array|string $message = null, array|string $errors = []): JsonResponse;
    public function serverError(array|string $message = null, array|string $errors = []): JsonResponse;
    public function customError(int $statusCode, array|string $message = null, array|string $errors = []): JsonResponse;
}
