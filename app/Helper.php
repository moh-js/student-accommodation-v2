<?php

use App\Models\Room;
use App\Models\Shortlist;

if (!function_exists('checkEligibility')) {
    function checkEligibility($student)
    {
        if ($student->gender_id == 1) { // check if student is eligible to be selected to get room
            $roomsCount = Room::maleRooms()->sum('capacity') - 275;
            $studentShortlist = Shortlist::maleShortlist()->orderBy('id', 'asc')->with('student')->get();
        } else {
            $roomsCount = Room::femaleRooms()->sum('capacity');
            $studentShortlist = Shortlist::femaleShortlist()->orderBy('id', 'asc')->with('student')->get();
        }
    
        $studentKeyNumber = $studentShortlist->whereIn('student_id', $student->id)->keys()->first()+1;
        
        return $studentKeyNumber <= $roomsCount;
    }
}


if (!function_exists('selected')) {
    function selected($student, $gender_id, $maleRoomsNumber, $femaleRoomsNumber, $maleShortlist, $femaleShortlist)
    {
        if ($gender_id == 1) { 
            $roomsCount = $maleRoomsNumber - 275;
            $studentShortlist = $maleShortlist;
        } else {
            $roomsCount = $femaleRoomsNumber;
            $studentShortlist = $femaleShortlist;
        }
    
        $studentKeyNumber = $studentShortlist->whereIn('student_id', $student->id)->keys()->first()+1;
        
        // check if student is eligible to be selected to get room
        return $studentKeyNumber <= $roomsCount;
    }
}