<?php

namespace App\Service\Invoice\Pipelines;

use App\Dto\InvoicePassenger;
use App\Facade\OrderRepositoryFacade;
use Closure;

class RemoveInvoice
{
    public function handle(InvoicePassenger $dto, Closure $next)
    {
        OrderRepositoryFacade::deleteByInvoiceId(invoiceId: $dto->getInvoiceId());

        return $next($dto);
    }
}
