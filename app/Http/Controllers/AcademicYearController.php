<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('academic-year-view');

        $academic_years = AcademicYear::withTrashed()->orderBy('id', 'desc')->paginate(10);

        return view('academic-year.index', [
            'academic_years' => $academic_years
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('academic-year-add');

        return view('academic-year.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('academic-year-add');
        
        $data = request()->validate([
            'name' => ['required', 'string', 'max:9'],
            'end_date' => ['required', 'date']
        ]);

        $oldAcademicYear = AcademicYear::current()->first();
        if ($oldAcademicYear) {
            $oldAcademicYear->delete();
        }

        AcademicYear::firstOrCreate($data);
        toastr()->success('Academic Year added successfully');
        return redirect()->route('academic-year.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function edit(AcademicYear $academicYear)
    {
        $this->authorize('academic-year-update');
        
        return view('academic-year.edit', [
            'academicYear' => $academicYear
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AcademicYear $academicYear)
    {
        $this->authorize('academic-year-update');
        
        $data = request()->validate([
            'name' => ['required', 'string', 'max:9'],
            'end_date' => ['required', 'date']
        ]);

        $academicYear->update($data);

        toastr()->success('Academic Year updated successfully');

        return redirect()->route('academic-year.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function destroy(AcademicYear $academicYear)
    {
        $this->authorize('academic-year-delete');
        //
    }
}
