<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Services\OTP;
use App\Models\Student;
use App\Models\Shortlist;
use App\Models\Application;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Jobs\Shortlist as JobsShortlist;
use Illuminate\Database\Eloquent\Builder;

class ApplicationController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('deadline.check')->only(['identification', 'apply']);
        $this->middleware('eligibility.check:'.$request->student)->only(['createInvoice', 'sendOTP', 'payment']);
    }

    public function index()
    {
        return view('applications.index');
    }

    public function studentType(Request $request)
    {
        $request->validate([
            'fresher' => ['sometimes', 'integer'],
            'continuous' => ['sometimes', 'integer'],
        ]);

        if ($request->input('fresher') == 1) {
            $student_type = 'fresher';
        } else if ($request->input('continuous') == 1) {
            $student_type = 'continuous';
        } else {
            return redirect()->route('applications-status');
        }

        session(['student_type' => $student_type]);
        return redirect()->route('identification');
    }

    public function getStatus()
    {
        return view('applications.get-status');
    }

    public function identification()
    {
        if (session()->has('student_type')) { // check student type session if contains data
            if (session('student_type') == 'fresher') {
                $programmes = Http::get('https://must.ac.tz/website_api/public/programmes')->collect()['data'];
                // return ($programmes);
                return view('applications.identification-fresher', [
                    'programmes' => collect($programmes)->sortBy('name')
                ]);
            }
            return view('applications.identification-continuous');
        }

        toastr()->error('Session has expired!');
        return redirect()->route('apply');
    }

    public function identify(Request $request)
    {
        if (session('student_type') == 'fresher') {
            if (session()->has('student_type')) { // check student type session if contains data

                $request->validate([
                    'last_name' => ['required', 'string', 'max:255'],
                    'first_name' => ['required', 'string', 'max:255'],
                    'programme' => ['required', 'string', 'max:255'],
                    'level' => ['required', 'string', 'max:255'],
                    'middle_name' => ['nullable', 'string', 'max:255'],
                    'phone' => ['required', 'string', 'digits:12', 'unique:students,phone'],
                    'email' => ['required', 'email', 'unique:students,email'],
                    'gender' => ['required', 'integer'],
                    'username' => ['required', 'string', 'max:15', 'min:15','unique:students,username']
                ]);

                $first_name = $request->first_name;
                $middle_name = $request->middle_name;
                $last_name = $request->last_name;

                $student = Student::firstOrCreate([
                    'username' => $request->username,
                ], [
                    'student_type' => session('student_type'),
                    'name' => Student::generateFullName($first_name, $last_name, $middle_name),
                    'phone' => $request->phone,
                    'programme' => $request->programme,
                    'level' => $request->level,
                    'email' => $request->email,
                    'gender_id' => $request->gender
                ]);

                toastr()->success('Identification completed successfully');
                return redirect()->route('application', $student->slug);
            } else {
                toastr()->error('Session has expired!');
                return redirect()->route('apply');
            }
        } else {

            request()->validate([
                'id' => ['required', 'string', 'max:255'],
                'level' => ['required', 'string', 'max:255'],
            ]);


            $student = Student::where([['username', request('id')], ['student_type', 'continuous']])
            ->orWhereHas('applications', function (Builder $query)
            {
                $query->where([['application_id', request()->id], ['academic_year_id', AcademicYear::current()->id]]);
            })
            ->first();

            if ($student) {
                if (!($student->currentApplication()??false)) {
                    $student->update([ // update level
                        'level' => request()->input('level'),
                    ]);
                } else {
                    toastr()->error('Application already sent check status instead');
                    return back();
                }

            }

            if ($student) {
                toastr()->success("Weclome $student->name.");
                return redirect()->route('application', $student->slug);
            } else {
                toastr()->error("We couldn't find your registration number.");
                return back();
            }

        }
    }

    public function resume()
    {
        $student = $this->identifyStudentApplication(request());
        if ($student) {
            toastr()->success('Welcome back '. $student->name);

            if ($student->currentInvoice()) {
                return redirect()->route('payment', $student->slug);
            }

            return redirect()->route('application', $student->slug);
        } else {
            toastr()->error('Incorrect username or application id');
            return back();
        }
    }

    public function identifyStudentApplication(Request $request)
    {
        $request->validate([
            'id' => ['required', 'string']
        ]);

        return Student::where([['username', $request->id]])
        ->orWhereHas('applications', function (Builder $query)
        {
            $query->where([['application_id', request()->id], ['academic_year_id', AcademicYear::current()->id]]);
        })
        ->first();
    }

    public function application(Student $student)
    {
        if ($student->gender_id == 1) { // check if student is eligible to be selected to get room
            $roomsCount = Room::maleRooms()->sum('capacity');
            $studentShortlist = Shortlist::maleShortlist()->with('student')->get();
        } else {
            $roomsCount = Room::femaleRooms()->sum('capacity');
            $studentShortlist = Shortlist::femaleShortlist()->with('student')->get();
        }

        $studentKeyNumber = $studentShortlist->whereIn('student_id', $student->id)->keys()->last();

        return view('applications.application', [
            'deadline' => $student->studentDeadline(),
            'student' => $student,
            'roomsCount' => $roomsCount,
            'studentKeyNumber' => $studentKeyNumber,
            'shortlist' => $student->shortlist,
            'shortlisted' => $student->isShortlisted(),
        ]);
    }

    public function apply(Student $student)
    {
        if ($student) {
            if (!$student->currentApplication()) {
                Application::firstOrCreate([
                    'academic_year_id' => AcademicYear::current()->id,
                    'student_id' => $student->id
                ], [
                    'application_id' => rand(11299,1212121),
                ]);

                toastr()->success('application sent successfully');
            } else {
                toastr()->success('Application already sent check the status instead '. $student->name);
                return redirect()->route('identification');
            }

            return redirect()->back();

        } else {
            return abort(404);
        }
    }

    public function payment(Student $student)
    {
        return view('applications.payment', [
            'student' => $student,
            'currentAcademicYear' => AcademicYear::current(),
            'invoice' => $student->currentInvoice(),
            'shortlist' => $student->shortlist,

        ]);
    }

    public function createInvoice(Request $request, Student $student, $otp = null)
    {
        $request->validate([
            'otp' => ['required', 'string'],
        ]);

        if (! $request->hasValidSignature()) { // abort if the url is expired
            toastr()->error('URL has expired! URL expire after 1 minute');
            return back();
        }

        $otp = new OTP();
        if ($otp->verifyOTP($student, $request->otp)) { // otp is valid

            // create invoice
            $invoice = $student->invoices()->firstOrCreate([
                'academic_year_id' => AcademicYear::current()->id
            ], [
                'reference' => rand(18821,12128121)
            ]);

            // TODO
            // call billing api for invoice creation

            toastr()->success('Invoice has been created successfully');
            return back();
        } else {
            toastr()->error('OTP is invalid');
            return back();
        }
    }

    public function sendOTP(Student $student)
    {
        if ($student) {
            $otp = new OTP();
            $otpCode = $otp->sendOTP($student);

            session()->flash('otp', $otpCode);
            toastr()->success('OTP sent successfully');
            return back();
        }

    }

    public function allocation(Student $student, AcademicYear $academicYear)
    {
        return view('applications.allocation', [
            'student' => $student
        ]);
    }

    /* Dashboard Area */

    public function applicationLists()
    {
        $this->authorize('application-view');

        return view('applications.application-list', [
            'applications' => Application::currentYear()->get(),
        ]);
    }

    public function decline(Application $application)
    {
        $this->authorize('application-decline');

        $application->update([
            'red_flagged' => 1
        ]);

        toastr()->success("Application declined successfully.");
        return redirect()->route('applications-list');
    }

    public function accept(Application $application)
    {
        $this->authorize('application-accept');

        $application->update([
            'red_flagged' => 0
        ]);

        toastr()->success("Application accepted successfully.");
        return redirect()->route('applications-list');
    }

    public function shortlist(Request $request)
    {
        $this->authorize('shortlist-create');

        JobsShortlist::dispatch();

        toastr()->success('Process has started successfully');
        return redirect()->route('applications-list');
    }
}
