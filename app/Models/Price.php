<?php

namespace App\Models;

use App\Models\Relations\PriceRelations;
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
}
