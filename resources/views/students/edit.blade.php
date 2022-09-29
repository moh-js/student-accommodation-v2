@extends('layouts.app')

@push('title')
    Edit Student
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('students.update', $student->slug) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="row">
                           
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $student->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter full name">

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" id="username" value="{{ old('username', $student->username) }}" class="form-control @error('username') is-invalid @enderror" placeholder="Enter username">

                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $student->email) }}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email">

                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-7">
                                <div class="form-group">
                                    <label for="">Programme</label>
                                    <select class="form-control @error('programme') is-invalid @enderror" type="text" name="programme">
                                        <option value="{{ null }}">Choose programme</option>
                                        @foreach ($programmes as $programme)
                                            <option {{ old('programme', $student->programme) == ($programme['name'])? 'selected':'' }} value="{{ $programme['name'] }}">{{ $programme['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('programme')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Level</label>
                                    <select class="form-control" name="level">
                                        <option  value="{{ null }}">Choose level</option>
                                        <option {{ old('level', $student->level) == 'first year'? 'selected':'' }} value="first year">First Year</option>
                                        <option {{ old('level', $student->level) == 'second year'? 'selected':'' }} value="second year">Second Year</option>
                                        <option {{ old('level', $student->level) == 'third year'? 'selected':'' }} value="third year">Third Year</option>
                                        <option {{ old('level', $student->level) == 'fourth year'? 'selected':'' }} value="fourth year">Fourth Year</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone', $student->phone) }}" class="form-control @error('phone') is-invalid @enderror" placeholder="255623412290">

                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Date of Birth</label>
                                    <input type="date" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob', $student->dob) }}" name="dob">
                                    @error('dob')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-size-14 mb-4">Gender</label>
                                    <div class="clearfix"></div>
                                    @foreach (App\Models\Gender::all() as $gender)
                                        <div class="custom-control custom-radio d-inline mr-3">
                                            <input type="radio" {{ old("gender_id", $student->gender_id) == $gender->id? 'checked':'' }} value="{{ $gender->id }}" name="gender_id" id="gender{{ $gender->id }}" class="custom-control-input">
                                            <label class="custom-control-label" for="gender_id{{ $gender->id }}">{{ $gender->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
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
