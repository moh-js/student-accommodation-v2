<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Room;
use App\Models\Student;
use App\Models\Shortlist;
use Illuminate\Http\Request;

class EligibilityCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $studentSlug)
    {
        $student = Student::where('slug', $studentSlug)->first();

        if ($student) {
            if ($student->gender_id == 1) { // check if student is eligible to be selected to get room
                $roomsCount = Room::maleRooms()->sum('capacity');
                $studentShortlist = Shortlist::maleShortlist()->with('student')->get();
            } else {
                $roomsCount = Room::femaleRooms()->sum('capacity');
                $studentShortlist = Shortlist::femaleShortlist()->with('student')->get();
            }

            $studentKeyNumber = $studentShortlist->whereIn('student_id', $student->id)->keys()->last();

            if ($studentKeyNumber <= $roomsCount) {
                return $next($request);
            } else {
                toastr()->error('Sorry you are not eligible to do this action');
                return redirect()->route('apply');
            }
        } else {
            toastr()->error('Oops! something went wrong');
            return redirect()->route('apply');
        }

    }
}
