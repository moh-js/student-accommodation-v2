@extends('layouts.app')

@section('content')
@include('layouts.partials.nav')

<div class="row no-gutters">
    <div class="col-sm-12">
        <div class="container">
            <div class="card mt-5">
                <div class="card-body">
                    <span class="card-title" style="font-size: 18px;"><strong>CHeck Application</strong></span>
                    <hr>
                    <p>Enter your registration number or application ID to check your application</p>


                    <form action="{{ route('resume') }}" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="id">Registration #</label>
                                    <input type="text" class="form-control @error('id') is-invalid @enderror" value="{{ old('id') }}" name="id">
                                    @error('id')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Level</label>
                                    <select class="form-control @error('student_type') is-invalid @enderror" name="student_type">
                                        <option value="{{ null }}">Choose type</option>
                                        <option value="fresher">Fresher</option>
                                        <option value="continuous">Continuous</option>
                                    </select>
                                    @error('student_type')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
