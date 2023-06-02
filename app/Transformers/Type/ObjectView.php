<?php

namespace App\Transformers\Type;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ObjectView extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            "type_id"        => $this->id,
            "type_name"      => $this->name,
        ];
    }
}
