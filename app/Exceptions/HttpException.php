<?php

namespace App\Exceptions;

use App\Facade\FailedResponseFacade;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException as BaseHttpException;

class HttpException extends BaseHttpException
{
    private array $errors = [];

    public function render(Request $request)
    {
        return FailedResponseFacade::customError(
            statusCode: $this->getStatusCode(),
            message: $this->getMessage(),
            errors: $this->getErrors()
        );
    }

    protected function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    protected function getErrors(): array
    {
        return $this->errors;
    }
}
