<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function receiveControlNumber()
    {
        return 'control';
    }

    public function receivePayment()
    {
        return 'payment';
    }
}
