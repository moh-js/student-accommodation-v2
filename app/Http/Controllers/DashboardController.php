<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Invoice;
use App\Models\Shortlist;
use App\Models\Application;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $invoices = Invoice::where('academic_year_id', AcademicYear::current()->id)->with('student')->get();
        $applications = Application::currentYear();
        $maleApplication = Application::currentYear()->byGender(1)->count();
        $femaleApplication = Application::currentYear()->byGender(2)->count();
        

        $maleRooms = roomsAvailable(1);
        $femaleRooms = roomsAvailable(2);
        $maleShortlist = Shortlist::maleShortlist()->orderBy('id', 'asc')->with('student')->get();
        $femaleShortlist = Shortlist::femaleShortlist()->orderBy('id', 'asc')->with('student')->get();

        $shortlisted = Shortlist::query()->with('student')->get()->map(function ($value, $key) use ($maleRooms, $femaleRooms, $maleShortlist, $femaleShortlist)
        {
            return (selected($value->student, $value->student->gender_id, $maleRooms, $femaleRooms, $maleShortlist, $femaleShortlist))?($value):(null);
        });

        return view('dashboard', [
            'invoices' => $invoices,
            'invoicesMale' => $invoices->pluck('student')->where('gender_id', 1),
            'invoicesFemale' => $invoices->pluck('student')->where('gender_id', 2),
            'shortlisted' => $shortlisted->filter(),
            'applications' => $applications,
            'maleApplication' => $maleApplication,
            'femaleApplication' => $femaleApplication,
            'maleSelected' => $shortlisted->pluck('student')->where('gender_id', 1),
            'femaleSelected' => $shortlisted->pluck('student')->where('gender_id', 2)
        ]);
    }
}
