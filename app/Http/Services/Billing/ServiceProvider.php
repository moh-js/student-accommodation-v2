<?php
namespace App\Http\Services\Billing;

use Illuminate\Support\Facades\Http;

class ServiceProvider 
{
    protected $customerInvoiceURL = '';
    protected $nonCustomerInvouiceURL = '';
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

        $this->itemGFSCode = $itemGFSCode;
        $this->currency = $currency;
        $this->amount = $amount;
        $this->description = $description;
    }

    public function createCustomerInvoice($customerNo, $reference)
    {
        $data = [
            'customer_no' => $customerNo,
            'reference' => $reference,
            'description' => $this->description,
            'amount' => $this->amount,
            'item_code' => $this->itemGFSCode,
            'currency' => $this->currency,
        ];

        $auth = [
            'code' => $this->apiCode,
            'token' => $this->apiKey,
        ];

        $response = Http::post($this->customerInvoiceURL, ['auth' => $auth, 'data' => $data]);
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
        ];

        $auth = [
            'code' => $this->apiCode,
            'token' => $this->apiKey,
        ];

        $response = Http::post($this->nonCustomerInvouiceURL, ['auth' => $auth, 'data' => $data]);   
    }


}
