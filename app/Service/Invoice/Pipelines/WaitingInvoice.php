<?php

namespace App\Service\Invoice\Pipelines;

use App\Dto\InvoicePassenger;
use App\Enums\StatusOrder;
use App\Errors\Http\CantEditOrder;
use App\Errors\Http\ProductNotFound;
use Closure;

class WaitingInvoice
{
    public function handle(InvoicePassenger $dto, Closure $next)
    {
        if ($dto->getOrders()->count() == 0) {
            throw new ProductNotFound;
        }

        if ($dto->getOrders()->first()->status != StatusOrder::WAITING) {
            throw new CantEditOrder;
        }

        return $next($dto);
    }
}
