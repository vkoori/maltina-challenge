<?php

namespace App\Transformers\TypeGroup;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Transformers\Type\ListView as TypeListView;

class ObjectView extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'group_id'      => $this->id,
            'group_name'    => $this->name,
            'types'         => $this->whenLoaded(
                relationship: 'types',
                value: fn() => TypeListView::make($this->types)
            ),
        ];
    }
}
