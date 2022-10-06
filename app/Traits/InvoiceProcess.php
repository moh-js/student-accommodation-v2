<?php
namespace App\Traits;

use App\Models\AcademicYear;
use App\Http\Services\BillingServiceProvider;


trait InvoiceProcess {

    protected $amount;

    public function invoiceCreate($student)
    {
        $this->amount = 107100;
        
        // create invoice
        $invoice = $student->invoices()->firstOrCreate([
            'academic_year_id' => AcademicYear::current()->id
        ]);

        // call billing api for invoice creation
        $billingService = new BillingServiceProvider('141501070144', 'TZS', $this->amount, 'accommodation fee');

        $invoice->save([
            'reference' => $this->generate($invoice),
            'amount' => $this->amount
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
                $invoice->save([
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
            toastr()->error($e->message, 'Something went wrong!');
            return 0;
        }
    }
}