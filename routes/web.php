<?php

use App\Http\Controllers\ShipmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('shipments.index'));

Route::controller(ShipmentController::class)
    ->prefix('shipments')
    ->name('shipments.')
    ->group(function () {
        Route::get('/',        'index')->name('index');
        Route::get('/{shipment}', 'show')->name('show');
    });
