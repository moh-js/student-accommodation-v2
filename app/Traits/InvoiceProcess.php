<?php
namespace App\Traits;

use App\Models\AcademicYear;
use App\Http\Services\BillingServiceProvider;


trait InvoiceProcess {

    public function invoiceCreate($student)
    {
        $amount = 107100;
        $GFSCode = 141501070144;
        $description = 'accommodation fee';
        $currency = 'TZS';
        
        // create invoice
        if (checkEligibility($student)) {
            $invoice = $student->invoices()->firstOrCreate([
                'academic_year_id' => AcademicYear::current()->id
            ]);
    
          
            $invoice->update([
                'reference' => $this->generate($invoice),
                'amount' => $amount
            ]);
    
            // call billing api for invoice creation
            $billingService = new BillingServiceProvider($GFSCode, $currency, $invoice->amount, $description);
    
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
        } else {
            toastr()->error('Unable to create invoice student not selected for accommodation');
        }
    }
}