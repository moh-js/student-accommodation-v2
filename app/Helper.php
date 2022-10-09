<?php

use App\Models\Room;
use App\Models\Shortlist;

function checkEligibility($student)
{
    if ($student->gender_id == 1) { // check if student is eligible to be selected to get room
        $roomsCount = Room::maleRooms()->sum('capacity');
        $studentShortlist = Shortlist::maleShortlist()->orderBy('id', 'asc')->with('student')->get();
    } else {
        $roomsCount = Room::femaleRooms()->sum('capacity');
        $studentShortlist = Shortlist::femaleShortlist()->orderBy('id', 'asc')->with('student')->get();
    }

    $studentKeyNumber = $studentShortlist->whereIn('student_id', $student->id)->keys()->first()+1;
    
    return $studentKeyNumber <= $roomsCount;
}