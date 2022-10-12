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

        $invoice = Invoice::where([['invoice_no', $request->input('invoice_no')], ['reference', $request->input('reference')]])->first();

        if ($invoice) {
            $invoice->save([
                'control_number' => $request->input('control_number')
            ]);

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

        $invoice = Invoice::where([['invoice_no', $request->input('invoice_no')], ['reference', $request->input('reference')]])->first();

        if ($invoice) {
            if ($invoice->receipt == $request->input('receipt') || $invoice->bank_receipt == $request->input('bank_receipt') || $invoice->gateway_receipt == $request->input('gateway_receipt')) {
                return $this->failed();

            } else {
                $invoice->save([
                    'receipt' => $request->input('receipt'),
                    'bank_receipt' => $request->input('bank_receipt'),
                    'gateway_receipt' => $request->input('gateway_receipt'),
                    'amount_paid' => $invoice->amount_paid + $request->input('amount'),
                    'currency' => $request->input('currency'),
                    'trans_date' => $request->input('trans_date'),
                    'bank_account' => $request->input('bank_account'),
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
