<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class BillingServiceProvider
{
    protected $nonCustomerInvouiceURL;
    protected $customerInvoiceURL;
    protected $registerCostumer;
    protected $itemGFSCode;
    protected $currency;
    protected $amount;
    protected $description;

    private $apiCode;
    private $apiKey;

    public function __construct($itemGFSCode, $currency, $amount, $description)
    {
        $this->apiCode = env('BILLING_CODE');
        $this->apiKey = env('BILLING_KEY');
        $this->nonCustomerInvouiceURL = env('BILLING_URL') . '/index.php/v1/noncustomer_invoice_receiver';
        $this->customerInvoiceURL = env('BILLING_URL') . '/index.php/v1/customer_invoice_receiver';
        $this->registerCostumer = env('BILLING_URL') . '/index.php/v1/register_customer';

        $this->itemGFSCode = $itemGFSCode;
        $this->currency = $currency;
        $this->amount = $amount;
        $this->description = $description;
    }

    public function createCustomerInvoice($customerNo, $reference, $programmeCode = null, $level = null)
    {
        $data = [
            'customer_no' => $customerNo,
            'reference' => $reference,
            'ProgrammeCode' => $programmeCode,
            'Class' => $level,
            'description' => $this->description,
            'amount' => $this->amount,
            'item_code' => $this->itemGFSCode,
            'currency' => $this->currency,
            'payment_option' => 1 // 1.Exact , 2.Partial
        ];

        $auth = [
            'code' => $this->apiCode,
            'token' => $this->apiKey,
        ];

        $response = Http::post($this->customerInvoiceURL, ['auth' => $auth, 'data' => $data])->json();

        return $response;
    }

    public function createNonCustomerInvoice($customerNo, $reference, $name, $mobile, $email)
    {
        $data = [
            'payer_id' => $customerNo,
            'reference' => $reference,
            'mobile' => $mobile,
            'name' => $name,
            'email' => $email,
            'description' => $this->description,
            'amount' => $this->amount,
            'item_code' => $this->itemGFSCode,
            'currency' => $this->currency,
            'payment_option' => 1
        ];

        $auth = [
            'code' => $this->apiCode,
            'token' => $this->apiKey,
        ];

        return $response = Http::post($this->nonCustomerInvouiceURL, ['auth' => $auth, 'data' => $data])->json();
    }
}
