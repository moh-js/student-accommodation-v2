<?php

namespace App\Http\Controllers;

use App\Settings\AllocationSettings;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function allocation()
    {
        return view('settings.allocation');
    }

    public function allocationStore(Request $request, AllocationSettings $settings)
    {

        $request->validate([
           'female_reserved_room' => ['required', 'integer'], 
           'male_reserved_room' => ['required', 'integer'], 
        //    'criteria' => ['required', 'array'], 
        ]);

        $settings->female_reserved_room = $request->female_reserved_room;
        $settings->male_reserved_room = $request->male_reserved_room;
        // $settings->criteria = $request->criteria;
        $settings->save();

        toastr()->success('Allocation setting configured successfully');
        return redirect()->back();
    }
}
