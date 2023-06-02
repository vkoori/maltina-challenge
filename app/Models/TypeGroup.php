<?php

namespace App\Models;

use App\Models\Relations\TypeGroupRelations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class TypeGroup extends Model
{
    use HasFactory, TypeGroupRelations;

    protected $fillable = ['product_id', 'name'];

    public function scopeProductId(Builder $query, int $productId)
    {
        return $query->where('product_id', $productId);
    }
}
