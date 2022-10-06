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
        // $request = json_decode('{
        //     "invoice_no":"MB1030229",
        //     "reference":"MR222760227",
        //     "control_number":"991541054826"
        //     }');

        $invoice = Invoice::where([['invoice_no', $request->invoice_no], ['reference', $request->reference]])->first();

        if ($invoice) {
            $invoice->update([
                'control_number' => $request->control_number
            ]);

            // fire event of control number recival for broadcasting

            return $this->success();

        } else {
            return $this->failed();
        }
    }

    public function receivePayment(Request $request)
    {
        // $request = json_decode('{
        //     "invoice_no":"MB1030229",
        //     "reference":"MR222760227",
        //     "control_number":"991541058633",
        //     "receipt":"REC210001927",
        //     "bank_receipt":"EC100676587634655IP",
        //     "gateway_receipt":"9202390065609874934",
        //     "amount":"2000.00",
        //     "currency":"TZS",
        //     "trans_date":"2021-06-23",
        //     "timestamp":"2021-06-23 03:50:53",
        //     "bank_account":"20901100002"
        //     }');

        $invoice = Invoice::where([['invoice_no', $request->invoice_no], ['reference', $request->reference]])->first();

        if ($invoice) {
            if ($invoice->receipt == $request->receipt || $invoice->bank_receipt == $request->bank_receipt || $invoice->gateway_receipt == $request->gateway_receipt) {
                return $this->failed();

            } else {
                $invoice->update([
                    'receipt' => $request->receipt,
                    'bank_receipt' => $request->bank_receipt,
                    'gateway_receipt' => $request->gateway_receipt,
                    'amount_paid' => $invoice->amount_paid + $request->amount,
                    'currency' => $request->currency,
                    'trans_date' => $request->trans_date,
                    'bank_account' => $request->bank_account,
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
