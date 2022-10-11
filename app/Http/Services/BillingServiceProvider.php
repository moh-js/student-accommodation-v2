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
        $this->nonCustomerInvouiceURL = env('BILLING_URL').'/v1/noncustomer_invoice_receiver';
        $this->customerInvoiceURL = env('BILLING_URL').'/v1/customer_invoice_receiver';
        $this->registerCostumer = env('BILLING_URL').'/v1/register_customer';
        
        $this->itemGFSCode = $itemGFSCode;
        $this->currency = $currency;
        $this->amount = $amount;
        $this->description = $description;
    }

    public function createCustomerInvoice($customerNo, $reference, $name=null, $mobile=null, $email=null)
    {
        // do {
            $data = [
                'customer_no' => $customerNo,
                'reference' => $reference,
                'description' => $this->description,
                'amount' => $this->amount,
                'item_code' => $this->itemGFSCode,
                'currency' => $this->currency,
                'payment_option' => 2
            ];
    
            $auth = [
                'code' => $this->apiCode,
                'token' => $this->apiKey,
            ];
    
            $oldResponse = Http::post($this->customerInvoiceURL, ['auth' => $auth, 'data' => $data])->json();
    
        //     if ($oldResponse['code'] === 104) {
        //         $data = [
        //             'customer_no' => $customerNo,
        //             'mobile' => $mobile,
        //             'customer_name' => $name,
        //             'email' => $email,
        //         ];
    
        //         $response = Http::post($this->registerCostumer, ['auth' => $auth, 'data' => $data])->json();
        //     }
        // } while ($oldResponse['code'] === 104);

        return $oldResponse;
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

        return $response = Http::post($this->nonCustomerInvouiceURL, ['auth' => $auth, 'data' => $data])->json();
    }
}
