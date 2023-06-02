<?php

namespace App\Http\Requests\V1\User\Order;

use App\Enums\Location;
use App\Traits\InvalidFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class Update extends FormRequest
{
    use InvalidFormRequest;

    public function rules()
    {
        return [
            'cancel'                    => ['array'],
            'cancel.order_id'           => ['required_with:cancel', 'array'],
            'cancel.order_id.*'         => ['required_with:cancel', 'integer', 'min:1'],
            'order'                     => ['required_without:cancel', 'array'],
            'order.*.product_id'        => ['required_with:order', 'integer', 'min:1'],
            'order.*.type_id'           => ['nullable', 'integer', 'min:1'],
            'order.*.count'             => ['required_with:order', 'integer', 'min:1', 'max:100'],
            'order.*.consume_location'  => ['required_with:order', new Enum(Location::class)],
        ];
    }
}
