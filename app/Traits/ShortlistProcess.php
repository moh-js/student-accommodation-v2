<?php

namespace App\Traits;

use App\Models\Invoice;
use App\Models\Shortlist;
use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Builder;

/**
 * Shortlist
 */
trait ShortlistProcess
{
    public function ban()
    {

        $maleRooms = roomsAvailable(1);
        $femaleRooms = roomsAvailable(2);
        $maleShortlist = Shortlist::maleShortlist()->orderBy('id', 'asc')->with('student')->get();
        $femaleShortlist = Shortlist::femaleShortlist()->orderBy('id', 'asc')->with('student')->get();
        $invoices = Invoice::where('academic_year_id', AcademicYear::current()->id)->with('student')->get();
        $shortlisted = Shortlist::query()->with('student')->get();

        foreach ($shortlisted as $shortlist) {
            if (selected($shortlist->student, $shortlist->student->gender_id, $maleRooms, $femaleRooms, $maleShortlist, $femaleShortlist) && !$shortlist->student->currentInvoice()) {
                if ($shortlist->student->sponsor != 'government') {
                    $shortlist->update([
                        'is_banned' => 1
                    ]);
                }
            }
        }
    }
}
