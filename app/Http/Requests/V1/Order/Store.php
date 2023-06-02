<?php

namespace App\Http\Requests\V1\Order;

use App\Enums\Location;
use App\Traits\InvalidFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class Store extends FormRequest
{
    use InvalidFormRequest;

    public function rules()
    {
        return [
            'order'                     => ['bail', 'required', 'array'],
            'order.*.product_id'        => ['bail', 'required', 'integer', 'min:1'],
            'order.*.type_id'           => ['nullable', 'integer', 'min:1'],
            'order.*.count'             => ['bail', 'required', 'integer', 'min:1', 'max:100'],
            'order.*.consume_location'  => ['bail', 'required', new Enum(Location::class)],
        ];
    }
}
