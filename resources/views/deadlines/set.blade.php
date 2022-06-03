@extends('layouts.app')

@push('title')
    Add new User
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('deadline.store') }}" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Type of students</label>
                                    <select data-placeholder="Select student type" name="student_type" class="form-control @error('student_type') is-invalid @enderror">
                                        @foreach (['fresher', 'continuous'] as $studentType)
                                            <option {{ collect(old('student_type'))->contains($studentType)? 'selected':'' }} value="{{ $studentType }}">{{ title_case($studentType) }}</option>
                                        @endforeach
                                    </select>

                                    @error('student_type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="form-control @error('start_date') is-invalid @enderror" placeholder="Enter first name">

                                    @error('start_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="form-control @error('end_date') is-invalid @enderror" placeholder="Enter middle name">

                                    @error('end_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="academic_year_id">Academic Year</label>
                                    <input type="text" name="academic_year_id" id="academic_year_id" value="{{ $academicYear->name }}" class="form-control @error('academic_year_id') is-invalid @enderror" disabled placeholder="Enter last name">

                                    @error('academic_year_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Set <i class="ri-save-line align-middle"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
@endpush

@push('link')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
