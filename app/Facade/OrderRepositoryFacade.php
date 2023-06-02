<?php

namespace App\Facade;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Facade;
use App\Dto\OrderList as DtoOrderList;
use Illuminate\Support\Collection;

/**
 * @method static LengthAwarePaginator paginate(array $filters = [], int $perPage = 10, array $columns = ['*'], array $relations = [], ?string $sortBy = null, string $sortType = 'asc')
 * @method static Order singleOrderSave(int $userId, string $uuid, int $productId, ?int $typeId, int $count, float $price, Location $consumeLocation)
 * @method static boolean bulkOrderSave(string $uuid, DtoOrderList $items)
 * @method static Order findOrFail(int $modelId, array $columns = ['*'], array $relations = [])
 * @method static Order updateStatus(Order $order, StatusOrder $status)
 * @method static Collection getOrders(array $orderIds, ?string $invoiceId = null, ?int $userId = null)
 * @method static boolean delete(array $orderIds)
 * @method static Collection getByInvoiceId(string $invoiceId)
 * @method static boolean deleteByInvoiceId(string $invoiceId)
 *
* @see \App\Constraint\PriceRepository::class
 */
class OrderRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'order-queries';
    }
}
