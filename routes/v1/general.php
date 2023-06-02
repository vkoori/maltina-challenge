<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\General\Product;

Route::resource('products', Product::class)->only(['index']);
