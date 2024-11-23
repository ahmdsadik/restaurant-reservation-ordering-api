<?php

use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\MealController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ReservationController;
use App\Http\Controllers\API\TableController;
use Illuminate\Support\Facades\Route;

Route::get('check-availability', [TableController::class, 'checkAvailability']);
Route::post('reserve-table', [ReservationController::class, 'reserveTable']);

Route::get('menu', [MealController::class, 'listMenu']);
Route::post('order', [OrderController::class, 'store']);
Route::post('checkout/{order}', [CheckoutController::class, 'checkout']);
