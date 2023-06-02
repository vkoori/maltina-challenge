<?php

namespace App\Http\Controllers\V1\General;

use App\Facade\ProductRepositoryFacade;
use App\Facade\SuccessResponseFacade;
use App\Transformers\Product\ListView as ProductListView;

class Product
{
    public function index()
    {
        return SuccessResponseFacade::ok(
            message: __('general.success'),
            data: ProductListView::make(ProductRepositoryFacade::paginate(
                relations: ['typeGroup.types', 'prices']
            ))
        );
    }
}
