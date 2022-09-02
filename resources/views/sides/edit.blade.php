@extends('layouts.app')

@push('title')
    Edit the side {{ $side->name }} of the block
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('sides.update', $side->slug) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Block</label>
                                    <select data-placeholder="Select block" name="block_id" class="form-control @error('block_id') is-invalid @enderror">
                                        @foreach ($blocks as $block)
                                            <option {{ collect(old('block_id'))->contains($block->name)? 'selected':'' }} value="{{ $block->id }}">{{ $block->name }}</option>
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
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $side->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter side name">

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
                                    <input type="text" name="short_name" id="short_name" value="{{ old('short_name', $side->short_name) }}" class="form-control @error('short_name') is-invalid @enderror" placeholder="Enter side short name">

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
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" data-placeholder="Enter last name">{{ old('description', $block->description) }}</textarea>

                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
