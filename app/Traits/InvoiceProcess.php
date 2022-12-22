<?php

namespace App\Traits;

use App\Models\Invoice;
use App\Models\AcademicYear;
use App\Http\Services\BillingServiceProvider;


trait InvoiceProcess
{

    public function invoiceCreate($student)
    {
        // create invoice
        if (checkEligibility($student)) {
            return $this->make($student);
        } else {
            toastr()->error('Unable to create invoice student not selected for accommodation');
            return 0;
        }
    }

    public function checkInvoiceCreated($student)
    {
        $invoices = Invoice::where('academic_year_id', AcademicYear::current()->id)->with('student')->get();

        $invoices = $invoices->pluck('student')->where('gender_id', $student->gender_id)->count();

        if ($invoices < roomsAvailable($student->gender_id)) {
            return 1;
        }

        return 0;
    }

    public function make($student)
    {
        $amount = 107100;
        $GFSCode = 141501070144;
        $description = 'accommodation fee';
        $currency = 'TZS';

        if ($this->checkInvoiceCreated($student)) {
            $invoice = $student->invoices()->firstOrCreate([
                'academic_year_id' => AcademicYear::current()->id
            ]);

            $invoice->update([
                'reference' => $this->generate($invoice),
                'amount' => $amount
            ]);

            // do not create invoice for government sponsored students
            if ($student->sponsor == 'government') {
                $invoice->update([
                    'status' => 1,
                    'control_number' => 1
                ]);
            } else {
                // call billing api for invoice creation
                $billingService = new BillingServiceProvider($GFSCode, $currency, $invoice->amount, $description);

                try {

                    $response = $billingService->createCustomerInvoice(
                        $student->username,
                        $invoice->reference,
                        $student->programme_code,
                        $student->class_level
                    );

                    if ($response['code'] === 200) {
                        $invoice->update([
                            'invoice_no' => $response['response']['invoice_no'],
                            'currency' => $response['response']['currency']
                        ]);
                        return 1;
                    } else {
                        toastr()->error($response['message']);

                        if ($response['code'] == 104) {
                            session()->flash('no_costumer', 'You should pay for administrative fee first before paying for accommodation');
                        }

                        $invoice->forceDelete();
                        return 0;
                    }
                } catch (\Throwable $e) {
                    toastr()->error('Something went wrong!');
                    return 0;
                }
            }
        } else {
            toastr()->error('Unable to create invoice no rooms to accommodate student');
            return 0;
        }
    }
}
