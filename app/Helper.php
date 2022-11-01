<?php

use App\Models\Room;
use App\Models\Shortlist;

if (!function_exists('checkEligibility')) {
    function checkEligibility($student)
    {
        if ($student->gender_id == 1) { // check if student is eligible to be selected to get room
            $roomsCount = roomsAvailable(1);
            $studentShortlist = Shortlist::maleShortlist()->orderBy('id', 'asc')->with('student')->get();
        } else {
            $roomsCount = roomsAvailable(2);
            $studentShortlist = Shortlist::femaleShortlist()->orderBy('id', 'asc')->with('student')->get();
        }

        $studentKeyNumber = $studentShortlist->whereIn('student_id', $student->id)->keys()->first() + 1;

        return $studentKeyNumber <= $roomsCount;
    }
}


if (!function_exists('selected')) {
    function selected($student, $gender_id, $maleRoomsNumber, $femaleRoomsNumber, $maleShortlist, $femaleShortlist)
    {
        if ($gender_id == 1) {
            $roomsCount = $maleRoomsNumber;
            $studentShortlist = $maleShortlist;
        } else {
            $roomsCount = $femaleRoomsNumber;
            $studentShortlist = $femaleShortlist;
        }

        $studentKeyNumber = $studentShortlist->whereIn('student_id', $student->id)->keys()->first() + 1;

        // check if student is eligible to be selected to get room
        return $studentKeyNumber <= $roomsCount;
    }
}


if (!function_exists('roomsAvailable')) {
    function roomsAvailable(int $gender_id) : int 
    {
        if ($gender_id == 1) {
            if (!session()->has('male_rooms')) {
                session(['male_rooms' => Room::maleRooms()->sum('capacity') - 275]);
            }

            return session('male_rooms');
        } elseif ($gender_id == 2) {
            if (!session()->has('female_rooms')) {
                session(['female_rooms' => Room::femaleRooms()->sum('capacity')]);
            }
            return session('female_rooms');
        } else return 0;
    }
}
