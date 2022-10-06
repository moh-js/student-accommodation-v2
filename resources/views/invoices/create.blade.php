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
                    <form action="{{ route('invoice.store', $student->slug) }}" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="id">Username</label>
                                    <input type="text" class="form-control" disabled value="{{ $student->username }}">
                                 
                                </div>
                            </div>
                          
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="id">Full Name</label>
                                    <input type="text" class="form-control" disabled value="{{ $student->name }}">
                               
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
