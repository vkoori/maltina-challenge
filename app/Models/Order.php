<?php

namespace App\Models;

use App\Enums\Location;
use App\Enums\StatusOrder;
use App\Models\Relations\OrderRelations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property string $invoice_id
 * @property int $product_id
 * @property ?int $type_id
 * @property int $count
 * @property float $price
 * @property Location $consume_location
 * @property StatusOrder $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Order extends Model
{
    use HasFactory, OrderRelations, SoftDeletes;

    protected $fillable = [
        'user_id',
        'invoice_id',
        'product_id',
        'type_id',
        'count',
        'price',
        'consume_location',
        'status'
    ];

    protected $casts = [
        'consume_location' => Location::class,
        'status' => StatusOrder::class,
    ];

    public function scopeUserId(Builder $query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeIds(Builder $query, array $orderIds)
    {
        return $query->whereIn('id', $orderIds);
    }

    public function scopeInvoiceId(Builder $query, string $invoiceId)
    {
        return $query->where('invoice_id', $invoiceId);
    }
}
