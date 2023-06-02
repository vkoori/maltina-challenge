<?php

namespace App\Http\Controllers\V1\Admin;

use App\Dto\OrderManage;
use App\Enums\StatusOrder;
use App\Facade\SuccessResponseFacade;
use App\Http\Requests\V1\Admin\Order\Update;
use App\Service\Order\Pipelines\OrderFinder;
use App\Service\Order\Pipelines\UpdateOrderStatus;
use Illuminate\Pipeline\Pipeline;

class Order
{
    public function update(Update $request, int $id)
    {
        app(Pipeline::class)
            ->send(passable: new OrderManage(
                orderId: $id,
                status: StatusOrder::from($request->get('status'))
            ))->pipe(pipes: [
                OrderFinder::class,
                UpdateOrderStatus::class
            ])->thenReturn();

        return SuccessResponseFacade::ok(
            message: __('order.statusUpdated')
        );
    }
}
