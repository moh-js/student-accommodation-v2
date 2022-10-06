<?php
namespace App\Traits;

use Carbon\Carbon;

/**
 * Billing Payment
 */
trait Payment
{
    public function validatePayment($invoice)
    {
        $calculatedAmount = $invoice->amount_paid*$this->getFactor();
        // change status

        $invoice->update([
            'status' => ($calculatedAmount >= $invoice->amount)?1:0
        ]);
    }

    public function getFactor(): int
    {
        $currentDate = now();
        $nextYear = now()->addYear();
        $dateOneFirstSemester = Carbon::create($currentDate->year, 10, 1);
        $dateTwoFirstSemester = Carbon::create($nextYear->year, 3, 1);


        $dateOneSecondSemester = Carbon::create($currentDate->year, 3, 2);
        $dateTwoSecondSemester = Carbon::create($currentDate->year, 9, 1);

        if ($currentDate->between($dateOneFirstSemester,$dateTwoFirstSemester)) {
            return 2;
        } else if ($currentDate->between($dateOneSecondSemester,$dateTwoSecondSemester)) {
            return 1;
        } else {
            return 0;
        }
    }
}
