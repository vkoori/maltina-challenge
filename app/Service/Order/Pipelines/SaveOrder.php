<?php

namespace App\Service\Order\Pipelines;

use App\Dto\OrderList as DtoOrderList;
use App\Errors\Runtime\SaveException;
use App\Facade\OrderRepositoryFacade;
use Closure;
use Illuminate\Support\Str;

class SaveOrder
{
    public function handle(DtoOrderList $dto, Closure $next)
    {
        $invoiceId = is_null($dto->getInvoiceId()) ? Str::uuid()->toString() : $dto->getInvoiceId();
        $saved = OrderRepositoryFacade::bulkOrderSave(uuid: $invoiceId, items: $dto);

        if (!$saved) {
            throw new SaveException;
        }

        $dto->setInvoiceId(uuid: $invoiceId);

        return $next($dto);
    }
}
