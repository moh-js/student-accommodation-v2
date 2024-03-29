@extends('layouts.app')

@push('title')
    Create new Invoice
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="container">
                <div class="card mt-5">
                    <div class="card-body">
                        <form action="{{ route('invoice.store.nonstudent') }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="id">Username</label>
                                        <input type="text" name="username"
                                            class="form-control @error('username') is-invalid @enderror"
                                            value="{{ old('username') }}">
                                        @error('username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="id">Full Name</label>
                                        <input type="text" name="full_name"
                                            class="form-control @error('full_name') is-invalid @enderror"
                                            value="{{ old('full_name') }}">
                                        @error('full_name')
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
                                                <input type="radio" {{ old('gender_id') == $gender->id ? 'checked' : '' }}
                                                    value="{{ $gender->id }}" name="gender_id"
                                                    id="gender{{ $gender->id }}" class="custom-control-input">
                                                <label class="custom-control-label"
                                                    for="gender{{ $gender->id }}">{{ $gender->name }}</label>
                                            </div>
                                        @endforeach
                                        @error('gender_id')
                                            <div class="text-danger">
                                                <small>
                                                    {{ $message }}
                                                </small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="">Programme</label>
                                        <select class="form-control @error('programme') is-invalid @enderror" type="text"
                                            name="programme">
                                            <option value="{{ null }}">Choose programme</option>
                                            @foreach ($programmes as $programme)
                                                <option {{ old('programme') == $programme['Code'] ? 'selected' : '' }}
                                                    value="{{ $programme['Code'] }}">{{ $programme['Name'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('programme')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Level</label>
                                        <select class="form-control" name="level">
                                            <option value="{{ null }}">Choose level</option>
                                            <option {{ old('level') == 'first year' ? 'selected' : '' }} value="first year">
                                                First Year</option>
                                            <option {{ old('level') == 'second year' ? 'selected' : '' }} value="second year">
                                                Second Year</option>
                                            <option {{ old('level') == 'third year' ? 'selected' : '' }} value="third year">
                                                Third Year</option>
                                            <option {{ old('level') == 'fourth year' ? 'selected' : '' }} value="fourth year">
                                                Fourth Year</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Create Invoice</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials.footer')
@endsection
