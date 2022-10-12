<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Traits\Payment;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    use Payment;

    public function receiveControlNumber(Request $request)
    {
        return $request['invoice_no'];

        $invoice = Invoice::where([['invoice_no', $request['invoice_no']], ['reference', $request['reference']]])->first();
        
        if ($invoice) {
            $invoice->update([
                'control_number' => $request['control_number']
            ]);

            return $this->success();

        } else {
            return $this->failed();
        }
    }

    public function receivePayment(Request $request)
    {

        $invoice = Invoice::where([['invoice_no', $request['invoice_no']], ['reference', $request['reference']]])->first();

        if ($invoice) {
            if ($invoice->receipt == $request['receipt'] || $invoice->bank_receipt == $request['bank_receipt'] || $invoice->gateway_receipt == $request['gateway_receipt']) {
                return $this->failed();

            } else {
                $invoice->update([
                    'receipt' => $request['receipt'],
                    'bank_receipt' => $request['bank_receipt'],
                    'gateway_receipt' => $request['gateway_receipt'],
                    'amount_paid' => $invoice->amount_paid + $request['amount'],
                    'currency' => $request['currency'],
                    'trans_date' => $request['trans_date'],
                    'bank_account' => $request['bank_account'],
                ]);

                $this->validatePayment($invoice);
            }

            return $this->success();

        } else {
            return $this->failed();
        }
    }

    public function success(): array
    {
        return [
            "status" => 1,
            "message" => "Successfully received"
        ];
    }

    public function failed(): array
    {
        return [
            "status" => 0,
            "message" => "Some error occur during processing"
        ];
    }
}
