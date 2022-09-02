<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Invoice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $invoices = Invoice::where('academic_year_id', AcademicYear::current()->id)->get();

        return view('dashboard', [
            'invoices' => $invoices
        ]);
    }
}
