<?php

namespace App\Errors\Runtime;

use RuntimeException;

class SaveException extends RuntimeException
{
    public function __construct()
    {
        return parent::__construct(
            message: 'Data not saved into db!'
        );
    }
}
