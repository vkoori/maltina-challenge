<?php

namespace App\Service\Order\Pipelines;

use App\Dto\OrderManage;
use App\Facade\OrderRepositoryFacade;
use Closure;

class OrderFinder
{
    public function handle(OrderManage $dto, Closure $next)
    {
        $order = OrderRepositoryFacade::findOrFail(modelId: $dto->getOrderId());

        $dto->setOrder(order: $order);

        return $next($dto);
    }
}
