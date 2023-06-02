<?php

namespace App\Http\Requests\V1\Admin\Order;

use App\Enums\StatusOrder;
use App\Traits\InvalidFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class Update extends FormRequest
{
    use InvalidFormRequest;

    public function rules()
    {
        return [
            'status'                     => ['bail', 'required', new Enum(StatusOrder::class)],
        ];
    }
}
