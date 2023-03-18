@extends('layouts.app')

@push('title')
    Add side of the block
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('sides.store') }}" method="post">
                        @csrf

                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Block</label>
                                    <select data-placeholder="Select block" name="block_id"
                                        class="form-control @error('block_id') is-invalid @enderror">
                                        @foreach ($blocks as $block)
                                            <option {{ collect(old('block_id'))->contains($block->name) ? 'selected' : '' }}
                                                value="{{ $block->id }}">{{ $block->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('block_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="gender_id">Based Gender</label>
                                    <select name="gender_id"
                                        class="form-control @error('gender_id') is-invalid @enderror">
                                        <option selected value="{{ null }}">Choose Gender</option>
                                        @foreach (\App\Models\Gender::all() as $gender)
                                            <option {{ (old('gender_id') == $gender->id) ? 'selected' : '' }}
                                                value="{{ $gender->id }}">{{ $gender->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('gender_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter side name">

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="short_name">Short Name</label>
                                    <input type="text" name="short_name" id="short_name" value="{{ old('short_name') }}"
                                        class="form-control @error('short_name') is-invalid @enderror"
                                        placeholder="Enter side short name">

                                    @error('short_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                        data-placeholder="Enter last name">{{ old('description') }}</textarea>

                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Create <i
                                            class="ri-save-line align-middle"></i></button>
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
