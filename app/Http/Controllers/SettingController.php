<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function allocation()
    {
        return view('settings.allocation');
    }

    public function allocationStore(Request $request)
    {
        return $request;
    }
}
