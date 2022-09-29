<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Http\Services\BillingServiceProvider;
use App\Traits\ReferenceGenerator;

class TestController extends Controller
{
    use ReferenceGenerator;

    public function testApi()
    {
        $student = Student::find(rand(1,1999));
    // create invoice
    $invoice = $student->invoices()->firstOrCreate([
        'academic_year_id' => AcademicYear::current()->id
    ]);

    $invoice->update([
        'reference' => $this->generate($invoice)
    ]);

    // call billing api for invoice creation
    $billingService = new BillingServiceProvider('141501070144', 'TZS', 107100, 'accommodation fee');

    try {
        // if ($student->is_fresher) {
        //     $response = $billingService->createNonCustomerInvoice(
        //         $student->username,
        //         $invoice->reference,
        //         $student->name,
        //         $student->phone,
        //         $student->email
        //     );
        // } else {
            $response = $billingService->createCustomerInvoice(
                $student->username,
                $invoice->reference,
                $student->name,
                $student->phone,
                $student->email
            );
        // }

        if ($response['code'] === 200) {
            $invoice->update([
                'invoice_no' => $response['response']['invoice_no']
            ]);
        }
        return $invoice;
    } catch (\Throwable $e) {
        return $e;
        toastr()->error($e->message, 'Something went wrong!');
    }
    }
}
