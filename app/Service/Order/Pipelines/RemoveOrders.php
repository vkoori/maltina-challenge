<?php

namespace App\Service\Order\Pipelines;

use App\Dto\OrderList as DtoOrderList;
use App\Enums\StatusOrder;
use App\Errors\Http\CantEditOrder;
use App\Errors\Http\ProductNotFound;
use App\Facade\OrderRepositoryFacade;
use Closure;

class RemoveOrders
{
    public function handle(DtoOrderList $dto, Closure $next)
    {
        if ($dto->getOrderIdsMustBeCancel()) {
            $this->areOrderIdsToBeDeletedValid(dto: $dto);
            OrderRepositoryFacade::delete(orderIds: $dto->getOrderIdsMustBeCancel());
        }

        return $next($dto);
    }

    private function areOrderIdsToBeDeletedValid(DtoOrderList $dto): void
    {
        $order = OrderRepositoryFacade::getOrders(
            orderIds: $dto->getOrderIdsMustBeCancel(),
            invoiceId: $dto->getInvoiceId(),
            userId: $dto->getUserId()
        );

        if ($order->count() != count($dto->getOrderIdsMustBeCancel())) {
            throw new ProductNotFound;
        }

        if ($order->first()->status != StatusOrder::WAITING) {
            throw new CantEditOrder;
        }
    }
}
