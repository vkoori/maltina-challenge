<?php

namespace App\Errors\Http;

use App\Exceptions\HttpException;

class ProductNotFound extends HttpException
{
    public function __construct()
    {
        parent::__construct(
            statusCode: 404,
            message: __('product.notFound')
        );
    }
}
