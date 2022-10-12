<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillingController;

Route::any('/control_number_callback', [BillingController::class, 'receiveControlNumber']);
Route::any('/payment_callback', [BillingController::class, 'receivePayment']);
