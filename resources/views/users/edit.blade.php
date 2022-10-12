@extends('layouts.app')

@push('title')
    Edit {{ $user->full_name }}
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('users.update', $user->slug) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Group</label>
                                    <select data-placeholder="Select user group" name="groups[]" class="form-control @error('groups') is-invalid @enderror select2" multiple>
                                        @foreach ($groups as $group)
                                            <option {{ old('groups')? (collect(old('groups'))->contains($group->name)? 'selected':''):($user->roles->contains('id', $group->id)? 'selected':'') }} value="{{ $group->name }}">{{ $group->proper_name }}</option>
                                        @endforeach
                                    </select>

                                    @error('groups')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name')??$user->first_name }}" class="form-control @error('first_name') is-invalid @enderror" placeholder="Enter first name">

                                    @error('first_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name')??$user->middle_name }}" class="form-control @error('middle_name') is-invalid @enderror" placeholder="Enter middle name">

                                    @error('middle_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name')??$user->last_name }}" class="form-control @error('last_name') is-invalid @enderror" placeholder="Enter last name">

                                    @error('last_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone')??$user->phone }}" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone">

                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email')??$user->email }}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email">

                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <a href="{{ route('users.index') }}" class="btn btn-danger waves-effect waves-light">Back <i class="ri-arrow-go-back-line align-middle"></i></a>

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
