<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Http\Services\BillingServiceProvider;
use App\Traits\ReferenceGenerator;
use App\Traits\ShortlistProcess;

class TestController extends Controller
{
    use ReferenceGenerator;
    use ShortlistProcess;

    public function testApi()
    {
        $student = Student::find(rand(1, 1999));
        // create invoice
        $invoice = $student->invoices()->firstOrCreate([
            'academic_year_id' => AcademicYear::current()->id
        ]);

        $invoice->update([
            'reference' => $this->generate($invoice),
            'amount' => 107100
        ]);

        // call billing api for invoice creation
        $billingService = new BillingServiceProvider('141501070144', 'TZS', $invoice->amount, 'accommodation fee');

        try {
            $response = $billingService->createCustomerInvoice(
                $student->username,
                $invoice->reference,
                $student->name,
                $student->phone,
                $student->email
            );



            if ($response['code'] === 200) {
                $invoice->update([
                    'invoice_no' => $response['response']['invoice_no'],
                    'currency' => $response['response']['currency']
                ]);
            }

            return $response;
        } catch (\Throwable $e) {
            return $e;
            toastr()->error($e->message, 'Something went wrong!');
        }
    }

    public function banTest()
    {
        return $this->ban();
    }
}
