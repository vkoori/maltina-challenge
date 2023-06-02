<?php

namespace App\Service\Responses;

use App\Service\Responses\Constraint\Error as ConstraintError;
use App\Service\Responses\Trait\ResponseParser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class Error implements ConstraintError
{
    use ResponseParser;

    public function badRequest(array|string $message = null, array|string $errors = []): JsonResponse
    {
        return $this->standardResp(
            statusCode: Response::HTTP_BAD_REQUEST,
            message: $message,
            data: $errors
        );
    }

    public function notFound(array|string $message = null, array|string $errors = []): JsonResponse
    {
        return $this->standardResp(
            statusCode: Response::HTTP_NOT_FOUND,
            message: $message,
            data: $errors
        );
    }

    public function unauthorized(array|string $message = null, array|string $errors = []): JsonResponse
    {
        return $this->standardResp(
            statusCode: Response::HTTP_UNAUTHORIZED,
            message: $message,
            data: $errors
        );
    }

    public function unprocessableEntity(array|string $message = null, array|string $errors = []): JsonResponse
    {
        return $this->standardResp(
            statusCode: Response::HTTP_UNPROCESSABLE_ENTITY,
            message: $message,
            data: $errors
        );
    }

    public function serverError(array|string $message = null, array|string $errors = []): JsonResponse
    {
        return $this->standardResp(
            statusCode: Response::HTTP_INTERNAL_SERVER_ERROR,
            message: $message,
            data: $errors
        );
    }

    public function customError(int $statusCode, array|string $message = null, array|string $errors = []): JsonResponse
    {
        return $this->standardResp(
            statusCode: $statusCode,
            message: $message,
            data: $errors
        );
    }
}
