@extends('layouts.app')

@section('content')
@include('layouts.partials.nav')

<div class="row no-gutters">
    <div class="col-sm-12">
        <div class="container">
            <div class="card mt-5">
                <div class="card-body">
                    <span class="card-title" style="font-size: 18px;"><strong>Edit Application</strong></span>
                    <hr>
                    <form action="{{ route('application.update', $student->slug) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">First Name</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" name="first_name">
                                    @error('first_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Middle Name</label>
                                    <input type="text" class="form-control @error('middle_name') is-invalid @enderror" value="{{ old('middle_name') }}" name="middle_name">
                                    @error('middle_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Last Name</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" name="last_name">
                                    @error('last_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">Form 4 index number</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" name="username">
                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Programme</label>
                                    <select class="form-control @error('programme') is-invalid @enderror" type="text" name="programme">
                                        <option value="{{ null }}">Choose the your programme</option>
                                        @foreach ($programmes as $programme)
                                            <option {{ old('programme') == $programme['name']? 'selected':'' }} value="{{ $programme['name'] }}">{{ $programme['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('programme')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Level</label>
                                    <select class="form-control @error('level') is-invalid @enderror" name="level">
                                        <option value="{{ null }}">Choose the your level</option>
                                        <option {{ old('level') == 'first year'? 'selected':'' }} value="first year">First Year</option>
                                        <option {{ old('level') == 'second year'? 'selected':'' }} value="second year">Second Year</option>
                                        <option {{ old('level') == 'third year'? 'selected':'' }} value="third year">Third Year</option>
                                        <option {{ old('level') == 'fourth year'? 'selected':'' }} value="fourth year">Fourth Year</option>
                                    </select>
                                    @error('level')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Date of Birth</label>
                                    <input type="date" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob') }}" name="dob">
                                    @error('dob')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Phone Number</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" name="phone">
                                    @error('phone')
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
                                        <div class="custom-control @error('gender') is-invalid @enderror custom-radio d-inline mr-3">
                                            <input type="radio" {{ old("gender") == $gender->id? 'checked':'' }} value="{{ $gender->id }}" name="gender" id="gender{{ $gender->id }}" class="custom-control-input">
                                            <label class="custom-control-label" for="gender{{ $gender->id }}">{{ $gender->name }}</label>
                                        </div>
                                    @endforeach
                                    @error('gender')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Do you have any disability?</label>
                                    <select class="form-control" name="disability" id="disability">
                                        <option value="{{ 0 }}">No</option>
                                        <option value="{{ 1 }}">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Are you a foreigner student?</label>
                                    <select class="form-control" name="foreigner" id="foreigner">
                                        <option value="{{ 0 }}">No</option>
                                        <option value="{{ 1 }}">Yes</option>
                                    </select>
                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.partials.footer')

@endsection
