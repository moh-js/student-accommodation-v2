<?php

namespace App\Http\Middleware;

use App\Models\AcademicYear;
use Closure;
use App\Models\Deadline;
use Illuminate\Http\Request;

class DeadlineCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $deadline = Deadline::where([['student_type', session('student_type')], ['academic_year_id', AcademicYear::current()->id]])->first();

        if ($deadline) {
            $start_date = $deadline->start_date;
            $end_date = $deadline->end_date;

            if ($start_date < now() && $end_date > now()) {
                return $next($request);
            } else {
                toastr()->error('Application is now closed!');
                return redirect()->route('apply');
            }
        }

        toastr()->error('Session has expired!');
        return redirect()->route('apply');
    }
}
