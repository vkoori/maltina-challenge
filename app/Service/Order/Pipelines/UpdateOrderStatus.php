<?php

namespace App\Service\Order\Pipelines;

use App\Dto\OrderManage;
use App\Facade\OrderRepositoryFacade;
use Closure;

class UpdateOrderStatus
{
    public function handle(OrderManage $dto, Closure $next)
    {
        $order = OrderRepositoryFacade::updateStatus(
            order: $dto->getOrder(),
            status: $dto->getStatus()
        );

        $dto->setOrder(order: $order);

        return $next($dto);
    }
}
