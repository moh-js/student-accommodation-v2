<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Rules\CustomUnique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Builder;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('student-view');

        if ($request->has('search')) {
            $students = Student::where('username', 'like', '%'.request('search').'%')->paginate(50);
        } else {
            $students = Student::paginate(50);
        }

        return view('students.index', [
            'students' => $students
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('student-add');

        $programmes = Http::get('https://must.ac.tz/website_api/public/programmes')->collect()['data'];
        // return ($programmes);
        return view('students.add', [
            'programmes' => collect($programmes)->sortBy('name')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('student-add');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $this->authorize('student-update');

        $programmes = Http::get('https://must.ac.tz/website_api/public/programmes')->collect()['data'];

        return view('students.edit', [
            'student' => $student,
            'programmes' => collect($programmes)->sortBy('name')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $this->authorize('student-update');
        
        $data = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'programme' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date'],
            'level' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'digits:12', new CustomUnique(Student::class, 'phone',$student->id,'id')],
            'email' => ['required', 'email', new CustomUnique(Student::class, 'email',$student->id,'id')],
            'gender_id' => ['required', 'integer'],
            'username' => ['required', 'string', new CustomUnique(Student::class, 'username',$student->id,'id')]
        ]);

        $student->update($data);
        toastr()->success('Student info updated successfully');
        
        return redirect()->route('students.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        if ($student->trashed()) {
            $this->authorize('student-activate');
            $student->restore();
            $action = 'restored';
        } else {
            $this->authorize('student-deactivate');
            $student->delete();
            $action = 'deleted';
        }

        toastr()->success("group $action successfully");
        return redirect()->route('students.index');
    }
}
