<?php

namespace App\Http\Controllers\V1\User;

use App\Dto\InvoicePassenger;
use App\Dto\OrderList as DtoOrderList;
use App\Facade\OrderRepositoryFacade;
use App\Facade\SuccessResponseFacade;
use App\Http\Requests\V1\User\Order\Index;
use App\Http\Requests\V1\User\Order\Store;
use App\Http\Requests\V1\User\Order\Update;
use App\Service\Invoice\Pipelines\InvoiceFinder;
use App\Service\Invoice\Pipelines\RemoveInvoice;
use App\Service\Invoice\Pipelines\WaitingInvoice;
use App\Service\Order\Pipelines\PriceFinder;
use App\Service\Order\Pipelines\RemoveOrders;
use App\Service\Order\Pipelines\SaveOrder;
use App\Transformers\Order\ListView as OrderListView;
use Illuminate\Pipeline\Pipeline;

class Order
{
    public function store(Store $request)
    {
        /** @var DtoOrderList $dto */
        $dto = app(Pipeline::class)
            ->send(
                passable: new DtoOrderList(request: $request)
            )->pipe(pipes: [
                PriceFinder::class,
                SaveOrder::class
            ])->thenReturn();

        return SuccessResponseFacade::ok(
            message: __('order.buy'),
            data: ['invoiceId' => $dto->getInvoiceId()]
        );
    }

    public function index(Index $request)
    {
        $filters = $request->validated() + ['user_id' => $request->attributes->get('userId')];

        return SuccessResponseFacade::ok(
            message: __('general.success'),
            data: OrderListView::make(
                OrderRepositoryFacade::paginate(filters: $filters, relations: ['product', 'type'])
            )
        );
    }

    public function update(Update $request, string $invoiceId)
    {
        /** @var DtoOrderList $dto */
        $dto = app(Pipeline::class)
            ->send(
                passable: new DtoOrderList(request: $request, invoiceId: $invoiceId)
            )->pipe(pipes: [
                RemoveOrders::class,
                PriceFinder::class,
                SaveOrder::class
            ])->thenReturn();

        return SuccessResponseFacade::ok(
            message: __('general.success'),
            data: ['invoiceId' => $dto->getInvoiceId()]
        );
    }

    public function cancel(string $invoiceId)
    {
        app(Pipeline::class)
            ->send(
                passable: new InvoicePassenger(invoiceId: $invoiceId)
            )->pipe(pipes: [
                InvoiceFinder::class,
                WaitingInvoice::class,
                RemoveInvoice::class
            ])->thenReturn();

        return SuccessResponseFacade::ok(
            message: __('general.success'),
        );
    }
}
