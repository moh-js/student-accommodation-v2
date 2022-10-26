@extends('layouts.app')

@push('title')
    Allocation Setting
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('rooms.store') }}" method="post">
                        @csrf

                        <div class="row">

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Side</label>
                                    <select data-placeholder="Select side" name="side_id" class="form-control @error('side_id') is-invalid @enderror">
                                        @foreach ($sides as $side)
                                            <option {{ collect(old('side'))->contains($side->name)? 'selected':'' }} value="{{ $side->id }}">Block {{ $side->block->name }} - Side {{ $side->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('side_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter side name">

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="capacity">Capacity</label>
                                    <input type="text" name="capacity" id="capacity" value="{{ old('capacity') }}" class="form-control @error('capacity') is-invalid @enderror" placeholder="Enter capacity">

                                    @error('capacity')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Create <i class="ri-save-line align-middle"></i></button>
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
