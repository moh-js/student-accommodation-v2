<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Deadline;
use Illuminate\Http\Request;

class DeadlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('deadline-view');

        $deadlines = Deadline::where('academic_year_id', AcademicYear::current()->id)->get();
        return view('deadlines.index', [
            'deadlines' => $deadlines
        ]);
    }

    /**
     * Show the form for setting a new deadline.
     *
     * @return \Illuminate\Http\Response
     */
    public function set()
    {
        $this->authorize('deadline-add');

        return view('deadlines.set', [
            'academicYear' => AcademicYear::current()
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
        $this->authorize('deadline-add');

        $validatedData = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'student_type' => ['required', 'string'],
        ]);

        $data = collect($validatedData)->merge(['academic_year_id' => AcademicYear::current()->id])->toArray();

        // Delete previous deadline of the same academic year to the current
        $deadline = Deadline::where([['academic_year_id', AcademicYear::current()->id], ['student_type', $request->input('student_type')]])->first();
        if ($deadline) {
            $deadline->delete();
        }

        Deadline::firstOrCreate($data);

        toastr()->success('Deadline is set');
        return redirect()->route('deadline.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Deadline  $deadline
     * @return \Illuminate\Http\Response
     */
    public function show(Deadline $deadline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Deadline  $deadline
     * @return \Illuminate\Http\Response
     */
    public function edit(Deadline $deadline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deadline  $deadline
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deadline $deadline)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deadline  $deadline
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deadline $deadline)
    {
        $this->authorize('deadline-delete');

        $deadline->delete();

        toastr()->success('Deadline removed succssfully');
        return redirect()->route('deadline.index');
    }
}
