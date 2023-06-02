<?php

namespace App\Models;

use App\Models\Relations\TypeRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $type_group_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Type extends Model
{
    use HasFactory, TypeRelations;
    protected $fillable = ['type_group_id', 'name'];
}
