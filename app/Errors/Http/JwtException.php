<?php

namespace App\Errors\Http;

use App\Exceptions\HttpException;

class JwtException extends HttpException
{
    public function __construct()
    {
        parent::__construct(
            statusCode: 401,
            message: __('Your request header is invalid!')
        );
    }
}
