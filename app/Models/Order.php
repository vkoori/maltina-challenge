<?php

namespace App\Models;

use App\Enums\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $product_id
 * @property ?int $type_id
 * @property int $count
 * @property Location $consume_location
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'type_id', 'count', 'consume_location'];

    protected $casts = [
        'consume_location' => Location::class
    ];
}
