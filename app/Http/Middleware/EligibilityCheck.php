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
            if (checkEligibility($student)) {
                return $next($request);
            } else {
                toastr()->error('Sorry you are not selected!', 'Not authorized');
                return redirect()->back();
            }
        } else {
            toastr()->error('Oops! something went wrong');
            return redirect()->back();
        }

    }
}
