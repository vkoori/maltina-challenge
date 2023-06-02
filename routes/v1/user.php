<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Transaction;
use App\Http\Controllers\V1\User\Order;

Route::resource('orders', Order::class)->middleware(Transaction::class)->only(['store', 'index']);
Route::patch('orders/{invoiceId}', [Order::class, 'update'])->middleware(Transaction::class)->name('orders.update');
