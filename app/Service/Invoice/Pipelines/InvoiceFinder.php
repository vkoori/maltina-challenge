<?php

namespace App\Service\Invoice\Pipelines;

use App\Dto\InvoicePassenger;
use App\Facade\OrderRepositoryFacade;
use Closure;

class InvoiceFinder
{
    public function handle(InvoicePassenger $dto, Closure $next)
    {
        $orders = OrderRepositoryFacade::getByInvoiceId(invoiceId: $dto->getInvoiceId());

        $dto->setOrders(orders: $orders);

        return $next($dto);
    }
}
