<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Exports\InvoiceExport;
use App\Exports\ShortlistExport;
use App\Exports\ApplicationExport;
use App\Exports\StudentExport;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    public function exportShortlistedSimple(Request $request)
    {
        Gate::authorize('report-shortlist-export');

        $name = now()->format('ydhi');

        session(['shortlist_file_name' => $name . "_shortlists.xlsx"]);

        if ($request->gender_id == null) {
            (new ShortlistExport)->queue($name . "_shortlists.xlsx");
        } else {
            (new ShortlistExport((int)$request->input('gender_id')))->queue($name . "_shortlists.xlsx");
        }

        toastr()->success('export process started successfully');
        return redirect()->back();
    }

    public function reportPayment()
    {
        $this->authorize('report-payment-export');

        return view('reports.payment');
    }

    public function exportPayment(Request $request)
    {
        $this->authorize('report-payment-export');


        if ($request->status == null) {
            $invoices = Invoice::query();
        } else {
            $invoices = Invoice::where('status', $request->status);
        }

        if ($invoices->count()) {
            $name = now()->format('ydhi');

            if ($request->status == null) {
                return (new InvoiceExport)->download($name . "_invoices.xlsx");
            } else {
                return (new InvoiceExport($request->input('status')))->download($name . "_invoices.xlsx");
            }
        } else {
            toastr()->error('No invoice found to export');
            return back()->withInput();
        }
    }

    public function reportStudent()
    {
        $this->authorize('report-student-export');

        return view('reports.student');
    }

    public function exportStudent(Request $request)
    {
        // return $request;
        $request->validate([
            'start' => ['nullable', 'string'],
            'end' => ['nullable', 'string'],
        ]);

        if ($request->input('start') && $request->input('end')) {
            $start = Carbon::parse($request->start);
            $end = Carbon::parse($request->end);
        }
        $status = $request->status;

        $data = [
            'start' => $start??null,
            'end' => $end??null,
            'status' => $status??null,
        ];

        $name = now()->format('ydhi');

        if (collect($data)->filter()->count()) {
            return (new StudentExport($data))->download($name . "_students.xlsx");
        } else {
            return (new StudentExport)->download($name . "_students.xlsx");
        }
    }

    public function reportApplication()
    {
        $this->authorize('report-application-export');

        return view('reports.application');
    }

    public function exportApplication(Request $request)
    {
        $this->authorize('report-application-export');

        if ($request->red_flagged == null) {
            $application = application::query();
        } else {
            $application = application::where('red_flagged', $request->red_flagged);
        }

        if ($application->count()) {
            $name = now()->format('ydhi');

            if ($request->red_flagged == null) {
                return (new ApplicationExport)->download($name . "application.xlsx");
            } else {
                return (new ApplicationExport($request->input('red_flagged')))->download($name . "_application.xlsx");
            }
        } else {
            toastr()->error('No application found to export');
            return back()->withInput();
        }
    }

    public function reportShortlisted()
    {
    }
}
