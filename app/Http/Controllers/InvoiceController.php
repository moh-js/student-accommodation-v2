<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Student;
use App\Models\AcademicYear;
use App\Traits\InvoiceProcess;
use App\Traits\ReferenceGenerator;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    use InvoiceProcess;
    use ReferenceGenerator;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('invoice-view');

        return view('payments.index', [
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Student $student)
    {
        $this->authorize('invoice-create');

        // $students = Student::all();
        
        return view('invoices.create', [
            'student' => $student,
            'hasInvoice' => $student->currentInvoice(),
            'eligible' => checkEligibility($student)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createNonRegisteredStudentInvoicePage()
    {
        $this->authorize('invoice-create-non-student');

        return view('invoices.anony-invoice', [
        ]);
    }

    public function createNonRegisteredStudentInvoice(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'full_name' => ['required', 'string'],
            'gender_id' => ['required', 'integer']
        ]);

        $student = Student::firstOrCreate([
            'username' => $request->username
        ], [
            'name' => $request->full_name,
            'gender_id' => $request->gender_id,
            'sponsor' => 'private',
            'is_fresher' => 0,
            'student_type' => 'continuous'
        ]);

        if ($student->currentInvoice()) {
            toastr()->error('Student has already created an invoice');
            return back()->withInput();
        }

        if ($this->make($student)) {
            toastr()->success('Invoice created successfully');
            return redirect()->back();
        } else {
            // toastr()->error('Invoice could no be created no space available to accommodate');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Student $student)
    {
        $this->authorize('invoice-create');

        if ($student) {
            if ($this->invoiceCreate($student)) {
                toastr()->success('Invoice created successfully');
                return redirect()->route('invoices.index', AcademicYear::current()->slug);
            } else {
                return back()->withInput();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'control_number' => ['nullable', 'integer']
        ]);

        $invoice->update([
            'control_number' => $request->control_number??null,
            'status' => $request->status,
        ]);

        toastr()->success('Data updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $this->authorize('invoice-delete');

        if ($invoice->control_number || $invoice->status) {
            toastr()->error("Invoice could not be deleted");
        } else {
            $invoice->forceDelete();
            toastr()->success('Invoice deleted successfully');
        }

        return redirect()->route('invoices.index', AcademicYear::current()->slug);
    }
}
