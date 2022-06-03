@extends('layouts.app')

@push('title')
    Edit {{ $group->proper_name }}
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('groups.update', $group->name) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name')??$group->name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter first name">

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <a href="{{ route('groups.index') }}" class="btn btn-danger waves-effect waves-light">Back <i class="ri-arrow-go-back-line align-middle"></i></a>

                                    <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Update <i class="ri-save-line align-middle"></i></button>
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
