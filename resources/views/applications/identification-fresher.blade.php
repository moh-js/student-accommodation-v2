@extends('layouts.app')

@section('content')
@include('layouts.partials.nav')

<div class="row no-gutters">
    <div class="col-sm-12">
        <div class="container">
            <div class="card mt-5">
                <div class="card-body">
                    <span class="card-title" style="font-size: 18px;"><strong>Registration</strong></span>
                    <hr>
                    <form action="{{ route('identify') }}" method="post">
                        @csrf

                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">First Name</label>
                                    <input type="text" class="form-control" value="{{ old('first_name') }}" name="first_name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Middle Name</label>
                                    <input type="text" class="form-control" value="{{ old('middle_name') }}" name="middle_name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Last Name</label>
                                    <input type="text" class="form-control" value="{{ old('last_name') }}" name="last_name">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">Form 4 index number</label>
                                    <input type="text" class="form-control" value="{{ old('username') }}" name="username">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Programme</label>
                                    <select class="form-control" type="text" name="programme">
                                        <option value="{{ null }}">Choose the your programme</option>
                                        @foreach ($programmes as $programme)
                                            <option value="{{ $programme['name'] }}">{{ $programme['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Level</label>
                                    <select class="form-control" name="level">
                                        <option value="{{ null }}">Choose the your level</option>
                                        <option value="first year">First Year</option>
                                        <option value="second year">Second Year</option>
                                        <option value="third year">Third Year</option>
                                        <option value="fourth year">Fourth Year</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" value="{{ old('email') }}" name="email">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Phone Number</label>
                                    <input type="text" class="form-control" value="{{ old('phone') }}" name="phone">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-size-14 mb-4">Gender</label>
                                    <div class="clearfix"></div>
                                    @foreach (App\Models\Gender::all() as $gender)
                                        <div class="custom-control custom-radio d-inline mr-3">
                                            <input type="radio" {{ old("gender") == $gender->id? 'checked':'' }} value="{{ $gender->id }}" name="gender" id="gender{{ $gender->id }}" class="custom-control-input">
                                            <label class="custom-control-label" for="gender{{ $gender->id }}">{{ $gender->name }}</label>
                                        </div>
                                    @endforeach
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

@endsection
