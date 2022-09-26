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
                    <p>Enter your registration number  to send your application</p>


                    <form action="{{ route('identify') }}" method="post">
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

@include('layouts.partials.footer')

@endsection
