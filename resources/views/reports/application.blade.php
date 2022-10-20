@extends('layouts.app')

@push('title')
    Export Payment Reports
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('export.application') }}" method="get">
                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="academic_year_id">Academic Year</label>
                                    <select class="form-control" name="academic_year_id" id="academic_year_id">
                                        @foreach (App\Models\AcademicYear::all() as $academicYear)
                                            <option value="{{ $academicYear->slug }}">{{ $academicYear->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="red_flagged">Status</label>
                                    <select class="form-control" name="red_flagged">
                                        <option value="{{ null }}">All</option>
                                        <option value="{{ 0 }}">Received</option>
                                        <option value="{{ 1 }}">Banned</option>
                                    </select>

                                    @error('red_flagged')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success waves-effect waves-light w-md">Export <i
                                            class="ri-download-line align-middle"></i></button>
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
    {{-- <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script> --}}
@endpush

@push('link')
    {{-- <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> --}}
@endpush
