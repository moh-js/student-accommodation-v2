<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Services\OTP;
use App\Models\Gender;
use App\Models\Invoice;
use App\Models\Student;
use App\Models\Shortlist;
use App\Models\Application;
use App\Rules\CustomUnique;
use App\Models\AcademicYear;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\StudentSimsDB;
use Illuminate\Support\Facades\Http;
use App\Jobs\Shortlist as JobsShortlist;
use Illuminate\Database\Eloquent\Builder;
use GuzzleHttp\Exception\ConnectException;
use App\Http\Services\BillingServiceProvider;
use App\Traits\InvoiceProcess;
use App\Traits\ReferenceGenerator;
use Illuminate\Http\Client\ConnectionException;

class ApplicationController extends Controller
{
    use ReferenceGenerator;
    use InvoiceProcess;

    public function __construct(Request $request)
    {
        $this->middleware('deadline.check')->only(['identification', 'apply']);
        $this->middleware('eligibility.check:' . $request->student)->only(['createInvoice', 'sendOTP', 'payment']);
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

                // In the future use try {} to catch the exception
                try {
                    $programmes = Http::get('https://must.ac.tz/website_api/public/programmes')->collect()['data'];
                } catch (ConnectionException $e) {
                    toastr()->error('Could not fetch programmes refresh the page', 'Host resolve failure');
                    $programmes = [];
                }

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
                    'middle_name' => ['nullable', 'string', 'max:255'],
                    'programme' => ['required', 'string', 'max:255'],
                    'dob' => ['required', 'date'],
                    'level' => ['required', 'string', 'max:255'],
                    'phone' => ['required', 'string', 'digits:12', 'unique:students,phone'],
                    'email' => ['required', 'email', new CustomUnique(Student::class, 'email')],
                    'gender' => ['required', 'integer'],
                    'username' => ['required', 'string', 'max:15', 'min:15', new CustomUnique(Student::class, 'username'), 'regex:/[^a-zA-Z0-9 .$]/']
                ], [
                    'regex' => 'use "/" instead of "."'
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
                    'dob' => $request->dob,
                    'email' => $request->email,
                    'gender_id' => $request->gender
                ]);

                if ($request->foreigner) {
                    $student->student_type = 'foreigner';
                }

                if ($request->disabled) {
                    $student->student_type = 'disabled';
                }

                $student->save();

                toastr()->success('Registration process completed successfully');
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
                ->orWhereHas('applications', function (Builder $query) {
                    $query->where([['application_id', request()->id], ['academic_year_id', AcademicYear::current()->id]]);
                })
                ->first();

            if ($student) {
                if (!($student->currentApplication() ?? false)) {
                    $student->update([ // update level
                        'level' => request()->input('level'),
                    ]);
                } else {
                    toastr()->error('Application already sent check status instead');
                    return back();
                }
            } else {
                $student = StudentSimsDB::where('RegNo', $request->id)->first();

                if (isset($student->dob)) {
                    $dobChecker = checkdate(Carbon::parse($student->dob)->format('m'), Carbon::parse($student->dob)->format('d'), Carbon::parse($student->dob)->format('Y'));

                    $student = Student::firstOrCreate([
                        'username' => $student->RegNo,
                    ], [
                        'student_type' => session('student_type'),
                        'name' => Student::generateFullName($student->FirstName, $student->LastName, $student->MiddleName),
                        'phone' => $student->Mobile??rand(255623000000,255623999999),
                        'level' => $request->level,
                        'sponsor' => strtolower($student->sponsor->name),
                        'email' => $student->Email??$student->FirstName.'@'.$student->LastName.'.sample',
                        'edit' => 1,
                        'programme' => title_case($student->programme->Name),
                        'dob' => $dobChecker?Carbon::parse($student->dob)->toDate():null,
                        'gender_id' => Gender::where('short_name', $student->Gender)->first()->id,
                        'verified' => 1,
                        'is_fresher' => 0
                    ]);
                } else {
                    $student = false;
                }

            }

            if ($student) {
                toastr()->success("Weclome $student->name.");
                return redirect()->route('application', $student->slug);
            } else {
                toastr()->error("We couldn't find your registration number.");
                return back()->withInput();
            }
        }
    }

    public function resume()
    {
        $student = $this->identifyStudentApplication(request());
        if ($student) {
            toastr()->success('Welcome back ' . $student->name);

            session(['student_type' => $student->student_type]);

            if ($student->currentInvoice()) {
                return redirect()->route('payment', $student->slug);
            }

            return redirect()->route('application', $student->slug);
        } else {
            toastr()->error('Incorrect username or application id');
            return back()->withInput();
        }
    }

    public function identifyStudentApplication(Request $request)
    {
        $request->validate([
            'id' => ['required', 'string']
        ]);

        return Student::where([['username', $request->id]])
            ->orWhereHas('applications', function (Builder $query) {
                $query->where([['application_id', request()->id], ['academic_year_id', AcademicYear::current()->id]]);
            })
            ->first();
    }

    public function application(Student $student)
    {
        

        try {
            $programmes = Http::get('https://must.ac.tz/website_api/public/programmes')->collect()['data'];
        } catch (ConnectionException $e) {
            toastr()->error('Could not fetch programmes refresh the page', 'Host resolve failure');
            $programmes = [];
        }

        return view('applications.application', [
            'deadline' => $student->studentDeadline(),
            'student' => $student,
            'programmes' => collect($programmes)->sortBy('name'),
            'shortlist' => $student->shortlist,
            'shortlisted' => $student->isShortlisted(),
        ]);
    }

    public function apply(Student $student, Request $request)
    {
        if ($student) {
            if ($student->edit) {
                $data = $request->validate([
                    'programme' => ['required', 'string', 'max:255'],
                    'level' => ['required', 'string', 'max:255'],
                    'award' => ['required', 'string', 'max:255'],
                    'phone' => ['required', 'string', 'digits:12', "unique:students,phone,$student->id,id"],
                    'email' => ['required', 'email', new CustomUnique(Student::class, 'email', $student->id, 'id')],
                ]);

                if ($request->foreigner) {
                    $student->student_type = 'foreigner';
                }

                if ($request->disabled) {
                    $student->student_type = 'disabled';
                }

                $student->update($data);
            }

            if (!$student->currentApplication()) {
                Application::firstOrCreate([
                    'academic_year_id' => AcademicYear::current()->id,
                    'student_id' => $student->id
                ], [
                    'application_id' => now()->format('y') . $student->id . rand(11299, 1212121),
                ]);

                toastr()->success('application sent successfully');
            } else {
                toastr()->success('Application already sent check the status instead ' . $student->name);
                return redirect()->back();
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
        // $request->validate([
        //     'otp' => ['required', 'string'],
        // ]);

        if (!$request->hasValidSignature()) { // abort if the url is expired
            toastr()->error('link expire after 1 minute', 'URL has expired!');
            return back();
        }

        // $otp = new OTP();
        // if ($otp->verifyOTP($student, $request->otp)) { // otp is valid

            // create invoice
            if ($this->invoiceCreate($student)) {
                toastr()->success('Invoice created successfully');
            }

            return back();
        // } else {
        //     toastr()->error('OTP is invalid');
        //     return back();
        // }
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
        $invoice = Invoice::where([['student_id', $student->id], ['academic_year_id', $academicYear->id]])->first();

        if ($invoice->status === 1) {
            return view('applications.allocation', [
                'student' => $student
            ]);
        } else {
            toastr()->success('You have not paid the application fee.');
            return back();
        }
    }

    /* Dashboard Area */

    public function applicationLists(Request $request)
    {
        $this->authorize('application-view');

        if ($request->has('search')) {
            $applications = Application::currentYear()->whereHas('student', function (Builder $query)
            {
                $query->where('username', 'like', '%'.request('search').'%');
            })->paginate(50);
        } else {
            $applications = Application::currentYear()->paginate(50);
        }

        return view('applications.application-list', [
            'applications' => $applications,
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

    public function shortlistPage(Request $request)
    {
        $this->authorize('shortlist-view');

        if ($request->has('search')) {
            $shortlists = Shortlist::whereHas('student', function (Builder $query)
            {
                $query->where('username', 'like', '%'.request('search').'%');
            })->paginate(50);
        } else {
            $shortlists = Shortlist::paginate(50);
        }

        return view('applications.shortlist', [
            'shortlists' => $shortlists,
        ]);
    }

    public function removeShortlisted(Request $request, Shortlist $shortlist)
    {
        $this->authorize('shortlist-delete');

        $shortlist->delete();

        toastr()->success('Selection has been declined successfully');
        return redirect()->back();
    }

    // public function editApplication(Student $student)
    // {
    //     $this->authorize('application-update');
        
    //     return view('applications.application-info-edit', [
    //         'student' => $student
    //     ]);
    // }
}
