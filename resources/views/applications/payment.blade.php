@extends('layouts.app')

@section('content')
@include('layouts.partials.nav')

<div class="row no-gutters">
    <div class="col-sm-12">
        <div class="container">
            <div class="card mt-5">
                <div class="card-body">
                    <span class="card-title" style="font-size: 18px;"><strong>Application</strong></span>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <p><strong>Name</strong>: {{ $student->name }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p><strong>Email</strong>: {{ $student->email }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p><strong>Phone Number</strong>: {{ $student->phone }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p><strong>Username</strong>: {{ $student->username }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p><strong>Programme</strong>: {{ $student->programme }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p><strong>Level</strong>: {{ title_case($student->level) }}</p>
                        </div>
                    </div>


                    @if ($invoice)
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered">
                                    <thead class="">
                                        <tr class="table-primary">
                                            <td>Reference #</td>
                                            <td>Invoice #</td>
                                            <td>Control #</td>
                                            <td>Amount</td>
                                            <td class="text-center">Status</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $invoice->reference }}</td>
                                            <td>{{ $invoice->invoice_no }}</td>
                                            <td>{{ $invoice->control_number }}</td>
                                            <td>{{ $invoice->amount }}</td>
                                            <td class="text-center">
                                                <span class="badge badge-danger">Not paid</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if ($invoice->status)
                            <a href="{{ route('allocation', ['student' => $student->slug, 'academic_year' => $currentAcademicYear->slug]) }}" class="btn btn-primary">Next</a>
                        @endif
                    @else
                        <form action="{{ URL::temporarySignedRoute('invoice.create-otp', now()->addMinutes(1), ['otp' => $shortlist->otp, 'student' => $student->slug]) }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">OTP</label>
                                        <input type="text" class="form-control @error('otp') is-invalid @enderror" value="{{ old('otp') }}" name="otp">
                                        @error('otp')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{ session('otp') }}

                            <div class="form-group">
                                <a href="{{ route('otp.send', $student->slug) }}" class="btn btn-info">Get otp code</a>
                                <button type="submit" class="btn btn-primary">Create invoice</button>
                            </div>

                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>


</div>
@endsection
