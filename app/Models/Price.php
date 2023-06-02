<?php

namespace App\Models;

use App\Models\Relations\PriceRelations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $product_id
 * @property ?int $type_id
 * @property int $price
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Price extends Model
{
    use HasFactory, PriceRelations;

    protected $fillable = ['product_id', 'type_id', 'price'];

    public function scopeProductId(Builder $query, int $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function scopeTypeId(Builder $query, ?int $typeId)
    {
        return is_null($typeId)
            ? $query->whereNull('type_id')
            : $query->where('type_id', $typeId);
    }

    public function scopePriceFinder(Builder $query, int $productId, ?int $typeId)
    {
        return $query->orWhere(function (Builder $condition) use ($productId, $typeId) {
            $condition
                ->productId($productId)
                ->typeId($typeId);
        });
    }
}
