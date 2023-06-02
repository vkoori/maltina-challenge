<?php

namespace App\Traits;

use App\Errors\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

trait InvalidFormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException(invalid: $validator->errors());
    }
}
