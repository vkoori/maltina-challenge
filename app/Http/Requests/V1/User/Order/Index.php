<?php

namespace App\Http\Requests\V1\User\Order;

use App\Traits\InvalidFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class Index extends FormRequest
{
    use InvalidFormRequest;

    public function rules()
    {
        return [
            'invoice_id'            => ['string'],
        ];
    }
}
