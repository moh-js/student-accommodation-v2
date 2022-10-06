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

                    @if (session('no_costumer'))
                        <div class="alert alert-danger" role="alert">
                            <strong>Note: {{ session('no_costumer') }}</strong>
                            <p>You must use your <a href="https://sims.must.ac.tz" target="_blank">SIMS</a> account to create invoice and pay for administrative fee first, before paying the accommodation fee.</p>
                        </div>
                    @endif

                    @if ($invoice)
                        @livewire('invoice-table', ['student' => $student], key($student->id))

                        @if ($invoice->status)
                            <a href="{{ route('allocation', ['student' => $student->slug, 'academic_year' => $currentAcademicYear->slug]) }}" class="btn btn-primary">Next</a>
                        @endif
                    @else
                        <form action="{{ URL::temporarySignedRoute('invoice.create-otp', now()->addMinutes(1), ['otp' => $shortlist->otp, 'student' => $student->slug]) }}" method="POST">
                            @csrf

                            {{-- <div class="row">
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
                            </div> --}}

                            <div class="form-group">
                                {{-- <a href="{{ route('otp.send', $student->slug) }}" class="btn btn-info">Get otp code</a> --}}
                                <button type="submit" class="btn btn-primary">Create invoice</button>
                            </div>

                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.partials.footer')

@endsection
