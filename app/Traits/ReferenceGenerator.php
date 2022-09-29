<?php
namespace App\Traits;

use App\Models\Invoice;

trait ReferenceGenerator
{
    /**
     * Generate the new receipt ID
     *
     * @param Invoice $invoice
     * @return string $receipt_id
     */
    public static function generate($invoice, $type = 'reference')
    {
        // format MYYDDMM{000000ID}

        $id = $invoice->id;
        $count = 1;
        $initialLimit = 9999;
        $finalLimit = $initialLimit;

        do { // Reset receipt id after it exceed six digits number
            $reset = false;

            if ($id > $initialLimit) { // check if id exceed limit
                $id = $invoice->id - $finalLimit;

                if ($id > $initialLimit) { // check if substracted id still exceed the limit number
                    $count = $count+1;
                    $finalLimit = $count*$initialLimit;
                    $reset = true;
                }
            } else {
                $id = $invoice->id;
            }
        } while ($reset);

        if ($type == 'reference') {
            $code = 'MR';
        } else {
            $code = 'MI';
        }

        $date = now()->format('yz');
        $length = strlen($initialLimit);
        $string = substr(str_repeat(0, $length).$id, - $length);

        $receipt_id = $code.$date.$string;
        return $receipt_id;
    }
}
