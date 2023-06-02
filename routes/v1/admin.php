<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Transaction;
use App\Http\Controllers\V1\Admin\Order;

Route::resource('orders', Order::class)->middleware(Transaction::class)->only(['update']);
