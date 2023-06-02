<?php

namespace App\Errors\Http;

use App\Exceptions\HttpException;

class CantEditOrder extends HttpException
{
    public function __construct()
    {
        parent::__construct(
            statusCode: 400,
            message: __('order.cantEditOrder')
        );
    }
}
