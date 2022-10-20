@extends('layouts.app')

@push('title')
    Export Payment Reports
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('export.student') }}" method="get">
                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="created_at">Created On</label>
                                    <div class="input-daterange input-group" data-provide="datepicker" data-date-format="dd M, yyyy" data-date-autoclose="true">
                                        <input type="text" class="form-control" name="start">
                                        <input type="text" class="form-control" name="end">
                                    </div>


                                    @error('created_at')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="{{ null }}">All</option>
                                        <option value="{{ 1 }}">Active</option>
                                        <option value="{{ 0 }}">Inactive</option>
                                    </select>

                                    @error('status')
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
    <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>


@endpush

@push('link')
    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">

    {{-- <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> --}}
@endpush
