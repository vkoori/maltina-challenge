<?php

namespace App\Errors\Validation;

use App\Exceptions\HttpException;

class ValidationException extends HttpException
{
    public function __construct(private \Illuminate\Support\MessageBag $invalid)
    {
        $this->setErrors(errors: $invalid->toArray());

        parent::__construct(
            statusCode: 422,
            message: __('general.unprocessableEntity')
        );
    }
}
