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
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="id">Username</label>
                                        <input type="text" class="form-control" disabled
                                            value="{{ $student->username }}">

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="id">Full Name</label>
                                        <input type="text" class="form-control" disabled value="{{ $student->name }}">

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="id">On-Campus Status</label>
                                        @if ($eligible)
                                            <button type="button" disabled
                                                class="btn btn-block btn-primary">Selected</button>
                                        @else
                                            <button type="button" disabled class="btn btn-block btn-danger">Not
                                                Selected</button>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            @if ($hasInvoice)
                                <div class="alert alert-warning" role="alert">
                                    <h4 class="alert-heading"><strong>Alert</strong></h4>
                                    <p>Student has already created an invoice</p>
                                    <p class="mb-0"></p>
                                </div>
                            @elseif ($eligible)
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Create Invoice</button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials.footer')
@endsection
