<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\OrdersController;

Route::apiResource('/products', ProductsController::class);
Route::apiResource('/orders', OrdersController::class);
